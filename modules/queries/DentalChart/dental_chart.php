<?php
date_default_timezone_set('Asia/Manila');

function getDentalChart($conn, $patient_id, $appointment_id = null)
{
    if ($appointment_id) {
        $sql = "SELECT tooth_number, tooth_surface, status, notes, date_updated FROM patient_dental_chart WHERE patient_id = ? AND appointment_id = ? ORDER BY tooth_number, tooth_surface";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $patient_id, $appointment_id);
    } else {
        // Base chart (no appointment linked)
        $sql = "SELECT tooth_number, tooth_surface, status, notes, date_updated FROM patient_dental_chart WHERE patient_id = ? AND appointment_id IS NULL ORDER BY tooth_number, tooth_surface";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $patient_id);
    }
    
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $chart = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $tooth = $row['tooth_number'];
        $surface = $row['tooth_surface'] ?? 'whole';
        if (!isset($chart[$tooth])) {
            $chart[$tooth] = [];
        }
        $chart[$tooth][$surface] = $row;
    }
    return $chart;
}

function updateToothStatus($conn, $patient_id, $tooth_number, $tooth_surface, $status, $notes, $modifier_id, $appointment_id = null)
{
    $surface = $tooth_surface ?: 'whole';
    $now = date("Y-m-d H:i:s");

    // Check if exists for specific appointment scope
    if ($appointment_id) {
        $sql_check = "SELECT id FROM patient_dental_chart WHERE patient_id = ? AND tooth_number = ? AND tooth_surface = ? AND appointment_id = ?";
        $stmt_check = mysqli_prepare($conn, $sql_check);
        mysqli_stmt_bind_param($stmt_check, "iisi", $patient_id, $tooth_number, $surface, $appointment_id);
    } else {
        $sql_check = "SELECT id FROM patient_dental_chart WHERE patient_id = ? AND tooth_number = ? AND tooth_surface = ? AND appointment_id IS NULL";
        $stmt_check = mysqli_prepare($conn, $sql_check);
        mysqli_stmt_bind_param($stmt_check, "iis", $patient_id, $tooth_number, $surface);
    }
    
    mysqli_stmt_execute($stmt_check);
    $result_check = mysqli_stmt_get_result($stmt_check);
    $exists = mysqli_num_rows($result_check) > 0;

    if ($exists) {
        if ($appointment_id) {
            $sql = "UPDATE patient_dental_chart SET status = ?, notes = ?, modified_by = ?, date_updated = ? WHERE patient_id = ? AND tooth_number = ? AND tooth_surface = ? AND appointment_id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssisiisi", $status, $notes, $modifier_id, $now, $patient_id, $tooth_number, $surface, $appointment_id);
        } else {
            $sql = "UPDATE patient_dental_chart SET status = ?, notes = ?, modified_by = ?, date_updated = ? WHERE patient_id = ? AND tooth_number = ? AND tooth_surface = ? AND appointment_id IS NULL";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssisiis", $status, $notes, $modifier_id, $now, $patient_id, $tooth_number, $surface);
        }
    } else {
        $sql = "INSERT INTO patient_dental_chart (patient_id, tooth_number, tooth_surface, status, notes, modified_by, date_updated, appointment_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "iisssssi", $patient_id, $tooth_number, $surface, $status, $notes, $modifier_id, $now, $appointment_id);
    }

    return mysqli_stmt_execute($stmt);
}

// Get dental chart history for treatment history page
function getDentalChartHistory($conn, $patient_id)
{
    $sql = "SELECT pdc.tooth_number, pdc.tooth_surface, pdc.status, pdc.notes, pdc.date_updated,
            CONCAT(u.first_name, ' ', u.last_name) AS modified_by_name
            FROM patient_dental_chart pdc
            LEFT JOIN users u ON pdc.modified_by = u.user_id
            WHERE pdc.patient_id = ?
            ORDER BY pdc.date_updated DESC";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $patient_id);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}

// Manual treatment functions
function addManualTreatment($conn, $patient_id, $treatment, $notes, $doctor_id)
{
    $sql = "INSERT INTO treatments (patient_id, treatment, notes, doctor_id) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "issi", $patient_id, $treatment, $notes, $doctor_id);
    return mysqli_stmt_execute($stmt);
}

function getManualTreatments($conn, $patient_id)
{
    $sql = "SELECT t.id, t.treatment, t.notes, t.date_created,
            CONCAT(u.first_name, ' ', u.last_name) AS doctor_name
            FROM treatments t
            LEFT JOIN users u ON t.doctor_id = u.user_id
            WHERE t.patient_id = ?
            ORDER BY t.date_created DESC";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $patient_id);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}

function getPatientLedger($conn, $patient_id)
{
    // 1. Get Charges (Procedures)
    // We treat each 'payment' record as a Charge (Initial Balance) linked to an appointment
    $sql_charges = "SELECT 
        p.id, 
        p.payment_id as ref_id, 
        a.appointment_date as trans_date, 
        a.appointment_time as trans_time,
        p.services as description, 
        p.initial_balance as debit, 
        0 as credit,
        'charge' as type
    FROM payments p
    JOIN appointments a ON p.appointment_id = a.appointment_id
    WHERE p.user_id = ?";

    // 2. Get Payments (Credits)
    // We link back to payments to get the service name if needed, or just say 'Payment'
    // payment_history links to payments via payment_id (the int ID or string ID? Schema says int linked to int PK?)
    // Wait, payments table: `payment_id` int(11) is likely the specialized ID (2025xxxx), and `id` is PK?
    // payment_history: `payment_id` matches `payments.payment_id`?
    // Let's check schema constraints.
    // payment_history.payment_id REFERENCES payments.payment_id? No, usually ID.
    // Schema dump: payment_history foreign key references payments(payment_id). 
    // payments(payment_id) is indexed.

    $sql_payments = "SELECT 
        ph.id, 
        ph.payment_id as ref_id, 
        ph.date_created as trans_date, 
        '00:00' as trans_time, 
        CONCAT('Payment - ', p.services) as description, 
        0 as debit, 
        ph.payment_received as credit,
        'payment' as type
    FROM payment_history ph
    JOIN payments p ON ph.payment_id = p.payment_id
    WHERE p.user_id = ?";

    // UNION and Order
    $sql = "($sql_charges) UNION ALL ($sql_payments) ORDER BY trans_date ASC, trans_time ASC";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $patient_id, $patient_id);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}
?>