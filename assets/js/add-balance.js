$(document).ready(function() {
  $('.add-balance').on('click', function(){
    var id = $(this).data('id')
    $.ajax({
      url: "../../includes/payments/payment.php",
      type: "POST",
      data: { id: id },
      success: function(res){
        $('.addForm').html(res)
      }
    })
  })
})
