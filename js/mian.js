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
});


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


