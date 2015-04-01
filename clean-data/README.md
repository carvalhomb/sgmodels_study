# Description of the fields

## clean_data_quantitative.csv

Fields in the dataset:

id
:   Assigned id for the participant 

group
:   To which group the participant was assigned. Location 1 participants were in Group A.

age
:   Age of the participant

gender
:   Sex of participant

edlevel
:   Educational level. Options:  
    [1] Primary school  
    [2] Secondary school  
    [3] Professional/vocational/trade school  
    [4] Bachelor's degree  
    [5] Master's degree  
    [6] Doctoral degree  
    [7] No formal education  
    [8] Other  

study
:   Field of work/study.

country
:   Country of origin.

residence
:   Country of current residence

gamefam
:   Self-reported level of familiarity with games. Options:  
    [1] I have never played digital games  
    [2] I have played digital games only once or twice  
    [3] I have played digital games a few times  
    [4] I play digital games every now and then  
    [5] I am a gamer/I play digital games regularly   
    
sgsfam
:   Self-reported level of familiarity with serious games. Options:  
    [1] I don't know what Serious Games or games for learning are  
    [2] I have seen, used or played a Serious Game or game for learning only once or twice  
    [3] I have seen, used or played a Serious Game or game for learning a few times  
    [4] I use or play Serious Game or games for learning every now and then  
    [5] I use or play Serious Games regularly -or- I work with Serious Games or games for learning  
 
A_Game
:   The game used in the ATMSG analysis.

A_analysis
:   Not used.

A_SUS01-10
:   Level of agreement, from 1 (strongly disagree) to 5 (strongly agree), to each of the SUS questions, below:  
    [1] I think that I would like to use the ATMSG model if/when I study games for learning  
    [2] I found the ATMSG model unnecessarily complex  
    [3] I thought the ATMSG model was easy to use  
    [4] I think that I would need the support of an expert to be able to use the ATMSG model  
    [5] I found the various steps in the ATMSG model were well integrated  
    [6] I thought there was too much inconsistency in the ATMSG model  
    [7] I would imagine that most people would learn to use the ATMSG model very quickly  
    [8] I found the ATMSG model very cumbersome to use  
    [9] I felt very confident using the ATMSG model  
    [10] I needed to learn a lot of things before I could get going with the ATMSG model  

L_Game
:   The game used in the LMGM analysis.

L_analysis
:   Not used.

L_SUS01-10
:   Level of agreement, from 1 (strongly disagree) to 5 (strongly agree), to each of the SUS questions, below:  
    [1] I think that I would like to use the LMGM model if/when I study games for learning  
    [2] I found the LMGM model unnecessarily complex  
    [3] I thought the LMGM model was easy to use  
    [4] I think that I would need the support of an expert to be able to use the LMGM model  
    [5] I found the various steps in the LMGM model were well integrated  
    [6] I thought there was too much inconsistency in the LMGM model  
    [7] I would imagine that most people would learn to use the LMGM model very quickly  
    [8] I found the LMGM model very cumbersome to use  
    [9] I felt very confident using the LMGM model  
    [10] I needed to learn a lot of things before I could get going with the LMGM model  


## full_data_qualitative.csv

id
:   Assigned id for the participant.

question_code
:   Code of the open-ended questions, below:  
    - **ATMSG-Perception**: Did your perception of the game change after using the ATMSG model to analyze it? If yes, what changed?  
    - **ATMSG-Suggestion**: Do you have any suggestions on how to improve the ATMSG model and its
application?  
    - **LMGM-Perception**: Did your perception of the game change after using the LM-GM model to
analyze it? If yes, what changed?  
    - **LMGM-Suggestion**: Do you have any suggestions on how to improve the LM-GM model and its
application?  
    - **Comparison01-EasierUnderstand**: Which model, ATMSG or LM-GM, was easier to understand? Why?  
    - **Comparison02-EasierApply**: Which model, ATMSG or LM-GM, was easier to apply? Why?  
    - **Comparison03-BetterUnderstanding**: In your opinion, which model, ATMSG or LM-GM, gave you a better understanding of the characteristics of the games you analyzed? Why?  
    - **Comment**: If you have any comments about the models or about this study, please write them down below.  

answer
:   Participant's answer (in some cases, transcribed from paper).

comment
:   Evaluator's comments on the answer.

first_label
:   First round of coding the answers.

second_label
:   Second (and final) round of coding the answers.
