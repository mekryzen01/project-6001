<?php include('../header.php');
include('../components/Siderbar.php'); ?>


<script>
    if (localStorage.getItem("emp_position") != 1 && localStorage.getItem("emp_id") == null) {
        localStorage.clear()
        window.location.href = '../'
    }
</script>
<?php include('../footer.php') ?>