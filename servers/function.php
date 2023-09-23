<?php
include('connect.php');
function ConvertToThaiDate($value, $short = '1', $need_time = '1', $need_time_second = '0')
{
    $date_arr = explode(' ', $value);
    $date = $date_arr[0];
    if (isset($date_arr[1])) {
        $time = $date_arr[1];
    } else {
        $time = '';
    }

    $value = $date;
    if ($value != "0000-00-00" && $value != '') {
        $x = explode("-", $value);
        if ($short == false)
            $arrMM = array(1 => "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
        else
            $arrMM = array(1 => "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
        // return $x[2]." ".$arrMM[(int)$x[1]]." ".($x[0]>2500?$x[0]:$x[0]+543);
        if ($need_time == '1') {
            if ($need_time_second == '1') {
                $time_format = $time != '' ? date('H:i:s น.', strtotime($time)) : '';
            } else {
                $time_format = $time != '' ? date('H:i น.', strtotime($time)) : '';
            }
        } else {
            $time_format = '';
        }

        return (int)$x[2] . " " . $arrMM[(int)$x[1]] . " " . ($x[0] > 2500 ? $x[0] : $x[0] + 543) . " " . $time_format;
    } else
        return "";
}
// (central function) //
function generateNewId($db, $table)
{
    // 1. ดึงวันที่ปัจจุบัน
    $date = date("dmY"); // วันที่ปัจจุบันในรูปแบบ ddmmyyyy
    // 2. ดึงตัวเลขล่าสุดจากฐานข้อมูล
    $stmt = $db->query("SELECT MAX(product_id) as max_id FROM {$table} ");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $lastNumber = isset($result['max_id']) ? substr($result['max_id'], -4) : "0000"; // ดึงตัวเลขที่อยู่หลังวันที่
    // 3. เพิ่มตัวเลขทีละหนึ่ง
    $newNumber = str_pad((int)$lastNumber + 1, 4, '0', STR_PAD_LEFT); // ตัวเลขใหม่ที่เพิ่มขึ้นมา 1 และมี 4 หลัก
    // 4. รวมวันที่ปัจจุบันกับตัวเลขใหม่เพื่อสร้าง ID ใหม่
    $newId = $date . $newNumber;

    return $newId;
}
function generateNewProject($db, $table)
{
    // 1. ดึงวันที่ปัจจุบัน
    $date = date("dmY"); // วันที่ปัจจุบันในรูปแบบ ddmmyyyy
    // 2. ดึงตัวเลขล่าสุดจากฐานข้อมูล
    $stmt = $db->query("SELECT MAX(project_id) as max_id FROM {$table} WHERE project_id LIKE '{$date}%'");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $lastNumber = isset($result['max_id']) ? substr($result['max_id'], -4) : "0000"; // ดึงตัวเลขที่อยู่หลังวันที่
    // 3. เพิ่มตัวเลขทีละหนึ่ง
    $newNumber = str_pad((int)$lastNumber + 1, 4, '0', STR_PAD_LEFT); // ตัวเลขใหม่ที่เพิ่มขึ้นมา 1 และมี 4 หลัก
    // 4. รวมวันที่ปัจจุบันกับตัวเลขใหม่เพื่อสร้าง ID ใหม่
    $newId = $date . $newNumber;
    return $newId;
}
//ดึงข้อมูล ตาม id
function fetchData($db, $query, $paramName, $paramValue)
{
    $stmt = $db->prepare($query);
    $stmt->bindParam($paramName, $paramValue, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

//ดึงข้อมูลทั้งหมด
function fetchDataAll($db, $query)
{
    $stmt = $db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
//เพิ่มข้อมูล
function insertIntoDatabase($db, $table, $data)
{
    $fields = implode(", ", array_keys($data));
    $placeholders = ":" . implode(", :", array_keys($data));

    $sql = "INSERT INTO $table ($fields) VALUES ($placeholders)";

    try {
        $stmt = $db->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        if ($stmt->execute()) {
            return ['status' => 200, 'message' => 'Data inserted successfully.'];
        } else {
            return ['status' => 500, 'message' => 'Error inserting data.'];
        }
    } catch (PDOException $e) {
        return ['status' => 500, 'message' => 'Database error: ' . $e->getMessage()];
    }
}
// update stock where product_id
function updateProductInDatabase($db, $productId, $data)
{
    $setFields = [];
    foreach ($data as $key => $value) {
        $setFields[] = "$key = :$key";
    }
    $sql = "UPDATE stock SET " . implode(", ", $setFields) . " WHERE product_id = :product_id";

    try {
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':product_id', $productId, PDO::PARAM_INT);
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        if ($stmt->execute()) {
            return ['status' => 200, 'message' => 'Product updated successfully.'];
        } else {
            return ['status' => 500, 'message' => 'Error updating product.'];
        }
    } catch (PDOException $e) {
        return ['status' => 500, 'message' => 'Database error: ' . $e->getMessage()];
    }
}
// (central function) //
// ดึง project by emp_id      
if (isset($_POST['function']) && $_POST['function'] == 'get_projectbyid') {
    $empId = $_POST['emp_id'];
    $stm = $db->prepare("SELECT * FROM project WHERE emp_id = :emp_id");
    $stm->bindParam(':emp_id', $empId, PDO::PARAM_INT);
    $stm->execute();
    $projects = $stm->fetchAll(PDO::FETCH_ASSOC);
    $results = [];
    $countData = count($projects);


    foreach ($projects as $project) {
        $datacustomer = fetchData($db, "SELECT * FROM customer WHERE cus_id = :id", ':id', $project['cus_id']);
        $dataemployee = fetchData($db, "SELECT * FROM employee WHERE emp_id = :id", ':id', $project['emp_id']);

        // $datahd = fetchData($db, "SELECT * FROM projcost_hd WHERE project_id = :id", ':id', $project['project_id']);
        // $dataclose = fetchData($db, "SELECT * FROM project_close WHERE project_id = :id", ':id', $project['project_id']);
        // $datadesc = fetchData($db, "SELECT * FROM projcost_desc WHERE projcost_saveid = :id", ':id', $datahd['projcost_saveid']);
        if ($project['project_status'] == 1) {
            $statusname = "อยู่ระหว่างดำเนินการ";
        } elseif ($project['project_status'] == 2) {
            $statusname = "ปิดโครงการ";
        } else {
            $statusname = "ยกเลิก";
        }
        $projectValue = is_numeric($project['project_value']) ? number_format($project['project_value'], 2) : "0.00";
        $results[] = array(
            "project_id" => $project['project_id'],
            "project_name" => $project['project_name'],
            "cus_id" => $datacustomer['cus_name'] . " " . $datacustomer['cus_sername'],
            "project_start" => ConvertToThaiDate($project['project_start'], 0),
            "project_end" => ConvertToThaiDate($project['project_end'], 0),
            "project_value" => $projectValue,
            "project_status" => $statusname,
            "employee" => $dataemployee['emp_name'] . " " . $dataemployee['emp_sername'],
            "countdata" => $countData
        );
    }

    echo json_encode($results);
}
// ดึง project by emp_id  where 1    
if (isset($_POST['function']) && $_POST['function'] == 'get_project_status1') {
    $empId = $_POST['emp_id'];
    $stm = $db->prepare("SELECT * FROM project WHERE emp_id = :emp_id AND project_status = 1");
    $stm->bindParam(':emp_id', $empId, PDO::PARAM_INT);
    $stm->execute();
    $projects = $stm->fetchAll(PDO::FETCH_ASSOC);
    $results = [];
    $countData = count($projects);


    foreach ($projects as $project) {
        if ($project['project_status'] == 1) {
            $statusname = "อยู่ระหว่างดำเนินการ";
        } elseif ($project['project_status'] == 2) {
            $statusname = "ปิดโครงการ";
        } else {
            $statusname = "ยกเลิก";
        }
        $projectValue = is_numeric($project['project_value']) ? number_format($project['project_value'], 2) : "0.00";

        $results[] = array(
            "project_id" => $project['project_id'],
            "project_name" => $project['project_name'],
            "cus_id" => $project['cus_id'],
            "project_start" => ConvertToThaiDate($project['project_start']),
            "project_end" => ConvertToThaiDate($project['project_end']),
            "project_value" =>  $projectValue,
            "project_status" => $statusname,
            "countdata" => $countData
        );
    }

    echo json_encode($results);
}
// ดึง project by emp_id  where 2    
if (isset($_POST['function']) && $_POST['function'] == 'get_project_status2') {
    $empId = $_POST['emp_id'];
    $stm = $db->prepare("SELECT * FROM project WHERE emp_id = :emp_id AND project_status = 2");
    $stm->bindParam(':emp_id', $empId, PDO::PARAM_INT);
    $stm->execute();
    $projects = $stm->fetchAll(PDO::FETCH_ASSOC);
    $results = [];
    $countData = count($projects);


    foreach ($projects as $project) {
        if ($project['project_status'] == 1) {
            $statusname = "อยู่ระหว่างดำเนินการ";
        } elseif ($project['project_status'] == 2) {
            $statusname = "ปิดโครงการ";
        } else {
            $statusname = "ยกเลิก";
        }
        $projectValue = is_numeric($project['project_value']) ? number_format($project['project_value'], 2) : "0.00";
        $results[] = array(
            "project_id" => $project['project_id'],
            "project_name" => $project['project_name'],
            "cus_id" => $project['cus_id'],
            "project_start" => ConvertToThaiDate($project['project_start']),
            "project_end" => ConvertToThaiDate($project['project_end']),
            "project_value" =>  $projectValue,
            "project_status" => $statusname,
            "countdata" => $countData
        );
    }

    echo json_encode($results);
}
// ดึง จังหวัด
if (isset($_POST['function']) && $_POST['function'] == 'get_provinces') {
    $stmtprovince = $db->prepare('SELECT * FROM provinces ORDER BY province_id ASC');
    $stmtprovince->execute();
    while ($row = $stmtprovince->fetch(PDO::FETCH_ASSOC)) {
        echo "<option value='{$row['province_id']}'>{$row['name_th']}</option>";
    }
}
// ดึงอำเภอ
if (isset($_POST['function']) && $_POST['function'] == 'get_amphures') {
    $provinceId = $_POST['provinceId'];
    $stmtAmphur = $db->prepare('SELECT * FROM amphures WHERE province_id = :provinceId');
    $stmtAmphur->bindParam(':provinceId', $provinceId, PDO::PARAM_INT);
    $stmtAmphur->execute();
    while ($row = $stmtAmphur->fetch(PDO::FETCH_ASSOC)) {
        echo "<option value='{$row['amphure_id']}'>{$row['name_th']}</option>";
    }
}
// ดึงตำบล
if (isset($_POST['function']) && $_POST['function'] == 'get_districts') {
    $amphurId = $_POST['amphurId'];
    $stmtdistricts = $db->prepare('SELECT * FROM districts WHERE amphure_id = :amphurId');
    $stmtdistricts->bindParam(':amphurId', $amphurId, PDO::PARAM_INT);
    $stmtdistricts->execute();

    while ($row = $stmtdistricts->fetch(PDO::FETCH_ASSOC)) {
        echo "<option value='{$row['district_id']}' data-zipcode='{$row['zip_code']}'>{$row['name_th']}</option>";
    }
}
// ดึง customer
if (isset($_POST['function']) && $_POST['function'] == 'get_customer') {
    $stmtprovince = $db->prepare('SELECT * FROM customer ORDER BY cus_id ASC');
    $stmtprovince->execute();
    while ($row = $stmtprovince->fetch(PDO::FETCH_ASSOC)) {
        $fullname = $row['cus_name'] . " " . $row['cus_sername'];
        echo "<option value='{$row['cus_id']}'>{$fullname}</option>";
    }
}
// ดึง employee all
if (isset($_POST['function']) && $_POST['function'] == 'get_employee') {
    $stm = $db->prepare("SELECT * FROM employee");
    $stm->execute();
    $employees = $stm->fetchAll(PDO::FETCH_ASSOC);
    $results = [];
    $countData = count($employees);

    foreach ($employees as $employee) {
        $dataprovince = fetchData($db, "SELECT * FROM provinces WHERE province_id = :id", ':id', $employee['emp_province']);
        $dataamphure = fetchData($db, "SELECT * FROM amphures WHERE amphure_id = :id", ':id', $employee['emp_aumpher']);
        $datadistricts = fetchData($db, "SELECT * FROM districts WHERE district_id = :id", ':id', $employee['emp_tumbon']);
        $dataposition = fetchData($db, "SELECT * FROM employee_position WHERE position_id = :id", ':id', $employee['emp_position']);

        $statusname = ($employee['emp_status'] == 1) ? "เป็นพนักงาน" : "ลาออก";
        $results[] = array(
            "emp_id" => $employee['emp_id'],
            "fullname" => $employee['emp_name'] . "" . $employee['emp_sername'],
            "emp_address" => $employee['emp_address'],
            "emp_tumbon" => $datadistricts['name_th'],
            "emp_aumpher" => $dataamphure['name_th'],
            "emp_province" => $dataprovince['name_th'],
            "emp_post" => $datadistricts['zip_code'],
            "emp_phone" => $employee['emp_phone'],
            "emp_email" => $employee['emp_email'],
            "emp_startwork" => ConvertToThaiDate($employee['emp_startwork']),
            "emp_position" => $dataposition['position_name'],
            "emp_status" => $statusname,
            "countdata" => $countData
        );
    }

    echo json_encode($results);
}

if (isset($_POST['function']) && $_POST['function'] == 'get_employeebyid') {
    $emp_id = $_POST['emp_id'];
    $employeebyid = $db->prepare("SELECT * FROM employee WHERE emp_id = :id");
    $employeebyid->bindParam(":id", $emp_id, PDO::PARAM_INT);
    $employeebyid->execute();
    $dataempbyid = $employeebyid->fetchAll(PDO::FETCH_ASSOC);
    $results = [];
    $countData = count($dataempbyid);

    foreach ($dataempbyid as $employee) {
        $dataprovince = fetchData($db, "SELECT * FROM provinces WHERE province_id = :id", ':id', $employee['emp_province']);
        $dataamphure = fetchData($db, "SELECT * FROM amphures WHERE amphure_id = :id", ':id', $employee['emp_aumpher']);
        $datadistricts = fetchData($db, "SELECT * FROM districts WHERE district_id = :id", ':id', $employee['emp_tumbon']);
        $dataposition = fetchData($db, "SELECT * FROM employee_position WHERE position_id = :id", ':id', $employee['emp_position']);

        $statusname = ($employee['emp_status'] == 1) ? "เป็นพนักงาน" : "ลาออก";
        $results[] = array(
            "emp_id" => $employee['emp_id'],
            "fullname" => $employee['emp_name'] . "" . $employee['emp_sername'],
            "emp_address" => $employee['emp_address'],
            "emp_tumbon" => $datadistricts['name_th'],
            "emp_aumpher" => $dataamphure['name_th'],
            "emp_province" => $dataprovince['name_th'],
            "emp_post" => $datadistricts['zip_code'],
            "emp_phone" => $employee['emp_phone'],
            "emp_email" => $employee['emp_email'],
            "emp_startwork" => ConvertToThaiDate($employee['emp_startwork']),
            "emp_position" => $dataposition['position_name'],
            "emp_status" => $statusname,
            "countdata" => $countData
        );
    }

    echo json_encode($results);
}
if (isset($_POST['function']) && $_POST['function'] == 'get_stock') {
    $res = fetchDataAll($db, "SELECT * FROM stock");
    $results = [];
    foreach ($res as $data) {
        $results[] = array(
            "product_id" => $data['product_id'],
            "product_name" => $data['product_name'],
            "product_counting" => $data['product_counting'],
            "product_cost" => $data['product_cost'],
        );
    }
    echo json_encode($results);
}
if (isset($_POST['function']) && $_POST['function'] == 'get_stock_option') {
    $res = fetchDataAll($db, "SELECT * FROM stock");
    foreach ($res as $data) {
        echo "<option value='{$data['product_id']}' data-counting='{$data['product_counting']}' data-cost='{$data['product_cost']}'>{$data['product_name']}</option>";
    }
}
if (isset($_POST['function']) && $_POST['function'] == 'delete_product') {
    $productID = $_POST['product_id'];
    $stmt = $db->prepare("DELETE FROM stock WHERE product_id = :product_id");
    $stmt->bindParam(':product_id', $productID, PDO::PARAM_INT);
    $results = array();
    if ($stmt->execute()) {
        $results['status'] = 200;
    } else {
        $results['status'] = 201;
    }
    echo json_encode($results);
}
if (isset($_POST['function']) && $_POST['function'] == 'edit_product') {
    $productId = $_POST['product_id'];
    $productName = $_POST['product_name'];
    $productCounting = $_POST['product_counting'];
    $productValue = $_POST['product_cost'];

    $data = [
        'product_name' => $productName,
        'product_counting' => $productCounting,
        'product_cost' => $productValue
    ];

    $results = updateProductInDatabase($db, $productId, $data);
    echo json_encode($results);
}
if (isset($_POST['function']) && $_POST['function'] == 'insert_stock') {
    $productName  = $_POST['product_name'];
    $productCounting = $_POST['product_counting'];
    $productValue = $_POST['product_value'];
    $emp_id = $_POST['emp_id'];

    $data = [
        'product_id' => generateNewId($db, "stock"),
        'product_name' => $productName,
        'product_counting' => $productCounting,
        'product_cost' => $productValue,
        'emp_id' => $emp_id
    ];

    $results = insertIntoDatabase($db, 'stock', $data);
    echo json_encode($results);
}

if (isset($_POST['function']) && $_POST['function'] == 'get_stockByid') {
    $productID = $_POST['product_id'];
    $stm = $db->prepare("SELECT * FROM stock WHERE product_id = :id");
    $stm->bindParam(":id", $productID);
    $stm->execute();
    $res = $stm->fetchAll(PDO::FETCH_ASSOC);
    $results = [];
    foreach ($res as $data) {
        $results[] = array(
            "product_id" => $data['product_id'],
            "product_name" => $data['product_name'],
            "product_counting" => $data['product_counting'],
            "product_cost" => $data['product_cost'],
        );
    }
    echo json_encode($results);
}
if (isset($_POST['function']) && $_POST['function'] == 'insert_project') {
    $ProjectName  = $_POST['ProjectName'];
    $projectStart = $_POST['projectStart'];
    $projectclose = $_POST['projectclose'];
    $Projectvalue = $_POST['Projectvalue'];
    $Custormer = $_POST['Custormer'];
    $status = $_POST['status'];
    $emp_id = $_POST['emp_id'];

    $data = [
        'project_id' => generateNewProject($db, "project"),
        'project_name' => $ProjectName,
        'project_start' => $projectStart,
        'project_end' => $projectclose,
        'project_value' => $Projectvalue,
        'cus_id' => $Custormer,
        'project_status' => $status,
        'emp_id' => $emp_id
    ];

    $results = insertIntoDatabase($db, 'project', $data);
    echo json_encode($results);
}

if (isset($_POST['function']) && $_POST['function'] == 'delete_project') {
    $projectID = $_POST['project_id'];
    $stmt = $db->prepare("DELETE FROM project WHERE project_id = :project_id");
    $stmt->bindParam(':project_id', $projectID, PDO::PARAM_INT);
    $results = array();
    if ($stmt->execute()) {
        $results['status'] = 200;
    } else {
        $results['status'] = 201;
    }
    echo json_encode($results);
}
if (isset($_POST['function']) && $_POST['function'] == 'check_login') {
    session_start();
    $email = $_POST['email'];
    $password = $_POST['password'];

    $select_stmtapi = $db->prepare("SELECT * FROM employee WHERE emp_email = :email");
    $select_stmtapi->bindParam(':email', $email);
    $select_stmtapi->execute();
    $rowapi = $select_stmtapi->fetch(PDO::FETCH_ASSOC);

    if ($rowapi && password_verify($password, $rowapi['emp_password'])) {
        // รหัสผ่านถูกต้อง
        $_SESSION['emp_id'] = $rowapi['emp_id'];
        $_SESSION['emp_name'] = $rowapi['emp_name'];
        $_SESSION['emp_sername'] = $rowapi['emp_sername'];
        $_SESSION['emp_position'] = $rowapi['emp_position'];
        echo json_encode(array(
            "statusCode" => 200,
            "emp_id" => $_SESSION['emp_id'],
            "fullname" => $_SESSION['emp_name'] . " " . $_SESSION['emp_sername'],
            "emp_position" => $_SESSION['emp_position']
        ));
    } else {
        // รหัสผ่านไม่ถูกต้อง
        echo json_encode(array("statusCode" => 201));
    }
}
