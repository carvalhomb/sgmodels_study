################################################################################
# Copyright 2011
# Andrew Redd
# 11/23/2011
#
# Description of File:
# Makefile for knitr compiling
# 
################################################################################
all:pdf  # default rule DO NOT EDIT
################################################################################
MAINFILE  := test
RNWFILES  := 
RFILES    := 
TEXFILES  := 
CACHEDIR  := cache
FIGUREDIR := figure
LATEXMK_FLAGS := 
##### Explicit Dependencies #####
################################################################################
RNWTEX = $(RNWFILES:.Rnw=.tex)
ROUTFILES = $(RFILES:.R=.Rout)
RDATAFILES= $(RFILES:.R=.Rdata)
RMDFILE=Report
SCRIPTDIR=R

R_OPTS=--no-save --no-restore --no-init-file --no-site-file # vanilla, but with --environ

.PHONY:report clean clearcache cleanall
pdf: $(MAINPDF)
tex: $(RDATAFILES) $(ALLTEX) 


report: $(SCRIPTDIR)/$(RMDFILE).Rmd
#	Rscript -e "require(knitr); require(markdown); knit('$(SCRIPTDIR)/$(RMDFILE).Rmd'); markdownToHTML('$(RMDFILE).md', '$(RMDFILE).html',  stylesheet='includes/style.css', options=c('toc','')); browseURL(paste('file://', file.path(getwd(),'$(RMDFILE).html'), sep=''))"
	R ${R_OPTS} -e "rmarkdown::render('$(SCRIPTDIR)/$(RMDFILE).Rmd','md_document')"
	R ${R_OPTS} -e "markdown::markdownToHTML('$(SCRIPTDIR)/$(RMDFILE).md','$(RMDFILE).html', stylesheet='$(SCRIPTDIR)/includes/style.css')"
	-rm -f $(SCRIPTDIR)/$(RMDFILE).md


clean:
	-rm -f $(SCRIPTDIR)/$(RMDFILE).md
	-rm -rf $(SCRIPTDIR)/$(FIGUREDIR)
	-rm -rf $(SCRIPTDIR)/$(RMDFILE)_files
	
clearcache:
	-rm -rf $(SCRIPTDIR)/$(RMDFILE)_cache
  
cleanall: clean clearcache


