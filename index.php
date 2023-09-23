<?php include('./header.php');
?>
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="text-center">
            <!-- <h1>Login</h1> -->
            <h1>Project management system</h1>
        </div>
    </div>
    <!-- <form action="./servers/checklogin" method="post"> -->
    <div class="row justify-content-center mt-3">
        <div class="col-12 col-md-6 col-lg-4">
            <label for="">Email :</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
                <input type="email" class="form-control" name="email" id="emailcheck" placeholder="Email" aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <div class="email-error-message" id="email-error-message"></div>
        </div>
    </div>
    <div class="row justify-content-center mt-2">
        <div class="col-12 col-md-6 col-lg-4">
            <label for="">Password :</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon2"><i class="fas fa-key"></i></span>
                <input type="password" class="form-control" id="paswordcheck" name="password" placeholder="Password" aria-label="Password" aria-describedby="basic-addon2">
            </div>
            <div class="password-error-message" id="password-error-message"></div>
        </div>
    </div>
    <div class="row justify-content-center mt-2">
        <div class="col-6 col-md-6 col-lg-4">
            <div class="text-center">
                <input type="submit" name="Login" id="Login" value="Login" class="btn btn-success">
            </div>
        </div>
    </div>
    <!-- </form> -->
    <div class="text-center my-3">
        <span class="border-top w-25 d-inline-block"></span>
        <span class="px-2">or</span>
        <span class="border-top w-25 d-inline-block"></span>
    </div>

</div>

<script>
    $(document).ready(function() {

        $('#Login').on('click', function() {
            $("#Login").attr("disabled", "disabled");
            var email = $("#emailcheck").val()
            var password = $("#paswordcheck").val()
            if (email != "" && password != "") {
                $.ajax({
                    url: "./servers/function",
                    type: "POST",
                    data: {
                        function: "check_login",
                        email: email,
                        password: password,
                    },
                    cache: false,
                    success: function(dataResult) {
                        var dataResult = JSON.parse(dataResult);
                        if (dataResult.statusCode == 200) {
                            const actions = {
                                0: './pages/dashborad.php',
                                1: './admin/dashbroad'
                            };
                            if (actions.hasOwnProperty(dataResult.emp_position)) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Login Success'
                                }).then(function() {
                                    localStorage.setItem("emp_id", dataResult.emp_id);
                                    localStorage.setItem("fullname", dataResult.fullname);
                                    localStorage.setItem("emp_position", dataResult.emp_position);
                                    window.location.href = actions[dataResult.emp_position];
                                });
                            }
                        } else if (dataResult.statusCode == 201) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Login Error'
                            }).then(function() {
                                window.location.reload()
                            });
                        }
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Login Error'
                }).then(function() {
                    window.location.reload()
                });
            }
        });
    });

    function isValidEmail(email) {
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailPattern.test(email);
    }

    const emailInput = document.getElementById('emailcheck');
    const emailErrorMessage = document.getElementById('email-error-message');

    emailInput.addEventListener('input', function() {
        const emailValue = emailInput.value;

        if (isValidEmail(emailValue)) {
            emailErrorMessage.textContent = 'Valid email format.';
            emailErrorMessage.classList.remove('invalid');
            emailErrorMessage.classList.add('valid');
        } else {
            emailErrorMessage.textContent = 'Invalid email format.';
            emailErrorMessage.classList.remove('valid');
            emailErrorMessage.classList.add('invalid');
        }
    });

    function isValidPassword(password, minLength = 8) {
        // ตรวจสอบความยาว
        if (password.length < minLength) return false;
        // ตรวจสอบตัวเลข
        if (!/[0-9]/.test(password)) return false;
        // ตรวจสอบตัวใหญ่
        if (!/[A-Z]/.test(password)) return false;
        // ตรวจสอบอักษรพิเศษ
        if (!/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/.test(password)) return false;

        return true;
    }
    const paswordInput = document.getElementById('paswordcheck');
    const paswordErrorMessage = document.getElementById('password-error-message');

    paswordInput.addEventListener('input', function() {
        const paswordValue = paswordInput.value;

        if (isValidPassword(paswordValue)) {
            paswordErrorMessage.textContent = 'Valid pasword format.';
            paswordErrorMessage.classList.remove('invalid');
            paswordErrorMessage.classList.add('valid');
        } else {
            paswordErrorMessage.textContent = 'Invalid pasword format.';
            paswordErrorMessage.classList.remove('valid');
            paswordErrorMessage.classList.add('invalid');
        }
    });
</script>



<?php include('./footer.php'); ?>