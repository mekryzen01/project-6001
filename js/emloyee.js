$(document).ready(function () {
    fetchData("get_employee");
    fetchData("get_employeebyid", { emp_id: localStorage.getItem("emp_id") });
});

function fetchData(funcName, data = {}) {
    $.ajax({
        type: "POST",
        url: "../servers/function",
        data: { function: funcName, ...data },
        success: function (response) {
            let result = JSON.parse(response);
            console.log(result);
            if (funcName === "get_employee") {
                // Handle employee data
            } else if (funcName === "get_employeebyid") {
                // Handle employeebyid data
            }
        },
        error: function (error) {
            console.error("Error fetching data:", error);
        }
    });
}