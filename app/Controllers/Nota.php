<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use setasign\Fpdi\Tcpdf\Fpdi;
use setasign\Fpdi\PdfReader;

class Nota extends BaseController
{
    public function index()
    {
        $pdf = new Fpdi('L', 'mm');
        $pdf->AddPage();

        $pdf->SetFont('', 'B', 14);
        $pdf->Cell(277, 1, "DAFTAR PEGAWAI AYONGODING.COM", 0, 1, 'C');
        $pdf->SetAutoPageBreak(true, 0);
        $pdf->Ln(10);

        // $pdf->SetFont('', 'B', 12);
        // $pdf->Cell(20, 8, "No", 1, 0, 'C');
        // $pdf->Cell(100, 8, "Nama Barang", 1, 0, 'C');
        // $pdf->Cell(120, 8, "Status", 1, 0, 'C');
        // $pdf->Cell(37, 8, "Stok", 1, 1, 'C');

        // $pdf->SetFont('', '', 12);
        // $barang = model('ProductsModel')->findAll();
        // $no=0;
        // foreach ($barang as $data){
        //     $no++;
        //     $pdf->Cell(20,8,$no,1,0, 'C');
        //     $pdf->Cell(100,8,$data['name'],1,0);
        //     $pdf->Cell(120,8,$data['status'],1,0);
        //     $pdf->Cell(37,8,$data['quantity'],1,1);
        // }

        $pdf->SetFont('', 'B', 10);
        $pdf->Cell(277, 10, "Laporan Pdf Menggunakan Tcpdf, Instalasi Tcpdf Via Composer", 0, 1, 'L');

        
        $html = view('note/coba');
        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Output('coba.pdf'); 
        $pdf->exit();
    }

    function coba() 
    {
        $pdf = new Fpdi('P', 'mm', [215, 300]);
		$pdf->setTitle('Ini Judul');
		$pdf->setAuthor('bacabakat.com');
        
		// $aa = $pdf->AddFont('aefurat','','aefurat.php');
	    $nunito_r = \TCPDF_FONTS::addTTFfont(APPPATH.'Font\Nunito-Regular.ttf','TrueTypeUnicode', '', 96);

        $pageCount = $pdf->setSourceFile(APPPATH.'template.pdf');
        $pageId = $pdf->importPage(1, PdfReader\PageBoundaries::MEDIA_BOX);

		$pdf->addPage();
		$pdf->useImportedPage($pageId, 0, 0, 215,300);
        // $pdf->SetFont($nunito_r ,'',26);
		// $pdf->SetTextColor(0, 0, 0);
		// $pdf->SetXY(215-50, 50);
		// $pdf->Write(2, "Cobaaa");

        $db = \Config\Database::connect([
            'hostname' => 'localhost',
            'username' => 'root',
            'password' => '',
            'database' => 'bacabakat',
            'DBDriver' => 'MySQLi',
            'DBPrefix' => '',
            'pConnect' => true,
            'DBDebug'  => true,
            'charset'  => 'utf8',
            'DBCollat' => 'utf8_general_ci',
            'swapPre'  => '',
            'encrypt'  => false,
            'compress' => false,
            'strictOn' => false,
        ]);
        $bakats = $db->table('kode_bakat')->select('tema')->get()->getResultArray();

        $pageId = $pdf->importPage(11, PdfReader\PageBoundaries::MEDIA_BOX);
		$pdf->addPage();
		$pdf->useImportedPage($pageId, 0, 0, 215,300);
        $pdf->SetFont($nunito_r,'',10);
		$pdf->SetTextColor(250, 250, 250);
		$pdf->SetXY(45, 105);
		$pdf->Cell(55,8,strtoupper($bakats[0]['tema']),0,0,'C');
		for($i=1;$i<17;$i++){
			$pdf->SetXY(45,$pdf->getY()+10.3);
			$pdf->Cell(55,8,strtoupper($bakats[$i]['tema']),0,0,'C');
		}
		$pdf->SetXY(123, 105);
		$pdf->Cell(55,8,strtoupper($bakats[17]['tema']),0,0,'C');
		for($i=18;$i<34;$i++){
			$pdf->SetXY(123,$pdf->getY()+10.3);
			$pdf->Cell(55,8,strtoupper($bakats[$i]['tema']),0,0,'C');
		}

        $pdf->Output('coba.pdf'); 
        $pdf->exit();
    }
}
