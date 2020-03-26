 <html>
 <head>
  <title>Report PDF</title>
</head>
<body>
  <?php
// Require composer autoload
//if ($_POST["start"] >= 0 && $_POST["end"] > 0 && $_POST["end"] >= $_POST["start"]) {
  if (1==1) {

    // $start = $_POST["start"];
    // $end = $_POST["end"];



    require('fpdf182/fpdf.php');

    define('FPDF_FONTPATH','fpdf182/font/');

    $pdf=new FPDF();
    $pdf->AddPage();
    $pdf->AddFont('angsa','','angsa.php');
    $pdf->SetFont('angsa','',36);
    $pdf->Cell(0,20,iconv( 'UTF-8','TIS-620','รายงานประวัติยืมตืนอุปกรณ์'),0,1,'C');
    $header = array('ลำดับที่','อุปกรณ์ที่ยืม', 'ผู้ยืม','วันที่ยืม'
      ,'วันที่ส่งคืน','รายการที่','สถาณะ');

    $pdf->SetFont('angsa','',16);
    $pdf->AddFont('angsa','B','angsa.php');

    $pdf->Cell(15,10,iconv( 'UTF-8','TIS-620',$header[0]),1,'C');

    $pdf->Cell(30,10,iconv( 'UTF-8','TIS-620',$header[2]),1,'C');
    $pdf->Cell(25,10,iconv( 'UTF-8','TIS-620',$header[3]),1,'C');
    $pdf->Cell(25,10,iconv( 'UTF-8','TIS-620',$header[4]),1,'C');
    $pdf->Cell(15,10,iconv( 'UTF-8','TIS-620',$header[5]),1,'C');
    $pdf->Cell(30,10,iconv( 'UTF-8','TIS-620',$header[6]),1,'C');
    $pdf->Cell(40,10,iconv( 'UTF-8','TIS-620',$header[1]),1,'C');
    $pdf->Ln();

    $num_i = 1;

    require 'model/connection.php';

    $number = 1 ;
    $item_oder = "
    SELECT id_order,order_proceed,order_date_stat,order_date_end
    FROM cs_item_order_group

    where order_status != 1

    ORDER BY id_order DESC
    LIMIT 0,3 
    ";

    $show_order = $mysqli -> query($item_oder);
    while($show_order_i = $show_order->fetch_assoc()){

      $id_order = $show_order_i["id_order"];
      $order_proceed = $show_order_i["order_proceed"];
      $order_date_stat = $show_order_i["order_date_stat"];
      $order_date_end = $show_order_i["order_date_end"];
      $y=0;
      $text="";
      $order = "
      SELECT cs_item.item_name , cs_item_order.item_number
      FROM  cs_item 
      INNER JOIN cs_item_order  
      ON cs_item_order.id_item = cs_item.item_id
      where cs_item_order.group_order = $id_order 
      ";

      $show_item = $mysqli -> query($order);
      while($rows_item = $show_item->fetch_assoc()){

       $text = $text.$rows_item["item_name"]." ".$rows_item["item_number"]." ";
       $y = $y+10; 

     }

  
     $pdf->Cell(15,$y,iconv( 'UTF-8','TIS-620',$num_i),1,'L',false);
     $pdf->Cell(30,$y,iconv( 'UTF-8','TIS-620',"สมชาย"),1,'L',false);
     $pdf->Cell(25,$y,iconv( 'UTF-8','TIS-620',$order_date_stat),1,'L',false);
     $pdf->Cell(25,$y,iconv( 'UTF-8','TIS-620',$order_date_end),1,'L',false);
     $pdf->Cell(15,$y,iconv( 'UTF-8','TIS-620',$id_order),1,'L',false);
     if ($order_proceed == 1) {
      $p = "รอดำเนินการ";
    }else if($order_proceed == 2) {
      $p =  "ไม่อนุมัติ";
    }else if($order_proceed == 3) {
      $p =  "รอส่งคืน";
    }else if($order_proceed == 4) {
      $p =  "ตรวจสอบส่งคืน";
    }else if($order_proceed == 5) {
      $p =  "ส่งคืนเรียบร้อย";
    }else{
      $p =  "ไม่มีบันทึก";
    }
   
    $pdf->Cell(30,$y,iconv( 'UTF-8','TIS-620',$p),1,'L',false);
    $pdf->MultiCell(40,10, iconv('UTF-8', 'TIS-620', $text),1,'L',false);
    $num_i++;
  }


  $pdf->Output("MyPDF.pdf","F");
  
  ?>

  PDF Created Click <a href="MyPDF.pdf">here</a> to Download
<?php  }else{
  echo "<script>alert('กรอกข้อมูลผิดพลาด');</script>";
  echo "<script>window.close();</script>";
}
?>  

</body>
</html> 

