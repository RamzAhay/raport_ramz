<?php
require('fpdf.php');

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);

$pdf->Cell(0,10,'Hello World dari FPDF!',0,1,'C');

$pdf->Output();
?>