<!-- pages/dashborad.php -->
<?php include('../components/header.php'); ?>


<div class="wrapper">
    <?php include('../components/Siderbar.php'); ?>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <?php include('../components/Navbar.php'); ?>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <h2 class="m-0">Project</h2>
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Project </li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="row justify-content-end my-3">
                <div class="col-4 col-md-2 col-lg-2">
                    <div class="text-end">
                        <button class="btn btn-primary form-control"><i class="fa-solid fa-plus"></i>Add</button>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table id="project-table" class="display responsive nowrap" width="100%">
                    <thead>
                        <tr>
                            <th>project_id</th>
                            <th>project_name</th>
                            <th>project_start</th>
                            <th>project_end</th>
                            <!-- <th>cus_id</th> -->
                            <th>project_status</th>
                            <th></th>
                            <!-- <th></th>
                            <th></th> -->
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="insertprojectModal" tabindex="-1" aria-labelledby="insertprojectModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="insertprojectModalLabel">Add New Project</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="insertprojectForm">
                                <div class="mb-3">
                                    <label for="ProjectName" class="form-label">Project Name :</label>
                                    <input type="text" class="form-control" id="ProjectName" required>
                                </div>
                                <div class="mb-3">
                                    <label for="Projectvalue" class="form-label">Project Value :</label>
                                    <input type="text" class="form-control" id="Projectvalue" required>
                                </div>
                                <div class="mb-3">
                                    <label for="projectStart" class="form-label">Project Start :</label>
                                    <input type="date" class="form-control" id="projectStart" required>
                                </div>
                                <div class="mb-3">
                                    <label for="projectclose" class="form-label">Project Close :</label>
                                    <input type="date" class="form-control" id="projectclose" required>
                                </div>
                                <div class="mb-3">
                                    <label for="Custormer" class="form-label">Custormer :</label>
                                    <select name="Custormer" id="Custormer" class="form-select">
                                        <option value="">Select Customer</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="saveprojectData">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    if (localStorage.getItem("emp_position") != 0 && localStorage.getItem("emp_id") == null) {
        localStorage.clear()
        window.location.href = '../index'
    }
</script>
<?php include('../components/footer.php') ?>