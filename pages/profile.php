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
                    <h2 class="m-0">Profile</h2>
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content">
          
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