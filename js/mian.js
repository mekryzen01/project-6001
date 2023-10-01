document.addEventListener("DOMContentLoaded", function () {
    const submenuToggles = document.querySelectorAll('[data-bs-toggle="collapse"]');

    submenuToggles.forEach(submenuToggle => {
        submenuToggle.addEventListener('click', function () {
            const submenuIcon = this.querySelector('.fas');
            submenuIcon.classList.toggle('fa-chevron-down');
            submenuIcon.classList.toggle('fa-chevron-up');
        });
    });
});

const fullname = localStorage.getItem("fullname")
$("#fullname").html(fullname)
$("#fullnameNav").html(fullname)



$(document).ready(function () {
    $('#toggleSidebar').click(function () {
        $('.sidebar').toggleClass('sidebar-collapsed');
        $('.content-wrapper').toggleClass('content-expanded');
    });
      //ดึง จังหวัด
      $.ajax({
        url: '../servers/function',
        type: 'POST',
        data: {
            function: "get_provinces"
        },
        success: function(data) {
            $('#province').append(data);
        }
    });
    //ดึง อำเภอ
    $('#province').change(function() {
        var provinceId = $(this).val();

        $.ajax({
            url: '../servers/function',
            type: 'POST',
            data: {
                function: "get_amphures",
                provinceId: provinceId
            },
            success: function(data) {
                $('#amphur').html('<option value="">Select Amphur</option>').append(data);
            }
        });
    });
    //ดึง ตำบล 
    $('#amphur').change(function() {
        var amphurId = $(this).val();
        $.ajax({
            url: '../servers/function',
            type: 'POST',
            data: {
                function: "get_districts",
                amphurId: amphurId
            },
            success: function(data) {
                $('#district').html('<option value="">Select District</option>').append(data);
            }
        });
    });
    //ดึง zipcode ผ่าน data attribute
    $('#district').change(function() {
        var selectedDistrict = $(this).find('option:selected');
        var zipcode = selectedDistrict.data('zipcode'); // รับค่า zipcode จาก data attribute
        // แสดง zipcode ใน <input> 
        $('#zipcode').val(zipcode);
    });

});
window.addEventListener('beforeunload', function (e) {
    localStorage.removeItem('ProjectID');
});

// window.addEventListener('beforeunload', function (e) {
//     localStorage.removeItem('emp_id');
//     localStorage.removeItem('emp_position');
//     localStorage.removeItem('fullname');
// });

function displayImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#uploaded_image').attr('src', e.target.result).show();
        }
        reader.readAsDataURL(input.files[0]);
    }
}



function Logout() {
    Swal.fire({
        icon: 'question',
        title: 'Logout',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            localStorage.clear()
            window.location.href = "../"
        }

    });

}


