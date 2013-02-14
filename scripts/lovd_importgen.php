<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
/*******************************************************************************
 *
 * LOVD Import File Generator
 *
 * Created     : 2012-10-09
 * Modified    : 
 * For LOVD    : 3.0
 *
 * Copyright   : 2012 GEN2PHEN; http://gen2phen.org/
 * Programmers : Juha Muilu <juha.muilu@helsinki.fi>
 *               Myles Byrne <myles.byrne@helsinki.fi>
 *
 * with much assistance from:
 *				 Ivo F.A.C Fokkema, LOVD3 Team, Leiden, NL
 *				 http://lovd.nl
 * 
 * This is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This tool is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 *************/
$genes = " ";
$genecount = 0;
$transcripts = " ";
$transcount = 0;
$diseases = " ";
$diseasecount = 0;
$vars_on_genome = " ";
$varcount = 0;
$vars_on_trans = " ";
$vartranscount = 0;
$vargen = " ";

// LOVD import file header
print "### LOVD-version 2999-080 ### Full data download ### To import, do not remove or alter this header ###\n";

// Enter filename and filepath of CSV file to read

$csvfile = "GENE.csv"; // name of csv file to import to LOVD

if (($handle = fopen($csvfile, "r")) !== FALSE) {
	while (($data = fgetcsv($handle,0,",")) !== FALSE) {

/*
 * Loop through each line of csv, placing field values into array elements
 */

/*
 *    Transcripts - data

		$trans = "\"\"	\"".$data[7]."\"\n";
*/
/*
ID used here 
\"geneid\"	\"name\"	\"id_mutalyzer\"	\"
DATA7 USED HERE
	\"id_ensembl\"	\"id_protein_ncbi\"	\"id_protein_ensembl\"	\"id_protein_uniprot\"	\"position_c_mrna_start\" \"position_c_mrna_end\"	\"position_c_cds_end\"	\"position_g_mrna_start\" \"position_g_mrna_end\"	\"created_by\"	\"created_date\"	\"edited_by\"	\"edited_date\"
*/
//		$transcount = $transcount + 1;
//		$transcripts = $transcripts . $trans;

/*
 *    Diseases - data
 */
/*
		$dis = "\"\"	\"".$data[0]."\"\n";
//		$diseasecount = $diseasecount + 1;
		$diseases = $diseases . $dis;
*/
/*
DATA 0 HERE
	\"name\"	\"id_omim\"	\"created_by\"	\"created_date\"	\"edited_by\"	\"edited_date\"
*/


/*
 *    VariantsOnGenome - data
 */

/*
 *    Helper Functions - the following functions convert typical data formats into LOVD3 formats for given fields
 */

/* 
  Assign allele ID (data15)
	0 => Unknown
	1 => Parent #1
	2 => Parent #2
	10 => Paternal (inferred)
	11 => Paternal (confirmed)
	20 => Maternal (inferred)
	21 => Maternal (confirmed)
*/
		$allid = $data[15];
		$allele = "";
		switch ($allid) {
			case "Unknown":
				$allele = 1;
				break;
			case "Paternal (inferred)":
				$allele = 10;
				break;
			case "Paternal (confirmed)":
				$allele = 11;
				break;
			case "Maternal (inferred)":
				$allele = 20;
				break;
			case "Maternal (confirmed)":
				$allele = 21;
				break;
			case "Both (homozygous)":
				$allele = 3;
				break;
			case "Both":
				$allele = 3;
				break;
			case "mother":
				$allele = 21;
				break;
			case "father":
				$allele = 11;
				break;
			default:
				$allele = "";
				break;
			}

/* 
  Assign Effect ID (data13 and 14)
	1 => No known pathogenicity
	3 => Probably no pathogenicity
	5 => Unknown
	7 => Probably pathogenic
	9 => Pathogenic
  mapped to ..
	1 => No effect
	3 => Probably no effect
	5 => Effect unknown
	7 => Probably affects function
	9 => Affects function
*/
		$effect_r = $data[13];
		$effect_c = $data[14];
		$effectid_r = "";
		$effectid_c = "";
		switch ($effect_r) {
			case "No effect":
				$effectid_r = "1";
				break;
			case "Probably no effect":
				$effectid_r = "3";
				break;
			case "Effect unknown":
				$effectid_r = "5";
				break;
			case "Probably affects function":
				$effectid_r = "7";
				break;
			case "Affects function":
				$effectid_r = "9";
				break;
			default:
				echo "No reported effect found";
				break;
			}
		switch ($effect_c) {
			case "No effect":
				$effectid_c = "1";
				break;
			case "Probably no effect":
				$effectid_c = "3";
				break;
			case "Effect unknown":
				$effectid_c = "5";
				break;
			case "Probably affects function":
				$effectid_c = "7";
				break;
			case "Affects function":
				$effectid_c = "9";
				break;
			default:
				echo "No concluded effect found";
				break;
			}
		$effectid = $effectid_r . $effectid_c;

/* 
 ## Assign segregation
	FinDis values mapped to LOVD3 values:
	- segregates w disease = 'yes'
	- segregates w phenotype = 'yes'
	- does not segregate = 'no'
	- unknown = '?'
*/
		$seg = $data[22];
		$segregation = " ";
		switch ($seg) {
			case "Segregates with disese":
				$segregation = "yes";
				break;
			case "Segregates with disease":
				$segregation = "yes";
				break;
			case "Segregates with phenotype":
				$segregation = "yes";
				break;
			case "Does not segregate":
				$segregation = "no";
				break;
			case "segregates with disease":
				$segregation = "yes";
				break;
			case "segregates with phenotype":
				$segregation = "yes";
				break;
			case "does not segregate":
				$segregation = "no";
				break;
			case "Unknown":
				$segregation = "?";
				break;
			case "unknown":
				$segregation = "?";
				break;
			default:
				$segregation = " ";
				break;
			}


// owner_id (data29)
		$ownerid = "00015";

/* 
  Assign status ID (data30)
	1 => Submitted
	4 => Non public
	7 => Marked
	9 => Public
*/
		$status = $data[30];
		$statusid = "";
		switch ($status) {
			case "Submitted":
				$statusid = "1";
				break;
			case "Non public":
				$statusid = "4";
				break;
			case "Marked":
				$statusid = "7";
				break;
			case "Public":
				$statusid = "9";
				break;
			default:
				$statusid = "0";
				break;
			}

// Truncate VariantOnGenome/Frequency free text to 15 characters, LOVD's limit.
$freqstr = " ";
$freqstr = substr($data[25], 0, 15);
//$freqstr = $data[25];

// Truncate VariantOnGenome/Published_As free text to 200 characters, LOVD's limit.
$pubstr = " ";
$pubstr = substr($data[10], 0, 200);
//$pubstr = $data[10];

// Truncate VariantOnGenome/Remarks free text to 200 characters, LOVD's limit.
$remstr = " ";
$remstr = substr($data[23], 0, 200);
//$pubstr = $data[10];

/*
Variant_on_Genome section mapping

"\"{{id}}\"	\"{{allele}}\"	\"{{chromosome}}\"	\"{{VariantOnGenome/DNA}}\"	\"{{VariantOnGenome/DBID}}\"	\"{{effectid}}\"	\"{{VariantOnGenome/Genetic_origin}}\"	\"{{VariantOnGenome/Segregation}}\"	\"{{VariantOnGenome/Remarks}}\"	\"{{VariantOnGenome/Reference}}\"	\"{{VariantOnGenome/Frequency}}\"	\"{{VariantOnGenome/Restriction_site}}\"	\"{{owned_by}}\"	\"{{statusid}}\"	\"{{created_by}}\"\n"; 
*/
$varcount = $varcount + 1;
		$vargen = "\"".$varcount."\"	\"".$allele."\"	\"".$data[16]."\"	\"".$data[17]."\"	\"".$data[19]."\"	\"".$effectid."\"	\"".$data[21]."\"	\"".$segregation."\"	\"".$remstr."\"	\"".$data[24]."\"	\"".$freqstr."\"	\"".$data[26]."\"	\"".$ownerid."\"	\"".$statusid."\"	\"".$ownerid."\"\n";
		// add new records to variant_on_genome
		$vars_on_genome = $vars_on_genome . $vargen;
/*
BTW data16 and data17:
\"position_g_start\"	\"position_g_end\" 	\"type\"	\"mapping_flags\" 	\"owned_by\"	\"created_by\" 	\"VariantOnGenome/DBID\"	
after data 17 (genome DNA change):
	\"".$data[18]."\"
	ID removed from first position - leave blank for LOVD, so replaced with empty field: 
	\"".$data[19]."\"	
	DBID Removed from fourth position - best to leave blank and let LOVD assign, , so replaced with empty field: 	\"".$data[31]."\"
*/


/*
 *    Variants_On_Transcripts section mapping

 "\"{{id}}\"	\"{{transcriptid}}\"	\"{{VariantOnTranscript/DNA}}\"	\"{{VariantOnTranscript/Exon}}\"	\"{{VariantOnTranscript/Protein}}\"	\"{{VariantOnTranscript/RNA}}\"	\"{{effectid}}\"	\"{{VariantOnTranscript/Published_as}}\"\n";
 */
		$vartrans = "\"".$varcount."\"	\"".$data[7]."\"	\"".$data[9]."\"	\"".$data[8]."\"	\"".$data[12]."\"	\"".$data[11]."\"	\"".$effectid."\"	\"".$pubstr."\"\n";
//		$vartranscount = $vartranscount + 1;
		// add new records to variant_on_genome
		$vars_on_trans = $vars_on_trans . $vartrans;
/*
AFTER id BEFORE data9:
		\"effectid\"	\"position_c_start\"	\"position_c_start_intron\"	\"position_c_end\"	\"position_c_end_intron\"	
		NM transcriptids not supported -  \"".$data[7]."\" removed from second position, replaced correctly with LOVD ID (which was previously incorrectly in ID section.)
*/
	}
	fclose($handle);
}

/*
 *    Genes section header
*/
print "\n## Genes ## Do not remove or alter this header ##\n";
// print "## Count = ".$genecount."\n";
// print "\"{{id}}\"\n";
// print $genes;
/*
AFTER id:
	\"{{name}}\"	\"{{chromosome}}\"	\"{{chrom_band}}\"	\"{{imprinting}}\"	\"{{refseq_genomic}}\"	\"{{refseq_UD}}\"	\"{{reference}}\"	\"{{url_homepage}}\"	\"{{url_external}}\"	\"{{allow_download}}\"	\"{{allow_index_wiki}}\"	\"{{id_hgnc}}\" \"{{id_entrez}}\"	\"{{id_omim}}\"	\"{{show_hgmd}}\"	\"{{show_genecards}}\"	\"{{show_genetests}}\"	\"{{note_index}}\"	\"{{note_listing}}\"	\"{{refseq}}\"	\"{{refseq_url}}\"	\"{{disclaimer}}\"	\"{{disclaimer_text}}\"	\"{{header}}\"	\"{{header_align}}\"	\"{{footer}}\"	\"{{footer_align}}\"	\"{{created_by}}\"	\"{{created_date}}\"	\"{{edited_by}}\"	\"{{edited_date}}\" \"{{updated_by}}\"	\"{{updated_date}}\"
*/

/*
 *    Transcripts section header
*/
print "\n## Transcripts ## Do not remove or alter this header ##\n";
// print "## Count = ".$transcount."\n";
// print "\"{{id}}\"	\"{{id_ncbi}}\"\n";
// print $transcripts;
/*
id HERE
\"{{geneid}}\"	\"{{name}}\"	\"{{id_mutalyzer}}\"	
id_ncbi USED HERE
	\"{{id_ensembl}}\"	\"{{id_protein_ncbi}}\"	\"{{id_protein_ensembl}}\"	\"{{id_protein_uniprot}}\"	\"{{position_c_mrna_start}}\"	\"{{position_c_mrna_end}}\"	\"{{position_c_cds_end}}\"	\"{{position_g_mrna_start}}\"	\"{{position_g_mrna_end}}\"	\"{{created_by}}\"	\"{{created_date}}\"	\"{{edited_by}}\"	\"{{edited_date}}\"
*/


/*
 *	Diseases section header
*/
print "\n## Diseases ## Do not remove or alter this header ##\n";
// print "## Count = ".$diseasecount."\n";
// print "\"{{id}}\"	\"{{symbol}}\"\n";
// used here: $data[0]
// print $diseases;
/*
id and symbol HERE
	\"{{name}}\"	\"{{id_omim}}\"	\"{{created_by}}\"	\"created_date}}\"	\"{{edited_by}}\"	\"{{edited_date}}\"
*/

/*
 *	Variants On Genome section header
 */
print "\n## Variants_On_Genome ## Do not remove or alter this header ##\n";
// print "## Count = ".$varcount."\n";
print "\"{{id}}\"	\"{{allele}}\"	\"{{chromosome}}\"	\"{{VariantOnGenome/DNA}}\"	\"{{VariantOnGenome/DBID}}\"	\"{{effectid}}\"	\"{{VariantOnGenome/Genetic_origin}}\"	\"{{VariantOnGenome/Segregation}}\"	\"{{VariantOnGenome/Remarks}}\"	\"{{VariantOnGenome/Reference}}\"	\"{{VariantOnGenome/Frequency}}\"	\"{{VariantOnGenome/Restriction_site}}\"	\"{{owned_by}}\"	\"{{statusid}}\"	\"{{created_by}}\"\n"; 
// used here: $data[] 
print $vars_on_genome;
/*
BTW Chromosom and VarOnGen/DNA:
\"{{position_g_start}}\"	\"{{position_g_end}}\"	\"{{type}}\"	\"{{mapping_flags}}\"	\"{{owned_by}}\"	\"{{created_by}}\"	\"{{VariantOnGenome/DBID}}\"
*/

/*
 *	Variants On Transcript section header
 */
print "\n## Variants_On_Transcripts ## Do not remove or alter this header ##\n";
// print "## Count = ".$vartranscount."\n";
print "\"{{id}}\"	\"{{transcriptid}}\"	\"{{VariantOnTranscript/DNA}}\"	\"{{VariantOnTranscript/Exon}}\"	\"{{VariantOnTranscript/Protein}}\"	\"{{VariantOnTranscript/RNA}}\"	\"{{effectid}}\"	\"{{VariantOnTranscript/Published_as}}\"\n";
print $vars_on_trans;
/*
AT START after \"{{id}}\" and :
\"{{transcriptid}}\"	\"{{effectid}}\"	\"{{position_c_start}}\"	\"{{position_c_start_intron}}\"	\"{{position_c_end}}\"	\"{{position_c_end_intron}}\"	
ID removed from first position - let LOVD fill on: \"{{id}}\"	
*/

print "\n## Genes_To_Diseases ## Do not remove or alter this header ##\n";

print "\n## Individuals ## Do not remove or alter this header ##\n";

print "\n## Individuals_To_Diseases ## Do not remove or alter this header ##\n";

print "\n## Phenotypes ## Do not remove or alter this header ##\n";

print "\n## Screenings ## Do not remove or alter this header ##\n";

print "\n## Screenings_To_Genes ## Do not remove or alter this header ##\n";

print "\n## Screenings_To_Variants ## Do not remove or alter this header ##\n";
?>