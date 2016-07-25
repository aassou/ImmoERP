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
    $contratTitle = "";
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
        $contratTitle = "عقد حفظ الحق في ملكية شقة";
        $etage = $bien->niveau();        
    }
    else if ( $contrat->typeBien() == "localCommercial" ) {
        $locauxManager = new LocauxManager($pdo);
        $bien = $locauxManager->getLocauxById($contrat->idBien());
        $typeBien = "محل تجاري";
        $contratTitle = "عقد حفظ الحق في ملكية محل تجاري";
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
$pdf->Cell(0, 12, 'نص العقد',0,1,'C');
$pdf->SetFont('aealarabiya', '', 12);
//Contenu du contrat
//Acte 1:
$htmlcontent = '<strong>'.'البند الأول&nbsp;:&nbsp;'.'</strong>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = 'يقر الطرفان بأهليتهما للتعاقد و التصرف القانوني طبقا لقواعد حسن النية و التراض وبدون قهر ولا غبن.';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
//Acte 2:
$htmlcontent = '<strong>'.'البند الثاني&nbsp;:&nbsp;'.'</strong>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = 'اتفق الطرفان على أن هدا العقد ليس عقد بيع ابتدائي، وغير ناقل لملكية الوحدة العقارية إلا بعد سداد كامل الثمن إلى الطرف الأول و إبرام
العقد النهائي وفق الشروط و الشكليات المحددة في القانون.';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
//Acte 3:
$htmlcontent = '<strong>'.'البند الثالث&nbsp;:&nbsp;'.'</strong>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = 'يقر الطرف الأول انه يحفظ حق الطرف الثاني في شراء '.$typeBien.' '.$cave.' .في مشروعه السكني المسمى ب'.$projet->nomArabe().' '.'الكائن ب'.$projet->adresseArabe().' وفق المواصفات الآتية&nbsp;:&nbsp;';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
//Acte 3 : Details
    //Detail 1:
    $htmlcontent = '<div style="margin-right:100px; margin-left:100px;">';
    $htmlcontent .= '1. مساحة ال'.$typeBien.' : المساحة الهندسية المبنية بالتقريب '.$superficie.' متر مربع،. و المساحة المحفظة، سيتم الحصول عليها من طرف إدارة
    المحافظة العقارية عند الحصول على التحفيظ العقاري لل'.$typeBien.'.';
    $pdf->WriteHTML($htmlcontent, true, 0, true, 0);
    //Detail 2:
    $htmlcontent = '2. الطابق : '.$etage;
    $pdf->WriteHTML($htmlcontent, true, 0, true, 0);
    //Detail 3:
    $rue = 80;
    $htmlcontent = '3. الواجهة : تطل على شارع '.$facade.'  متر ';
    $pdf->WriteHTML($htmlcontent, true, 0, true, 0);
    //Detail 4:
    $htmlcontent = '4. الرقم : '.$numero;
    $pdf->WriteHTML($htmlcontent, true, 0, true, 0);
    //Detail 5:
    $htmlcontent = '5.وضعية ال'.$typeBien.' وفق الاتفاق  : تسليم ال'.$typeBien.' في وضعية '.$etatBien.'.';
    $pdf->WriteHTML($htmlcontent, true, 0, true, 0);
    //Detail 6:
    $htmlcontent = '6.الرسم العقاري الأم : '.$titreProjet;
    $htmlcontent .= '</div>';
    $pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
//Acte 4:
$htmlcontent = '<strong>'.'البند الرابع&nbsp;:&nbsp;'.'</strong>';
$avance = $contrat->avance();
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = 'يؤدي الطرف الثاني للطرف الأول من أجل حفظ حقه في ملكية '.$typeBien.' موضوع العقد مبلغ تسبيق حدد بالتراضي في '.$avance.' درهم ( '.$avanceLettresArabe.' درهم) ، مقابل توصيل مفصل كوسيلة وحيدة لإثبات الأداء، وذلك في أجل لا يتعدى خمسة ايام ابتدءا من تاريخ توقيع هذا العقد..';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
//Acte 5:
$montant = $contrat->prixVente();
$htmlcontent = '<strong>'.'البند الخامس&nbsp;:&nbsp;'.'</strong>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = 'اتفق الطرفان على تحديد الثمن النهائي لبيع ال'.$typeBien.' '.$cave.' في مبلغ   درهم '.$montant.'('.$prixLettresArabe.' درهم). يؤديها الطرف الثاني للطرف الأول على شكل أقساط ابتدءا من قسط التسبيق إلى تاريخ انتهاء الأشغال المتعلقة بتسليم ال'.$typeBien.' وذلك حسب الدفعات المبينة في الجدول المرفق .';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
//Acte 6:
$htmlcontent = '<strong>'.'البند السادس&nbsp;:&nbsp;'.'</strong>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = 'يوجه الطرف الأول للطرف الثاني إخطارا مكتوبا في الموطن و العنوان الذي حدده الطرف الثاني في هدا العقد في حالة التماطل أو التوقف عن أداء الأقساط أو باقي الثمن و ذلك بإحدى الوسائل المنصوص عليها في الفصل 38 و 37 من قانون المسطرة المدنية.';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
//Acte 7:
$htmlcontent = '<strong>'.'البند السابع&nbsp;:&nbsp;'.'</strong>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = 'يحدد الطرف الأول أجلا لا يقل عن 15 يوما في إخطاره الموجه للطرف الثاني ابتدءا من تاريخ التوصل لأداء الأقساط أو باقي  الثمن. ';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
//Acte 8:
$htmlcontent = '<strong>'.'البند الثامن&nbsp;:&nbsp;'.'</strong>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = 'يقر الطرف الثاني أن العنوان الذي اختاره وحدده في هدا العقد هو موطنه  المختار من طرفه و أنه يتحمل مسؤولية عدم توصله في حالة رجوع الإفادة بعبارة (العنوان ناقص) أو عبارة (غير مطالب به في البريد ) أو أي عبارة أخرى يفيد معناها الخطأ أو التحايل أو التلاعب في العنوان.';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
//Acte 9:
$htmlcontent = '<strong>'.'البند التاسع&nbsp;:&nbsp;'.'</strong>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = ' يتعهد الطرف الأول بعد انصرام أجل 15 يوما المحدد في إخطاره الموجه للطرف الثاني إن يرجع مبلغ التسبيق و كدا الإقساط التي قد يكون تم أداؤها للطرف الثاني شريطة أن يدلى هدا الأخير بالتواصيل المثبتة للأداء.كما يتعهد بدلك في حالة الاتفاق على انجازه لأشغال بناء الأساسية فقط بعد انصرام أجل ثلاثة أشهر عن تاريخ توصل الطرف الثاني بالاخطار المنصوص عليه في هدا العقد ';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
//Acte 10:
$htmlcontent = '<strong>'.'البند العاشر&nbsp;:&nbsp;'.'</strong>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = 'يحق للطرف الأول التصرف في ال'.$typeBien.' موضوع العقد مباشرة بعد انتهاء الآجال المحددة في الأخطار المنصوص عليه في هذا العقد. ';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
//Acte 11:
$htmlcontent = '<strong>'.'البند الحادي عشر&nbsp;:&nbsp;'.'</strong>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = 'لا يحق للطرف الثاني المطالبة بأي تعويض سواء وديا أو قضائيا بعد انصرام الأجل المحدد له في الإخطار الموجه له باستثناء تمكينه من المبالغ المثبتة في التواصيل الصادرة عن الطرف الأول.';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
//Acte 12:
$htmlcontent = '<strong>'.'البند الثاني عشر&nbsp;:&nbsp;'.'</strong>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = 'اتفق الطرفان في حالة تماطل الطرف الثاني بعد توجيه الإخطار المنصوص عليه في البندين السادس و السابع و انصرام الأجل المحدد إخضاع هدا العقد لمقتضيات الفقرة الثانية من الفصل 114 من قانون الالتزامات و العقود.';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
//Autres Actes
//$htmlcontent = '<strong>'.'بنود أخرى&nbsp;:&nbsp;'.'</strong>';
//$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = $contrat->articlesArabes();
$pdf->WriteHTML($contrat->articlesArabes(), true, 0, true, 0);
$pdf->Ln();
//Acte 13:
$htmlcontent = '<strong>'.'البند الأخير&nbsp;:&nbsp;'.'</strong>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = 'يعد هذا العقد عرفيا و ملزما لطرفيه فقط يحفظ حقوقهما في مواجهة بعضهما بمجرد التوقيع عليه دون تصحيح الإمضاء في انتظار إبرام عقد البيع النهائي وفق الشروط و الشكليات المحددة قانونا.';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
//Contrat Footer:
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('aealarabiya', '', 16);
$htmlcontent = '<strong>'.'الناظور في '.'</strong>'.date('d/m/Y', strtotime($contrat->dateCreation()));
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