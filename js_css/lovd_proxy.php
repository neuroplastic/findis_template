<?php
include_once('simple_html_dom.php');
require('phpQuery-onefile.php');

// Retrieve gene name in HTTP request
$gene = isset($_GET['gene'])?$_GET['gene']:false;
if (!$gene) {
    header("HTTP/1.0 400 Bad Request");
    echo "Gene parameter is missing";
    exit();
}

// Map gene into LOVD URI for Finnish variants
$lovd_url = "http://databases.lovd.nl/shared/variants/".$gene."?search_VariantOnGenome/Remarks=finnish&in_window&page_size=25&page=1";
$html = file_get_html($lovd_url);

// Replace call to LOVD's View script with one using proxy server 
$html->find('script[src=inc-js-viewlist.php]', 0)->src = 'http://127.0.0.1:8080/FinDIs_from_LOVD/proxy.php?proxy_url=http://databases.lovd.nl/shared/inc-js-viewlist.php';

// Remove unwanted columns and decorations

// Remove LOVD header
$html->find('h2[class=LOVD]', 0)->innertext = '';
$html->find('h2[class=LOVD]', 0)->outertext = '';

// Remove Legend link
$html->find('b[class=legend]', 0)->innertext = '';
$html->find('b[class=legend]', 0)->outertext = '';

$html->find('b[class=legend]', 1)->innertext = '';
$html->find('b[class=legend]', 1)->outertext = '';

// Remove hidden Legend table
$html->find('table[class=info]', 0)->innertext = '';
$html->find('table[class=info]', 0)->outertext = '';

// Remove DB_ID

$html->find('th[title="database ID of variant starting with the HGNC gene symbol, followed by an underscore (_) and a six digit number (e.g. DMD_012345). _000000 is used for variants where DNA was not analysed (change predicted from RNA analysis), variants seen in animal models or variants not seen in humans but functionally tested in vitro"]', 0)->innertext = '';
$html->find('th[title="database ID of variant starting with the HGNC gene symbol, followed by an underscore (_) and a six digit number (e.g. DMD_012345). _000000 is used for variants where DNA was not analysed (change predicted from RNA analysis), variants seen in animal models or variants not seen in humans but functionally tested in vitro"]', 0)->outertext = '';

$idgn = $gene."_00";
$idrows = $html->find('td[plaintext^='.$idgn.']');
foreach($idrows as $idrow){
$idnm = (count($idrow));
$idnm = $idnm - 2;
$html->find('td[plaintext^='.$idgn.']',$idnm)->outertext = '';
$html->find('td[plaintext^='.$idgn.']',$idnm)->innertext = '';
}

$html->find('td[plaintext^='.$idgn.']',$idnm - 1)->innertext = '';
// $html->find('td[plaintext^='.$idgn.']',$idnm - 1)->outertext = '';

// END Remove DB_ID

// Remove Effect - uses + character
$html->find('th[title="The variant\'s effect on the protein\'s function, in the format Reported/Curator concluded; ranging from \'+\' (variant affects function) to \'-\' (does not affect function)."]', 0)->innertext = '';
$html->find('th[title="The variant\'s effect on the protein\'s function, in the format Reported/Curator concluded; ranging from \'+\' (variant affects function) to \'-\' (does not affect function)."]', 0)->outertext = '';

$idrows = $html->find('td[plaintext^="+"]');
foreach($idrows as $idrow){
$idnm = (count($idrow));
$idnm = $idnm - 2;
$html->find('td[plaintext^="+"]',$idnm)->outertext = '';
$html->find('td[plaintext^="+"]',$idnm)->innertext = '';
}

// $html->find('td[plaintext^="NPHS1_00"]',$idnm - 1)->innertext = '';
$html->find('td[plaintext^="+"]',$idnm - 1)->outertext = '';
// END Remove Effect

// Remove page splitting navigation dropdown
$html->find('table[class=pagesplit_nav]', 0)->innertext = '';
$html->find('table[class=pagesplit_nav]', 0)->outertext = '';
$html->find('table[class=pagesplit_nav]', 1)->innertext = '';
$html->find('table[class=pagesplit_nav]', 1)->outertext = '';

// Remove column form inputs
// $html->find('form[id=viewlistForm_CustomVL_VOT_VOG_LCT]', 0)->style = 'margin : 0px; visibility : hidden;';
$html->find('input[name=search_VariantOnTranscript/Exon]', 0)->style = 'width : 44px; font-weight : normal; visibility : hidden;';
$html->find('input[name=search_VariantOnTranscript/DNA]', 0)->style = 'width : 44px; font-weight : normal; visibility : hidden;';
$html->find('input[name=search_VariantOnTranscript/RNA]', 0)->style = 'width : 44px; font-weight : normal; visibility : hidden;';
$html->find('input[name=search_VariantOnTranscript/Protein]', 0)->style = 'width : 44px; font-weight : normal; visibility : hidden;';

$html->find('input[name=search_VariantOnGenome/DNA]', 0)->style = 'width : 44px; font-weight : normal; visibility : hidden;';
$html->find('input[name=search_VariantOnGenome/Published_as]', 0)->style = 'width : 44px; font-weight : normal; visibility : hidden;';
$html->find('input[name=search_VariantOnGenome/dbSNP]', 0)->style = 'width : 44px; font-weight : normal; visibility : hidden;';
$html->find('input[name=search_VariantOnGenome/Genetic_origin]', 0)->style = 'width : 44px; font-weight : normal; visibility : hidden;';
$html->find('input[name=search_VariantOnGenome/Segregation]', 0)->style = 'width : 44px; font-weight : normal; visibility : hidden;';
$html->find('input[name=search_VariantOnGenome/Frequency]', 0)->style = 'width : 44px; font-weight : normal; visibility : hidden;';
$html->find('input[name=search_VariantOnGenome/Restriction_site]', 0)->style = 'width : 44px; font-weight : normal; visibility : hidden;';
$html->find('input[name=search_VariantOnGenome/Remarks]', 0)->style = 'width : 44px; font-weight : normal; visibility : hidden;';
$html->find('input[name=search_VariantOnGenome/Reference]', 0)->style = 'width : 44px; font-weight : normal; visibility : hidden;';
$html->find('input[name=search_owned_by_]', 0)->style = 'width : 44px; font-weight : normal; visibility : hidden;';


// Remove ordering arrows
// $html->find('img')->style = 'visibility : hidden;';
$imgr = 0;
foreach($html->find('img') as $element){
$html->find('$img',$imgr)->outertext = '';
$html->find('$img',$imgr)->innertext = '';
$imgr = $imgr + 1;
}

//Change onclicks (for ea. TR) to open LOVD variant page in new window
$cknm = 0;
foreach($html->find('tr[onclick]') as $element){
$nclks = $html->find('tr[onclick]',$cknm);
$mpat = 'location.href = ';
$npat = 'open(';
$n2clks = str_replace($mpat, $npat, $nclks);

$m2pat = ';">  ';
$n2pat = ');">  ';
$n3clks = str_replace($m2pat, $n2pat, $n2clks);

$html->find('tr[onclick]',$cknm)->outertext = $n3clks;
$cknm = $cknm + 1;
}

// Add base target of _blank for opening LOVD links in new window 
$html->find('base', 0)->target = '_blank';

// Switch out to modified stylesheet
$html->find('link[rel=stylesheet]', 0)->href = 'http://127.0.0.1:8080/FinDIs_from_LOVD/styles.css';

// Write altered LOVD table to FinDis page
echo $html;

$html->clear();
?>