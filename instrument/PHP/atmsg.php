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

	<title>ATMSG Analysis</title>


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
<a name="step1"></a>
<h1>ATMSG Analysis</h1>

<h2>Step 1: Describe the activities</h2>

<div class="instruction"><p>In <em>step 1</em>, you fill in the table describing the main activities involved in the activity system and identify their subjects and corresponding motives.</p></div>

<p>For this questionnaire, please ignore "extrinsic instruction". This is because we are not considering one specific context of use of this game, and consequently an analysis of the extrinsic instructional activity cannot be performed.</p>

<p>This is your first table. Please substitute the <span class="blue">blue cells</span> with your analysis (leave "Extrinsic instruction" empty/unchanged). To edit the table, <b><a href="<?php echo sprintf($included_objects['atmsg_table01'],'edit#','');?>" target="_blank" >click here</a></b>!</p>

<p><iframe frameborder="1" style="width:100%;height:250px"  src="<?php echo sprintf($included_objects['atmsg_table01'],'pubhtml?',''); ?>&amp;single=true&amp;widget=false&amp;headers=false"></iframe><br />
<a class="button-link" href="<?php echo sprintf($included_objects['atmsg_table01'],'edit#',''); ?>" target="_blank" ><img src="pencil.png" />Edit table</a> <a href="#step1" onClick="reloadDocument()" class="button-link button-link-blue">Refresh (~5 minutes delay)</a> <a href="atmsg-example.pdf" class="button-link button-link-gray" target="_blank">Example analysis</a></p>



<hr />
<a name="step2"></a>
<h2>Step 2: Represent the game sequence</h2>

<div class="instruction"><p>In <em>step 2</em>, you create a diagram that represents the game sequence in a rough time-line. The purpose of this diagram is to establish a reference point to uncover how the elements of the activity system, which will be identified in Step 3, are connected throughout the game.</p></div>

<?php 
	if ($participant_group=="2") { 

?>
<br />
<div class="alert"><p>Since you already created the diagram for the LM-GM analysis, you can open both documents and copy and paste your diagram. <a href="<?php echo $included_objects['lmgm_diagram'];?>edit" target="_blank">Click here to open your LM-GM diagram</a>.</p></div>

<?php 
	}
?>

<p>Below you find your ATMSG diagram. To edit it, <b><a href="<?php echo $included_objects['atmsg_diagram'];?>edit" target="_blank" >click here</a></b>!</p>

<p><img src="<?php echo $included_objects['atmsg_diagram'];?>pub?w=1200&amp;h=360" style="border: 1px solid #444;"/><br />	
<a  class="button-link" href="<?php echo $included_objects['atmsg_diagram'];?>edit" target="_blank"><img src="pencil.png" />Edit diagram</a> <a href="#step2" onClick="reloadDocument()" class="button-link button-link-blue">Refresh</a> <a href="atmsg-example.pdf" class="button-link button-link-gray" target="_blank">Example analysis</a></p>

<hr />
<a name="step3"></a>
<h2>Step 3: Identify actions, tools and goals</h2>

<div class="instruction"><p>In <em>step 3</em>, you proceed to identify elements related to each node of the game sequence.</p>
<p>At this level of the analysis, each event in the game is decomposed in its actions, tools and goals. Together, the elements essentially answer, for each step of the game, the question: "what is the subject doing, how, and why".</p>

<p>Refer to the <a href="atmsg-taxonomy.pdf" target="_blank">ATMSG taxonomy</a> for the full list of elements.</p>
</div>

<p>This is your second table. Please fill in the <span class="blue">blue cells</span> with elements from the <a href="atmsg-taxonomy.pdf" target="_blank">ATMSG taxonomy</a> that you find are relevant. Leave "Extrinsic instruction" empty/unchanged. To edit the table, <b><a href="<?php echo sprintf($included_objects['atmsg_table02'],'edit#','');?>" target="_blank" >click here</a></b>!</p>

<p><iframe frameborder="1" style="width:100%;height:500px"  src="<?php echo sprintf($included_objects['atmsg_table02'],'pubhtml?',''); ?>&amp;single=true&amp;widget=false&amp;headers=false"></iframe><br />
<a class="button-link" href="<?php echo sprintf($included_objects['atmsg_table02'],'edit#',''); ?>" target="_blank" ><img src="pencil.png" />Edit table</a> <a href="#step3" onClick="reloadDocument()" class="button-link button-link-blue">Refresh (~5 minutes delay)</a> <a class="button-link  button-link-blue" href="atmsg-taxonomy.pdf" target="_blank">Full list of elements</a> <a href="atmsg-example.pdf" class="button-link button-link-gray" target="_blank">Example analysis</a></p>

<div style="text-align: center"><a href="atmsg-taxonomy.pdf" target="_blank"><img src="atmsg-elements.png" width="806"></a>
<br />
<p>Click on the picture to see the full list of elements.</p></div>

<hr />
<a name="step4"></a>
<h2>Step 4: Description of the implementation</h2>

<div class="instruction"><p>In <em>step 4</em>, the user groups each set of actions, tools and goals that are from the same type of activity and that are related to the same node of the game sequence. For each of those blocks, the user provides a more complete description of their implementation. </p></div>

<p>In this table, the user can complement the description of the blocks of elements with more specific details of its implementation (e.g. how a score is calculated, or the characteristics of a non-player character) and explain how the usage of such elements and characteristics support the achievement of the entertainment and/or pedagogical goals of the game.</p>

<p>This is your third table. Please substitute the <span class="blue">blue cells</span> with your analysis (leave "Extrinsic instruction" empty/unchanged). To edit the table, <b><a href="<?php echo sprintf($included_objects['atmsg_table03'],'edit#','');?>" target="_blank" >click here</a></b>!</p>

<p>
<iframe frameborder="1" style="width:100%;height:380px"  src="<?php echo sprintf($included_objects['atmsg_table03'],'pubhtml?',''); ?>&amp;single=true&amp;widget=false&amp;headers=false"></iframe><br />
<a class="button-link" href="<?php echo sprintf($included_objects['atmsg_table03'],'edit#',''); ?>" target="_blank" ><img src="pencil.png" />Edit table</a> <a href="#step4" onClick="reloadDocument()" class="button-link button-link-blue">Refresh (~5 minutes delay)</a> <a href="atmsg-example.pdf" class="button-link button-link-gray" target="_blank">Example analysis</a></p>
 
<hr />

<div class="concluded"><p>This is the end of the ATMSG analysis.</p></div>
 
    <?php
  }
  ?>
</div>
</body>
</html>

