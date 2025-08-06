$(document).ready(function(){
    initPasswordToggles();
})

function initPasswordToggles() {
  $('.pw-toggle').on('click', function () {
    const $icon = $(this).find('i');
    const targetSelector = $(this).data('target');
    const $password = $(targetSelector);
    const isPassword = $password.attr('type') === 'password';

    $password.attr('type', isPassword ? 'text' : 'password');
    $icon.toggleClass('fa-eye fa-eye-slash');

  });
}