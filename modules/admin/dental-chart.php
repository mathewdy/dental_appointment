<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/Users/users.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/Users/patients.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/DentalChart/dental_chart.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/Appointments/appointments.php');

$user_id = $_GET['user_id'] ?? 0;
$result = getPatientById($conn, $user_id);
if (!$result || mysqli_num_rows($result) == 0) {
    echo "<script>alert('Patient not found'); window.location.href='patients.php';</script>";
    exit;
}
$row_profile = mysqli_fetch_assoc($result);

// Revert: Always use Global Chart (null appointment_id)
$appointment_id = null;
$chart_data = getDentalChart($conn, $user_id, null);
$appointments_list = getAllPatientAppointments($conn, $user_id);

?>
<style>
    .tooth-container {
        display: grid;
        grid-template-columns: repeat(16, 1fr);
        gap: 5px;
        margin-bottom: 20px;
        overflow-x: auto;
        padding-bottom: 10px;
    }

    /* Geometric Tooth Map Styles */
    .tooth-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin: 5px;
        position: relative;
    }

    .tooth-chart {
        display: grid;
        width: 60px;
        height: 60px;
        background: #fff;
        border: 1px solid #ccc;
        /* Outer border */
    }

    /* Posterior (Back): 3x3 Grid */
    /* For Q1 (1-8) and Q4 (25-32): Mesial is toward midline (left for Q4, right for Q1) */
    .tooth-posterior {
        grid-template-columns: 1fr 2fr 1fr;
        grid-template-rows: 1fr 2fr 1fr;
        grid-template-areas:
            ". buccal ."
            "mesial occlusal distal"
            ". lingual .";
    }

    /* Anterior (Front): 3x3 Grid but Center is merged or split differently? 
       Actually, standard chart is usually just 4 quadrants. 
       Let's use a similar 3x3 but Occlusal is just 'Incisal' edge or similar. 
       For simplicity matching the image, Anterior is often just Left/Right/Top/Bottom.
    */
    .tooth-anterior {
        grid-template-columns: 1fr 2fr 1fr;
        grid-template-rows: 1fr 2fr 1fr;
        grid-template-areas:
            ". buccal ."
            "mesial occlusal distal"
            ". lingual .";
        /* Center is empty or part of lingual? Let's keep it simple: 4 zones. */
    }

    .tooth-zone {
        border: 1px solid #eee;
        cursor: pointer;
        transition: background 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 8px;
        position: relative;
        overflow: hidden;
        min-width: 0;
        min-height: 0;
        line-height: 1;
    }

    .tooth-zone:hover {
        background-color: #f0f0f0;
    }

    /* Zones */
    /* Flipped Chart (Left Side of Patient: Q2 9-16, Q3 17-24) */
    /* For Q2/Q3: Mesial is toward midline (on RIGHT side), Distal on LEFT */
    .tooth-flipped .tooth-posterior {
        grid-template-areas: 
            ". buccal ."
            "distal occlusal mesial"
            ". lingual .";
    }

    .tooth-flipped .tooth-anterior {
        grid-template-areas: 
            ". buccal ."
            "distal occlusal mesial" 
            ". lingual .";
    }

    /* Whole tooth status overlay */
    .chart-whole-status {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 18px;
        color: #333;
        z-index: 10;
        pointer-events: none;
        background-color: rgba(255,255,255,0.7);
    }

    .zone-buccal { grid-area: buccal; border-bottom: 1px solid #ccc; }
    .zone-lingual { grid-area: lingual; border-top: 1px solid #ccc; }
    .zone-mesial { grid-area: mesial; border-left: 1px solid #ccc; }
    .zone-distal { grid-area: distal; border-right: 1px solid #ccc; }
    .zone-occlusal { grid-area: occlusal; border: 1px solid #ccc; background: #fdfdfd; }

    /* Letter display in zones */
    .tooth-zone .zone-letter {
        font-size: 9px;
        font-weight: bold;
        color: #333;
    }
    
    .tooth-number {
        font-size: 12px;
        font-weight: bold;
        margin-bottom: 4px;
        color: #555;
    }
</style>

<div class="wrapper">
    <?php include '../../includes/sidebar.php'; ?>
    <div class="main-panel">
        <?php include '../../includes/topbar.php'; ?>
        <div class="container">
            <div class="page-inner">
                <div class="page-header">
                    <div class="d-flex align-items-center gap-4 w-100">
                        <h4 class="page-title text-truncate">Dental Chart</h4>
                        <div class="d-flex align-items-center gap-2 me-auto">
                            <div class="nav-home">
                                <a href="dashboard.php" class="text-decoration-none text-muted"><i
                                        class="icon-home"></i></a>
                            </div>
                            <div class="separator"><i class="icon-arrow-right fs-bold"></i></div>
                            <div class="nav-item">
                                <a href="patients.php"
                                    class="text-decoration-none text-truncate text-muted">Patients</a>
                            </div>
                            <div class="separator"><i class="icon-arrow-right fs-bold"></i></div>
                            <div class="nav-item">
                                <span class="text-muted">
                                    <?= $row_profile['first_name'] . ' ' . $row_profile['last_name']; ?>
                                </span>
                            </div>
                        </div>


                        <?php if($_SESSION['role_id'] != 3): // Hide Payments for Dentists ?>
                        <a href="view-patient-payments.php?user_id=<?= $user_id ?>"
                            class="btn btn-sm text-white" style="background-color: #1471e7;">Payments & Balance</a>
                        <?php endif; ?>
                    </div>
                </div>



                <div class="page-category">
                    <div class="card p-4">
                        <div class="card-header">
                            <h3>Teeth Diagram</h3>
                        </div>
                        <div class="card-body">
                            <h5 class="text-center mb-3">Upper Arch</h5>
                            <div class="tooth-container">
                                <?php
                                // Letter codes for each status
                                $status_letter_map = [
                                    'Normal' => '',
                                    'Caries' => 'C',
                                    'Amalgam Filling' => 'Am',
                                    'Composite' => 'Co',
                                    'Gold Filling' => 'G',
                                    'Inlay/Onlay' => 'In',
                                    'Temporary Filling' => 'TF',
                                    'Extraction' => 'X',
                                    'Missing' => 'M',
                                    'Fractured' => 'Frac',
                                    'Impacted Tooth' => 'Im',
                                    'Jacket Crown' => 'JC',
                                    'Pit & Fissure Sealant' => 'PFS',
                                    'Supernumerary' => 'Sp'
                                ];

                                function getStatusLetter($status, $map)
                                {
                                    return $map[$status] ?? '';
                                }

                                // 1 to 16 (Upper)
                                for ($i = 1; $i <= 16; $i++) {
                                    $tooth_data = $chart_data[$i] ?? [];
                                    
                                    // Determine type: Anterior (6-11) vs Posterior (1-5, 12-16)
                                    $is_anterior = ($i >= 6 && $i <= 11);
                                    $type_class = $is_anterior ? 'tooth-anterior' : 'tooth-posterior';

                                    // Orientation: Q2 (9-16) is Flipped (Mesial on Left)
                                    $flipped_class = ($i >= 9 && $i <= 16) ? 'tooth-flipped' : '';

                                    // Get status for whole tooth
                                    $whole_status = $tooth_data['whole']['status'] ?? 'Normal';
                                    $whole_letter = getStatusLetter($whole_status, $status_letter_map);

                                    // Get status letters for each surface
                                    $s_mesial   = $tooth_data['Mesial']['status'] ?? null;
                                    $s_distal   = $tooth_data['Distal']['status'] ?? null;
                                    $s_buccal   = $tooth_data['Buccal']['status'] ?? null;
                                    $s_lingual  = $tooth_data['Lingual']['status'] ?? null;
                                    $s_occlusal = $tooth_data['Occlusal']['status'] ?? null;

                                    $l_mesial   = $s_mesial ? getStatusLetter($s_mesial, $status_letter_map) : $whole_letter;
                                    $l_distal   = $s_distal ? getStatusLetter($s_distal, $status_letter_map) : $whole_letter;
                                    $l_buccal   = $s_buccal ? getStatusLetter($s_buccal, $status_letter_map) : $whole_letter;
                                    $l_lingual  = $s_lingual ? getStatusLetter($s_lingual, $status_letter_map) : $whole_letter;
                                    $l_occlusal = $s_occlusal ? getStatusLetter($s_occlusal, $status_letter_map) : $whole_letter;

                                    $json_info = htmlspecialchars(json_encode($tooth_data), ENT_QUOTES, 'UTF-8');
                                    echo "
                                    <div class='tooth-wrapper'>
                                        <div class='tooth-number'>$i</div>
                                        <div class='tooth-chart $type_class $flipped_class' data-tooth-info='$json_info' onclick='openToothModal($i, event, this)'>
                                            <div class='tooth-zone zone-buccal' title='Buccal'><span class='zone-letter'>$l_buccal</span></div>
                                            <div class='tooth-zone zone-lingual' title='Lingual'><span class='zone-letter'>$l_lingual</span></div>
                                            <div class='tooth-zone zone-mesial' title='Mesial'><span class='zone-letter'>$l_mesial</span></div>
                                            <div class='tooth-zone zone-distal' title='Distal'><span class='zone-letter'>$l_distal</span></div>
                                            <div class='tooth-zone zone-occlusal' title='Occlusal'><span class='zone-letter'>$l_occlusal</span></div>
                                        </div>
                                    </div>";
                                }
                                ?>
                            </div>

                            <h5 class="text-center mb-3 mt-4">Lower Arch</h5>
                            <div class="tooth-container">
                                <?php
                                // 32 down to 17 (Lower)
                                for ($i = 32; $i >= 17; $i--) {
                                    $tooth_data = $chart_data[$i] ?? [];
                                    
                                    // Determine type: Anterior (22-27) vs Posterior (17-21, 28-32)
                                    $is_anterior = ($i >= 22 && $i <= 27);
                                    $type_class = $is_anterior ? 'tooth-anterior' : 'tooth-posterior';

                                    // Orientation: Q3 (17-24) is Flipped (Mesial on Left)
                                    $flipped_class = ($i >= 17 && $i <= 24) ? 'tooth-flipped' : '';

                                    // Get status for whole tooth
                                    $whole_status = $tooth_data['whole']['status'] ?? 'Normal';
                                    $whole_letter = getStatusLetter($whole_status, $status_letter_map);

                                    // Get status letters for each surface
                                    $s_mesial   = $tooth_data['Mesial']['status'] ?? null;
                                    $s_distal   = $tooth_data['Distal']['status'] ?? null;
                                    $s_buccal   = $tooth_data['Buccal']['status'] ?? null;
                                    $s_lingual  = $tooth_data['Lingual']['status'] ?? null;
                                    $s_occlusal = $tooth_data['Occlusal']['status'] ?? null;

                                    $l_mesial   = $s_mesial ? getStatusLetter($s_mesial, $status_letter_map) : $whole_letter;
                                    $l_distal   = $s_distal ? getStatusLetter($s_distal, $status_letter_map) : $whole_letter;
                                    $l_buccal   = $s_buccal ? getStatusLetter($s_buccal, $status_letter_map) : $whole_letter;
                                    $l_lingual  = $s_lingual ? getStatusLetter($s_lingual, $status_letter_map) : $whole_letter;
                                    $l_occlusal = $s_occlusal ? getStatusLetter($s_occlusal, $status_letter_map) : $whole_letter;

                                    $json_info = htmlspecialchars(json_encode($tooth_data), ENT_QUOTES, 'UTF-8');
                                    echo "
                                    <div class='tooth-wrapper'>
                                        <div class='tooth-number'>$i</div>
                                        <div class='tooth-chart $type_class $flipped_class' data-tooth-info='$json_info' onclick='openToothModal($i, event, this)'>
                                            <div class='tooth-zone zone-buccal' title='Buccal'><span class='zone-letter'>$l_buccal</span></div>
                                            <div class='tooth-zone zone-lingual' title='Lingual'><span class='zone-letter'>$l_lingual</span></div>
                                            <div class='tooth-zone zone-mesial' title='Mesial'><span class='zone-letter'>$l_mesial</span></div>
                                            <div class='tooth-zone zone-distal' title='Distal'><span class='zone-letter'>$l_distal</span></div>
                                            <div class='tooth-zone zone-occlusal' title='Occlusal'><span class='zone-letter'>$l_occlusal</span></div>
                                        </div>
                                    </div>";
                                }
                                ?>
                            </div>
                            
                            <!-- Legend -->
                            <div class="mt-5 border-top pt-4">
                                <h6 class="fw-bold mb-3 text-center text-uppercase text-muted" style="letter-spacing: 1px;">Chart Legend & Guide</h6>
                                <div class="row g-4 justify-content-center">
                                    <!-- Visual Guide -->
                                    <div class="col-md-5 text-center border-end">
                                        <div class="mb-3 fw-bold small text-secondary">SURFACE ORIENTATION</div>
                                        <div class="d-flex justify-content-center align-items-center gap-4">
                                            <!-- Right Side Q1/Q4 -->
                                            <div>
                                                <div class="tooth-chart tooth-posterior mx-auto mb-2">
                                                    <div class="tooth-zone zone-buccal" title="Buccal"><span class="zone-letter">B</span></div>
                                                    <div class="tooth-zone zone-lingual" title="Lingual"><span class="zone-letter">L</span></div>
                                                    <div class="tooth-zone zone-mesial" title="Mesial"><span class="zone-letter">M</span></div>
                                                    <div class="tooth-zone zone-distal" title="Distal"><span class="zone-letter">D</span></div>
                                                    <div class="tooth-zone zone-occlusal" title="Occlusal"><span class="zone-letter">O</span></div>
                                                </div>
                                                <small class="d-block text-muted bg-light border rounded px-2 py-1" style="font-size:10px">
                                                    <strong>Right Side (Q1/Q4)</strong><br>
                                                    ← M (Midline) | D →
                                                </small>
                                            </div>
                                            
                                            <!-- Left Side Q2/Q3 -->
                                            <div>
                                                <div class="tooth-chart tooth-posterior tooth-flipped mx-auto mb-2">
                                                    <div class="tooth-zone zone-buccal" title="Buccal"><span class="zone-letter">B</span></div>
                                                    <div class="tooth-zone zone-lingual" title="Lingual"><span class="zone-letter">L</span></div>
                                                    <div class="tooth-zone zone-mesial" title="Mesial"><span class="zone-letter">M</span></div>
                                                    <div class="tooth-zone zone-distal" title="Distal"><span class="zone-letter">D</span></div>
                                                    <div class="tooth-zone zone-occlusal" title="Occlusal"><span class="zone-letter">O</span></div>
                                                </div>
                                                <small class="d-block text-muted bg-light border rounded px-2 py-1" style="font-size:10px">
                                                    <strong>Left Side (Q2/Q3)</strong><br>
                                                    ← D | M (Midline) →
                                                </small>
                                            </div>
                                        </div>
                                        <div class="mt-3 small text-muted">
                                            <strong>B</strong> = Buccal (Outer) &nbsp;|&nbsp; 
                                            <strong>L</strong> = Lingual (Inner) &nbsp;|&nbsp; 
                                            <strong>O</strong> = Occlusal (Biting)<br>
                                            <strong>M</strong> = Mesial (Toward Midline) &nbsp;|&nbsp; 
                                            <strong>D</strong> = Distal (Away from Midline)
                                        </div>
                                    </div>

                                    <!-- Status Keys (Letter-Based) -->
                                    <div class="col-md-7">
                                        <div class="mb-3 fw-bold small text-secondary text-center">STATUS LETTER CODES</div>
                                        <div class="row" style="font-size: 12px;">
                                            <div class="col-4">
                                                <ul class="list-unstyled mb-0">
                                                    <li><strong>C</strong> – Caries</li>
                                                    <li><strong>Am</strong> – Amalgam Filling</li>
                                                    <li><strong>Co</strong> – Composite</li>
                                                    <li><strong>G</strong> – Gold Filling</li>
                                                    <li><strong>TF</strong> – Temporary Filling</li>
                                                </ul>
                                            </div>
                                            <div class="col-4">
                                                <ul class="list-unstyled mb-0">
                                                    <li><strong>JC</strong> – Jacket Crown</li>
                                                    <li><strong>In</strong> – Inlay/Onlay</li>
                                                    <li><strong>Im</strong> – Impacted Tooth</li>
                                                    <li><strong>PFS</strong> – Pit & Fissure Sealant</li>
                                                    <li><strong>Frac</strong> – Fractured</li>
                                                </ul>
                                            </div>
                                            <div class="col-4">
                                                <ul class="list-unstyled mb-0">
                                                    <li><strong>X</strong> – Extraction</li>
                                                    <li><strong>M</strong> – Missing</li>
                                                    <li><strong>Sp</strong> – Supernumerary</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Account Ledger Section (Paper-style with Red Borders) -->
                    <div class="card mt-4" style="border: 2px solid #c9302c; background: #fffdf5;">
                        <div class="card-header"
                            style="background: linear-gradient(135deg, #f8f8f5 0%, #f0ede5 100%); border-bottom: 2px solid #c9302c;">
                            <h4 class="mb-0" style="color: #8b0000; font-weight: bold;">
                                <i class="fas fa-file-invoice-dollar me-2"></i>Account Ledger
                            </h4>
                            <small class="text-muted">Treatment charges and payment history</small>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table mb-0" style="border-collapse: collapse;">
                                    <thead>
                                        <tr style="background: #fdf5e6;">
                                            <th
                                                style="border: 1px solid #c9302c; color: #8b0000; padding: 10px; width: 12%;">
                                                DATE</th>
                                            <th
                                                style="border: 1px solid #c9302c; color: #8b0000; padding: 10px; width: 10%;">
                                                TIME</th>
                                            <th
                                                style="border: 1px solid #c9302c; color: #8b0000; padding: 10px; width: 33%;">
                                                DESCRIPTION</th>
                                            <th
                                                style="border: 1px solid #c9302c; color: #8b0000; padding: 10px; width: 15%; text-align: right;">
                                                DEBIT</th>
                                            <th
                                                style="border: 1px solid #c9302c; color: #8b0000; padding: 10px; width: 15%; text-align: right;">
                                                CASH/GCASH</th>
                                            <th
                                                style="border: 1px solid #c9302c; color: #8b0000; padding: 10px; width: 15%; text-align: right;">
                                                BALANCE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $ledger_res = getPatientLedger($conn, $user_id);
                                        $running_balance = 0;
                                        if ($ledger_res && mysqli_num_rows($ledger_res) > 0) {
                                            while ($row = mysqli_fetch_assoc($ledger_res)) {
                                                $debit = floatval($row['debit']);
                                                $credit = floatval($row['credit']);
                                                $running_balance = $running_balance + $debit - $credit;

                                                $desc = htmlspecialchars($row['description']);
                                                $date = date('m/d/y', strtotime($row['trans_date']));
                                                $time = ($row['trans_time'] == '00:00:00' || $row['trans_time'] == '00:00') ? '-' : date('h:i A', strtotime($row['trans_time']));

                                                $debit_display = $debit > 0 ? number_format($debit, 2) : '-';
                                                $credit_display = $credit > 0 ? '<span style="color: #c9302c;">' . number_format($credit, 2) . '</span>' : '-';
                                                $balance_display = number_format($running_balance, 2);

                                                $row_bg = $row['type'] == 'payment' ? '#fff8f0' : '#fff';

                                                echo "
                                                <tr style='background: $row_bg;'>
                                                    <td style='border: 1px solid #c9302c; padding: 8px; text-align: center;'>$date</td>
                                                    <td style='border: 1px solid #c9302c; padding: 8px; text-align: center;'>$time</td>
                                                    <td style='border: 1px solid #c9302c; padding: 8px;'>$desc</td>
                                                    <td style='border: 1px solid #c9302c; padding: 8px; text-align: right; font-weight: bold;'>$debit_display</td>
                                                    <td style='border: 1px solid #c9302c; padding: 8px; text-align: right; font-weight: bold;'>$credit_display</td>
                                                    <td style='border: 1px solid #c9302c; padding: 8px; text-align: right; font-weight: bold;'>$balance_display</td>
                                                </tr>
                                                ";
                                            }
                                        } else {
                                            echo "<tr><td colspan='6' style='border: 1px solid #c9302c; padding: 20px; text-align: center; color: #999;'>No transaction history found.</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer"
                            style="background: #fdf5e6; border-top: 2px solid #c9302c; text-align: right; padding: 10px 15px;">
                            <strong style="color: #8b0000;">Current Balance:
                                ₱<?= number_format($running_balance, 2) ?></strong>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="toothModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Tooth #<span id="modalToothNum"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="toothForm">
                    <input type="hidden" name="patient_id" value="<?= $user_id ?>">
                    <input type="hidden" name="appointment_id" value="<?= $appointment_id ?? '' ?>">
                    <input type="hidden" name="tooth_number" id="inputToothNum">



                        <div class="mb-3">
                            <label class="form-label">Surface</label>
                            <select class="form-select" name="tooth_surface" id="inputSurface">
                                <option value="whole">Whole Tooth</option>
                                <option value="Mesial">Mesial (Left)</option>
                                <option value="Distal">Distal (Right)</option>
                                <option value="Buccal">Buccal (Outer)</option>
                                <option value="Lingual">Lingual (Inner)</option>
                                <option value="Occlusal">Occlusal (Top/Biting)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status" id="inputStatus">
                                <option value="Normal">Normal</option>
                                <optgroup label="Common">
                                    <option value="Caries">Caries (C)</option>
                                    <option value="Extraction">Extraction (X)</option>
                                    <option value="Missing">Missing (M)</option>
                                </optgroup>
                                <optgroup label="Restorations">
                                    <option value="Amalgam Filling">Amalgam Filling (Am)</option>
                                    <option value="Composite">Composite (Co)</option>
                                    <option value="Gold Filling">Gold Filling (G)</option>
                                    <option value="Temporary Filling">Temporary Filling (TF)</option>
                                    <option value="Inlay/Onlay">Inlay/Onlay (In)</option>
                                </optgroup>
                                <optgroup label="Others">
                                    <option value="Jacket Crown">Jacket Crown (JC)</option>
                                    <option value="Impacted Tooth">Impacted Tooth (Im)</option>
                                    <option value="Pit & Fissure Sealant">Pit & Fissure Sealant (PFS)</option>
                                    <option value="Fractured">Fractured (Frac)</option>
                                    <option value="Supernumerary">Supernumerary (Sp)</option>
                                </optgroup>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Notes</label>
                            <textarea class="form-control" name="notes" id="inputNotes" rows="3"></textarea>
                        </div>
                    </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saveTooth()">Save changes</button>
            </div>
        </div>
    </div>
</div>

<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/scripts.php'); ?>
<script>
    var toothModal = new bootstrap.Modal(document.getElementById('toothModal'));

    // Open modal only needs Number now, as Status/Notes are fetched per Surface? 
    // Simplified: Just open blank or default 'Whole'. User picks surface and status.
    // For better UX, we could pass current status of Whole.
    function openToothModal(num, event, element) {
        $('#modalToothNum').text(num);
        $('#inputToothNum').val(num);

        // Determine surface from click event
        var surface = 'whole';
        if (event && event.target) {
            if (event.target.classList.contains('zone-mesial')) surface = 'Mesial';
            else if (event.target.classList.contains('zone-distal')) surface = 'Distal';
            else if (event.target.classList.contains('zone-buccal')) surface = 'Buccal';
            else if (event.target.classList.contains('zone-lingual')) surface = 'Lingual';
            else if (event.target.classList.contains('zone-occlusal')) surface = 'Occlusal';
        }
        $('#inputSurface').val(surface);

        // Pre-fill Status and Notes
        var status = 'Normal';
        var notes = '';

        if (element) {
            var info = $(element).data('tooth-info');
            // Check if we have data for this surface
            // Keys in info match surface names (whole, Mesial, Distal...)
            if (info && info[surface]) {
                status = info[surface].status || 'Normal';
                notes = info[surface].notes || '';
            }
        }

        $('#inputStatus').val(status);
        $('#inputNotes').val(notes);

        toothModal.show();
    }

    function saveTooth() {
        var formData = $('#toothForm').serialize();
        $.post('save_dental_chart.php', formData, function (res) {
            try {
                var resp = JSON.parse(res);
                if (resp.success) {
                    success('Tooth updated successfully', () => location.reload());
                } else {
                    error(resp.message || 'Error updating tooth', () => { });
                }
            } catch (e) {
                error('Server error', () => { });
            }
        });
    }
</script>