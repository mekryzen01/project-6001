<?php
include('connect.php');
include('./central_function.php');
// ดึง project by emp_id      
if (isset($_POST['function']) && $_POST['function'] == 'get_projectbyempid') {
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
        } else if ($project['project_status'] == 3) {
            $statusname = "เกินกำหนดการ";
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
if (isset($_POST['function']) && $_POST['function'] == 'get_projectbyid') {
    $empId = $_POST['emp_id'];
    $projectID = $_POST['projectID'];
    $stm = $db->prepare("SELECT * FROM project WHERE emp_id = :emp_id AND project_id = :id");
    $stm->bindParam(':emp_id', $empId, PDO::PARAM_INT);
    $stm->bindParam(':id', $projectID, PDO::PARAM_INT);
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
            "normalstart" => $project['project_start'],
            "project_end" => ConvertToThaiDate($project['project_end'], 0),
            "normalend" => $project['project_end'],
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
            "emp_name" => $employee['emp_name'],
            "emp_sername" => $employee['emp_sername'],
            "emp_address" => $employee['emp_address'],
            "emp_tumbon" => $datadistricts['name_th'],
            "emp_aumpher" => $dataamphure['name_th'],
            "emp_province" => $dataprovince['name_th'],
            "emp_post" => $datadistricts['zip_code'],
            "emp_phone" => $employee['emp_phone'],
            "emp_email" => $employee['emp_email'],
            "emp_startwork" => ConvertToThaiDate($employee['emp_startwork']),
            "emp_position" => $dataposition['position_name'],
            "imageuser" => $employee['emp_image'],
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
        'product_id' => generateNumber5($db, "product_id", "stock"),
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
if (isset($_POST['function']) && $_POST['function'] == 'insert_reportcost') {
    $today = $_POST['today'];
    $insertprojectid = $_POST['insertprojectid'];
    $insertprojectname = $_POST['insertprojectname'];
    $empname = $_POST['empname'];
    $addIdValues = $_POST['addIdValues'];
    $productNames = $_POST['productNames'];
    $productValues = $_POST['productValues'];
    $productTotal = $_POST['productTotal'];
    $productCosts = $_POST['productCosts'];
    $projcost_id = generateNumber($db, 'projcost_id', 'projcost_hd');

    $projcost_saveids = [];

    foreach ($addIdValues as $index => $value) {
        $productName = $productNames[$index];
        $productValue = $productValues[$index];
        $total = $productTotal[$index];
        $cost = $productCosts[$index];

        $data = [
            'projcost_saveid' => generateNumber5($db, 'projcost_saveid', 'projcost_desc'),
            'product_id' => $productName,
            'desc_unit' => $productValue,
            'product_cost' => $cost,
            'desc_value' => $total,
            'project_id' => $insertprojectid,
        ];
        $results = insertIntoDatabase($db, 'projcost_desc', $data);

        if ($results['status'] == 200) {
            $projcost_saveids[] = $data['projcost_saveid'];
        }
    }

    if (!empty($projcost_saveids)) {
        $dataproject = fetchData($db, "SELECT * FROM project WHERE project_id = :id", ":id", $insertprojectid);
        $data_to_projcost_hd = [
            'projcost_id' => $projcost_id,
            'projcost_saveid' => implode(',', $projcost_saveids), // รวม projcost_saveid เป็น string ด้วย comma
            'projcost_save' => $today,
            'project_id' => $dataproject['project_id'],
            'projcost_value' => $dataproject['project_value'],
            'projcost_status' => 1,
            'projcost_date' => $today,
        ];
        $results = insertIntoDatabase($db, 'projcost_hd', $data_to_projcost_hd);

        if ($results['status'] == 200) {
            echo json_encode(array('status' => 200, 'message' => 'Success'));
        } else {
            echo json_encode(array('status' => 500, 'message' => 'Failed to insert into projcost_hd'));
        }
    } else {
        echo json_encode(array('status' => 500, 'message' => 'No projcost_saveid generated'));
    }
}

if (isset($_POST['function']) && $_POST['function'] == 'get_desc') {
    $projectID = $_POST['projectID'];
    $res = fetchDataAllID($db, "SELECT * FROM projcost_desc WHERE project_id = :id", ":id", $projectID);
    $results = [];
    foreach ($res as $row) {
        $datastock = fetchData($db, "SELECT * FROM stock WHERE product_id = :id", ":id", $row['product_id']);
        $results[] = array(
            'product_id' => $row['product_id'],
            'product_name' => $datastock['product_name'],
            'product_counting' => $datastock['product_counting'],
            'desc_unit' => $row['desc_unit'],
            'product_cost' => $datastock['product_cost'],
            'desc_value' => $row['desc_value']
        );
    }

    echo json_encode($results);
}
if (isset($_POST['function']) && $_POST['function'] == 'edit_product_desc') {
    $productID = $_POST['product_id'];
    $productcost = $_POST['product_cost'];

    try {
        // เริ่มธุรกรรม
        $db->beginTransaction();

        $stm = $db->prepare("UPDATE projcost_desc SET product_cost = :product_cost WHERE product_id = :product_id");
        $stm->bindParam(":product_cost", $productcost);
        $stm->bindParam(":product_id", $productID);
        $stm->execute();

        $stmt = $db->prepare("UPDATE projcost_desc SET desc_value = desc_unit * product_cost WHERE product_id = :product_id");
        $stmt->bindParam(":product_id", $productID);
        $stmt->execute();

        // ยืนยันธุรกรรม
        $db->commit();
    } catch (Exception $e) {
        // มีข้อผิดพลาดเกิดขึ้น, ยกเลิกธุรกรรม
        $db->rollBack();
        // จัดการหรือรายงานข้อผิดพลาดตามความจำเป็น
        echo "Error: " . $e->getMessage();
    }
}
if (isset($_POST['function']) && $_POST['function'] == "get_total_cost_emp") {
    $results = fetchDataAll($db, "SELECT project_id, SUM(desc_value) as totalall FROM projcost_desc GROUP BY project_id");
    $empTotals = []; // สร้าง array เพื่อเก็บผลรวมของแต่ละ empid

    foreach ($results as $row) {
        $res = fetchDataAllID($db, "SELECT * FROM project WHERE project_id= :id", ":id", $row['project_id']);
        foreach ($res as $newrow) {
            $emp_id = $newrow['emp_id'];
            if (!isset($empTotals[$emp_id])) {
                $empTotals[$emp_id] = 0; // ถ้ายังไม่มี empid ใน array, ตั้งค่าเริ่มต้นเป็น 0
            }
            $empTotals[$emp_id] += $row['totalall']; // เพิ่มผลรวม
        }
    }

    $data = [];
    foreach ($empTotals as $emp_id => $total) {
        $data[] = [
            "emp_id" => $emp_id,
            "sumtotal" => number_format($total, 2)
        ];
    }

    echo json_encode($data);
}
if (isset($_POST['function']) && $_POST['function'] == "Update_personal_emp") {
    $empID = $_POST['emp_id'];
    $newnameuser = $_POST['newnameuser'];
    $newsername = $_POST['newsername'];

    // ตรวจสอบว่ามีการอัปโหลดไฟล์รูปภาพ
    if (isset($_FILES['newimage'])) {
        $file = $_FILES['newimage'];

        // ตรวจสอบข้อผิดพลาดในการอัปโหลด
        if ($file['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../images/';
            $newImageName = $file['name'];
            $fullpath = $uploadDir . $newImageName;
            // ย้ายไฟล์ไปยังไดเรกทอรีที่ต้องการ
            move_uploaded_file($file['tmp_name'], $uploadDir . $newImageName);
        } else {
            $response = array('status' => 400, 'message' => 'File upload error');
            echo json_encode($response);
            exit; // หยุดการทำงาน
        }
    }

    $stm = $db->prepare("UPDATE employee SET emp_name = :newnames , emp_sername = :newsername , emp_image = :newimage WHERE emp_id = :id");
    $stm->bindParam(":newnames", $newnameuser);
    $stm->bindParam(":newsername", $newsername);
    $stm->bindParam(":newimage", $fullpath);
    $stm->bindParam(":id", $empID);
    if ($stm->execute()) {
        echo json_encode(["status" => 200]);
    } else {
        echo json_encode(["status" => 201]);
    }
}
if (isset($_POST['function']) && $_POST['function'] == "Update_address_emp") {
    $empID = $_POST['emp_id'];
    $newAddress = $_POST['newAddress'];
    $newprovince = $_POST['newprovince'];
    $newamphur = $_POST['newamphur'];
    $newdistrict = $_POST['newdistrict'];
    $zipcode = $_POST['zipcode'];

    $stm = $db->prepare("UPDATE employee SET emp_address = :newaddress ,emp_province = :newprovince ,emp_aumpher = :newampher , emp_tumbon = :newtumbon ,emp_post = :newzip WHERE emp_id = :id");
    $stm->bindParam(":newaddress", $newAddress);
    $stm->bindParam(":newprovince", $newprovince);
    $stm->bindParam(":newampher", $newamphur);
    $stm->bindParam(":newtumbon", $newdistrict);
    $stm->bindParam(":newzip", $zipcode);
    $stm->bindParam(":id", $empID);
    if ($stm->execute()) {
        echo json_encode(["status" => 200]);
    } else {
        echo json_encode(["status" => 201]);
    }
}
if (isset($_POST['function']) && $_POST['function'] == "Update_user_emp") {
    $empID = $_POST['emp_id'];
    $emailnew = $_POST['email_emp'];
    $passwordnew = $_POST['password_emp'];

    $hashpass = password_hash($passwordnew, PASSWORD_DEFAULT);

    $stm = $db->prepare("UPDATE employee SET emp_email = :newemail , emp_password = :newpassword WHERE emp_id = :id");
    $stm->bindParam(":newemail", $emailnew);
    $stm->bindParam(":newpassword", $hashpass);
    $stm->bindParam(":id", $empID);
    if ($stm->execute()) {
        echo json_encode(["status" => 200]);
    } else {
        echo json_encode(["status" => 201]);
    }
}
if (isset($_POST['function']) && $_POST['function'] == 'update_project') {
    $projectID = $_POST['ProjectID'];
    $ProjectNameedit = $_POST['ProjectNameedit'];
    $Projectvalueedit = $_POST['Projectvalueedit'];
    $projectStartedit = $_POST['projectStartedit'];
    $projectcloseedit = $_POST['projectcloseedit'];
    $Custormer = $_POST['Custormer'];

    $stmt = $db->prepare("UPDATE project SET project_name = :pname ,cus_id = :cid ,project_start = :pstart ,project_end = :pend ,project_value = :pval WHERE project_id = :id");
    $stmt->bindParam(":pname", $ProjectNameedit);
    $stmt->bindParam(":cid", $Custormer);
    $stmt->bindParam(":pstart", $projectStartedit);
    $stmt->bindParam(":pend", $projectcloseedit);
    $stmt->bindParam(":pval", $Projectvalueedit);
    $stmt->bindParam(":id", $projectID);

    if ($stmt->execute()) {
        echo json_encode(["status" => 200]);
    } else {
        echo json_encode(["status" => 201]);
    }
}

if (isset($_POST['function']) && $_POST['function'] == 'getselect_project') {
    $res = fetchDataAll($db, "SELECT * FROM project");
    foreach ($res as $row) {
        echo "<option value='{$row['project_id']}'>{$row['project_name']}</option>";
    }
}
