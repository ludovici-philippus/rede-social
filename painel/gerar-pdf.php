<?php

use Mpdf\Mpdf;

ob_start();
    include("template_financeiro.php");
    $conteudo = ob_get_contents();
    ob_end_clean();

    $tcpdf = new TCPDF();
    $tcpdf->AddPage();
    $tcpdf->writeHTML($conteudo);
    $tcpdf->Output();

    
?>