//employee.js
$(document).ready(function () {
    fetchData("get_employee");
    fetchData("get_employeebyid", { emp_id: localStorage.getItem("emp_id") });



    function fetchData(funcName, data = {}) {
        $.ajax({
            type: "POST",
            url: "../servers/function",
            data: { function: funcName, ...data },
            success: function (dataincome) {
                // console.log(dataincome);
                let res = JSON.parse(dataincome);
                if (funcName === "get_employee") {
                    // Handle employee data
                } else if (funcName === "get_employeebyid") {
                    // Handle employeebyid data
                    $('#show_image').attr('src', res[0].imageuser).show();
                    $('#imageUser').attr('src', res[0].imageuser).show();
                    $('#nameusershow').html(res[0].emp_name);
                    $('#sernameshow').html(res[0].emp_sername);
                    $('#Addressuser').html(res[0].emp_address);
                    $('#provinceuser').html(res[0].emp_province);
                    $('#amphuruser').html(res[0].emp_aumpher);
                    $('#districtuser').html(res[0].emp_tumbon);
                    $('#zipcodeuser').html(res[0].emp_post);
                    $('#emailshow').html(res[0].emp_email)
                    $('.showprofile').click(function () {
                        editempModal();
                        $('#uploaded_image_edit').attr('src', res[0].imageuser).show();
                        $('#nameuser').val(res[0].emp_name);
                        $('#sername').val(res[0].emp_sername);
                    });
                    $('#updatedatapersonal').click(function () {
                        var newImageFile = $("#imageedit")[0].files[0];
                        var newnameuser = $("#nameuser").val()
                        var newsername = $("#sername").val()
                        var formData = new FormData();
                        formData.append('function', 'Update_personal_emp');
                        formData.append('emp_id', localStorage.getItem("emp_id"));
                        formData.append('newimage', newImageFile);
                        formData.append('newnameuser', newnameuser);
                        formData.append('newsername', newsername);
                       
                        $.ajax({
                            type: "POST",
                            url: "../servers/function",
                            processData: false, // ไม่ต้องประมวลผลข้อมูล
                            contentType: false, // ไม่ต้องตั้งค่า content type ใน header
                            data: formData,
                            success: function (respons) {
                                let res = JSON.parse(respons);
                                if (res.status == 200) {
                                    Swal.fire('Success!', 'Update data user', 'success').then(() => {
                                        window.location.reload();
                                    });
                                } else {
                                    Swal.fire('Error!', 'There was an error update your data.', 'error');
                                }
                            },
                            error: function (error) {
                                Swal.fire('Error!', 'There was an error update your data.', 'error');
                            }
                        });

                        $('#showprofile').modal('hide');
                    })
                    // คลิกเพื่อแสดงโมดัลแก้ไขที่อยู่
                    $('.editaddressemp').click(function () {
                        editAddressModal();
                        $('#Address').val(res[0].emp_address);
                        $('#province').val(res[0].emp_province);
                        $('#amphur').val(res[0].emp_aumpher);
                        $('#district').val(res[0].emp_tumbon);
                        $('#zipcode').val(res[0].emp_post);
                    });

                    // คลิกเพื่อบันทึกการแก้ไขที่อยู่
                    $('#updatedataAddress').click(function () {
                        var newAddress = $('#Address').val();
                        var newprovince = $('#province').val();
                        var newamphur = $('#amphur').val();
                        var newdistrict = $('#district').val();
                        var zipcode = $('#zipcode').val();

                        $.ajax({
                            type: "POST",
                            url: "../servers/function",
                            data: {
                                function: "Update_address_emp",
                                emp_id: localStorage.getItem("emp_id"),
                                newAddress: newAddress,
                                newprovince: newprovince,
                                newamphur: newamphur,
                                newdistrict: newdistrict,
                                zipcode: zipcode
                            },
                            success: function (respons) {
                                let res = JSON.parse(respons);
                                if (res.status == 200) {
                                    Swal.fire('Success!', 'Update data user', 'success').then(() => {
                                        window.location.reload();
                                    });
                                } else {
                                    Swal.fire('Error!', 'There was an error update your data.', 'error');
                                }
                            },
                            error: function (error) {
                                Swal.fire('Error!', 'There was an error update your data.', 'error');
                            }
                        });

                        $('#editaddressemp').modal('hide');
                    });

                    $('.editusers').click(function () {
                        editUserModal();
                        $('#emailuser').val(res[0].emp_email)
                    });
                    $('#updatedatauser').click(function () {
                        var newemail = $('#emailuser').val()
                        var newpass = $('#passworduser').val()
                        $.ajax({
                            type: "POST",
                            url: "../servers/function",
                            data: {
                                function: "Update_user_emp",
                                emp_id: localStorage.getItem("emp_id"),
                                email_emp: newemail,
                                password_emp: newpass

                            },
                            success: function (respons) {
                                let res = JSON.parse(respons)
                                if (res.status == 200) {
                                    Swal.fire('Success!', 'Update data user', 'success').then(() => {
                                        window.location.reload()
                                    });
                                } else {
                                    Swal.fire('Error!', 'There was an error update your data.', 'error');
                                }

                            },
                            error: function (error) {
                                Swal.fire('Error!', 'There was an error update your data.', 'error');
                            }

                        })
                        $('#editusers').modal('hide');
                    })
                }
            },
            error: function (error) {
                console.error("Error fetching data:", error);
            }
        });
    }
});
function editempModal() {
    $('#editempModal').modal('show')
}
function editAddressModal() {
    $('#editAddressModal').modal('show')
}
function editUserModal() {
    $('#editUserModal').modal('show')
}

