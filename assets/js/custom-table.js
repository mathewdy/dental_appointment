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
    $('#table3').DataTable({
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