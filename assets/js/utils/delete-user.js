$('.delete-btn').on('click', function(e) {
  e.preventDefault();
  const link = $(this).attr('href');

  confirmDelete("Are you sure you want to delete this user?", function() {
    window.location.href = link;
  });
});