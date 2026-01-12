<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/Users/dentists.php');

$first_name = $_SESSION['first_name'];

?>

<div class="wrapper">
    <?php include '../../includes/sidebar.php'; ?>
    <div class="main-panel">
        <?php include '../../includes/topbar.php'; ?>
        <div class="container">
            <div class="page-inner">
                <div class="page-header">
                    <div class="d-flex align-items-center gap-4 w-100">
                        <h4 class="page-title text-truncate">Dentists</h4>
                        <div class="d-flex align-items-center gap-2 me-auto">
                            <div class="nav-home">
                                <a href="dashboard.php" class="text-decoration-none text-muted">
                                    <i class="icon-home"></i>
                                </a>
                            </div>
                            <div class="separator">
                                <i class="icon-arrow-right fs-bold"></i>
                            </div>
                            <div class="nav-item">
                                <a href="#" class="text-decoration-none text-truncate text-muted">Dentists</a>
                            </div>
                        </div>
                        <a href="add-dentist.php" class="btn btn-sm btn-dark op-7 d-none d-md-block">Add New Dentist</a>
                    </div>
                </div>
                <div class="page-category">
                    <div class="text-end mb-2">
                        <a href="add-dentist.php" class="btn btn-sm btn-dark op-7 d-block d-md-none">Add New Dentist</a>
                    </div>
                    <div class="card py-3">
                        <div class="table-responsive">
                            <table id="dataTable" class="display table table-striped table-hover table-responsive">
                                <thead>
                                    <tr>
                                        <!--<th>Id</th>-->
                                        <th>Name</th>
                                        <th>Schedule</th>
                                        <th>Email</th>
                                        <th>Contact Number</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $run_dentists = getAllDentist($conn, "3");
                                    if (mysqli_num_rows($run_dentists) > 0) {
                                        foreach ($run_dentists as $row_dentist) {
                                            ?>
                                            <tr>
                                                <!--<td><?php echo $row_dentist['user_id'] ?></td>-->
                                                <td class="text-truncate">
                                                    <?php echo $row_dentist['first_name'] . " " . $row_dentist['middle_name'] . " " . $row_dentist['last_name'] ?>
                                                </td>
                                                <td>
                                                    <div class="text-truncate">
                                                        <?php echo formatDentistScheduleDisplay($conn, $row_dentist['user_id']); ?>
                                                    </div>
                                                </td>
                                                <td><?php echo $row_dentist['email'] ?></td>
                                                <td><?php echo $row_dentist['mobile_number'] ?></td>
                                                <td>
                                                    <div class="d-flex justify-content-center align-items-center">
                                                        <a class="text-info h4 mx-2"
                                                            href="edit-dentist.php?user_id=<?php echo $row_dentist['user_id'] ?>"
                                                            class="dropdown-item"><i class="fas fa-edit"></i></a>
                                                        <a class="text-danger h4 delete"
                                                            href="delete-dentist.php?user_id=<?php echo $row_dentist['user_id'] ?>"
                                                            class="dropdown-item delete-btn"><i class="fas fa-trash"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/scripts.php');
?>
<script>
    $(document).ready(function () {
        $('.delete').on('click', function (e) {
            e.preventDefault();
            confirmBeforeRedirect("Do you want to delete this dentist?", $(this).attr('href'))
        });
    });
</script>