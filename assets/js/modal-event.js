$(document).ready(function() {
  $('tbody').on('click', '#confirmBtn', function() {
      var dataId = $(this).data("id");
      var appointmentDate = $(this).data("date");
      var concern = $(this).data("concern");

      $("#patient_id").val(dataId); 
      $("#appointment").val(appointmentDate);  
      $("#modal-concern").val(concern);

      $('#doctorRemarks').modal('show');
  });

});