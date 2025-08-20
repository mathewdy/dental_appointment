$(document).ready(function() {
  $('.payment-history').on('click', function(){
    var id = $(this).data('id')
    var appointment = $(this).data('appointment')

    $.ajax({
      url: "../../includes/payments/payment-history.php",
      type: "POST",
      data: { id: id, appointment: appointment},
      success: function(res){
          $('.payment-list').html(res)

          console.log(appointment)
      }
    })
  })
})
