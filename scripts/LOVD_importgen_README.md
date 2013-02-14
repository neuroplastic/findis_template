
# LOVD Import File Generator utility

*Contents*
[Generating LOVD3 import files for genes][gen]
[Prepare your CSV files][prep]
[Align mapping of CSV columns to data# variables][align]
[Check that necessary LOVD IDs and cross-references are provided in your CSV][check]
[Point script to CSV files][point]
[Comment or uncomment import sections as needed][comment]
[Run the script and save the output][run]
[Error-check the output][error]
[Upload the Import file into LOVD3][upload]

## Generating LOVD3 import files for genes [gen]

The LOVD_importgen.php script can be used to generate import files for LOVD3. Some configuration will be necessary before the script can be used in your environment. Knowledge of PHP and CSV is required.

Be sure to check other methods of importing data to LOVD, such as:

- [Cafe Variome](http://cafevariome.org)
- [VarioML](http://varioml.org)
- [GenSearch]
- [Alamut]

Steps:

### Prepare your CSV files [prep]
 
The LOVD_importgen.php script will read a CSV file, e.g. generated from an OpenOffice or Excel table, and generate a txt file, which can be used to import variant data into LOVD3.


#### Align mapping of CSV columns to data# variables [align]

When first using this script, it is necessary to check the mapping of each row in the LOVD import file output. You may find it easier to adjust the mappings in the script, than to change the column order in your CSV files, depending on the complexity and number of your source tables.

The script assumes the CSV file to have the following columns, in this order. This order roughly corresponds to the fields in LOVD3 variant tables. The numbering gives the variable number, as read in by the script, and mapped into position for the LOVD import file.

Note that the fields listed below may be used in one or more LOVD import sections.

	0. disease_symbol 
	1. gene_symbol 
	2. n/a
	3. n/a
	4. n/a
	5. n/a
	6. n/a
	7. Transcript variant on 
	8. Exon 
	9. DNA change (HGVS format) 
	10. Published as (optional) 
	11. RNA change (HGVS format) 
	12. Protein change (HGVS format)
	13. Affects function (reported) 
	14. Affects function (concluded) 
	15. Allele 
	16. Chromosome 
	17. Genomic DNA change (HGVS format) 
	18. Published as (optional) 
	19. transcript ID 
	20. dbSNP
	21. Genetic origin 
	22. Segregation (optional)
	23. Remarks (optional) 
	24. Reference (optional) 
	25. Frequency (optional) 
	26. Re-site (optional) 
	27X Affects function (reported)
	28X Affects function (concluded)
	29. Owner of this data 
	30. Status of this data 
	31. Variant ID (not already in LOVD)

In the script, see the sections marked 'Variants_On_Genome section mapping' and 'Variants_On_Transcripts section mapping'. Comments above each section cop the headers for each section, which should assist in realigning mappings if necessary. Note that the actual header rows are printed to the import file elsewhere, in the final section of the script.

#### Check that necessary LOVD IDs and cross-references are provided in your CSV [check]

For LOVD import files to work, records must indicate to which transcripts they belong. Basic numbering is handled by the script .. Variants_on_Genome records are aligned with Variants_on_Transcripts records by the first field of each row. However, imports may also have to refer to existing Transcript_IDs or other fields.

### Point script to CSV files [point]

The $csvfile variable must be switched for each CSV file to be read. This can be done by changing the value of $csvfile to the filename and filepath from this script to your CSV file. Find this line at or near line 48.

### Comment or uncomment import sections as needed [comment]

This script currently produces LOVD3 import files with only the follwoign sections:

	## Variants_On_Genome ## Do not remove or alter this header ##
	## Variants_On_Transcripts ## Do not remove or alter this header ##

However, the script lists headers for all sections. The script can be expanded to produce output for any/all LOVD3 import sections, as needed. Here is a list of all LOVD3 section headers, which as headers only are present in the script:

	## Genes ## Do not remove or alter this header ##
	## Transcripts ## Do not remove or alter this header ##
	## Diseases ## Do not remove or alter this header ##
	## Variants_On_Genome ## Do not remove or alter this header ##
	## Variants_On_Transcripts ## Do not remove or alter this header ##
	## Genes_To_Diseases ## Do not remove or alter this header ##
	## Individuals ## Do not remove or alter this header ##
	## Individuals_To_Diseases ## Do not remove or alter this header ##
	## Phenotypes ## Do not remove or alter this header ##
	## Screenings ## Do not remove or alter this header ##
	## Screenings_To_Genes ## Do not remove or alter this header ##
	## Screenings_To_Variants ## Do not remove or alter this header ##

### Run the script and save the output [run]

Run the script from the command line: "php lovd_importgen.php"
Copy the output.
Paste the output into a text file.
Save output as GENE_NAME.txt.

### Error-check the output [error]

Unfortunately, the only way to be sure of avoiding import errors using this script, is to visually check each import file for errors using this procedure: 

1. Paste the output into a blank spreadsheet, using e.g. OpenOffice, Google sheets, or Excel. The tabs and return characters in the script's output should cause all columns and rows to fill automatically.
2. Check that each section's output aligns with the headers for that section. Note where there are errors. Find the corresponding line for each error in the output text file, and correct the error. This is typically a skipped tab. Correct the error and save the file.  
3. Tabs are sometimes skipped in output, apparently due to the character encoding in PHP being non binary-safe.

### Upload the Import file into LOVD3 [upload]


