<?php
$projectid = "";
$projectname = "";
if (isset($_POST['detail'])) {
    $projectid = $_POST['projectID'];
    $projectname = $_POST['projectname'];
}
include('../components/header.php');
?>
<div class="wrapper">
    <?php include('../components/Siderbar.php'); ?>
    <div class="content-wrapper">
        <?php include('../components/Navbar.php'); ?>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <h2 class="m-0">Project <?php echo $projectname ?></h2>
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Project </li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="card project mb-3">
                <div class="card-header">
                    <h3>รายละเอียด</h3>
                </div>
                <div class="card-body project">
                    <div class="box">
                        <div class="title">ข้อมูลโครงการ</div>
                        <div class="content-box">
                            <div class="row justify-content-center">
                                <div class="col-12 col-md-3 col-lg-3">
                                    <label for=""><b>รหัสโครงการ</b></label>
                                    <p id="projectid"></p>

                                </div>
                                <div class="col-12 col-md-3 col-lg-3">
                                    <label for=""><b>ชื่อโครงการ :</b></label>
                                    <p id="nameproject"></p>
                                </div>
                                <div class="col-12 col-md-3 col-lg-3">
                                    <label for=""><b>วันที่เริ่มโครงการ :</b></label>
                                    <p id="startp"></p>
                                </div>
                                <div class="col-12 col-md-3 col-lg-3">
                                    <label for=""><b>วันที่สิ้นสุดโครงการ :</b></label>
                                    <p id="endp"></p>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-12 col-md-3 col-lg-3">
                                    <label for=""><b>เจ้าของโครงการ :</b></label>
                                    <p id="customerp"></p>
                                </div>
                                <div class="col-12 col-md-3 col-lg-3">
                                    <label for=""><b>ผู้ดูแลโครงการ :</b></label>
                                    <p id="empp"></p>
                                </div>
                                <div class="col-12 col-md-3 col-lg-3">
                                    <label for=""><b>มูลค่าโครงการ :</b></label>
                                    <p id="projectvalue"></p>
                                </div>
                                <div class="col-12 col-md-3 col-lg-3">
                                    <label for=""><b>สถานะโครงการ :</b></label>
                                    <p id="statusbyid"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box mt-3">
                        <div class="title">ข้อมูลค่าใช้จ่ายโครงการ</div>
                        <div class="content-box">
                            <button type="button" class="btn btn-primary mb-2" onclick="showModalprojectcost()">เพิ่มค่าใช้จ่าย</button>
                            <input type="hidden" name="pid" id="pid">
                            <table id="datadesc" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>รหัสสินค้า</th>
                                        <th>รายการสินค้า</th>
                                        <th>หน่วยนับ</th>
                                        <th>จำนวน</th>
                                        <th>ราคา/หน่วย</th>
                                        <th>จำนวนเงิน</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- ข้อมูลจากฐานข้อมูล -->
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="5" style="text-align:right">รวมมูลค่าสินค้า:</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">

            </div>
        </div>







        <!-- Modal -->
        <div class="modal fade" id="insertprojectcostModal" tabindex="-1" aria-labelledby="insertprojectcostModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="insertprojectcostModalLabel">บันทึกค่าใช้จ่าย</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="insertprojectcostForm">
                            <div class="box">
                                <div class="title">บันทึกค่าใช้จ่ายโครงการ</div>
                                <div class="content-box">
                                    <div class="row">
                                        <div class="col-12 col-md-12 col-lg-12">
                                            <label for="">วันที่บันทึก :</label>
                                            <input type="date" class="form-control" id="today" readonly="readonly">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <label for="">รหัสโครงการ :</label>
                                            <input type="text" class="form-control" id="insertprojectid" readonly="readonly">
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <label for="">ชื่อโครงการ :</label>
                                            <input type="text" class="form-control" id="insertprojectname" readonly="readonly">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-12 col-lg-12">
                                            <label for="">เจ้าของโครงการ :</label>
                                            <input type="text" class="form-control" id="empname" readonly="readonly">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box mt-2">
                                <div class="title">รายการสินค้า</div>
                                <div class="content-box">
                                    <div class="addproducts"></div>
                                    <div class="row justify-content-center mt-2">
                                        <div class="col-12 col-md-4 col-lg-4">
                                            <div class="text-center">
                                                <button class="add_fields btn btn-primary" style="font-size: 16px;">เพิ่มสินค้า</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="savereportData">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end Modal -->
    </div>
</div>

<script>
    if (localStorage.getItem("emp_position") != 0 && localStorage.getItem("emp_id") == null) {
        localStorage.clear()
        window.location.href = '../index'
    }
</script>
<?php include('../components/footer.php') ?>