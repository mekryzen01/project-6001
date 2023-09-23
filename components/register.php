<?php include('../header.php'); ?>

<div class="row justify-content-center">
    <div class="col-12 col-md-6 col-lg-4">
        <label for="">Province :</label>
        <select id="province" class="form-select">
            <option value="">Select Province</option>
            <!-- Provinces will be populated here -->
        </select>
    </div>
    <div class="col-12 col-md-6 col-lg-4">
        <label for="">Amphur :</label>
        <select id="amphur" class="form-select">
            <option value="">Select Amphur</option>
            <!-- Amphurs will be populated based on selected province -->
        </select>
    </div>
    <div class="col-12 col-md-6 col-lg-4">
        <label for="">District :</label>
        <select id="district" class="form-select">
            <option value="">Select District</option>
            <!-- Districts will be populated based on selected amphur -->
        </select>
    </div>
</div>
<script>
    $(document).ready(function() {
        // Load provinces on page load
        $.ajax({
            url: '../servers/getProvinces',
            type: 'GET',
            success: function(data) {
                $('#province').append(data);
            }
        });

        // Load amphurs when a province is selected
        $('#province').change(function() {
            var provinceId = $(this).val();

            $.ajax({
                url: './servers/getAmphurs',
                type: 'GET',
                data: {
                    provinceId: provinceId
                },
                success: function(data) {
                    $('#amphur').html('<option value="">Select Amphur</option>').append(data);
                }
            });
        });

        // Load districts when an amphur is selected
        $('#amphur').change(function() {
            var amphurId = $(this).val();

            $.ajax({
                url: './servers/getDistricts',
                type: 'GET',
                data: {
                    amphurId: amphurId
                },
                success: function(data) {
                    $('#district').html('<option value="">Select District</option>').append(data);
                }
            });
        });
    });
</script>

<?php include('../footer.php'); ?>