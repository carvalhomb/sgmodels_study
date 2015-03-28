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

.PHONY:report clean clearcache cleanall
pdf: $(MAINPDF)
tex: $(RDATAFILES) $(ALLTEX) 


report:
	Rscript -e "require(knitr); require(markdown); knit('$(SCRIPTDIR)/$(RMDFILE).Rmd', '$(RMDFILE).md'); markdownToHTML('$(RMDFILE).md', '$(RMDFILE).html',  stylesheet='includes/style.css', options=c('use_xhtml', 'toc')); browseURL(paste('file://', file.path(getwd(),'$(RMDFILE).html'), sep=''))"


clean:
	-rm -f $(RMDFILE).md
	-rm -rf $(FIGUREDIR)
	
clearcache:
	-rm -rf cache
  
cleanall: clean clearcache


