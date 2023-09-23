<?php include('../components/header.php'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6 col-lg-3">
            <label for="">Name :</label>
            <input type="text" name="name" id="" class="form-control">
        </div>
        <div class="col-12 col-md-6 col-lg-3">
            <label for="">Sername :</label>
            <input type="text" name="sername" id="" class="form-control">
        </div>
        <div class="col-12 col-md-6 col-lg-3">
            <label for="">Address :</label>
            <input type="text" name="Address" id="" class="form-control">
        </div>
    </div>
    <div class="row justify-content-center mt-3">
        <div class="col-12 col-md-6 col-lg-3">
            <label for="">Province :</label>
            <select id="province" name="selectprovince" class="form-select">
                <option value="">Select Province</option>
            </select>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
            <label for="">Amphur :</label>
            <select id="amphur" name="selectamphur" class="form-select">
                <option value="">Select Amphur</option>
            </select>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
            <label for="">District :</label>
            <select id="district" name="selectdistrict" class="form-select">
                <option value="">Select District</option>
            </select>
        </div>
    </div>
    <div class="row justify-content-center mt-2">
        <div class="col-12 col-md-6 col-lg-4">
            <label for="">Zipcode :</label>
            <input type="text" name="zipcode" id="zipcode" readonly="readonly" class="form-control">
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
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
    //check email
    // function isValidEmail(email) {
    //     const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    //     return emailPattern.test(email);
    // }

    // const emailInput = document.getElementById('emailcheck');
    // const emailErrorMessage = document.getElementById('email-error-message');

    // emailInput.addEventListener('input', function() {
    //     const emailValue = emailInput.value;

    //     if (isValidEmail(emailValue)) {
    //         emailErrorMessage.textContent = 'Valid email format.';
    //     } else {
    //         emailErrorMessage.textContent = 'Invalid email format.';
    //     }
    // });
    //
    // check password
    // function isValidPassword(password, minLength = 8) {
    //     // ตรวจสอบความยาว
    //     if (password.length < minLength) return false;
    //     // ตรวจสอบตัวเลข
    //     if (!/[0-9]/.test(password)) return false;
    //     // ตรวจสอบตัวใหญ่
    //     if (!/[A-Z]/.test(password)) return false;
    //     // ตรวจสอบอักษรพิเศษ
    //     if (!/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/.test(password)) return false;

    //     return true;
    // }
    // const paswordInput = document.getElementById('paswordcheck');
    // const paswordErrorMessage = document.getElementById('pasword-error-message');

    // paswordInput.addEventListener('input', function() {
    //     const paswordValue = paswordInput.value;

    //     if (isValidPassword(paswordValue)) {
    //         paswordErrorMessage.textContent = 'Valid pasword format.';
    //     } else {
    //         paswordErrorMessage.textContent = 'Invalid pasword format.';
    //     }
    // });
    //
    //check PhoneNumber
    // function isValidPhoneNumber(phoneNumber) {
    //     var regex = /^\d{10}$/;
    //     return regex.test(phoneNumber);
    // }
    // const phoneInput = document.getElementById('phonecheck'); // Replace with your actual input ID
    // const phoneErrorMessage = document.getElementById('phone-error-message'); // Replace with your error message element

    // phoneInput.addEventListener('input', function() {
    //     const phoneValue = phoneInput.value;

    //     if (isValidPhoneNumber(phoneValue)) {
    //         phoneErrorMessage.textContent = 'Valid phone number format.';
    //     } else {
    //         phoneErrorMessage.textContent = 'Invalid phone number format. Please enter 10 digits.';
    //     }
    // });
    //
</script>

<?php include('../components/footer.php'); ?>