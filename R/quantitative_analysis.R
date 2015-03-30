
cleanquantdata <- function(mydata) {

  #Apply levels
  mydata[c('gamefam')] <-lapply(mydata[c('gamefam')], factor, levels = c('1','2','3','4','5'), labels = c('Non-Gamer','Non-Gamer','Non-Gamer','Gamer', 'Gamer'))
  mydata[c('sgsfam')] <- lapply(mydata[c('sgsfam')], factor, levels = c('1','2','3','4','5'), labels = c('Non-expert','Non-expert','Non-expert','SGExpert', 'SGExpert'))


  mydata <- droplevels(mydata) #Removing unused levels
  
  mydata[11,c("A_SUS09")]<-3L #fixing empty rating
  mydata[24,c("A_SUS01")]<-3L #fixing empty rating
  
  # Relevant columns for the analysis
  relevant_cols <- c("id","age", "gender", "gamefam", "sgsfam", "group", 
                     "A_Game", "A_Analysis", "A_SUS01","A_SUS02", "A_SUS03", 
                     "A_SUS04","A_SUS05","A_SUS06","A_SUS07","A_SUS08","A_SUS09",
                     "A_SUS10", "L_Game", "L_Analysis", "L_SUS01","L_SUS02", "L_SUS03", 
                     "L_SUS04","L_SUS05","L_SUS06","L_SUS07","L_SUS08","L_SUS09","L_SUS10")
  relevant_cols_sus_atmsg <- c("A_SUS01","A_SUS02", "A_SUS03", "A_SUS04","A_SUS05",
                               "A_SUS06","A_SUS07","A_SUS08","A_SUS09","A_SUS10")
  relevant_cols_sus_lmgm <- c("L_SUS01","L_SUS02", "L_SUS03", "L_SUS04","L_SUS05",
                              "L_SUS06","L_SUS07","L_SUS08","L_SUS09","L_SUS10")
  
  # Separating the data to include only relevant columns
  mycleandata <- mydata[,colnames(mydata)%in%relevant_cols]
  
  #Combining SUS for LM-GM and ATMSG, with levels to distinguish groups and methodologies
  mycombineddata <- mycleandata
  mycombineddata$model <- NA
  mycombineddata$game <- "empty"
  mycombineddata <- melt(mycombineddata, id = c("id", "group", "age","gender","gamefam", "sgsfam", "A_Game", "L_Game", "model","game"), na.rm=TRUE)
  
  mycombineddata$model[grep("A_", mycombineddata$variable)] <- "ATMSG"
  mycombineddata$game[grep("A_", mycombineddata$variable)] <- as.character(mycombineddata$A_Game[grep("A_", mycombineddata$variable)])
  mycombineddata$model[grep("L_", mycombineddata$variable)] <- "LMGM"
  mycombineddata$game[grep("L_", mycombineddata$variable)] <- as.character(mycombineddata$L_Game[grep("L_", mycombineddata$variable)])
  mycombineddata$variable<-sub("A_","",mycombineddata$variable)
  mycombineddata$variable<-sub("L_","",mycombineddata$variable)
  
  mycombineddata$A_Game <- NULL
  mycombineddata$L_Game <- NULL
  
  mycombineddata_factors <- dcast(mycombineddata, id + age + group + gamefam + sgsfam + game + model ~ variable)
  mycombineddata_factors[3:7] <- lapply(mycombineddata_factors[3:7], as.factor)
  
  rm(mycleandata)
  rm(mycombineddata)
  return(mycombineddata_factors)  
}

removeduplicates <- function(mydata) {
  # Data is arranged in long-format (see http://seananderson.ca/2013/10/19/reshape.html), but
  # that duplicates some basic information that we need to be unique for some basic
  # descriptive tables, such as age of participants.
  # This function returns non-duplicated descriptive data:
  # id, age, group, gamefam (familiarity with games), sgsfam (familiarity with SGs), location
  return(mydata[which( !duplicated(mydata[,1]) ), c(1:6,21)])
  
}

scoresus <- function(combined_data){
  #This function adds three rows to the dataset with sus_score, usable_score and learnable_score
  
  ##### Scoring the SUS ########
  #To calculate the SUS score, first sum the score contributions from each item. Each item's 
  #score contribution will range from 0 to 4. For items 1,3,5,7,and 9 the score contribution is 
  #the scale position minus 1. For items 2,4,6,8 and 10, the contribution is 5 minus the scale 
  #position. Multiply the sum of the scores by 2.5 to obtain the overall value of SU.
  
  combined_data["sus_score"] <- NA
  combined_data["usable_score"] <- NA
  combined_data["learnable_score"] <- NA
  combined_data$sus_score <- ( 
    (combined_data$SUS01-1) + (5-combined_data$SUS02) + (combined_data$SUS03-1) + 
      (5-combined_data$SUS04) + (combined_data$SUS05-1) + (5-combined_data$SUS06) + 
      (combined_data$SUS07-1) + (5-combined_data$SUS08) +  (combined_data$SUS09-1) + 
      (5-combined_data$SUS10) ) * 2.5
  combined_data$usable_score <- (
    (combined_data$SUS01-1) + (5-combined_data$SUS02) + (combined_data$SUS03-1) + 
      (combined_data$SUS05-1) + (5-combined_data$SUS06) + (combined_data$SUS07-1) + 
      (5-combined_data$SUS08) +  (combined_data$SUS09-1) ) * 3.125
  combined_data$learnable_score <- ( (5-combined_data$SUS04) + (5-combined_data$SUS10) ) * 12.5
  
  return(combined_data)
}

addlocation <-function(combined_data) {
  #Adding location of the test
  combined_data["location"] <- NA
  combined_data$location[combined_data$group %in% c('A')] <- 'Location1'
  combined_data$location[combined_data$group %in% c('B','C')] <- 'Location2'
  combined_data$location[combined_data$group %in% c('D','E')] <- 'Online'
  return(combined_data)
}


preparelikertdata <- function(likert_data) {
  # Preparing data for Likert plots
  relevantcolumns <- c(1,3:7,21,8:17) #id, group, gamefam, sgsfam, game, model, location, SUS01 to SUS10
  suscolumns <- c(8:17)
  likert_data[suscolumns] <-lapply(likert_data[suscolumns], factor, levels = c('1', '2', '3', '4', '5'))
  rm(suscolumns)
  
  # Renaming questions for beautiful plots
  likert_data <- rename(likert_data, c(
    SUS01 = "I think that I would like to use this model if/when I study games for learning",
    SUS02 = "I found the model unnecessarily complex",
    SUS03 = "I thought the model was easy to use",
    SUS04 = "I think that I would need the support of an expert to be able to use this model",
    SUS05 = "I found the various steps in this model were well integrated",
    SUS06 = "I thought there was too much inconsistency in this model",
    SUS07 = "I would imagine that most people would learn to use this model very quickly",
    SUS08 = "I found the model very cumbersome to use",
    SUS09 = "I felt very confident using the model",
    SUS10 = "I needed to learn a lot of things before I could get going with this model"
  ))  
  likert_data <- likert_data[relevantcolumns]

  rm(relevantcolumns)
  return(likert_data)  
}



get_unmatched_treatments <- function(mydata, by_columnname, id_columnname='id') {
    # We get the mydata vector, count how many id_column entries are there for each by_column
    
    df <- data.frame(mydata[, c(c(id_columnname),c(by_columnname))])
    number_of_treatments <- aggregate(list(count=mydata[, c(by_columnname)]), list(uniqueid = mydata[,c(id_columnname)]), function(x) length(unique(x)))
    
    # Now we select the treatments that had count == 1, that is, with no pair
    unmatched_treatments <- number_of_treatments[ number_of_treatments$count==1, ]    

    # Clean the variables
    rm(df)
    rm(number_of_treatments)
    
    #Return updated data
    return(unmatched_treatments$uniqueid)
}

