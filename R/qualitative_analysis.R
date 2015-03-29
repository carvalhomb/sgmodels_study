trim <- function( x ) {
  #Function to trim whitespaces, from http://stackoverflow.com/a/21882152
  gsub("(^[[:space:]]+|[[:space:]]+$)", "", x)
}


cleanqualdata <- function(myqualdata) {
  #Get id and second label, which is what we are interested in
  myqualdata <- myqualdata[ , c("id","question_code","second_label")]
  
  #renaming the "second_label" column for clarity
  colnames(myqualdata)[3] <- c("coded_answers") 
  
  # Remove empty cases
  myqualdata <- myqualdata[complete.cases(myqualdata), ]
  
  #Strip column into a string, then apply the strings to a new dataframe
  #following recommendation at http://stackoverflow.com/a/13773900
  s <- strsplit(as.character(myqualdata$coded_answers), ',')
  cleandata <- data.frame(id=rep(myqualdata$id, sapply(s, FUN=length)), question_code=rep(myqualdata$question_code, sapply(s, FUN=length)), coded_answer=unlist(s))
  
  #Trim whitespaces
  cleandata$coded_answer <- trim(cleandata$coded_answer)
  
  #Clean up used variables
  rm(myqualdata)
  rm(s)
  
  #Return new dataframe
  return(cleandata)
}


applylevels <- function(mydata) {    
  # Apply levels and labels
  mydata[c('gamefam')] <-lapply(mydata[c('gamefam')], factor, levels = c('1','2','3','4','5'), labels = c('None','Low','Medium','Medium-high', 'High'))
  mydata[c('sgsfam')] <- lapply(mydata[c('sgsfam')], factor, levels = c('1','2','3','4','5'), labels = c('None','Low','Medium','Medium-high', 'High'))
  return(mydata)  
}

buildfreqtable <- function(myqualdata) {
  myqualdata <- as.data.frame(sort(table(myqualdata$answers), TRUE))
  names(myqualdata) <- c('TimesMentioned')
  return(myqualdata)  
}


