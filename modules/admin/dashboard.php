<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/security.php');

$first_name = $_SESSION['first_name'];                
$today = date('m/d/Y'); // Matches your DB format
$currentWeek = date('W');
$currentMonth = date('m');
$currentYear = date('Y');

// DAILY REPORT
$query_daily = "
    SELECT 
        a.appointment_date,
        a.appointment_time,
        CONCAT(p.first_name, ' ', p.last_name) AS patient_name,
        CONCAT(d.first_name, ' ', d.last_name) AS doctor_name,
        a.concern,
        CASE 
            WHEN a.confirmed = 1 THEN 'Confirmed'
            WHEN a.confirmed = 2 THEN 'Cancelled'
            ELSE 'Pending'
        END AS status
    FROM appointments a
    LEFT JOIN users p ON a.user_id_patient = p.user_id
    LEFT JOIN users d ON a.user_id = d.user_id
    WHERE a.appointment_date = '$today'
    ORDER BY a.appointment_time ASC
";


// WEEKLY REPORT
$query_weekly = "
    SELECT 
        a.appointment_date,
        a.appointment_time,
        CONCAT(p.first_name, ' ', p.last_name) AS patient_name,
        CONCAT(d.first_name, ' ', d.last_name) AS doctor_name,
        a.concern,
        CASE 
            WHEN a.confirmed = 1 THEN 'Confirmed'
            WHEN a.confirmed = 2 THEN 'Cancelled'
            ELSE 'Pending'
        END AS status
    FROM appointments a
    LEFT JOIN users p ON a.user_id_patient = p.user_id
    LEFT JOIN users d ON a.user_id = d.user_id
    WHERE WEEK(STR_TO_DATE(a.appointment_date, '%m/%d/%Y'), 1) = '$currentWeek'
      AND YEAR(STR_TO_DATE(a.appointment_date, '%m/%d/%Y')) = '$currentYear'
    ORDER BY STR_TO_DATE(a.appointment_date, '%m/%d/%Y') ASC, a.appointment_time ASC
";

// MONTHLY REPORT
$query_monthly = "
    SELECT 
        a.appointment_date,
        a.appointment_time,
        CONCAT(p.first_name, ' ', p.last_name) AS patient_name,
        CONCAT(d.first_name, ' ', d.last_name) AS doctor_name,
        a.concern,
        CASE 
            WHEN a.confirmed = 1 THEN 'Confirmed'
            WHEN a.confirmed = 2 THEN 'Cancelled'
            ELSE 'Pending'
        END AS status
    FROM appointments a
    LEFT JOIN users p ON a.user_id_patient = p.user_id
    LEFT JOIN users d ON a.user_id = d.user_id
    WHERE MONTH(STR_TO_DATE(a.appointment_date, '%m/%d/%Y')) = '$currentMonth'
      AND YEAR(STR_TO_DATE(a.appointment_date, '%m/%d/%Y')) = '$currentYear'
    ORDER BY STR_TO_DATE(a.appointment_date, '%m/%d/%Y') ASC, a.appointment_time ASC
";

// Display function
function displayReport($result, $day, $date) {
    if (mysqli_num_rows($result) > 0) {
        echo "
            <thead>
            <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Patient Name</th>
                <th>Doctor</th>
                <th>Concern</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>    
        ";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "
                <tr>
                    <td>{$row['appointment_date']}</td>
                    <td>{$row['appointment_time']}</td>
                    <td>{$row['patient_name']}</td>
                    <td>Dr. {$row['doctor_name']}</td>
                    <td>{$row['concern']}</td>
                    <td>{$row['status']}</td>
                </tr>
            ";
        }
        echo "</tbody>";
    } else {
        echo '
          <div class="container">
            <div class="row text-center my-4 gap-4">
              <div class="col-lg-12">
                <i class="fas fa-calendar display-1 text-muted"></i>
                <p class="h4 fw-bold m-0 p-0">No Appointments ' . $day .' </p>
                <p class="h5 text-muted m-0 p-0">You have a clear schedule for ' . $day . ' </p>
              </div>
              <div class="col-lg-12">
                <a href="appointments.php" class="btn btn-primary rounded">Schedule Appointment</a>
              </div>
            </div>
          </div>
        ';
    }
}

$run_daily = mysqli_query($conn, $query_daily);
$run_weekly = mysqli_query($conn, $query_weekly);
$run_monthly = mysqli_query($conn, $query_monthly);
?>

<div class="wrapper">
	<?php include '../../includes/sidebar.php'; ?>

	<div class="main-panel">
		<?php include '../../includes/topbar.php'; ?>
		<div class="container">
			<div class="page-inner">
				<div class="page-header">
                    
					<span class="d-flex justify-content-between align-items-center w-100">
						<span class="d-flex">
							<h4 class="page-title">Home</h4>
							<ul class="breadcrumbs d-flex justify-items-center align-items-center">
								<li class="nav-home">
									<a href="dashboard.php"><i class="icon-home"></i></a>
								</li>
								<li class="separator"><i class="icon-arrow-right"></i></li>
							</ul>
						</span>    
					</span>
				</div>
				<div class="page-category">
					<h1>Welcome <?= $first_name; ?></h1>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link text-dark text-muted active" id="today-tab" data-bs-toggle="tab" data-bs-target="#today" type="button" role="tab" aria-controls="today" aria-selected="true">
                    Today's Appointments
                </button>
              </li>
              <li class="nav-item" role="presentation">
              <button class="nav-link text-dark text-muted" id="weekly-tab" data-bs-toggle="tab" data-bs-target="#weekly"
                  type="button" role="tab" aria-controls="weekly" aria-selected="false">
                  Weekly View
              </button>
              </li>
              <li class="nav-item" role="presentation">
              <button class="nav-link text-dark text-muted" id="monthly-tab" data-bs-toggle="tab" data-bs-target="#monthly"
                  type="button" role="tab" aria-controls="monthly" aria-selected="false">
                  Monthly View
              </button>
              </li>
            </ul>

                <!-- Tabs Content -->
                <div class="tab-content mt-3" id="myTabContent">
                  <div class="tab-pane fade show active" id="today" role="tabpanel" aria-labelledby="today-tab">
                    <div class="card">
                      <div class="card-header">
                        <div class="datatable-toolbar d-flex justify-content-between">
                          <div class="d-flex align-items-center gap-2">
                            <input type="text" id="customSearch" class="form-control" placeholder="Search appointments...">
                            <button id="filterBtn" class="btn btn-outline-secondary">
                              <i class="bi bi-funnel"></i> Filter
                            </button>
                          </div>
                          <div class="d-flex align-items-center">
                            <label class="me-2 mb-0">Show</label>
                            <select id="customLength" class="form-select form-select-sm w-auto">
                              <option value="10">10</option>
                              <option value="25" selected>25</option>
                              <option value="50">50</option>
                            </select>
                            <label class="ms-2 mb-0">entries</label>
                          </div>
                        </div>
                      </div>
                      <div class="card-body">
                        <table id="table1" class="table table-striped">
                          <?php displayReport($run_daily, 'today', ''); ?>
                        </table>
                      </div>
                    </div>
                    <div class="row align-items-center mt-2">
                      <div class="col-md-6">
                        <div id="myTable_info" class="dataTables_info" role="status" aria-live="polite"></div>
                      </div>
                      <div class="col-md-6 d-flex justify-content-end">
                        <div id="myTable_paginate" class="dataTables_paginate paging_simple_numbers"></div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="weekly" role="tabpanel" aria-labelledby="weekly-tab">
                    <div class="card">
                      <div class="card-header">
                        <div class="datatable-toolbar d-flex justify-content-between">
                          <div class="d-flex align-items-center gap-2">
                            <input type="text" id="customSearch" class="form-control" placeholder="Search appointments...">
                            <button id="filterBtn" class="btn btn-outline-secondary">
                              <i class="bi bi-funnel"></i> Filter
                            </button>
                          </div>
                          <div class="d-flex align-items-center">
                            <label class="me-2 mb-0">Show</label>
                            <select id="customLength" class="form-select form-select-sm w-auto">
                              <option value="10">10</option>
                              <option value="25" selected>25</option>
                              <option value="50">50</option>
                            </select>
                            <label class="ms-2 mb-0">entries</label>
                          </div>
                        </div>
                      </div>
                      <div class="card-body">
                        <table id="table2" class="table table-striped">
                          <?php displayReport($run_weekly, 'this week', ''); ?>
                        </table>
                      </div>
                    </div>
                    <div class="row align-items-center mt-2">
                      <div class="col-md-6">
                        <div id="myTable_info" class="dataTables_info" role="status" aria-live="polite"></div>
                      </div>
                      <div class="col-md-6 d-flex justify-content-end">
                        <div id="myTable_paginate" class="dataTables_paginate paging_simple_numbers"></div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="monthly" role="tabpanel" aria-labelledby="monthly-tab">
                    <div class="card">
                      <div class="card-header">
                        <div class="datatable-toolbar d-flex justify-content-between">
                          <div class="d-flex align-items-center gap-2">
                            <input type="text" id="customSearch" class="form-control" placeholder="Search appointments...">
                            <button id="filterBtn" class="btn btn-outline-secondary">
                              <i class="bi bi-funnel"></i> Filter
                            </button>
                          </div>
                          <div class="d-flex align-items-center">
                            <label class="me-2 mb-0">Show</label>
                            <select id="customLength" class="form-select form-select-sm w-auto">
                              <option value="10">10</option>
                              <option value="25" selected>25</option>
                              <option value="50">50</option>
                            </select>
                            <label class="ms-2 mb-0">entries</label>
                          </div>
                        </div>
                      </div>
                      <div class="card-body">
                        <table id="table3" class="table table-striped">
                          <?php displayReport($run_monthly, 'this month', ''); ?>
                        </table>
                      </div>
                    </div>
                    <div class="row align-items-center mt-2">
                      <div class="col-md-6">
                        <div id="myTable_info" class="dataTables_info" role="status" aria-live="polite"></div>
                      </div>
                      <div class="col-md-6 d-flex justify-content-end">
                        <div id="myTable_paginate" class="dataTables_paginate paging_simple_numbers"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/scripts.php'); 
?>
<script>
$(document).ready(function () {
  var table = $('#table1').DataTable({
    dom: 't<"bottom"ip>',
    info: true,
  });
  var table2 = $('#table2').DataTable({
    dom: 't<"bottom"ip>',
    info: true,
  });
  var table3 = $('#table2').DataTable({
    dom: 't<"bottom"ip>',
    info: true,
  });

  var bottom = $('#myTable_wrapper .bottom');
  bottom.addClass('row align-items-center mt-2');
  bottom.find('.dataTables_info').addClass('col-md-6 mb-2 mb-md-0');
  bottom.find('.dataTables_paginate').addClass('col-md-6 text-md-end');

  $('#customSearch').on('keyup', function () {
    table.search(this.value).draw();
  });

  $('#customLength').on('change', function () {
    table.page.len($(this).val()).draw();
  });

});

  </script>