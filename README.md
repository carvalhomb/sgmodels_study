# SG models study

Repository for data and R scripts used in study on two models for analysis of serious games.

The files in this repository allow you to re-generate the file *Report.hmtl* and see the data analyses yourself.

## Build the report

To generate the report yourself, you can use the Makefile. Just run (in UNIX or Cygwin):

```bash
make report
```

You can also use RStudio and Knitr to knit the script found in **R/report.Rmd**

## Folder organization

Here is what you will find in this repository:

**/clean-data**
:   The variables have been cleaned so that the data from the three studies is in one single dataset. Some of the data was originally collected on paper. This folder has it typed (but not translated). 

**/instrument**
:   LimeSurvey questionnaire applied in the online study plus templates.

**/R**
:   The R scripts that generate the report and the analyses

**/raw-data**
:   The original analyses (on paper and PDFs printed from the online versions)

**/raw-data**
:   The original analyses (on paper and PDFs printed from the online versions)

## License

The data and text in this repository are released as [public domain](http://creativecommons.org/publicdomain/zero/1.0/).

The R scripts are released under the [MIT License](http://opensource.org/licenses/MIT).

## Contact

Maira B. Carvalho  
PhD Candidate TU/e | UNIGE  
<http://mairacarvalho.com/contact>
