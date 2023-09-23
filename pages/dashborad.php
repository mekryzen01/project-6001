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
                    <h2 class="m-0">Dashboard</h2>
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard </li>
                    </ol>
                </div>
            </div>
            <a href=""></a>
        </div>
        <div class="content">
            <div class="row justify-content-center">
                <div class="col-12 col-md-4 col-lg-3">
                    <div class="card ds border-dark card-pink">
                        <div class="card-body ds">
                            <div>
                                <h3 id="countproject"></h3>
                                <b>Project</b>
                            </div>
                            <div class="card-icon">
                                <h1 style="font-size: 60px;"><i class="fa-solid fa-book-open"></i></h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 col-lg-3">
                    <div class="card ds border-dark card-green">
                        <div class="card-body ds">
                            <div>
                                <h3 id="status2"></h3>
                                <b>Success</b>
                            </div>
                            <div class="card-icon">
                                <h1 style="font-size: 60px;"><i class="fa-regular fa-circle-check"></i></h1>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 col-lg-3">
                    <div class="card ds border-dark card-yellow">
                        <div class="card-body ds">
                            <div>
                                <h3 id="status1"></h3>
                                <b>in progress</b>
                            </div>
                            <div class="card-icon">
                                <h1 style="font-size: 60px;"><i class="fa-solid fa-spinner"></i></h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 col-lg-3">
                    <div class="card ds border-dark card-grey">
                        <div class="card-body ds">
                            <div>
                                <h3 id="countproject"></h3>
                                <b>Total cost</b>
                            </div>
                            <div class="card-icon">
                                <h1 style="font-size: 60px;"><i class="fa-solid fa-dollar-sign"></i></h1>
                            </div>
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