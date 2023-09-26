$(document).ready(function () {
    // Variables

    // Fetch Data
    fetchData("get_projectbyempid", { emp_id: localStorage.getItem("emp_id") });
    fetchData("get_project_status1", { emp_id: localStorage.getItem("emp_id") });
    fetchData("get_project_status2", { emp_id: localStorage.getItem("emp_id") });
    fetchData("get_stock");
    // fetchData("get_customer");
    fetchData("get_desc", { projectID: localStorage.getItem("ProjectID") });

    // Event Listeners
    $(add_button).click(function (e) {
        e.preventDefault();
        addField();
    });

    $(wrapper).on("click", ".remove_field", function (e) {
        e.preventDefault();
        $(this).parent('div').remove();
        p--;
        x--;
    });

    $(document).on('click', '.btn-edit', function () {
        const productId = $(this).data('id');
        editProduct(productId);
    });

    $(document).on('click', '.btn-deletepd', function () {
        const productId = $(this).data('id');
        deleteProduct(productId);
    });

    $(document).on('click', '.btn-delete', function () {
        const projectId = $(this).data('id');
        deleteProject(projectId);
    });

    $('.btn-primary').click(function () {
        showModalproject();
    });
    $.ajax({
        url: '../servers/function',
        type: 'POST',
        data: {
            function: "get_customer"
        },
        success: function (data) {
            $('#Custormer').append(data);
        }
    });
    $('#saveprojectData').click(function () {
        const ProjectName = $('#ProjectName').val();
        const projectStart = $('#projectStart').val();
        const projectclose = $('#projectclose').val();
        const Custormer = $('#Custormer').val();
        const Projectvalue = $('#Projectvalue').val();
        const status = 1;
        const emp_id = localStorage.getItem("emp_id")

        $.ajax({
            type: "POST",
            url: "../servers/function",
            data: {
                function: "insert_project",
                ProjectName: ProjectName,
                projectStart: projectStart,
                projectclose: projectclose,
                Custormer: Custormer,
                Projectvalue: Projectvalue,
                status: status,
                emp_id: emp_id
            },
            success: function (response) {
                // Handle success response
                Swal.fire('Success!', 'Your product has been added.', 'success').then(() => {
                    window.location.reload()
                });
            },
            error: function (error) {
                Swal.fire('Error!', 'There was an error adding your product.', 'error');
            }
        });
        $('#insertprojectModal').modal('hide');
    });

    $('#savereportData').click(function () {
        let addIdValues = [];
        $('input[name="add_id[]"]').each(function () {
            addIdValues.push($(this).val());
        });

        let productNames = [];
        $('select[name="product_name[]"]').each(function () {
            productNames.push($(this).val());
        });

        let productValues = [];
        $('input[name="product_value[]"]').each(function () {
            productValues.push($(this).val());
        });

        let productCosts = [];
        $('input[name="product_cost[]"]').each(function () {
            productCosts.push($(this).val());
        });

        const today = $('#today').val();
        const insertprojectid = $('#insertprojectid').val();
        const insertprojectname = $('#insertprojectname').val();
        const empname = $('#empname').val();
        let productTotal = productValues.map((value, index) => value * productCosts[index]);

        // console.log(today,
        //     insertprojectid,
        //     insertprojectname,
        //     empname,
        //     addIdValues, productNames, productValues, productTotal);
        $.ajax({
            type: "POST",
            url: "../servers/function",
            data: {
                function: "insert_reportcost",
                today: today,
                insertprojectid: insertprojectid,
                insertprojectname: insertprojectname,
                empname: empname,
                addIdValues: addIdValues,
                productNames: productNames,
                productValues: productValues,
                productTotal: productTotal,
                productCosts: productCosts
            },
            success: function (response) {
                let res = JSON.parse(response)
                if (res.status == 200) {
                    Swal.fire('Success!', 'Your product has been added.', 'success').then(() => {
                        window.location.reload()
                    });
                }
            },
            error: function (error) {
                Swal.fire('Error!', 'There was an error adding your product.', 'error');
            }
        });
        $('#insertprojectcostModal').modal('hide');
    });
    const today = new Date();
    const formattedDate = today.toISOString().split('T')[0];
    $('#today').val(formattedDate);
    // Functions


    // ... ฟังก์ชันอื่น ๆ ของคุณ ...

});
function showModalprojectcost() {
    $('#insertprojectcostModal').modal('show');
}
function showModalproject() {
    $('#insertprojectModal').modal('show');
}

function fetchData(funcName, data = {}) {
    $.ajax({
        type: "POST",
        url: "../servers/function",
        data: { function: funcName, ...data },
        success: function (response) {
            let result = JSON.parse(response);
            // console.log(result);
            if (funcName === "get_projectbyempid") {
                // console.log(result[0].countdata);
                if (result && result.length > 0 && result.countdata != null) {
                    $('#countproject').html(result.countdata);
                } else {
                    $('#countproject').html(0);
                }
                $('#project-table').DataTable({
                    data: result,
                    responsive: true,
                    columns: [{
                        data: 'project_id'
                    },
                    {
                        data: 'project_name'
                    },
                    {
                        data: 'project_start'
                    },
                    {
                        data: 'project_end'
                    },
                    // {
                    //     data: 'cus_id'
                    // },
                    {
                        data: 'project_status',
                        createdCell: function (td, cellData, rowData, row, col) {
                            if (cellData == "อยู่ระหว่างดำเนินการ") {
                                $(td).addClass('status1');
                            } else if (cellData == "ปิดโครงการ") {
                                $(td).addClass('status2');
                            } else if (cellData == "ยกเลิก") {
                                $(td).addClass('status3');
                            }
                        }
                    },
                    {
                        data: null,
                        render: function (data, type, row) {
                            return `
                            <form action="../pages/projectid" method="post">
                                <input type="hidden" name="projectID" value="${data.project_id}">
                                <input type="hidden" name="projectname" value="${data.project_name}">
                                <button type="submit" name="detail" class="btn btn-primary btn-detail">detail</button>
                            </form>`;
                        }
                    },
                    ]
                });
               
               
            } else if (funcName === "get_project_status1") {
                if (result[0] != null) {
                    $('#status1').html(result[0].countdata)
                } else {
                    $('#status1').html(0)
                }
            } else if (funcName === "get_project_status2") {
                if (result[0] != null) {
                    $('#status2').html(result[0].countdata)
                } else {
                    $('#status2').html(0)
                }
            } else if (funcName === "get_stock") {
                $('#stock-table').DataTable({
                    data: result,
                    responsive: true,
                    columns: [{
                        data: 'product_id'
                    },
                    {
                        data: 'product_name'
                    },
                    {
                        data: 'product_counting'
                    },
                    {
                        data: 'product_cost'
                    },
                    {
                        data: null,
                        render: function (data, type, row) {
                            return `<button class="btn btn-primary btn-edit" data-id="${data.product_id}">Edit</button>`;
                        }
                    },
                    {
                        data: null,
                        render: function (data, type, row) {
                            return `<button class="btn btn-danger btn-deletepd" data-id="${data.product_id}">Delete</button>`;
                        }
                    }
                    ]
                });
            } else if (funcName === "get_desc") {
                $('#datadesc').DataTable({
                    data: result,
                    columns: [
                        { data: 'product_id' },
                        { data: 'product_name' },
                        { data: 'product_counting' },
                        { data: 'desc_unit' },
                        {
                            data: 'product_cost',
                            render: $.fn.dataTable.render.number(',', '.', 2)
                        },
                        {
                            data: 'desc_value',
                            render: $.fn.dataTable.render.number(',', '.', 2)
                        }
                    ],
                    "paging": true,
                    "ordering": true,
                    "info": true,
                    "responsive": true,
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Thai.json"
                    },
                    "footerCallback": function (row, data, start, end, display) {
                        var api = this.api(), data;
                        var total = api
                            .column(5)
                            .data()
                            .reduce(function (a, b) {
                                return parseFloat(a.toString().replace(/,/g, '')) + parseFloat(b.toString().replace(/,/g, ''));
                            }, 0);

                        $(api.column(5).footer()).html(total.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
                    }
                });
            }
        },
        error: function (error) {
            console.error("Error fetching data:", error);
        }
    });

}
const wrapper = $(".addproducts");
const add_button = $(".add_fields");
let x = 1;
let p = 1;

function addField() {
    x++;
    $.ajax({
        type: "POST",
        url: '../servers/function',
        data: {
            function: "get_stock_option"
        },
        success: function (response) {
            $(wrapper).append(`
            <div class="row justify-content-center mt-5">
                <div class="col-12 col-md-12 col-lg-12">
                    <input type="hidden" name="add_id[]" id="add_id[]" value="0" />
                    <div class="row">
                        <div class="col-12 col-md-4 col-lg-4">
                            <label>ชื่อสินค้า :</label>
                            <select name="product_name[]" id="product_name[]" class="form-select product-name-select">
                                <option value="">Select Product</option>
                                ${response}
                            </select>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <label>จำนวน :</label>
                            <input type="text" name="product_value[]" id="product_value[]" class="form-control" >
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <label>ราคา/หน่วย :</label>
                            <input type="text" name="product_cost[]" id="product_cost[]" class="product-cost form-control" placeholder="" />
                        </div>
                    </div>
                    <div class="mt-2"></div>
                    <a href="javascript:void(0);" class="btn btn-primary remove_field">ลบ</a>
                </div>
            </div>
        `);
            $(wrapper).find('.product-name-select').last().change(function () {
                var selectedOption = $(this).find('option:selected');
                var cost = selectedOption.data('cost');
                $(this).closest('.row').find('.product-cost').val(cost);
            });
        },
        error: function (xhr, status, error) {
            console.error(xhr, status, error);
        }
    });

}

function editProduct(productId) {
    $.ajax({
        type: "POST",
        url: "../servers/function",
        data: {
            function: "get_stockByid",
            product_id: productId
        },
        success: function (response) {
            const productDetails = JSON.parse(response);
            // 2. แสดง SweetAlert2 modal พร้อมกับข้อมูลเดิม
            console.log(productDetails);
            Swal.fire({
                title: 'Edit Product',
                html: `
                <input type="text" id="productName" class="swal2-input" placeholder="Product Name" value="${productDetails[0].product_name}">
                <input type="text" id="productCounting" class="swal2-input" placeholder="Product Counting" value="${productDetails[0].product_counting}">
                <input type="text" id="productValue" class="swal2-input" placeholder="Product Value" value="${productDetails[0].product_cost}">
            `,
                confirmButtonText: 'Save',
                focusConfirm: false,
                preConfirm: () => {
                    const productName = Swal.getPopup().querySelector('#productName').value;
                    const productCounting = Swal.getPopup().querySelector('#productCounting').value;
                    const productValue = Swal.getPopup().querySelector('#productValue').value;
                    if (!productName || !productCounting || !productValue) {
                        Swal.showValidationMessage(`Please enter all fields`);
                    }
                    return {
                        productName: productName,
                        productCounting: productCounting,
                        productValue: productValue
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "../servers/function",
                        data: {
                            function: "edit_product",
                            product_id: productId,
                            product_name: result.value.productName,
                            product_counting: result.value.productCounting,
                            product_cost: result.value.productValue
                        },
                        success: function (response) {
                            Swal.fire('Updated!', 'Your product has been updated.', 'success').then(() => {
                                window.location.reload()
                            });
                        },
                        error: function (error) {
                            Swal.fire('Error!', 'There was an error updating your product.', 'error');
                        }
                    });
                }
            });
        },
        error: function (error) {
            Swal.fire('Error!', 'There was an error fetching product details.', 'error');
        }
    });
}

function deleteProduct(productId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "../servers/function",
                data: {
                    function: "delete_product",
                    product_id: productId
                },
                success: function (response) {
                    let res = JSON.parse(response)
                    if (res.status == 200) {
                        Swal.fire('Deleted!', 'Your product has been deleted.', 'success').then(() => {
                            window.location.reload()
                        });
                    }

                },
                error: function (error) {
                    Swal.fire('Error!', 'There was an error deleting your product.', 'error');
                }
            });
        }
    });
}
