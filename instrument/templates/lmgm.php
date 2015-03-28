<?php

//initialize vars

$participant_token = false;
$participant_group = false;
$valid_user = false;

//Get variables for token and participant id and check if they match
include_once('tokentable.php');

?>
<!doctype html>

<html lang="en">
<head>
	<meta charset="utf-8">

	<title>LM-GM Analysis</title>

	<link rel="stylesheet" type="text/css" href="jquery-ui-custom.css" />
	<link rel="stylesheet" type="text/css" href="template.css" />
	<script type="text/javascript" src="template.js"></script>
	<script type="text/javascript">
		function reloadDocument() {
			document.location.reload();
		}
	</script>
	  <!--[if lt IE 9]>
	  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	  <![endif]-->

	<link rel="stylesheet" type="text/css" href="style.css" />
</head>

<body>

	<?php
  if (!$valid_user) {
	echo '<p>Sorry, authentication error. Please go back to the survey and try to click in the link again.';
  }	else {
	 echo sprintf("<!-- Token %s, Group %s -->\n\n", $participant_token, $participant_group);
	 
 ?>

<div id="analysis">
<h1>LM-GM Analysis</h1>

<a name="step1"></a>
<h2>Step 1: Identify Learning Mechanics (LMs) and Game Mechanics (GMs)</h2>

<div class="instruction"><p>In <em>step 1</em>, you look at the list of Learning Mechanics and Game Mechanics (see Figure below) to identify which of them are used in the game, in each situation.</p></div>
<br />
<div style="text-align: center"><a href="lmgm-elements.pdf" target="_blank"><img src="lmgm-elements.png" width="740"></a>
<br />
Click on the picture to see an enlarged version.</div>
<br />

<hr />

<a name="step2"></a>
<h2>Step 2: Fill in description table</h2>

<div class="instruction"><p>In <em>step 2</em>, you fill in a description table to express details on the actual implementation of the relationships 
between the LMs and GMs in the serious game.</p></div>

<p>This is your description table. Please substitute the <span class="blue">blue cells</span> with your analysis. To edit it, <b><a href="<?php echo sprintf($included_objects['lmgm_table01'],'edit#','');?>" target="_blank" >click here</a></b>!</p>

<p><iframe frameborder="1" style="width:100%;height:250px"  src="<?php echo sprintf($included_objects['lmgm_table01'],'pubhtml?',''); ?>&amp;single=true&amp;widget=false&amp;headers=false"></iframe><br />
<a class="button-link" href="<?php echo sprintf($included_objects['lmgm_table01'],'edit#',''); ?>" target="_blank" ><img src="pencil.png" />Edit document</a> <a href="#step2" onClick="reloadDocument()" class="button-link button-link-blue">Refresh (~5 minutes delay)</a> <a href="lmgm-example.pdf" class="button-link button-link-gray" target="_blank">Example analysis</a></p>

<br />

<hr />
<a name="step3"></a>
<h2>Step 3: Draw game flow diagram</h2>

<div class="instruction"><p>In <em>step 3</em>, you  draw a map representing the game flow in a rough time-line.</p></div>

<?php 

	if ($participant_group=="1") { 

?>
<br />
<div class="alert"><p>Since you already created the diagram for the ATMSG analysis, you can open both documents and copy and paste your diagram. <a href="<?php echo $included_objects['atmsg_diagram'];?>edit" target="_blank">Click here to open your ATMSG diagram</a>.</p></div>

<?php 
	}
?>

<p>Below you find the game flow diagram. To edit it, <b><a href="<?php echo $included_objects['lmgm_diagram'];?>edit" target="_blank" >click here</a></b>!</p>
    
<p><img src="<?php echo $included_objects['lmgm_diagram'];?>pub?w=1200&amp;h=360" style="border: 1px solid #444;"/><br />	
<a  class="button-link" href="<?php echo $included_objects['lmgm_diagram'];?>edit" target="_blank"><img src="pencil.png" />Edit diagram</a> <a href="#step3" onClick="reloadDocument()" class="button-link button-link-blue">Refresh</a> <a href="lmgm-example.pdf" class="button-link button-link-gray" target="_blank">Example analysis</a></p>
	
<hr />

<a name="step4"></a>
<h2>Step 4: Relate learning and gaming mechanics</h2>

<div class="instruction"><p>In <em>step 4</em>, you can use the list of LMs and GMs that you identified previously and relate them to describe the gaming situations. For that, use the numbers you designated in your diagram and the <a href="lmgm-elements.pdf" target="_blank">names (or codes) of the LM-GM nodes</a> in the table below.</p></div>

<p>Confused? Look at page 2 of the <a href="lmgm-example.pdf" target="_blank">example LM-GM analysis</a>. In the diagram, there are numbers and letters relating each node of the game sequence with the elements from the list of LMs and GMs. The relationship table below is an alternative representation of the same thing: you will be describing which LMs and GMs are connected to each node of the game sequence. Only this will happen in a table format, rather than a graphical one.</p>

<p>This is your relationship table. Please substitute the <span class="blue">blue cells</span> with your analysis. To edit it, <b><a href="<?php echo sprintf($included_objects['lmgm_table02'],'edit#','');?>" target="_blank" >click here</a></b>!</p>



<p><iframe frameborder="1" style="width:100%;height:250px"  src="<?php echo sprintf($included_objects['lmgm_table02'],'pubhtml?',''); ?>&amp;single=true&amp;widget=false&amp;headers=false"></iframe><br />
<a class="button-link" href="<?php echo sprintf($included_objects['lmgm_table02'],'edit#',''); ?>" target="_blank" ><img src="pencil.png" />Edit document</a> <a href="#step4" onClick="reloadDocument()" class="button-link button-link-blue">Refresh (~5 minutes delay)</a> <a href="lmgm-example.pdf" class="button-link button-link-gray" target="_blank">Example analysis</a></p>


<hr />

<div class="concluded"><p>This is the end of the LM-GM analysis.</p></div>
 
    <?php
  }
  ?>
</div>
</body>
</html>

