<?php
require('../libs/fpdf/fpdf.php');
include_once '../config/database.php';

class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 16);
        $this->SetTextColor(30, 41, 59);
        $this->Cell(0, 10, 'Supplier Management System', 0, 1, 'C');
        
        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(100, 116, 139);
        $this->Cell(0, 6, 'Supplier Report', 0, 1, 'C');
        
        $this->Ln(8);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(148, 163, 184);
        $this->Cell(0, 10, 'Generated: ' . date('M d, Y'), 0, 0, 'L');
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'R');
    }
    
    function SimpleTable($header, $data)
    {
        $this->SetFont('Arial', 'B', 9);
        $this->SetTextColor(71, 85, 105);
        $this->SetDrawColor(226, 232, 240);
        
        $w = array(12, 40, 35, 45, 30, 20);
        for($i = 0; $i < count($header); $i++) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C');
        }
        $this->Ln();
        
        $this->SetFont('Arial', '', 9);
        $this->SetTextColor(51, 65, 85);
        
        foreach($data as $row)
        {
            $this->Cell($w[0], 6, $row['id'], 1, 0, 'C');
            $this->Cell($w[1], 6, substr($row['company_name'], 0, 22), 1, 0, 'L');
            $this->Cell($w[2], 6, substr($row['contact_person'], 0, 20), 1, 0, 'L');
            $this->Cell($w[3], 6, substr($row['email'], 0, 25), 1, 0, 'L');
            $this->Cell($w[4], 6, substr($row['phone'], 0, 18), 1, 0, 'L');
            $this->Cell($w[5], 6, $row['status'], 1, 0, 'C');
            $this->Ln();
        }
    }
}

$database = new Database();
$db = $database->getConnection();

$query = "SELECT * FROM suppliers ORDER BY id DESC";
$stmt = $db->prepare($query);
$stmt->execute();

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pdf = new PDF();
$pdf->AddPage();

$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(100, 116, 139);
$pdf->Cell(0, 8, 'Total Suppliers: ' . count($data), 0, 1, 'L');
$pdf->Ln(2);

$header = array('ID', 'Company Name', 'Contact Person', 'Email', 'Phone', 'Status');
$pdf->SimpleTable($header, $data);

$pdf->Output('I', 'suppliers_report.pdf');
?>
