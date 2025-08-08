$(document).ready(function() {
  $('.payment-history').on('click', function(){
    var id = $(this).data('id')
    console.log(id)

    $.ajax({
      url: "../../includes/payments/payment-history.php",
      type: "POST",
      data: { id: id },
      success: function(res){
          $('.payment-list').html(res)
      }
    })
  })
})
