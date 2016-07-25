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
    $contratEmployeManager = new ContratEmployeManager($pdo);
    $companyManager = new CompanyManager($pdo);
    $clientManager = new ClientManager($pdo);
    $projetManager = new ProjetManager($pdo);
    $employeManager = new EmployeManager($pdo);
    //classes
    $idContrat = $_GET['idContratEmploye'];
    $contrat = $contratEmployeManager->getContratEmployeById($idContrat);
    $projet = $projetManager->getProjetById($contrat->idProjet());
    $employe = $employeManager->getEmployeById($contrat->employe());
    //choix unité en arabe selon la valeur de l'unité
    $unite = "";
    if ( $contrat->unite() == "m²" ) {
        $unite = "المتر المربع";
    } 
    else if ( $contrat->unite() == "m lineaire" ) {
        $unite = "المتر الخطي";
    }
    else if ( $contrat->unite() == "appartement" ) {
        $unite = "الشقة";
    }
    else if ( $contrat->unite() == "unite" ) {
        $unite = $contrat->nomUniteArabe();
    }
    //choix unité 2 en arabe selon la valeur de l'unité
    $unite2 = "";
    if ( $contrat->unite2() == "m²" ) {
        $unite2 = "المتر المربع";
    } 
    else if ( $contrat->unite2() == "m lineaire" ) {
        $unite2 = "المتر الخطي";
    }
    else if ( $contrat->unite2() == "appartement" ) {
        $unite2 = "الشقة";
    }
    else if ( $contrat->unite2() == "unite" ) {
        $unite2 = $contrat->nomUniteArabe2();
    }
    $titreProjet = $projet->titre();
    $contratTitle = "تعاقد و اتفاق";
    $idSociete = $contrat->idSociete();
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
$pdf->Ln();
$pdf->SetFont('aealarabiya', '', 14);
//$pdf->Ln();
//$htmlcontent = '<strong>'.'الطرف الثاني'.'</strong>';
//$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = '<strong>'.'الطرف الأول'.'</strong>'.' : '.$company->nomArabe().'، في شخص ممثلها القانوني, و الكائن مقرها الاجتماعي '.$company->adresseArabe().'.';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
$htmlcontent = '<strong>'.'الطرف الثاني'.'</strong>'.': السيد(ة) ،'.$employe->nomArabe().' '.'المغربي (ة)، الراشد(ة) ، الحامل (ة)،  لرقم البطاقة الوطنية رقم'.$employe->cin().' '.'،  العنوان و الموطن المختار و المحدد هو,'.$employe->adresseArabe().'.';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->SetFont('aealarabiya', '', 18);
$pdf->Cell(0, 12, 'نص العقد و الاتفاق',0,1,'C');
$pdf->SetFont('aealarabiya', '', 12);
//Contenu du contrat
//Acte 1:
$htmlcontent = '<strong>'.'البند الأول&nbsp;:&nbsp;'.'</strong>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = 'يقر الطرفان بأهليتهما للتعاقد و التصرف القانوني طبقا لقواعد حسن النية و التراضي.';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
//Acte 2:
$htmlcontent = '<strong>'.'البند الثاني&nbsp;:&nbsp;'.'</strong>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = ' اتفق الطرفان على ان ينجز الطرف الثاني أشغال '.$contrat->traveauxArabe().' في المشروع السكني الذي يملكه الطرف الأول  ذو 
الرسوم العقارية الأم عدد'.$projet->titre();
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
//Acte 3:
$htmlcontent = '<strong>'.'البند الثالث&nbsp;:&nbsp;'.'</strong>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = 'حدد الطرفان الأشغال المذكورة و التي سينجزها الطرف الثاني لفائدة الطرف  الأول فيما يلي : ';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
$htmlcontent = '<ul><li>'.ceil($contrat->nombreUnites()).' '.$contrat->nomUniteArabe().' مقابل '.$contrat->prixUnitaire().' درهم  لكل '.$contrat->nomUniteArabe().'</li>';
if ( $contrat->prixUnitaire2() != 0 ) {
    $htmlcontent .= '<li>'.ceil($contrat->nombreUnites2()).' '.$contrat->nomUniteArabe2().' مقابل '.$contrat->prixUnitaire2().' درهم  لكل '.$contrat->nomUniteArabe2().'</li>';    
}
$htmlcontent .= '</ul>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
//Acte 4:
$htmlcontent = '<strong>'.'البند الرابع&nbsp;:&nbsp;'.'</strong>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = 'اتفق الطرفان على أن تمتد فترة الأشغال المذكورة من تاريخ  '.date('d/m/Y', strtotime($contrat->dateContrat())).' إلى غاية '.date('d/m/Y', strtotime($contrat->dateFinContrat()));
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
$htmlcontent = 'آو الجودة و المواصفات المحددة في هذا العقد فانه يؤدي تعويضا يقدر حسب الضرر الناجم عن تأخر إنجاز الأشغال المذكورة بعد 
انتداب احد الخبراء المتخصصين يختاره الطرفان بالتراضي أو يعين قضائيا مع التزام الطرف الثاني بأداء أتعابه و التزام الطرف 
الأول بإرجاعها في حالة ثبوت عدم وجود أي خلل في المدة أو المواصفات و الجودة';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
//Acte 5:
$htmlcontent = '<strong>'.'البند الخامس&nbsp;:&nbsp;'.'</strong>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = 'يستفيد الطرف الثاني مقابل أشغال  '.$contrat->traveauxArabe().' موضوع هذا التعاقد بمقابل مالي كالتالي:';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
$htmlcontent = '<ul><li>'.$contrat->prixUnitaire().' درهم  مقابل كل '.$unite.'</li>';
if ( $contrat->prixUnitaire2() != 0 ) {
    $htmlcontent .= '<li>'.$contrat->prixUnitaire2().' درهم  مقابل كل '.$unite2.'</li>';       
}
$htmlcontent .= '<li>المجموع : '.(($contrat->nombreUnites()*$contrat->prixUnitaire())+($contrat->nombreUnites2()*$contrat->prixUnitaire2())).' درهم </li></ul>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
$htmlcontent = 'و سيتم أداء المبلغ الإجمالي لكلفة ألأشغال التي سيقوم بها الطرف الثاني عن طريق دفعات مالية.';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
//Acte 6:
$htmlcontent = '<strong>'.'البند السادس&nbsp;:&nbsp;'.'</strong>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = 'يحرم الطرف الثاني من المقابل المتفق عليه في البند الخامس في حالة عدم قيامه  بالأشغال المتفق عليها في هذا العقد نهائيا أو عدم 
احترامه الجودة و المواصفات المذكورة فيه.';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
//Acte 7:
$htmlcontent = '<strong>'.'البند السابع&nbsp;:&nbsp;'.'</strong>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = 'يصبح هذا التعاقد ملغيا دون الحاجة إلى توجيه أي إنذار في حالة عدم قيام الطرف الثاني بمباشرة الأشغال.
وفي حالة وجود آلات و معدات أو سلع احضرها الطرف الثاني للورش دون أن يباشر الأشغال يوجه له الطرف الأول إنذارا كتابيا 
في العنوان الذي حدده في هذا العقد يخبره فيه انه يضع رهن إشارته الآلات و المعدات و السلع الموضوعة في الورش بعد أن أصبح
الاتفاق ملغيا ضمنيا للإخلال بالالتزام طبقا لمقتضيات الفصل 114 من ق. ل .ع.. ';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
//Acte 8:
$htmlcontent = '<strong>'.'البند الثامن&nbsp;:&nbsp;'.'</strong>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = 'يشهد الطرفان أن العناوين التي اختاراها في هذا العقد صحيحة و أنهما يتحملان مسؤولية عدم التوصل لخلل في العنوان.';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
//Acte 9:
$htmlcontent = '<strong>'.'البند التاسع&nbsp;:&nbsp;'.'</strong>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = 'يتحمل الطرف الثاني مسؤولية المستخدمين الذين  ينجز الأشغال بواسطتهم في الورش و   المشروع السكني موضوع هذا التعاقد و 
في حالة وقوع حادثة شغل أو تسببهم في أي ضرر يمس مصالح الطرف الأول.';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
//Acte 10:
$htmlcontent = '<strong>'.'البند العاشر&nbsp;:&nbsp;'.'</strong>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = 'اتفق الطرفان أن يتحمل الطرف الثاني مسؤولية الضرر الذي قد يلحق ما أنجزه من أشغال داخل اجل سنة كاملة ابتداء من تاريخ التسليم';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
//Acte 11:
$htmlcontent = '<strong>'.'البند الحادي عشر&nbsp;:&nbsp;'.'</strong>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = 'اتفق الطرفان أن ينعقد الاختصاص القضائي في حالة النزاع للدائرة القضائية لمحكمة الاستئناف بالناظور.';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$pdf->Ln();
//Acte 12:
$htmlcontent = '<strong>'.'البند الثاني عشر&nbsp;:&nbsp;'.'</strong>';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
$htmlcontent = 'يعد هذا التعاقد و الاتفاق عرفيا و ملزما لطرفيه يحفظ حقوقهما في مواجهة بعضهما و مواجهة الغير بمجرد التوقيع عليه.';
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
$htmlcontent = 'في حالة حادثة شغل أو نزاع بخصوص هذا العقد، كما أنه يقر أنه سيؤدي لهم المقابل المالي الخاص بأنجازهم للعمل المتفق عليه..';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
//Contrat Footer:
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('aealarabiya', '', 16);
$htmlcontent = '<strong>'.'الناظور في '.'</strong>'.date('d/m/Y', strtotime($contrat->dateContrat()));
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
$pdf->Output('contrat-employe.pdf', 'I');
// END OF FILE
//============================================================+