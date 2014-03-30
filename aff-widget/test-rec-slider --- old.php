<!-- --------------------------------- throw info php start --------------------------------- -->
<?php

ini_set('display_errors',0);
echo "<!-- here";
print_r($_REQUEST);
echo " -->";

if (isset($_SESSION['started'])) {


session_start(); 



} 
$_SESSION['started'] = 1;
	$affID = $_REQUEST['a_aid'];

	$errmgs = array();
	if($_REQUEST['Gender'] != '' || $_REQUEST['Age'] != '')
		{
			$_SESSION['Recommandation']['Gender'] = $_REQUEST['Gender'];
			$_SESSION['Recommandation']['Age'] = $_REQUEST['Age'];  
			if($_SESSION['Recommandation']['Zipcode'] == 'Zipcode' || $_SESSION['Recommandation']['Zipcode'] == '')
			$_SESSION['Recommandation']['Zipcode'] = 'Zipcode'; 
		}
  	$Recommandation = $_SESSION['Recommandation'];
	//
	if($_REQUEST['MyRecommandation'])
	{
	//pr($_REQUEST,1);
	if(empty($_REQUEST['Gender']))
		{
			$errmgs['Gender'] = 'Please select gender';
			$err = true;
		}
		if(empty($_REQUEST['Age']))
		{
			$errmgs['Age'] = 'Please select age';
			$err = true;
		}
		if(empty($_REQUEST['Zipcode']) || $_REQUEST['Zipcode'] == 'Zipcode')
		{
			$errmgs['Zipcode'] = 'Please enter zipcode';
			$err = true;
		}
		if(!is_numeric($_REQUEST['Zipcode']))
		{
			$errmgs['ValidZipCode'] = 'Please enter valid zipcode';
			$err = true;
		}
		if(empty($_REQUEST['SexualPartner']))
		{
			$errmgs['SexualPartner'] = 'Please choose sexual partner';
			$err = true;
		}
		if(empty($_REQUEST['LastSTDTest']))
		{
			$errmgs['LastSTDTest'] = 'When was your last STD test?';
			$err = true;
		}
		if(empty($_REQUEST['OneOrMoreSexualPartner']))
		{
			$errmgs['OneOrMoreSexualPartner'] = 'Have you had one or more new sexual partners since your last STD test, or within the last 6 months?';
			$err = true;
		}
		if(empty($_REQUEST['ConcernedWithOther']))
		{
			$errmgs['ConcernedWithOther'] = 'Are you concerned about your partner\'s sexual activity with others?';
			$err = true;
		}
		if(empty($_REQUEST['VaccinatedForHepatitisB']))
		{
			$errmgs['VaccinatedForHepatitisB'] = 'Have you been vaccinated for Hepatitis B?';
			$err = true;
		}
		if(empty($_REQUEST['RelationshipWithIVdrug']))
		{
			$errmgs['RelationshipWithIVdrug'] = 'Are you an intravenous (IV) drug user or have you had a relationship with an IV drug user?';
			$err = true;
		}
		if(empty($_REQUEST['InterestedWithGenitalHerpes']))
		{
			$errmgs['InterestedWithGenitalHerpes'] = 'Are you interested to know your genital herpes status?';
			$err = true;
		}
		$Recommandation = $_REQUEST;
		if(!$err)
		{
			$_SESSION['addressInput'] = $_REQUEST['Zipcode']; 
			$Recommandation['Gender'] = $_REQUEST['Gender'];
			$Recommandation['Age'] = $_REQUEST['Age'];
			$Recommandation['Zipcode'] = $_REQUEST['Zipcode'];
			$Recommandation['SexualPartner'] = $_REQUEST['SexualPartner'];
			$Recommandation['VaccinatedForHepatitisB'] = $_REQUEST['VaccinatedForHepatitisB'];
			$Recommandation['RelationshipWithIVdrug'] = $_REQUEST['RelationshipWithIVdrug'];
			$Recommandation['chkIndi1'] = $_REQUEST['chkIndi1'];
			$Recommandation['SetValue'] = 'Yes';
			$_SESSION['Recommandation'] = $Recommandation;
			$_SESSION['testRec'] = 1;
			echo "<script>top.location.href='/test-recommendation/test-recommendation-result?a_aid=".$affID."'</script>";
		}
	} 
   
	if($err) {
		echo '<div class="container">';
			echo ListErrorMsg($errmgs);
		echo '</div>';
	} 
?>

<!-- --------------------------------- throw info php end --------------------------------- -->




<!-- jQuery (required) -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js"></script>

<!-- Demo stuff -->
<link rel="stylesheet" href="css/page.css">

<!-- Anything Slider -->
<link rel="stylesheet" href="css/anythingslider.css">
<script src="js/jquery.anythingslider.js"></script>

<script>
// DOM Ready
$(function(){
	$('#slider').anythingSlider({
		// Appearance
		resizeContents      : true,      // If true, solitary images/objects in the panel will expand to fit the viewport
		// Appearance
		width               : "280px",      // Override the default CSS width
		height              : "195px",      // Override the default CSS height  // Navigation
		startPanel          : 1,         // This sets the initial panel
		hashTags            : true,      // Should links change the hashtag in the URL?
		buildArrows         : false,      // If true, builds the forwards and backwards buttons
		buildNavigation     : false,      // If true, buildsa list of anchor links to link to each panel
		navigationFormatter : null,      // Details at the top of the file on this use (advanced use)
		forwardText         : "&raquo;", // Link text used to move the slider forward (hidden by CSS, replaced with arrow image)
		backText            : "&laquo;", // Link text used to move the slider back (hidden by CSS, replace with arrow image)
	
		// Slideshow options
		autoPlay            : false,      // This turns off the entire slideshow FUNCTIONALY, not just if it starts running or not
		startStopped        : false,     // If autoPlay is on, this can force it to start stopped
		easing              : "swing"    // Anything other than "linear" or "swing" requires the easing plugin
	});
});
function next(){
	var qno = 11; // enter the number of questions here for the progress bar
	var wide = $("div.progresso").parent().width();
	var increment = parseInt(wide/qno);
	$("div.progresso").animate({    
		width: '+='+increment
	}, 800, function() {
	// Animation complete.
	});
$('#slider').data('AnythingSlider').goForward();	
}
function prev()
{
var qno = 11; // enter the number of questions here for the progress bar
var wide = $("div.progresso").parent().width();
var increment = parseInt(wide/qno);
$("div.progresso").animate({    
		width: '-='+increment
	}, 800, function() {
	// Animation complete.
	});
$('#slider').data('AnythingSlider').goBack();	
}
</script>

<!-- Older IE stylesheet, to reposition navigation arrows, added AFTER the theme stylesheet -->
<!--[if lte IE 7]>
<link rel="stylesheet" href="css/anythingslider-ie.css" type="text/css" media="screen" />
<![endif]-->



<!-- Simple AnythingSlider -->
<div style="width:300px; height:250px; float:left; overflow:hidden; background:#0e7b76;">

<div style="border:10px solid #3A3A3A; width:280px; height:230px;">

<form id="frmRecommandation" name="frmRecommandation" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
<!-- http://getstdtested.com/testrecommender/index/post/ -->
	<ul id="slider">
    
		<li>
			<div class="panecontain">
				
                <div id="qa-container">
                <div class="question_text"><div id="qa-nums">#1</div>Are you a man or a woman?</div>
                    <div style="clear:both;"></div>
                    <div class="content_area">
                        <select name="Gender" id="Gender" style="width: 100px;" onchange="(($(this).parent()).parent()).parent().children('.next').css('display','inline');">
                            <option></option>
                            <option value="Male" <?php if($_REQUEST['Gender'] == 'Male')echo'selected="selected"'; ?>>Man</option>
                            <option value="Female" <?php if($_REQUEST['Gender'] == 'Female')echo'selected="selected"'; ?>>Woman</option>
                        </select>
                    </div>
                </div>
                
                <div class="next">
                	<a href="#" onClick="next();"><img src="images/btn-next-inactive.png" alt="" onMouseOver="this.src='images/btn-next-active.png';" onMouseOut="this.src='images/btn-next-inactive.png';"/></a>
                </div>
                
                
			</div>
		</li>

		<li>
			<div class="panecontain">
            
                <div id="qa-container">
                    <div class="question_text"><div id="qa-nums">#2</div>How old are you?</div>
                    <div style="clear:both;"></div>
      <div class="content_area">
                        <select name="Age" id="Age" style="width: 100px;" onchange="(($(this).parent()).parent()).parent().children('.next').css('display','inline');">
                            <option></option>
                            <option value="under18" <?php if($_REQUEST['Age'] == 'under18')echo'selected="selected"'; ?>>Under 18</option>
                            <option value="18-24" <?php if($_REQUEST['Age'] == '18-24')echo'selected="selected"'; ?>>18-24</option>
                            <option value="25-29" <?php if($_REQUEST['Age'] == '25-29')echo'selected="selected"'; ?>>25-29</option>
                            <option value="30-39" <?php if($_REQUEST['Age'] == '30-39')echo'selected="selected"'; ?>>30-39</option>
                            <option value="40-49" <?php if($_REQUEST['Age'] == '40-49')echo'selected="selected"'; ?>>40-49</option>
                            <option value="50-59" <?php if($_REQUEST['Age'] == '50-59')echo'selected="selected"'; ?>>50-59</option>
                            <option value="60-69" <?php if($_REQUEST['Age'] == '60-69')echo'selected="selected"'; ?>>60-69</option>
                            <option value="70+" <?php if($_REQUEST['Age'] == '70+')echo'selected="selected"'; ?>>70+</option>
                        </select>
                    </div>
                </div>
                
				<div class="next">
                	<a href="#" onClick="next();"><img src="images/btn-next-inactive.png" alt="" onMouseOver="this.src='images/btn-next-active.png';" onMouseOut="this.src='images/btn-next-inactive.png';"/></a>
                </div>
                
				<div style="float: left;margin-top: 20px;">
                	<a href="#" onClick="prev();"><img src="images/btn-previous-inactive.png" alt="" onMouseOver="this.src='images/btn-previous-active.png';" onMouseOut="this.src='images/btn-previous-inactive.png';"/></a>
                </div>
                
			</div>
		</li>

		<li>
			<div class="panecontain">
            
                <div id="qa-container">
                    <div class="question_text"><div id="qa-nums">#3</div>Where are you located?</div>
                    <div style="clear:both;"></div>
                  <div class="content_area">
                        Enter Your Zip Code:<br />
                    <input name="Zipcode" id="Zipcode" onkeydown="(($(this).parent()).parent()).parent().children('.next').css('display','inline');" title="Zipcode" type="text" style="width:100px;" value="<?php echo $_REQUEST['Zipcode']?>"/>
                    </div>
                </div>

				<div class="next" onMouseOver="if(document.frmRecommandation.Zipcode.value == '')
{alert('Zipcode cannot be left empty..');this.style.display = 'none';}">
                	<a href="#" onClick="next();"><img src="images/btn-next-inactive.png" alt="" onMouseOver="this.src='images/btn-next-active.png';" onMouseOut="this.src='images/btn-next-inactive.png';"/></a>
                </div>
                
				<div style="float:left; margin-top:20px;">
                	<a href="#" onClick="prev();"><img src="images/btn-previous-question1.png" alt="" onMouseOver="this.src='images/btn-previous-question.png';" onMouseOut="this.src='images/btn-previous-question1.png';"/></a>
                </div>
                
			</div>
		</li>

		<li>
			<div class="panecontain">
            
                <div id="qa-container">
                    <div class="question_text"><div id="qa-nums">#4</div>Are your sex partners generally...</div>
                    <div style="clear:both;"></div>
      <div class="content_area">
                        <select name="SexualPartner" id="SexualPartner" style="width: 100px;"onchange="(($(this).parent()).parent()).parent().children('.next').css('display','inline');">
                            <option></option>
                            <option value="Male" <?php if($_REQUEST['SexualPartner'] == 'Male')echo'selected="selected"'; ?>>Male</option>
                            <option value="Female" <?php if($_REQUEST['SexualPartner'] == 'Female')echo'selected="selected"'; ?>>Female</option>
                            <option value="Both" <?php if($_REQUEST['SexualPartner'] == 'Both')echo'selected="selected"'; ?>>Both</option>
                        </select>
                    </div>
                </div>

				<div class="next">
                	<a href="#" onClick="next();"><img src="images/btn-next-inactive.png" alt="" onMouseOver="this.src='images/btn-next-active.png';" onMouseOut="this.src='images/btn-next-inactive.png';"/></a>
                </div>
                
				<div style="float:left; margin-top:20px;">
                	<a href="#" onClick="prev();"><img src="images/btn-previous-inactive.png" alt="" onMouseOver="this.src='images/btn-previous-active.png';" onMouseOut="this.src='images/btn-previous-inactive.png';"/></a>
                </div>
                
			</div>
		</li>

		<li>
			<div class="panecontain">
            
                <div id="qa-container">
                    <div class="question_text"><div id="qa-nums">#5</div>When was your last STD test?</div>
                    <div style="clear:both;"></div>
      <div class="content_area">
                        <select name="LastSTDTest" id="LastSTDTest"  style="width: 100px;" onchange="(($(this).parent()).parent()).parent().children('.next').css('display','inline');">
                            <option></option>
                            <option value="Never" <?php if($_REQUEST['LastSTDTest'] == 'Never')echo'selected="selected"'; ?>>Never</option>
                            <option value="+1yr" <?php if($_REQUEST['LastSTDTest'] == '+1yr')echo'selected="selected"'; ?>>+1 Year</option>
                            <option value="6months" <?php if($_REQUEST['LastSTDTest'] == '6months')echo'selected="selected"'; ?>>6 Months</option>
                            <option value="3months" <?php if($_REQUEST['LastSTDTest'] == '3months')echo'selected="selected"'; ?>>3 Months</option>
                        </select>
                    </div>
				</div>
                
				<div class="next">
                	<a href="#" onClick="next();"><img src="images/btn-next-inactive.png" alt="" onMouseOver="this.src='images/btn-next-active.png';" onMouseOut="this.src='images/btn-next-inactive.png';"/></a>
                </div>
                
				<div style="float:left; margin-top:20px;">
                	<a href="#" onClick="prev();"><img src="images/btn-previous-inactive.png" alt="" onMouseOver="this.src='images/btn-previous-active.png';" onMouseOut="this.src='images/btn-previous-inactive.png';"/></a>
                </div>
                
			</div>
		</li>

		<li>
			<div class="panecontain">
            
                <div id="qa-container">
                    <div class="question_text"><div id="qa-nums">#6</div>Have you had one or more new sexual partners since your last STD test, or within the last 6 months?</div>
                    <div style="clear:both;"></div>
                    <div class="content_area">
                        <select name="OneOrMoreSexualPartner" id="OneOrMoreSexualPartner" style="width: 100px;" onchange="(($(this).parent()).parent()).parent().children('.next').css('display','inline');">
                            <option></option>
                            <option value="Yes" <?php if($_REQUEST['OneOrMoreSexualPartner'] == 'Yes')echo'selected="selected"'; ?>>Yes</option>
                            <option value="No" <?php if($_REQUEST['OneOrMoreSexualPartner'] == 'No')echo'selected="selected"'; ?>>No</option>
                        </select>
                    </div>
                </div>

				<div class="next">
                	<a href="#" onClick="next();"><img src="images/btn-next-inactive.png" alt="" onMouseOver="this.src='images/btn-next-active.png';" onMouseOut="this.src='images/btn-next-inactive.png';"/></a>
                </div>
                
				<div style="float:left; margin-top:20px;">
                	<a href="#" onClick="prev();"><img src="images/btn-previous-inactive.png" alt="" onMouseOver="this.src='images/btn-previous-active.png';" onMouseOut="this.src='images/btn-previous-inactive.png';"/></a>
                </div>
                
			</div>
		</li>

		<li>
			<div class="panecontain">
            
                <div id="qa-container">
                    <div class="question_text"><div id="qa-nums">#7</div>Are you concerned about your partner's sexual activity with others?</div>
                    <div style="clear:both;"></div>
                    <div class="content_area">
                        <select name="ConcernedWithOther" id="ConcernedWithOther" style="width: 100px;" onchange="(($(this).parent()).parent()).parent().children('.next').css('display','inline');">
                            <option></option>
                            <option value="Yes" <?php if($_REQUEST['ConcernedWithOther'] == 'Yes')echo'selected="selected"'; ?>>Yes</option>
                            <option value="No" <?php if($_REQUEST['ConcernedWithOther'] == 'No')echo'selected="selected"'; ?>>No</option>
                        </select>
                    </div>
                </div>

				<div class="next">
                	<a href="#" onClick="next();"><img src="images/btn-next-inactive.png" alt="" onMouseOver="this.src='images/btn-next-active.png';" onMouseOut="this.src='images/btn-next-inactive.png';"/></a>
                </div>
				<div style="float:left; margin-top:20px;">
                	<a href="#" onClick="prev();"><img src="images/btn-previous-inactive.png" alt="" onMouseOver="this.src='images/btn-previous-active.png';" onMouseOut="this.src='images/btn-previous-inactive.png';"/></a>
                </div>
			</div>
		</li>

		<li>
			<div class="panecontain">
            
                <div id="qa-container">
                    <div class="question_text"><div id="qa-nums">#8</div>Have you been vaccinated for Hepatitis B?</div>
                    <div style="clear:both;"></div>
                    <div class="content_area">
                        <select name="VaccinatedForHepatitisB" id="VaccinatedForHepatitisB" style="width: 100px;" onchange="(($(this).parent()).parent()).parent().children('.next').css('display','inline');">
                            <option></option>
                            <option value="Yes" <?php if($_REQUEST['VaccinatedForHepatitisB'] == 'Yes')echo'selected="selected"'; ?>>Yes</option>
                            <option value="No" <?php if($_REQUEST['VaccinatedForHepatitisB'] == 'No')echo'selected="selected"'; ?>>No</option>
                            <option value="DoNotKnow" <?php if($_REQUEST['VaccinatedForHepatitisB'] == 'DoNotKnow')echo'selected="selected"'; ?>>Don't Know</option>
                        </select>
                    </div>
                </div>

				<div class="next">
                	<a href="#" onClick="next();"><img src="images/btn-next-inactive.png" alt="" onMouseOver="this.src='images/btn-next-active.png';" onMouseOut="this.src='images/btn-next-inactive.png';"/></a>
                </div>
                
				<div style="float:left; margin-top:20px;">
                	<a href="#" onClick="prev();"><img src="images/btn-previous-inactive.png" alt="" onMouseOver="this.src='images/btn-previous-active.png';" onMouseOut="this.src='images/btn-previous-inactive.png';"/></a>
                </div>
                
			</div>
		</li>

		<li>
			<div class="panecontain">
            
                <div id="qa-container">
                    <div class="question_text"><div id="qa-nums">#9</div>Have you ever used intravenous (IV) drugs or have had a relationship with an IV drug user?</div>
                    <div style="clear:both;"></div>
                    <div class="content_area">
                        <select name="RelationshipWithIVdrug" id="RelationshipWithIVdrug" style="width: 100px;" onchange="(($(this).parent()).parent()).parent().children('.next').css('display','inline');">
                            <option></option>
                            <option value="Yes" <?php if($_REQUEST['RelationshipWithIVdrug'] == 'Yes')echo'selected="selected"'; ?>>Yes</option>
                            <option value="No" <?php if($_REQUEST['RelationshipWithIVdrug'] == 'No')echo'selected="selected"'; ?>>No</option>
                            <option value="DoNotKnow" <?php if($_REQUEST['RelationshipWithIVdrug'] == 'DoNotKnow')echo'selected="selected"'; ?>>Don't Know</option>
                        </select>
                    </div>
                </div>

				<div class="next">
                	<a href="#" onClick="next();"><img src="images/btn-next-inactive.png" alt="" onMouseOver="this.src='images/btn-next-active.png';" onMouseOut="this.src='images/btn-next-inactive.png';"/></a>
                </div>
                
				<div style="float:left; margin-top:20px;">
                	<a href="#" onClick="prev();"><img src="images/btn-previous-inactive.png" alt="" onMouseOver="this.src='images/btn-previous-active.png';" onMouseOut="this.src='images/btn-previous-inactive.png';"/></a>
                </div>
                
			</div>
		</li>

		<li>
			<div class="panecontain">
            
                <div id="qa-container">
                    <div class="question_text"><div id="qa-nums">#10</div>Please check any of the following which you have tested positive for in the past:</div>
                    <div style="clear:both;"></div>
      <div class="content_area">
                        <input type="checkbox" class="customCheckbox" name="chkIndi1[2]" id="chkIndi1" value="hepatitis-b" /> Hepatitis B
                        <input type="checkbox" class="customCheckbox" name="chkIndi1[4]" id="chkIndi1" value="oral-herpes" /> Herpes 1
                        <input type="checkbox" class="customCheckbox" name="chkIndi1[7]" id="chkIndi1" value="syphilis" /> Syphilis
                        <br />
                        <input type="checkbox" class="customCheckbox" name="chkIndi1[3]" id="chkIndi1" value="hepatitis-c" /> Hepatitis C
                        <input type="checkbox" class="customCheckbox" name="chkIndi1[5]" id="chkIndi1" value="genital-herpes" /> Herpes 2
                        <input type="checkbox" class="customCheckbox" name="chkIndi1[6]" id="chkIndi1" value="hiv" /> HIV
                    </div>
                </div>

				<div class="next" style="display: inline;">
                	<a href="#" onClick="next();"><img src="images/btn-next-inactive.png" alt="" onMouseOver="this.src='images/btn-next-active.png';" onMouseOut="this.src='images/btn-next-inactive.png';"/></a>
                </div>
                
				<div style="float:left; margin-top:20px;">
                	<a href="#" onClick="prev();"><img src="images/btn-previous-inactive.png" alt="" onMouseOver="this.src='images/btn-previous-active.png';" onMouseOut="this.src='images/btn-previous-inactive.png';"/></a>
                </div>
                
			</div>
		</li>

		<li>
			<div class="panecontain">

                <div id="qa-container">
                    <div class="question_text"><div id="qa-nums">#11</div>Would you like to know whether or not you have genital herpes?</div>
                    <div style="clear:both;"></div>
                    <div class="content_area">
                        <select name="InterestedWithGenitalHerpes" id="InterestedWithGenitalHerpes" style="width: 100px;" onchange="(($(this).parent()).parent()).parent().children('.next').css('display','inline');">
                            <option></option>
                            <option value="Yes" <?php if($_REQUEST['InterestedWithGenitalHerpes'] == 'Yes')echo'selected="selected"'; ?>>Yes</option>
                            <option value="No" <?php if($_REQUEST['InterestedWithGenitalHerpes'] == 'No')echo'selected="selected"'; ?>>No</option>
                        </select>
                    </div>
                </div>

				<div style="float:left; margin-top:20px;">
                	<a href="#" onClick="prev();"><img src="images/btn-previous-inactive.png" alt="" onMouseOver="this.src='images/btn-previous-active.png';" onMouseOut="this.src='images/btn-previous-inactive.png';"/></a>
                </div>
                <input name="formSubmitTestRec" type="submit" value="Submit" class="next" />
			</div>
		</li>

	</ul>
    
<input type="hidden" name="MyRecommandation" id="MyRecommandation" value="MyRecommandation" />
<input type="hidden" name="a_aid" value="<?php echo $affID; ?>" />
</form>	
    

<div style="float:left; width:40px; font-size:10px; font-weight:bold; color:#FFF; margin-left:10px;">START</div>

<div style="width: 170px; height:10px; border:1px solid #008C8A;background: #fff; margin-bottom:10px; float:left;">
	<div class="progresso"></div>
</div>		

<div style="float:left; width:40px; font-size:10px; font-weight:bold; color:#FFF; text-align:right; margin-left:5px;">FINISH</div>

<div style="clear:both"></div>

</div>

</div>
	<!-- END AnythingSlider -->
    
<?php

?>
