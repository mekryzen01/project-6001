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

            <div class="row mt-2">
                <div class="box mt-3">
                    <div class="title">ข้อมูลส่วนตัว</div>
                    <div class="content-box">
                        <div class="row">
                            <div class="text-end">
                                <button type="button" class="btn btn-primary showprofile">
                                    แก้ไข
                                </button>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-4 col-lg-4">
                                <img id="show_image" class="show_image" src="" alt="Selected Image" style="display:none; width: 100%; height: 100%;  ">
                            </div>
                        </div>
                        <div class="row justify-content-center mt-2">
                            <div class="col-12 col-md-4 col-lg-4">
                                <label for="">ชื่อ :</label>
                                <p id="nameusershow" class="nameusershow"></p>
                            </div>
                            <div class="col-12 col-md-4 col-lg-4">
                                <label for="">นามสกุล :</label>
                                <p id="sernameshow" class="sernameshow"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box mt-3">
                    <div class="title">ข้อมูลที่อยู่</div>
                    <div class="content-box">
                        <div class="row">
                            <div class="text-end">
                                <button type="button" class="btn btn-primary editaddressemp">
                                    แก้ไข
                                </button>
                            </div>
                        </div>
                        <div class="row justify-content-center mt-2">
                            <div class="col-12 col-md-8 col-lg-8">
                                <label for="">ที่อยู่ :</label>
                                <p id="Addressuser" class="Addressuser"></p>
                            </div>
                        </div>
                        <div class="row justify-content-center mt-2">
                            <div class="col-12 col-md-4 col-lg-4">
                                <label for="">Province :</label>
                                <p id="provinceuser" class="provinceuser"> </p>
                            </div>
                            <div class="col-12 col-md-4 col-lg-4">
                                <label for="">Amphur :</label>
                                <p id="amphuruser" class="amphuruser"></p>
                            </div>
                        </div>
                        <div class="row justify-content-center mt-2">
                            <div class="col-12 col-md-4 col-lg-4">
                                <label for="">District :</label>
                                <p id="districtuser" class="districtuser"></p>
                            </div>
                            <div class="col-12 col-md-4 col-lg-4">
                                <label for="">Zipcode :</label>
                                <p id="zipcodeuser" class="zipcodeuser"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box mt-3">
                    <div class="title">ข้อมูลผู้ใช้</div>
                    <div class="content-box">
                        <div class="row">
                            <div class="text-end">
                                <button type="button" class="btn btn-primary editusers">
                                    แก้ไข
                                </button>
                            </div>
                        </div>
                        <div class="row justify-content-center mt-2">
                            <div class="col-12 col-md-8 col-lg-8">
                                <label for="">email :</label>
                                <p id="emailshow" class="emailshow"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-5"></div>

            </div>
            <div class="modal" id="editempModal" tabindex="-1" aria-labelledby="editempModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">ข้อมูลส่วนตัว</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="box mt-3">
                                <div class="title">ข้อมูลส่วนตัว</div>
                                <div class="content-box">
                                    <div class="row justify-content-center">
                                        <div class="col-12 col-md-12 col-lg-12">
                                            <img id="uploaded_image_edit" src="#" alt="Selected Image" style="display:none; width: 75%; height: 75%;  ">
                                            <label for="">รูปภาพ :</label>
                                            <input type="file" id="imageedit" onchange="displayImage(this)" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row justify-content-center mt-2">
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <label for="">ชื่อ :</label>
                                            <input type="text" name="nameuser" id="nameuser" class="form-control">
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <label for="">นามสกุล :</label>
                                            <input type="text" name="sername" id="sername" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="updatedatapersonal">Save</button>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal" id="editAddressModal" tabindex="-1" aria-labelledby="editAddressModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">ข้อมูลส่วนตัว</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="box mt-3">
                                <div class="title">ข้อมูลที่อยู่</div>
                                <div class="content-box">
                                    <div class="row justify-content-center mt-2">
                                        <div class="col-12 col-md-12 col-lg-12">
                                            <label for="">ที่อยู่ :</label>
                                            <input type="text" name="Address" id="Address" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row justify-content-center mt-2">
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <label for="">Province :</label>
                                            <select id="province" name="selectprovince" class="form-select">
                                                <option value="">Select Province</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <label for="">Amphur :</label>
                                            <select id="amphur" name="selectamphur" class="form-select">
                                                <option value="">Select Amphur</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center mt-2">
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <label for="">District :</label>
                                            <select id="district" name="selectdistrict" class="form-select">
                                                <option value="">Select District</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <label for="">Zipcode :</label>
                                            <input type="text" name="zipcode" id="zipcode" readonly="readonly" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="updatedataAddress">Save</button>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">ข้อมูลส่วนตัว</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="box mt-3">
                                <div class="title">ข้อมูลผู้ใช้</div>
                                <div class="content-box">
                                    <div class="row justify-content-center mt-2">
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <label for="">email :</label>
                                            <input type="email" name="emailuser" id="emailuser" class="form-control">
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <label for="passworduser">Password:</label>
                                            <input type="password" name="passworduser" id="passworduser" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="updatedatauser">Save</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- Button to Open the Modal -->


        <!-- The Modal -->


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