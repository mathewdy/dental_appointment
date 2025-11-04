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
                            <input type="text" id="customSearch1" class="form-control" placeholder="Search appointments...">
                            <input type="date" id="filterDate" class="form-control">
                          </div>
                          <div class="d-flex align-items-center">
                            <label class="me-2 mb-0">Show</label>
                            <select id="customLength1" class="form-select form-select-sm w-auto">
                              <option value="10">10</option>
                              <option value="25" selected>25</option>
                              <option value="50">50</option>
                            </select>
                            <label class="ms-2 mb-0">entries</label>
                          </div>
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="table-responsive">
                          <table id="table1" class="table table-striped">
                            <?php displayReport($conn); ?>
                          </table>
                        </div>
                        
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="weekly" role="tabpanel" aria-labelledby="weekly-tab">
                    <div class="card">
                      <div class="card-header">
                        <div class="datatable-toolbar d-flex justify-content-between">
                          <div class="d-flex align-items-center gap-2">
                            <input type="text" id="customSearch2" class="form-control" placeholder="Search appointments...">
                            <div class="d-flex gap-2">
                              <input type="date" id="filterWeek" class="form-control">
                            </div>
                          </div>
                          <div class="d-flex align-items-center">
                            <label class="me-2 mb-0">Show</label>
                            <select id="customLength2" class="form-select form-select-sm w-auto">
                              <option value="10">10</option>
                              <option value="25" selected>25</option>
                              <option value="50">50</option>
                            </select>
                            <label class="ms-2 mb-0">entries</label>
                          </div>
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="table-responsive">
                          <table id="table2" class="table table-striped">
                            <?php displayReport($conn); ?>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="monthly" role="tabpanel" aria-labelledby="monthly-tab">
                    <div class="card">
                      <div class="card-header">
                        <div class="datatable-toolbar d-flex justify-content-between">
                          <div class="d-flex align-items-center gap-2">
                            <input type="text" id="customSearch3" class="form-control" placeholder="Search appointments...">
                            <div class="d-flex gap-2">
                              <input type="date" id="filterMonth" class="form-control">
                            </div>
                          </div>
                          <div class="d-flex align-items-center">
                            <label class="me-2 mb-0">Show</label>
                            <select id="customLength3" class="form-select form-select-sm w-auto">
                              <option value="10">10</option>
                              <option value="25" selected>25</option>
                              <option value="50">50</option>
                            </select>
                            <label class="ms-2 mb-0">entries</label>
                          </div>
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="table-responsive">
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
</div>
<?php 
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/scripts.php'); 
?>
<script>
    $(document).ready(function () {
    var today = new Date().toISOString().split('T')[0];
    $('#filterDate').val(today).trigger('keyup');

    var table = $('#table1').DataTable({
      dom: 't<"bottom"ip>',
      info: true,
      language: { 
        emptyTable: `
        <div class="container">
          <div class="row text-center my-4 gap-4">
            <div class="col-lg-12">
              <i class="fas fa-calendar display-1 text-muted"></i>
              <p class="h4 fw-bold m-0 p-0">No Appointments today </p>
              <p class="h5 text-muted m-0 p-0">You have a clear schedule for today </p>
            </div>
            <div class="col-lg-12">
              <a href="appointments.php" class="btn btn-primary rounded">Schedule Appointment</a>
            </div>
          </div>
        </div>` 
      }
    });
    var table2 = $('#table2').DataTable({
      dom: 't<"bottom"ip>',
      info: true,
      language: { 
        emptyTable: `
        <div class="container">
          <div class="row text-center my-4 gap-4">
            <div class="col-lg-12">
              <i class="fas fa-calendar display-1 text-muted"></i>
              <p class="h4 fw-bold m-0 p-0">No Appointments this week </p>
              <p class="h5 text-muted m-0 p-0">You have a clear schedule for this week </p>
            </div>
            <div class="col-lg-12">
              <a href="appointments.php" class="btn btn-primary rounded">Schedule Appointment</a>
            </div>
          </div>
        </div>` 
      }
    });
    var table3 = $('#table3').DataTable({
      dom: 't<"bottom"ip>',
      info: true,
      language: { 
        emptyTable: `
        <div class="container">
          <div class="row text-center my-4 gap-4">
            <div class="col-lg-12">
              <i class="fas fa-calendar display-1 text-muted"></i>
              <p class="h4 fw-bold m-0 p-0">No Appointments this month </p>
              <p class="h5 text-muted m-0 p-0">You have a clear schedule for this month </p>
            </div>
            <div class="col-lg-12">
              <a href="appointments.php" class="btn btn-primary rounded">Schedule Appointment</a>
            </div>
          </div>
        </div>` 
      }
    });

    var bottom1 = $('#table1_wrapper .bottom');
    bottom1.addClass('row align-items-center mt-2');
    bottom1.find('.dataTables_info').addClass('col-md-6 mb-2 mb-md-0');
    bottom1.find('.dataTables_paginate').addClass('col-md-6 text-md-end');

    var bottom2 = $('#table2_wrapper .bottom');
    bottom2.addClass('row align-items-center mt-2');
    bottom2.find('.dataTables_info').addClass('col-md-6 mb-2 mb-md-0');
    bottom2.find('.dataTables_paginate').addClass('col-md-6 text-md-end');

    var bottom3 = $('#table3_wrapper .bottom');
    bottom3.addClass('row align-items-center mt-2');
    bottom3.find('.dataTables_info').addClass('col-md-6 mb-2 mb-md-0');
    bottom3.find('.dataTables_paginate').addClass('col-md-6 text-md-end');

    function addDailyFilter(tableSelector, dateSelector) {
      var table = $(tableSelector).DataTable();

      $.fn.dataTable.ext.search = $.fn.dataTable.ext.search.filter(
        f => !f._for || f._for !== tableSelector + '-daily'
      );

      const dailyFilter = function (settings, data, dataIndex) {
        if (settings.nTable.id !== tableSelector.replace('#', '')) return true;

        var selectedDate = $(dateSelector).val();
        if (!selectedDate) return true;

        var rowDate = data[0]?.trim();
        if (!rowDate) return true;

        var parts = rowDate.split('/');
        var formattedRowDate = `${parts[2]}-${parts[0].padStart(2, '0')}-${parts[1].padStart(2, '0')}`;

        return formattedRowDate === selectedDate;
      };

      dailyFilter._for = tableSelector + '-daily';
      $.fn.dataTable.ext.search.push(dailyFilter);

      $(dateSelector).on('change keyup', function () {
        table.draw();
      });

      var today = new Date().toISOString().split('T')[0];
      $(dateSelector).val(today);
      table.draw();
    }
    function addWeeklyFilter(tableSelector, dateSelector) {
      var table = $(tableSelector).DataTable();

      $.fn.dataTable.ext.search = $.fn.dataTable.ext.search.filter(
        f => !f._for || f._for !== tableSelector + '-weekly'
      );

      const weeklyFilter = function (settings, data, dataIndex) {
        if (settings.nTable.id !== tableSelector.replace('#', '')) return true;

        var selectedDate = $(dateSelector).val();
        if (!selectedDate) return true;

        var rowDate = data[0]?.trim();
        if (!rowDate) return true;

        var parts = rowDate.split('/');
        var recordDate = new Date(parts[2], parts[0] - 1, parts[1]);
        var selected = new Date(selectedDate);

        var dayOfWeek = selected.getDay();
        var diffToMonday = (dayOfWeek === 0 ? -6 : 1) - dayOfWeek;

        var weekStart = new Date(selected);
        weekStart.setDate(selected.getDate() + diffToMonday);
        weekStart.setHours(0, 0, 0, 0);

        var weekEnd = new Date(weekStart);
        weekEnd.setDate(weekStart.getDate() + 6);
        weekEnd.setHours(23, 59, 59, 999);

        return recordDate >= weekStart && recordDate <= weekEnd;
      };

      weeklyFilter._for = tableSelector + '-weekly';
      $.fn.dataTable.ext.search.push(weeklyFilter);

      $(dateSelector).on('change keyup', function () {
        table.draw();
      });

      var today = new Date().toISOString().split('T')[0];
      $(dateSelector).val(today);
      table.draw();
    }
    function addMonthlyFilter(tableSelector, dateSelector) {
      var table = $(tableSelector).DataTable();

      $.fn.dataTable.ext.search = $.fn.dataTable.ext.search.filter(
        f => !f._for || f._for !== tableSelector + '-monthly'
      );

      const monthlyFilter = function (settings, data, dataIndex) {
        if (settings.nTable.id !== tableSelector.replace('#', '')) return true;

        var selectedDate = $(dateSelector).val();
        if (!selectedDate) return true;

        var rowDate = data[0]?.trim();
        if (!rowDate) return true;

        var parts = rowDate.split('/');
        var recordDate = new Date(parts[2], parts[0] - 1, parts[1]);
        var selected = new Date(selectedDate);

        return (
          recordDate.getFullYear() === selected.getFullYear() &&
          recordDate.getMonth() === selected.getMonth()
        );
      };

      monthlyFilter._for = tableSelector + '-monthly';
      $.fn.dataTable.ext.search.push(monthlyFilter);

      $(dateSelector).on('change keyup', function () {
        table.draw();
      });

      var today = new Date().toISOString().split('T')[0];
      $(dateSelector).val(today);
      table.draw();
    }

    addDailyFilter('#table1', '#filterDate');
    addWeeklyFilter('#table2', '#filterWeek');
    addMonthlyFilter('#table3', '#filterMonth')

    $('#customSearch1').on('keyup', function () {
      table.search(this.value).draw();
    });
    
    $('#customLength1').on('change', function () {
      table.page.len($(this).val()).draw();
    });

    $('#customSearch2').on('keyup', function () {
      table2.search(this.value).draw();
    });

    $('#customLength2').on('change', function () {
      table2.page.len($(this).val()).draw();
    });

    $('#customSearch3').on('keyup', function () {
      table3.search(this.value).draw();
    });

    $('#customLength3').on('change', function () {
      table3.page.len($(this).val()).draw();
    });
  });
 </script>