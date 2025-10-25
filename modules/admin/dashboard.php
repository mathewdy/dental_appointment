<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/modules/queries/Reports/reports.php');

$first_name = $_SESSION['first_name'];                

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
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link text-dark text-muted active" id="today-tab" data-bs-toggle="tab" data-bs-target="#today" type="button" role="tab" aria-controls="today" aria-selected="true">
                    Today's Appointments <span class="badge bg-dark ms-2"><?php getRecordCount($conn, '') ?></span>
                </button>
              </li>
              <li class="nav-item" role="presentation">
              <button class="nav-link text-dark text-muted" id="weekly-tab" data-bs-toggle="tab" data-bs-target="#weekly"
                  type="button" role="tab" aria-controls="weekly" aria-selected="false">
                  Weekly View <span class="badge bg-dark ms-2"><?php getRecordCount($conn, 'week') ?></span>
              </button>
              </li>
              <li class="nav-item" role="presentation">
              <button class="nav-link text-dark text-muted" id="monthly-tab" data-bs-toggle="tab" data-bs-target="#monthly"
                  type="button" role="tab" aria-controls="monthly" aria-selected="false">
                  Monthly View <span class="badge bg-dark ms-2"><?php getRecordCount($conn, 'month') ?></span>
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
                            <input type="date" id="filterDate" class="form-control">
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
                          <?php displayReport($conn); ?>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="weekly" role="tabpanel" aria-labelledby="weekly-tab">
                    <div class="card">
                      <div class="card-header">
                        <div class="datatable-toolbar d-flex justify-content-between">
                          <div class="d-flex align-items-center gap-2">
                            <input type="text" id="customSearch" class="form-control" placeholder="Search appointments...">
                            <div class="d-flex gap-2">
                              <input type="date" id="filterWeek" class="form-control">
                            </div>
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
                          <?php displayReport($conn); ?>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="monthly" role="tabpanel" aria-labelledby="monthly-tab">
                    <div class="card">
                      <div class="card-header">
                        <div class="datatable-toolbar d-flex justify-content-between">
                          <div class="d-flex align-items-center gap-2">
                            <input type="text" id="customSearch" class="form-control" placeholder="Search appointments...">
                            <div class="d-flex gap-2">
                              <input type="date" id="filterMonth" class="form-control">
                            </div>
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
                          <?php displayReport($conn); ?>
                        </table>
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
<script src="../../assets/js/custom-table.js"></script>