<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/modules/queries/Reports/reports.php');

$first_name = $_SESSION['first_name'];
$id = $_SESSION['user_id'];

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
                  <a href="dashboard.php">
                      <i class="icon-home"></i>
                  </a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
              </ul>
            </span>    
          </span>
        </div>
        <div class="page-category">
          <div class="row mb-4">
            <div class="col-lg-12">
              <p class="h2 m-0 p-0">Hello <?= $first_name ?></p>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6">
              <div class="card">
                <div class="card-header">
                  <h2 class="h4 fw-bold m-0 p-0">Today's Appointments</h2>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="table1" class="table table-bordered">
                      <?php displayReportById($conn, $id); ?>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="card">
                <div class="card-header">
                  <h2 class="h4 fw-bold m-0 p-0">Upcoming Appointments</h2>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="table2" class="table table-bordered">
                      <?php displayReportById($conn, $id); ?>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="card">
                <div class="card-header">
                  <h2 class="h4 fw-bold m-0 p-0">Monthly Summary Status</h2>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="table2" class="table table-bordered">
                      <?php getMonthlyReport($conn, $id); ?>
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
      dom: 't',
      info: true
    });
    var table2 = $('#table2').DataTable({
      dom: 't',
      info: true
    });
    var table3 = $('#table3').DataTable({
      dom: 't<"bottom"ip>',
      info: true,
    });

    
    function addDailyFilter(tableSelector) {
      var table = $(tableSelector).DataTable();

      $.fn.dataTable.ext.search = $.fn.dataTable.ext.search.filter(
        f => !f._for || f._for !== tableSelector + '-daily'
      );

      const dailyFilter = function (settings, data, dataIndex) {
        if (settings.nTable.id !== tableSelector.replace('#', '')) return true;

        var rowDate = data[0]?.trim();
        if (!rowDate) return true;

        var parts = rowDate.split('/');
        var formattedRowDate = `${parts[2]}-${parts[0].padStart(2, '0')}-${parts[1].padStart(2, '0')}`;

        var today = new Date().toISOString().split('T')[0];

        return formattedRowDate === today;
      };

      dailyFilter._for = tableSelector + '-daily';
      $.fn.dataTable.ext.search.push(dailyFilter);

      table.draw();
    }

    function addUpcomingFilter(tableSelector) {
      var table = $(tableSelector).DataTable();

      $.fn.dataTable.ext.search = $.fn.dataTable.ext.search.filter(
        f => !f._for || f._for !== tableSelector + '-upcoming'
      );

      const upcomingFilter = function (settings, data, dataIndex) {
        if (settings.nTable.id !== tableSelector.replace('#', '')) return true;

        var rowDate = data[0]?.trim();
        if (!rowDate) return true;

        var parts = rowDate.split('/');
        var recordDate = new Date(parts[2], parts[0] - 1, parts[1]);
        recordDate.setHours(0, 0, 0, 0);

        var today = new Date();
        today.setHours(0, 0, 0, 0);

        return recordDate > today;
      };

      upcomingFilter._for = tableSelector + '-upcoming';
      $.fn.dataTable.ext.search.push(upcomingFilter);

      table.draw();
    }

    addDailyFilter('#table1');
    addUpcomingFilter('#table2');
  });
 </script>