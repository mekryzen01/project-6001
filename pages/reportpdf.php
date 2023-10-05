<?php
include("../fpdf186/fpdf.php");
include("../servers/connect.php");


$id = $_POST['projectID'];
$stmt = $db->prepare("SELECT * FROM project WHERE project_id = :id");
$stmt->bindParam(":id", $id);
$stmt->execute();
$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
function fetchData($db, $query, $paramName, $paramValue)
{
    $stmt = $db->prepare($query);
    $stmt->bindParam($paramName, $paramValue, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function fetchDataAllID($db, $query, $paramName, $paramValue)
{
    $stmt = $db->prepare($query);
    $stmt->bindParam($paramName, $paramValue, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function U2T($text)
{
    return @iconv("UTF-8", "TIS-620//IGNORE", ($text));
}
$pdf = new FPDF();
$pdf->AddPage();
$pdf->AddFont('AngsanaNew', '', 'angsa.php');
/// header
$pdf->SetFont('AngsanaNew', '', 28);
foreach ($res as $row) {

    $pdf->SetXY(60, 10);
    $pdf->MultiCell(80, 10, U2T("รายงานโครงการ" . " " . $row['project_name']), '', 'C');

    $datacus = fetchDataAllID($db, "SELECT * FROM customer WHERE cus_id = :cusID", ":cusID", $row['cus_id']);

    $pdf->SetFont('AngsanaNew', '', 18);
    $pdf->SetXY(20, 30);
    $pdf->MultiCell(100, 10, U2T("เจ้าของโครงการ"), '', 'L');
    $pdf->SetXY(20, 35);
    $pdf->MultiCell(100, 10, U2T($datacus['cus_name'] . " " . $datacus['cus_sername']), '', 'L');
    $pdf->SetXY(80, 30);
    $pdf->MultiCell(100, 10, U2T("มูลค่าโครงการ"), '', 'L');
    $pdf->SetXY(80, 35);
    $pdf->MultiCell(100, 10, U2T(number_format($row['project_value'], 2)), '', 'L');
    $pdf->SetXY(130, 30);
    $pdf->MultiCell(100, 10, U2T("วันที่เริ่มโครงการ"), '', 'L');
    $pdf->SetXY(130, 35);
    $pdf->MultiCell(100, 10, U2T(ConvertToThaiDate($row['project_start'], 0, 0)), '', 'L');
    $dataemp = fetchDataAllID($db, "SELECT * FROM employee WHERE emp_id =:empID", ":empID", $row['emp_id']);
    $pdf->SetXY(20, 45);
    $pdf->MultiCell(100, 10, U2T("ผู้ดูแลโครงการ"), '', 'L');
    $pdf->SetXY(20, 50);
    $pdf->MultiCell(100, 10, U2T($dataemp['emp_name'] . " " . $dataemp['emp_sername']), '', 'L');
    $pdf->SetXY(80, 45);
    $pdf->MultiCell(100, 10, U2T("สถานะโครงการ"), '', 'L');
    $pdf->SetXY(80, 50);
    if ($row['project_status'] == 1) {
        $pdf->MultiCell(100, 10, U2T("อยู่ระหว่างดำเนินการ"), '', 'L');
    } elseif ($row['project_status'] == 2) {
        $pdf->MultiCell(100, 10, U2T("ปิดโครงการ"), '', 'L');
    } elseif ($row['project_status'] == 3) {
        $pdf->MultiCell(100, 10, U2T("เกินกำหนดการ"), '', 'L');
    } else {
        $pdf->MultiCell(100, 10, U2T("ยกเลิก"), '', 'L');
    }
    $pdf->SetXY(130, 45);
    $pdf->MultiCell(100, 10, U2T("วันที่สิ้นสุดโครงการ"), '', 'L');
    $pdf->SetXY(130, 50);
    $pdf->MultiCell(100, 10, U2T(ConvertToThaiDate($row['project_end'], 0, 0)), '', 'L');
}



/// titel
$pdf->SetFont('AngsanaNew', '', 18);
$pdf->SetXY(20, 70);
$pdf->MultiCell(25, 10, U2T("รหัสสินค้า"), 1, 'C');
$pdf->SetXY(45, 70);
$pdf->MultiCell(40, 10, U2T("รายการสินค้า"), 1, 'C');
$pdf->SetXY(85, 70);
$pdf->MultiCell(20, 10, U2T("หน่วยนับ"), 1, 'C');
$pdf->SetXY(105, 70);
$pdf->MultiCell(20, 10, U2T("จำนวน"), 1, 'C');
$pdf->SetXY(125, 70);
$pdf->MultiCell(25, 10, U2T("ราคา/หน่วย"), 1, 'C');
$pdf->SetXY(150, 70);
$pdf->MultiCell(40, 10, U2T("จำนวนเงิน"), 1, 'C');
/// data
$y = 80;
$sumAmount = 0;
$datastm = $db->prepare("SELECT * FROM projcost_desc WHERE project_id = :id");
$datastm->bindParam(":id", $id);
$datastm->execute();
$datadesc = $datastm->fetchAll(PDO::FETCH_ASSOC);
foreach ($datadesc as $desc) {
    $datastock = fetchData($db, "SELECT * FROM stock WHERE product_id = :id", ":id", $desc['product_id']);
    $pdf->SetXY(20, $y);
    $pdf->MultiCell(25, 10, U2T($desc['product_id']), 1, 'C');
    $pdf->SetXY(45, $y);
    $pdf->MultiCell(40, 10, U2T($datastock['product_name']), 1, 'C');
    $pdf->SetXY(85, $y);
    $pdf->MultiCell(20, 10, U2T($datastock['product_counting']), 1, 'C');
    $pdf->SetXY(105, $y);
    $pdf->MultiCell(20, 10, U2T($desc['desc_unit']), 1, 'C');
    $pdf->SetXY(125, $y);
    $pdf->MultiCell(25, 10, U2T(number_format($desc['product_cost'], 2)), 1, 'C');
    $pdf->SetXY(150, $y);
    $pdf->MultiCell(40, 10, U2T(number_format($desc['desc_value'], 2)), 1, 'C');
    $sumAmount += $desc['desc_value'];
    $y += 10;
}
$pdf->SetXY(20, $y);
$pdf->MultiCell(130, 10, U2T("มูลค่ารวม"), 1, 'R');
$pdf->SetXY(150, $y);
$pdf->MultiCell(40, 10, number_format($sumAmount, 2), 1, 'C');
$pdf->Output();
