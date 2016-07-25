<?php

// Include the main TCPDF library (search for installation path).
//classes loading begin
    function classLoad ($myClass) {
        if(file_exists('../model/'.$myClass.'.php')){
            include('../model/'.$myClass.'.php');
        }
        elseif(file_exists('../controller/'.$myClass.'.php')){
            include('../controller/'.$myClass.'.php');
        }
    }
    spl_autoload_register("classLoad"); 
    include('../config.php');  
    include('../lib/image-processing.php');
    require_once('../lib/tcpdf/tcpdf.php');
    //classes loading end
    session_start();
    
    //classes managers
    $contratManager = new ContratManager($pdo);
    $clientManager = new ClientManager($pdo);
    $operationManager = new OperationManager($pdo);
    $projetManager = new ProjetManager($pdo);
    //classes
    $idOperation = $_GET['idOperation'];
    $operation = $operationManager->getOperationById($idOperation);
    $contrat = $contratManager->getContratById($operation->idContrat());
    $client = $clientManager->getClientById($contrat->idClient());
    $projet = $projetManager->getProjetById($contrat->idProjet());
    $typeBien = "";
    $niveau = "";
    
    if ( $contrat->typeBien() == "appartement" ) {
        $appartementManager = new AppartementManager($pdo);
        $appartement = $appartementManager->getAppartementById($contrat->idBien());
        $typeBien = "رقم الشقة : ".$appartement->nom();
        $niveau = "الطابق : ".$appartement->niveau();
    } 
    else {
        $locauxManager = new LocauxManager($pdo);
        $locaux = $locauxManager->getLocauxById($contrat->idBien());
        $typeBien = "رقم المحل التجاري : ".$locaux->nom();
        
    }
    $modePaiement = "";
    if ( $operation->modePaiement() == "Especes" ) {
        $modePaiement = "نقدا";    
    } 
    else if ( $operation->modePaiement() == "Virement" ) {
        $modePaiement = "حوالة بنكية";    
    }
    else if ( $operation->modePaiement() == "Versement" ) {
        $modePaiement = "حوالة بنكية";    
    }
    else if ( $operation->modePaiement() == "Cheque" ) {
        $modePaiement = "شيك";
    }
    else {
        $modePaiement = "كمبيالة";
    }


// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 018', PDF_HEADER_STRING);

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 5, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language dependent data:
$lg = Array();
$lg['a_meta_charset'] = 'UTF-8';
$lg['a_meta_dir'] = 'rtl';
$lg['a_meta_language'] = 'fa';
$lg['w_page'] = 'page';

// set some language-dependent strings (optional)
$pdf->setLanguageArray($lg);

// ---------------------------------------------------------

// set font
//$pdf->SetFont('dejavusans', '', 12);

// add a page
$pdf->AddPage('P', 'A5');
// Restore RTL direction
$pdf->setRTL(true);
// set font
$pdf->SetFont('aealarabiya', '', 14);
// print newline
// Arabic and English content
$contratTitle = "توصيل رقم : ".$operation->reference().'-'.$operation->id();
$pdf->Cell(0, 10, $contratTitle,0,1,'C');
$pdf->Ln();
$pdf->SetFont('aealarabiya', '', 12);
$htmlcontent = '<strong>'.'التاريخ : '.'</strong>'.date('d/m/Y', strtotime($operation->date()));
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
$htmlcontent = '<strong>'.'توصلنا بمبلغ قدره : '.'</strong>'.$operation->montant().' درهم';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
$htmlcontent = '<strong>'.'أداه السيد(ة) : '.'</strong>'.$client->nomArabe();
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
$htmlcontent = '<strong>'.'الراشد(ة)و رقم ب .ت .و : '.'</strong>'.$client->cin();
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
$htmlcontent = '<strong>'.'بواسطة : '.'</strong>'.$modePaiement.' - ( رقم العملية : '.$operation->numeroCheque().')';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
$htmlcontent = '<strong>'.'من اجل حفظ الحق في ملكية الشقة ذات المراجع التالية : '.'</strong>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
$htmlcontent = '<strong>'.'اسم المشروع : '.'</strong>'.$projet->nom();
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
$htmlcontent = '<strong>'.$typeBien.'</strong>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
$htmlcontent = '<strong>'.$niveau.'</strong>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
$htmlcontent = '<strong>'.'الرسم العقاري الأم: '.'</strong>'.$projet->titre();
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
$pdf->Ln();
$htmlcontent = '<strong style="text-align : left">'.'توقيع الشركة : '.'</strong>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('aealarabiya', '', 10);
$htmlcontent = '<strong>'.'ملاحظة : '.'</strong>'.'يعتبر هذا التوصيل ملغى في حالة عدم استخلاص مبلغ الشيك أو الكمبيالة التجارية أو عدم التوصل بمبلغ التحويل عن طريق البنك مهما كان
السبب.';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = 'يجب الاحتفاظ بأصل هذا التوصيل باعتباره الوسيلة الوحيدة المثبتة للأداء.';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();

// print newline
// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('Quittance.pdf', 'I');
// END OF FILE
//============================================================+