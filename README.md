# SG models study

Repository for data and R scripts used in study on two models for analysis of serious games.

The files in this repository allow you to re-generate the file *report.html* and see the data analyses yourself.

## Folder organization

Here is what you will find in this repository:

**clean-data/**
:   The variables have been cleaned so that the data from the three studies is in one single dataset. Some of the data was originally collected on paper; we transcribed (but not translated) the data and put it here. 

**figure/**
:   Figure files generated by R

**includes/**
:   Files needed to generate the report (CSS style)

**instrument/**
:   LimeSurvey questionnaire applied in the online study plus templates.

**R/**
:   The R scripts that generate the report and the analyses

**raw-data/**
:   The original analyses (on paper and PDFs printed from the online versions)

*Makefile*
:   GNU Makefile that can be used to re-generate the report.

*report.html*
:   The output of the R script with the analysis of the data. If you just want to look at the full report from the data, this is the file you want to open.

## Build the report

To generate the report yourself, you can use the Makefile. You can un it like this (in UNIX or Cygwin, assuming you have GNU make, R and all the necessary dependencies installed):

```bash
make report
```

If you change the R script, you might want to clean the temporary files before running the script:

```bash
make cleanall
```

You can also use RStudio and Knitr to knit the script found in *R/report.Rmd*, which outputs a much nicer looking HTML.

## License

The data and text in this repository are released as [public domain](http://creativecommons.org/publicdomain/zero/1.0/).

The R scripts are released under the [MIT License](http://opensource.org/licenses/MIT).

## Contact

Maira B. Carvalho  
PhD Candidate TU/e | UNIGE  
<http://mairacarvalho.com/contact>
