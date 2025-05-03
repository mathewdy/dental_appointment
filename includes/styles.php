<?php 
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/config.php');
echo '
<script src="' . BASE_PATH . '/assets/js/plugin/webfont/webfont.min.js"></script>
<script>
WebFont.load({
google: { families: ["Public Sans:300,400,500,600,700"] },
custom: {
    families: [
    "Font Awesome 5 Solid",
    "Font Awesome 5 Regular",
    "Font Awesome 5 Brands",
    "simple-line-icons",
    ],
    urls: ["' . BASE_PATH . '/assets/css/fonts.min.css"],
},
active: function () {
    sessionStorage.fonts = true;
},
});
</script>
<link rel="stylesheet" href="' . BASE_PATH . '/assets/css/bootstrap.min.css" />
<link rel="stylesheet" href="' . BASE_PATH . '/assets/css/plugins.min.css" />
<link rel="stylesheet" href="' . BASE_PATH . '/assets/css/kaiadmin.min.css" />
<link rel="stylesheet" href="' . BASE_PATH . '/assets/css/demo.css" />
'
?>