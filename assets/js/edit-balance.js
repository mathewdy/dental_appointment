$(document).ready(function() {
  $('.edit-balance').on('click', function(){
    var id = $(this).data('id')
    $.ajax({
      url: "../../includes/payments/edit-balance.php",
      type: "POST",
      data: { id: id},
      success: function(res){
        $('.editForm').html(res)
      }
    })
  })
})
