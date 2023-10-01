//employee.js
$(document).ready(function () {
    fetchData("get_employee");
    fetchData("get_employeebyid", { emp_id: localStorage.getItem("emp_id") });


    $('.showprofile').click(function () {
        showModalprofile();
    });
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

                    // console.log(res);
                    $('#show_image').attr('src', res[0].imageuser).show();
                    $('#nameusershow').html(res[0].emp_name);
                    $('#sernameshow').html(res[0].emp_sername);
                    $('#Addressuser').html(res[0].emp_address);
                    $('#provinceuser').html(res[0].emp_province);
                    $('#amphuruser').html(res[0].emp_aumpher);
                    $('#districtuser').html(res[0].emp_tumbon);
                    $('#zipcodeuser').html(res[0].emp_post);
                    $('#emailshow').html(res[0].emp_email);

                }
            },
            error: function (error) {
                console.error("Error fetching data:", error);
            }
        });
    }
});
function showModalprofile() {
    $('#editempModal').modal('show')
}
