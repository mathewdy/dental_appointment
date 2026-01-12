<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/connection/connection.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/security.php');

if (isset($_POST['appointment_id'])) {
    $appointment_id = $_POST['appointment_id'];

    // 1. Get Payment Record
    $sql_payment = "SELECT * FROM payments WHERE appointment_id = ?";
    $stmt_payment = mysqli_prepare($conn, $sql_payment);
    mysqli_stmt_bind_param($stmt_payment, "i", $appointment_id);
    mysqli_stmt_execute($stmt_payment);
    $res_payment = mysqli_stmt_get_result($stmt_payment);

    if (mysqli_num_rows($res_payment) > 0) {
        $payment = mysqli_fetch_assoc($res_payment);
        $payment_id = $payment['payment_id'];
        $initial = $payment['initial_balance'];
        $remaining = $payment['remaining_balance'];
        $paid = $initial - $remaining;

        // Display Summary
        echo "<div class='mb-3'>";
        echo "<h6><strong>Total Cost:</strong> ₱" . number_format($initial, 2) . "</h6>";
        echo "<h6><strong>Total Paid:</strong> ₱" . number_format($paid, 2) . "</h6>";
        echo "<h6><strong>Remaining Balance:</strong> ₱" . number_format($remaining, 2) . "</h6>";
        echo "</div>";

        // 2. Get Payment History
        $sql_history = "SELECT * FROM payment_history WHERE payment_id = ? ORDER BY date_created DESC";
        $stmt_history = mysqli_prepare($conn, $sql_history);
        mysqli_stmt_bind_param($stmt_history, "i", $payment_id);
        mysqli_stmt_execute($stmt_history);
        $res_history = mysqli_stmt_get_result($stmt_history);

        if (mysqli_num_rows($res_history) > 0) {
            echo "<table class='table table-bordered table-striped'>";
            echo "<thead>
                    <tr>
                        <th>Session Label</th>
                        <th>Amount Paid</th>
                        <th>Method</th>
                        <th>Date</th>
                    </tr>
                  </thead>";
            echo "<tbody>";
            while ($row = mysqli_fetch_assoc($res_history)) {
                $label = $row['session_label'] ?? '-';
                $amount = number_format($row['payment_received'], 2);
                $method = $row['payment_method'];
                $date = date("M d, Y h:i A", strtotime($row['date_created']));

                echo "<tr>
                        <td>{$label}</td>
                        <td>₱{$amount}</td>
                        <td>{$method}</td>
                        <td>{$date}</td>
                       </tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<div class='alert alert-info'>No payment transactions found.</div>";
        }

    } else {
        echo "<div class='alert alert-warning'>No billing record found for this appointment.</div>";
    }
}
?>