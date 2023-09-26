<?php
include("./connect.php");
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
function generateNumber($db, $id, $table)
{
    // 1. ดึงวันที่ปัจจุบัน
    $date = date("dmY"); // วันที่ปัจจุบันในรูปแบบ ddmmyyyy
    // 2. ดึงตัวเลขล่าสุดจากฐานข้อมูล
    $stmt = $db->query("SELECT MAX({$id}) as max_id FROM {$table} WHERE {$id} LIKE '{$date}%'");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $lastNumber = isset($result['max_id']) ? substr($result['max_id'], -4) : "0000"; // ดึงตัวเลขที่อยู่หลังวันที่
    // 3. เพิ่มตัวเลขทีละหนึ่ง
    $newNumber = str_pad((int)$lastNumber + 1, 4, '0', STR_PAD_LEFT); // ตัวเลขใหม่ที่เพิ่มขึ้นมา 1 และมี 4 หลัก
    // 4. รวมวันที่ปัจจุบันกับตัวเลขใหม่เพื่อสร้าง ID ใหม่
    $newId = $date . $newNumber;
    return $newId;
}
function generateNumber5($db, $id, $table)
{
    // 1. ดึงตัวเลขล่าสุดจากฐานข้อมูล
    $stmt = $db->query("SELECT MAX({$id}) as max_id FROM {$table}");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $lastNumber = isset($result['max_id']) ? $result['max_id'] : "00000"; // ดึงตัวเลขล่าสุด

    // 2. เพิ่มตัวเลขทีละหนึ่ง
    $newNumber = str_pad((int)$lastNumber + 1, 4, '0', STR_PAD_LEFT); // ตัวเลขใหม่ที่เพิ่มขึ้นมา 1 และมี 5 หลัก

    return $newNumber;
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

function fetchDataAllID($db, $query, $paramName, $paramValue)
{
    $stmt = $db->prepare($query);
    $stmt->bindParam($paramName, $paramValue, PDO::PARAM_INT);
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
            $lastInsertId = $db->lastInsertId();
            return ['status' => 200, 'message' => $lastInsertId];
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
