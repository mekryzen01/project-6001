<?php include("../components/header.php"); ?>

<div class="wrapper">
    <?php include('../components/Siderbar.php'); ?>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <?php include('../components/Navbar.php'); ?>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <h2 class="m-0">Stock</h2>
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="./dashborad">Home</a></li>
                        <li class="breadcrumb-item active">Stock </li>
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
                <table id="stock-table" class="display responsive nowrap" width="100%">
                    <thead>
                        <tr>
                            <th>product_id</th>
                            <th>product_name</th>
                            <th>product_counting</th>
                            <th>product_cost</th>
                            <th>edit</th>
                            <th>delete</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="insertModal" tabindex="-1" aria-labelledby="insertModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="insertModalLabel">Add New Data</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="insertForm">
                                <div class="mb-3">
                                    <label for="productName" class="form-label">Product Name</label>
                                    <input type="text" class="form-control" id="productName" required>
                                </div>
                                <div class="mb-3">
                                    <label for="productCounting" class="form-label">Product Counting</label>
                                    <input type="text" class="form-control" id="productCounting" required>
                                </div>
                                <div class="mb-3">
                                    <label for="productValue" class="form-label">Product Value</label>
                                    <input type="text" class="form-control" id="productValue" required>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="saveData">Save</button>
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
<?php include("../components/footer.php"); ?>