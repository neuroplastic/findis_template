# FinDis Website Template README

*Contents*  
[Introduction][intro]  
[Using the Country Node Website Template][using]  
[Site Template browser compatibility][compat]  
[Homepage][home]  
[Diseases][diseases]  
[Disease description snippets][dis_desc]  
[Genes | genes.html][genes]  
[LOVD3 genes][lovd3_genes]  
[Gene listings - concealed data:][gene_concealed]  
[Gene listings - alternate versions:][gene_alt]  
[Modifying lovd_proxy.html][mod_proxy]  
[LOVD2 genes][lovd2_genes]  
[Generating new native variant tables for LOVD2 Genes][tablegen]  
[Generating new native variant downloads for LOVD2 Genes][tablegen2]  
[Modifying lovd_tablegen.php][mod_tablegen]  
[Battenin Genes][battenin]  
[Publications | publications.html][pubs]  
[Disease Heritage, About, and Links pages][about]  


## Introduction [intro]

This is an open-source template for generating an online resource  collecting and organizing the information on diseases and related genetic variants for specific cultural and national populations. 

This template was used to create the FinDis Finnish Disease Database, http://findis.org. Finland is exceptionally well-represented as a population with known diseases and related genetic variations. As such, generating the Finnish version of this resource may act as both template and example for other countries to organize information similarly critical for alleviating diseases with genetic causes. 

This project is not directly affiliated with the Human Variome Project or its Country Nodes initiative, but takes its mission and inspiration from the same. See the paper, 'Human Variome Project country nodes: documenting genetic information within a country' at 
http://www.ncbi.nlm.nih.gov/pubmed/22753370.

This project is not a complete prototype of an HVP Country Node, but rather is a step towards a standardized, open-source set of resources to help all countries establish such resources, at low cost and with minimal technical requirements.

The assistance and support of the Leiden Open Variation Database was and continues to be essential to this project, providing the standards-based database format and many of the most important features of this resource.

As open-source, this software is made available free of charge, but also without support, beyond the documentation provided here. This is free software: it can be redistributed and/or modified under the terms of the GNU General Public License as published by the Free Software Foundation. This software is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details: http://www.gnu.org/licenses/gpl.html.

## Using the Country Node Website Template [using]

This template site comes with some genes, diseases, and publications already listed in final form. These are provided both as examples, and in the likely event that some of the genes and diseases will apply to other countries.

Use of this template begins with creating a copy of the template. This should only be a fork of the GitHub repository, if you plan to improve the Country Node site as a template, and make those improvements available as open source. Otherwise, create a copy of this template using the ZIP or TAR download buttons presented on the [GitHub Findis-dB page here](http://github.com/findis-db/).

Each LOVD3 gene-specific page fetches native and non-native variants for that gene live from the LOVD3 database. Your first act of customization should be to cause this template to separate the native and non-native variants for the genes specific to your country or ethnic group. Note that the selector used in this template for native variants is the use of this national or ethnically descriptive term in the *VariantOnGenome/Remark* field for variants stored in LOVD3.  

After identifying which of the included diseases and genes apply to your country, the rest should be deleted from your template. Then, duplicate existing gene, disease, and publication pages and listings as needed. The ability to edit HTML is the core requirement, with an intermediate understanding of javascript and PHP necessary to fully customize the site template.

### Site template compatibility [compat]
The site template has been tested and is compatible with all major browsers and browser versions currently in use:

IE 8 - 6.8%  
IE 9 - 6%  
Firefox 11 * - 31%  
Safari 5.1 * - 4.2%  
Chrome 18 - Win - 47%  

* = not the latest version, but an earlier version, effectively testing all later versions, since this browser is standards-compliant


## Homepage [home]

The homepage and all webpages use Bootstrap CSS, live-loaded from the web:

http://twitter.github.com/bootstrap/assets/css/bootstrap.css
http://twitter.github.com/bootstrap/assets/css/bootstrap-responsive.css

## Diseases [diseases]

*location: diseases.html*

The disease list page (diseases.html) passes a token to a wrapper page (disease.html), which reads the disease description snippet from the diseases directory.

### Disease description snippets [dis_desc]

*location: /diseases/*

The Disease description snippets in the diseases folder can be edited to update disease descriptions. 

Each Disease description snippet links to the Gene pages for genes associated with the given disease. These links pass critical information on the gene to the gene page template. These are the same links used to link to gene pages from the Gene listing page. *Please note that changes to the gene-specific links on the Gene listing page must be mirrored in the links to genes from disease description snippets.* 

## Genes [genes]

*location:  genes.html*

The Gene listing links to gene-specific pages. These links pass critical information on the gene to the gene page template:

   lovd_proxy.html?gene=AGA&name=%20Aspartylglucosaminidase&ensemb=ENSG00000038002&disease=AGU&omim=613228&ncbi=175

These are the same links used to link to gene pages from the disease description snippets in /diseases. *Please note that changes to the gene-specific links on the Gene listing page must be mirrored in the links to genes from disease description snippets.* 

### LOVD3 genes [lovd3_genes]

Each LOVD3 gene-specific page fetches native and non-native variants for that gene live from LOVD3.

To change the country, modifying the lovd_proxy.html file at line 261:

    $lovd_url = "http://databases.lovd.nl/shared/variants/".$gene."?search_VariantOnGenome/Remarks=finnish&in_window&page_size=25&page=1";

Change the term 'Remarks=finnish' to 'Remarks=[YOUR_COUNTRY-DESCRIPTIVE_TERM]', where 'YOUR_COUNTRY-DESCRIPTIVE_TERM' would be e.g. 'Albanian', 'Romanian', 'Cypriot', etc.

Note that the selector used in this template for native variants is the use of this national or ethnically descriptive term in the *VariantOnGenome/Remark* field for variants stored in LOVD3. 

All genes are sourced from LOVD3,  except those genes still in LOVD2. Some such genes are listed below, with example displays included in the template.

LOVD3 gene pages are shown using the lovd_proxy.html template, which takes these values through its link decorations:

	gene=AGA
	name=Aspartylglucosaminidase
	ensemb=ENSG00000038002
	disease=AGU
	omim=613228
	ncbi=175

Each LOVD3 gene-specific page fetches native and non-native variants for that gene live from LOVD3. If the layout of LOVD3 variant tables changes, this could break the presentation of native and non-native variants in the FinDis gene pages. If this occurs, the nativeand/or non-native variant tables will either fail to load, or display in a broken manner. Should this occur, here are the recommended actions:

- contact the LOVD3 developers and ask them what has changes in the variant display tables; and/or study the source code of these tables to see what has changed.
- armed with this information, modify the PHP in lovd_proxy.html to account for these changes (see below)
- as a stopgap, to hide the errors while they are fixed, the genes.html page can be switched out with the **genes_LOVD.html** page, which lists all genes, but provides only direct links to LOVD. Note that this way, users no longer have a side-by-side view of native vs. non-native genes.

#### Gene listings - concealed data: [gene_concealed]

The genes.html listing page holds concealed data:

- a column providing direct-to-LOVD links for each gene
- a column providing number of mutations (out of date)

.. These columns are concealed using jQuery Javscript found in the head section at the top of genes.html. To reveal either column, comment out the javascript line that hides it. 

#### Gene listings - alternate versions: [gene_alt]

- [http://findis.org/genes_LOVD.html](http://findis.org/genes_LOVD.html)  
.. provides only direct to LOVD links; no separation of Finnish variants.

- [http://findis.org/genes_2col.html](http://findis.org/genes_2col.html) 
.. provides both local gene pages and LOVD link columns 

#### Modifying lovd_proxy.html [mod_proxy]

Should LOVD3 table code change, adapting the php in lovd_proxy.html should allow quickly and simply adapting to these changes. Intermediate HTML , Javascript, and PHP knowledge is all that is required.

The lovd_proxy.html file reads Finnish and non-Finnish variants directly from LOVD3, using the PHP Simple DOM Parser library:

http://simplehtmldom.sourceforge.net/

lovd_proxy.html uses this library to strip out unwanted elements from the LOVD3 tables, and present native and non-native variants in a side-by-side view. Each such step is labelled in the code. The sections that read and reformat native and non-native variant tables are also labelled as such.

lovd_proxy.html also calls Troy Wolf's proxy.php script to pass links from the LOVD3 variant records through to LOVD3's viewlist.php script. This preserves the valuable click-through functionality of LOVD3 records.

### LOVD2 genes [lovd2_genes]

The following genes, still in LOVD2, are included in the template:

	TMEM216
	AIRE
	RS1
	CLRN1
	CHM
	OAT
	RS1

Gene pages for genes in LOVD2 use custom templates, named for the gene:

    http://findis.org/lovd2_REP1.html?gene=CHM&name=Rab%20escort%20protein%201&ensemb=ENSG00000188419&disease=CHM&omim=300390&exturl=https://grenada.lumc.nl/LOVD2/Usher_montpellier/home.php?select_db=CHM&extsrc=https://grenada.lumc.nl/LOVD2/Usher_montpellier/home.php?select_db=CHM&extsrctitle=Retinal%20and%20hearing%20impairment%20genetic%20mutation%20database&curator=David%20Baux&ncbi=1121

.. These pages can be found at the template root as e.g:

	lovd2_GENE.html

e.g:

	lovd2_REP1.html
	lovd2_AIRE.html
	lovd2_RS1.html
	lovd2_OAT.html
	etc.

More information is passed in link decorations for LOVD2 gene pages, to aid users in locating sources for these genes:

	gene=CHM
	name=Rab%20escort%20protein%201
	ensemb=ENSG00000188419
	disease=CHM
	omim=300390
	exturl=https://grenada.lumc.nl/LOVD2/Usher_montpellier/home.php?select_db=CHM
	extsrc=https://grenada.lumc.nl/LOVD2/Usher_montpellier/home.php?select_db=CHM
	extsrctitle=Retinal%20and%20hearing%20impairment%20genetic%20mutation%20database
	curator=David%20Baux
	ncbi=1121

No off-site lookup occurs for the LOVD2 genes. Since LOVD2 cannot be reliably parsed, each custom template shows the native variants for the LOVD2 gene as a static table. See below:

#### Generating new native variant tables for LOVD2 Genes [tablegen]

To update the variant table for a gene still listed in LOVD2 (see list above), follow these steps:

1. Go to the LOVD database for the gene (using the LOVD link on the gene specific page). 
2. At the LOVD db, under the Variants tab, click 'Variant listing based on patient origin'.
3. On the resultant 'LOVD - Search variants' page, select your national or ethnic designation under the Geographic origin form element. Native variants are then displayed in an LOVD table.
4. Open Developr Tools or otherwise view the source for this page. Find and copy the HTML source for the native variant table only. (Using Chrome or Mozilla Developer Tools is the fastest way to locate the table. The table is typically within 3 or 4 enclosing tables and 1 or 2 enclosing Divs. In Chrom Dev Tools, once the Table declaration has been found, the entire table can be copied by right-clicking the line and selecting 'Copy as HTML') 
5. Paste the native variant table HTML into a text editor.
6. In the variant table code, search for and remove this following string:

	<td align="right" width="13"></td>                 <td align="right" width="13"></td></tr>

7. In the variant table code, search for:

	class="ordered"  

and replace it with:

	class="order"

8. In the variant table code, search for:

	class="data"

and replace it with:

	class="data table table-striped table-hover table-bordered" style="max-width: none;"

9. Search for relative links within the table code. Add the LOVD2 database root to these links.  E.g., for OAT:
- search for '/LOVD2/eye/'
- replace with 'https://grenada.lumc.nl/LOVD2/eye/'

10. These operations will clean up the table enough to paste it into the LOVD2 gene description page, under "Native variants". After backing up the older version, 

Further use of regex can remove the extra formatting around the table headers. Here is an example, however this step is time-consuming and not straightforward, so we only provide a sample regex for that code here - this will not work without tweaking by an experienced RegEx user:

	Find:
	\s*<th valign="top" width="(\d*)" class="\S*">\s*<table border="0" cellpadding="0" cellspacing="0" width="100%" class="S11">\s*<tbody>\s*<th>(\S*\s*\S*)<\/th>\s*<\/tr><\/tbody><\/table><\/th>

	Replace:
	<th valign="middle" width="$1" class="order">$2<\/th>

#### Generating new native variant downloads for LOVD2 Genes [tablegen2]

Tab-separated native variant listings are provided for the above-listed LOVD2 genes. These can be regenerated by running the lovd_tablegen.php script, found at https://github.com/findis-db, and also in the /downloads directory of the template site. 

Note that the $gene and $lovd_url variables must be switched for each LOVD2 gene variant listing to be regenerated. This can be done simply by commenting and uncommenting the respective lines in the php script.

Steps:

	1. uncomment the $gene name to generate a download table for that gene.
	2. uncomment the $lovd_url address following the gene name.
	3. comment all other $gene names and $lovd_url addresses.
	4. run the script from the command line: "php lovd_tablegen.php"
	5. Copy the output into a text file
	6. Save output as GENE_NAME.tsv.txt in the /downloads folder.
	7. The updated download file should now be accessed by the download link for the given gene, on that gene's page.

##### Modifying lovd_tablegen.php [mod_tablegen]

If lovd_tablegen.php does not work correctly, it can be modified fairly easily. The script is a series of regex and string replacements, using the php functions:

preg_match, preg_replace, str_replace

### Battenin Genes [battenin]

The following genes are stored at the NCL Mutation and Patient Database:

CLN3, CLN5, CLN8, PPT1

These genes use the template 'exturl.html', and load tables directly from NCL. This template can be repurposed to present any external database information, not in LOVD. 

## Publications | publications.html  [pubs]

publications.html lists all selected publications for all native diseases. 

Individual publication listings for each disease are located in the /pubs directory. These are accessed via links on each Disease description page.

Each disease-specific publication page uses the pub.html template to display the table of disease-specific publications, stored in a snippet in the pubs/ directory.

Each publications snippet, as well as the collected publications.html listing, has a hidden Author column. This column is hidden using jQuery at the top of each page, and can be revealed by commenting out the relevant javascript line.

Disease-specific publication listings are simply made by copying the table sections from the publications.html collected listing. To update publications lists, be sure to update both publications.html and the table snippet for the given disease under /pubs.

## Native Disease Heritage, About, and Links pages [about]

These pages are static. Nothing tricky here, except that a jQuery popup script can be used to present large tables and images, as demonstrated in section 1 of the heritage.html page.

