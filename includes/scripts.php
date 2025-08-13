<?php 
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/config.php');
$userId = $_SESSION['user_id'] ?? null;

echo '
  <script src="' . BASE_PATH . '/assets/js/core/jquery-3.7.1.min.js"></script>
  <script src="' . BASE_PATH . '/assets/js/core/popper.min.js"></script>
  <script src="' . BASE_PATH . '/assets/js/core/bootstrap.min.js"></script>
  <script src="' . BASE_PATH . '/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
  <script src="' . BASE_PATH . '/assets/js/plugin/chart.js/chart.min.js"></script>
  <script src="' . BASE_PATH . '/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>
  <script src="' . BASE_PATH . '/assets/js/plugin/chart-circle/circles.min.js"></script>
  <script src="' . BASE_PATH . '/assets/js/plugin/datatables/datatables.min.js"></script>
  <script src="' . BASE_PATH . '/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>
  <script src="' . BASE_PATH . '/assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
  <script src="' . BASE_PATH . '/assets/js/plugin/jsvectormap/world.js"></script>
  <script src="' . BASE_PATH . '/assets/js/plugin/sweetalert/sweetalert.min.js"></script>
  <script src="' . BASE_PATH . '/assets/js/kaiadmin.min.js"></script>
  <script src="' . BASE_PATH . '/assets/js/pw-visibility.js"></script>
';
if(!empty($userId)){
  echo '
  <script src="' . BASE_PATH . '/assets/js/datatable-init.js"></script>
  <script src="' . BASE_PATH . '/libs/fullcalendar/index.global.js"></script>
  <script src="' . BASE_PATH . '/assets/js/events.js"></script>
  <script src="' . BASE_PATH . '/assets/js/modal-event.js"></script>
  <script src="' . BASE_PATH . '/assets/js/notification.js"></script>
  <script src="' . BASE_PATH . '/assets/js/add-balance.js"></script>
  <script src="' . BASE_PATH . '/assets/js/edit-balance.js"></script>
  <script src="' . BASE_PATH . '/assets/js/payment-history.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  ';
}

echo '
</body>
</html>
';
?>