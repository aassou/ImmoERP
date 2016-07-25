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
    $companyManager = new CompanyManager($pdo);
    $clientManager = new ClientManager($pdo);
    $projetManager = new ProjetManager($pdo);
    $reglementsPrevu = new ReglementPrevu($pdo);
    $contratCasLibre = new ContratCasLibre($pdo);
    //classes
    $idContrat = $_GET['idContrat'];
    $contrat = $contratManager->getContratById($idContrat);
    $client = $clientManager->getClientById($contrat->idClient());
    $projet = $projetManager->getProjetById($contrat->idProjet());

    $titreProjet = $projet->titre();
    $contratTitle = "فسخ عقد";
    $bien = "";
    $typeBien = "";
    $cave = "";
    $etage = "";
    if ( $contrat->typeBien() == "appartement" ) {
        $appartementManager = new AppartementManager($pdo);
        $bien = $appartementManager->getAppartementById($contrat->idBien());
        $typeBien = "شقة";
        if ( $bien->cave() == "Avec" ) {
            $cave = "بالمرأب";
        }
        else if ( $bien->cave() =="Sans" ) {
            $cave = "بدون مرأب";
        }
        $etage = $bien->niveau();        
    }
    else if ( $contrat->typeBien() == "localCommercial" ) {
        $locauxManager = new LocauxManager($pdo);
        $bien = $locauxManager->getLocauxById($contrat->idBien());
        $typeBien = "محل تجاري";
        $etage = "الطابق الأرضي";
    }
    $superficie = $bien->superficie();
    $numero = $bien->nom();
    $facade = $contrat->facadeArabe();
    $etatBien = "";
    if ( $contrat->etatBienArabe() == "GrosOeuvre" ) {
        $etatBien = "الأشغال الأساسية للبناء";    
    } 
    else if ( $contrat->etatBienArabe() == "Finition" ) {
        $etatBien = "الأشغال النهائية للبناء";
    }
    $contratReference = "";
    if ( strlen($contrat->reference()) > 1 ) {
        $contratReference = "رقم العقد : ".$contrat->reference().'-'.$contrat->id();   
    }
    $avanceLettresArabe = $contrat->avanceArabe();
    $prixLettresArabe = $contrat->prixVenteArabe();
    $idSociete = $contrat->societeArabe();
    $company = $companyManager->getCompanyById($idSociete);
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 018', PDF_HEADER_STRING);
//$pdf->SetHeaderData(false, false, false, false);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
//$pdf->setHeaderMargin(0);
// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
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
$pdf->AddPage();

// Restore RTL direction
$pdf->setRTL(true);

// set font
$pdf->SetFont('aealarabiya', '', 18);

// print newline
$pdf->Ln();
$pdf->Cell(0, 12, $contratTitle,0,1,'C');
$pdf->SetFont('aealarabiya', '', 12);
$pdf->Cell(0, 12, $contratReference,0,1,'C');
$pdf->Ln();
$pdf->SetFont('aealarabiya', '', 14);
//$pdf->Ln();
//$htmlcontent = '<strong>'.'الطرف الثاني'.'</strong>';
//$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = '<strong>'.'الطرف الأول'.'</strong>'.' : '.$company->nomArabe().'، في شخص ممثلها القانوني, و الكائن مقرها الاجتماعي '.$company->adresseArabe().'.';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
$htmlcontent = '<strong>'.'الطرف الثاني'.'</strong>'.': السيد(ة) ،'.$client->nomArabe().' '.'المغربي (ة)، الراشد(ة)، ، الحامل (ة)،  لرقم البطاقة الوطنية رقم'.$client->cin().' '.'،  العنوان و الموطن المختار و المحدد هو,'.$client->adresseArabe().'.';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->SetFont('aealarabiya', '', 18);
$pdf->Cell(0, 12, 'نص الفسخ',0,1,'C');
$pdf->SetFont('aealarabiya', '', 12);
//Contenu du contrat
//Acte 1:
$htmlcontent = '<strong>'.'البند الأول&nbsp;:&nbsp;'.'</strong>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = 'يشيد الطرف ان اعاله انيما تراضيا على فسخ العقد الذي يربط بينيما و المتعلق بحفظ حق الطرف الثاني في ملكية شقة و فق البيانات الاتية';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
//some details
$htmlcontent = 'تاريخ العقد : '.date('d/m/Y', strtotime($contrat->dateCreation()));
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
$htmlcontent = 'المشروع :'.$projet->nomArabe();
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
$htmlcontent = $typeBien." ".$bien->nom()." : الطابق ".$etage;
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
//Acte 2:
$htmlcontent = '<strong>'.'البند الثاني&nbsp;:&nbsp;'.'</strong>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = 'يشيد الطرف ان ان فسخ العقد المذكور يتم بينيما بالتراضي.';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
//Acte 3:
$htmlcontent = '<strong>'.'البند الثالث&nbsp;:&nbsp;'.'</strong>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = 'يلتزم الطرف ان بمجرد التوقيع على هذا الفسخ بعدم مطالبة اي طرف للآخر بتعويض او اداء حبيا او قضائيا اعتبارا لكون هذا الفسخ هو ابراء لذمتيما اتجاه بعضهما البعض.';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
//Acte 4:
$htmlcontent = '<strong>'.'البند الرابع&nbsp;:&nbsp;'.'</strong>';
$avance = $contrat->avance();
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = 'يشهد الطرف الثاني بشرفه و أنه في كامل قواه العقلية أنه توصل بكافة المبالغ التي كان قد أداها
بمقتضى العقد الذي قد تم فسخه و أن العقد المثبت و تواصيل الأداء لذلك و الذي سلم له من طرف الشركة قد أرجعه.
ويبرئ ذمت الشركة المذكورة و يتعهد بعدم مطالبتها بأي مبالغ أخرى و أنه عرض نفسه للمسألة الجنائية إذا أظهر أي
نسخة عن العقد و التواصيل التي سلمت له من طرف الشركة عند توقيعه على هذا الفسخ.';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
//Contrat Footer:
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('aealarabiya', '', 16);
$htmlcontent = '<strong>'.'الناظور في '.'</strong>'.date('d/m/Y');
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('aealarabiya', '', 16);
$htmlcontent = '<strong style="text-align:center">'.'التوقيع '.'</strong>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
$pdf->SetFont('aealarabiya', '', 16);
$htmlcontent = '<strong>'.'الطرف الأول '.'</strong>';
for($i=0;$i<80;$i++) { $htmlcontent.= '&nbsp;'; } ;
$htmlcontent .= '<strong>'.'الطرف الثاني '.'</strong>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
// print newline
$pdf->Ln();
// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('contrat.pdf', 'I');
// END OF FILE
//============================================================+