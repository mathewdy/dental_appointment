$(document).ready(function() {
  $('.add-balance').on('click', function(){
    var id = $(this).data('id')
    var concern = $(this).data('concern')
    $.ajax({
      url: "../../includes/payments/payment.php",
      type: "POST",
      data: { id: id, concern: concern},
      success: function(res){
        $('.addForm').html(res)
      }
    })
  })
})
