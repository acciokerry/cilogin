<?php
    $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetTitle('Contoh');
    $pdf->SetTopMargin(20);
    $pdf->setFooterMargin(20);
    $pdf->SetAutoPageBreak(true);
    $pdf->SetAuthor('Author');
    $pdf->SetDisplayMode('real', 'default');
    $pdf->AddPage();
    $pdf->Write(5, 'Contoh Laporan PDF dengan CodeIgniter + tcpdf');
    $pdf->Ln();
    $n = 'name';
    foreach ($data as $key => $value) {
        $pdf->Cell(0, 0, $value->$n, 0, 0, 'L');
        $pdf->Ln();
    }
    $pdf->Output('contoh1.pdf', 'I');
?>