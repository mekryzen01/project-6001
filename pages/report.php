<?php include('../components/header.php'); ?>


<div class="wrapper">
    <?php include('../components/Siderbar.php'); ?>
    <div class="content-wrapper">
        <?php include('../components/Navbar.php'); ?>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <h2 class="m-0">Report</h2>
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Report </li>
                    </ol>
                </div>
            </div>
            <a href=""></a>
        </div>
        <div class="content">
            <div class="row justify-content-center">
                <div class="col-12 col-md-4 col-lg-4">
                    <label for="">โครงการ :</label>
                    <select name="projectreport" class="form-select" id="projectreport">
                        <option value="">Select Project </option>
                    </select>
                </div>
            </div>
            <div class="row justify-content-center mt-2">
                <div class="col-12 col-md-2 col-lg-2">
                    <div class="text-center">
                        <div class="" id="showpdf"></div>
                    </div>
                </div>
                <div class="col-12 col-md-2 col-lg-2">
                    <div class="text-center">
                        <div class="" id="showexcel"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // เมื่อเลือกค่าใน <select>
    $("#projectreport").change(function() {
        let projectID = $(this).val(); // รับค่า projectID จาก <select>

        // อัปเดตปุ่ม "Export PDF"
        $("#showpdf").html(
            `<form action="./reportpdf" method="post">
        <input type="hidden" name="projectID" value="${projectID}">
        <button type="submit" class="btn btn-primary">Export PDF</button>
        </form>`
        );

        // อัปเดตปุ่ม "Export Excel"
        $("#showexcel").html(
            `<form action="./reportexcel" method="post">
        <input type="hidden" name="projectID" value="${projectID}">
        <button type="submit" class="btn btn-success">Export Excel</button>
        </form>`
        );
    });
</script>
<script>
    if (localStorage.getItem("emp_position") != 0 && localStorage.getItem("emp_id") == null) {
        localStorage.clear()
        window.location.href = '../index'
    }
</script>
<?php include('../components/footer.php') ?>