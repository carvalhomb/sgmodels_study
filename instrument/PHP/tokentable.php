<?php

include_once('config.php'); //Get config settings from config file
include_once('db.class.php'); //Get the DB class

$config_atmsg = new config($atmsg_db);
$config_limesurvey = new config($limesurvey_db);

//Open the DB connection to limesurvey DB
$db_limesurvey = new db($config_limesurvey);
$db_limesurvey->openConnection();

//What is the complete question id for the random group assignment?
$result = false;
$result = $db_limesurvey->query("SELECT qid FROM {questions} WHERE title LIKE %s AND sid = ".$survey_id." LIMIT 1", 'groupassignment');
$result_array = $db_limesurvey->fetchAssoc($result);

$question_id = $result_array['qid'];

$result = false;
$result_array = false;
$result = $db_limesurvey->query("SELECT gid FROM {groups} WHERE group_name LIKE %s AND sid = ".$survey_id." LIMIT 1", 'Demographics');
$result_array = $db_limesurvey->fetchAssoc($result);
$group_id = $result_array['gid'];

$completeqid = $survey_id . 'X' . $group_id . 'X' . $question_id;


// let's get the tokens directly from Limesurvey
$result = false;
$result = $db_limesurvey->query("SELECT token FROM {tokens_".$survey_id."}");

$accepted_tokens = array();
foreach ($result as $row) {
	$accepted_tokens[] = $row['token'];
}

$participant_token = false;

if ($_GET && array_key_exists('token',$_GET)) $participant_token = $_GET['token'];


//$groups = array();
if (in_array($participant_token, $accepted_tokens)) {
		$valid_user = true;
		
		
		//Token is valid
		
		// To which group does this participant belong?
		$result = false;
		$result_array = false;
		$result = $db_limesurvey->query("SELECT ".$completeqid." as group_assignment FROM {survey_".$survey_id."} WHERE token LIKE %s", $participant_token);
		$result_array = $db_limesurvey->fetchAssoc($result);
		$participant_group = $result_array['group_assignment'];		


		//now let's get the list of document hashes from the ATMSG database
		
		$db_atmsg = new db($config_atmsg);
		$db_atmsg->openConnection();

		//$query_string = 'SELECT * FROM {docs} WHERE ( (token is NULL) OR (token LIKE %s) ) ORDER BY id ASC LIMIT 1';
        $query_string = 'SELECT * FROM {docs} WHERE ( token LIKE %s ) ORDER BY id ASC LIMIT 1'; //Is the participant already in the token table?
        $result = false;
        $result = $db_atmsg->query($query_string, $participant_token);
		
        $docs = false;		
        
        $hasRows = $db_atmsg->hasRows($result);      
        
        if ($hasRows) { //Participant is already in token list            
            //Populate the $docs array with the existing google docs for that token
            foreach ($result as $row) {
                $docs['docs_id'] = $row['id'];
                $docs['atmsgdiagram_dochash'] = $row['atmsg_diagram'];
                $docs['atmsgtable_dochash'] = $row['atmsg_table'];
                $docs['lmgmdiagram_dochash'] = $row['lmgm_diagram'];
                $docs['lmgmtable_dochash'] = $row['lmgm_table'];
            }
        } else { //Participant is NOT in the list, so get an empty row of docs
            // Get the first empty entry in the token table
            $query_string_empty = 'SELECT * FROM {docs} WHERE (token is NULL) ORDER BY id ASC LIMIT 1'; 
            $result_empty = false;
            $result_empty = $db_atmsg->query($query_string_empty);
            $hasRows_empty = $db_atmsg->hasRows($result_empty);        
		
            if (!$hasRows_empty) { //No more empty rows in the table! Give error message and warn the admin
                echo "Sorry, there has been an error with the setup of the survey. The administrator has been warned of this.";
                $now = date(DATE_ATOM);
                $error_msg = "[$now] Uh-oh, it seems you ran out of Google Docs entries! \n--------------------------- TOKEN that triggered the error: $participant_token \n";			
                error_log($error_msg, 3, "error.log");
                if ($send_emails) {
                    error_log($error_msg, 1, $admin_email, "Subject: Error in ATMSG survey!\nFrom: $admin_email\n");	
                }
                exit();
            } else {
                //Populate the $docs array with the docs from an empty row
                foreach ($result_empty as $row) {
                    $docs['docs_id'] = $row['id'];
                    $docs['atmsgdiagram_dochash'] = $row['atmsg_diagram'];
                    $docs['atmsgtable_dochash'] = $row['atmsg_table'];
                    $docs['lmgmdiagram_dochash'] = $row['lmgm_diagram'];
                    $docs['lmgmtable_dochash'] = $row['lmgm_table'];
                }
                
            }

        }


					

		
		
	
		$included_objects = array(
			'atmsg_diagram' => sprintf('https://docs.google.com/drawings/d/%s/',$docs['atmsgdiagram_dochash']),
			'atmsg_table01' => sprintf('https://docs.google.com/spreadsheets/d/%s/%sgid=1044161728&%s',$docs['atmsgtable_dochash'],'%s','%s'),
			'atmsg_table02' => sprintf('https://docs.google.com/spreadsheets/d/%s/%sgid=0&%s',$docs['atmsgtable_dochash'],'%s','%s'),
			'atmsg_table03' => sprintf('https://docs.google.com/spreadsheets/d/%s/%sgid=1353567834&%s',$docs['atmsgtable_dochash'],'%s','%s'),
			'lmgm_diagram' => sprintf('https://docs.google.com/drawings/d/%s/',$docs['lmgmdiagram_dochash']),
			'lmgm_table01' => sprintf('https://docs.google.com/spreadsheets/d/%s/%sgid=0&%s',$docs['lmgmtable_dochash'],'%s','%s'),
			'lmgm_table02' => sprintf('https://docs.google.com/spreadsheets/d/%s/%sgid=580693403',$docs['lmgmtable_dochash'],'%s'), 
		);
		
		//Let's attach this participant's token to the google docs. Now these documents cannot be used by anyone else!
		
		$query_string = 'UPDATE {docs} SET token = %s WHERE (id = '.$docs['docs_id'].' AND token IS null) LIMIT 1';
		$result = false;
		$result = $db_atmsg->query($query_string, $participant_token);
		$affected_rows = false;
		$affected_rows = $db_atmsg->affectedRows($result);

		if ($send_emails && ($affected_rows > 0) ) {
			// Send the admin an email (if emails are allowed) to let them know how many google docs are left.	
			$query_string = 'SELECT count(*) as tokens_left FROM {docs} WHERE token IS null';
			$result = false;
			$result = $db_atmsg->query($query_string, $participant_token);
			$result_array = $db_limesurvey->fetchAssoc($result);
			$tokens_left = $result_array['tokens_left'];
			// the message
			$msg = "Dear admin of the ATMSG survey,\n\nThis is just to let you know that you have now \n only $tokens_left tokens left in the GDocs table.";
			// send email
			mail($admin_email,"Notice: $tokens_left tokens left in the GDocs table",$msg);
			
		}
		
		
		$db_limesurvey->closeConnection();
		$db_atmsg->closeConnection();

} else {
	$valid_user = false;
}

?>