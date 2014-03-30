<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>STD Test Recommendation | STD Testing | GetSTDTested.com</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<link rel="stylesheet" href="test-recommendation.css" type="text/css" media="screen"/>
	<meta name="keywords" content="std testing, home std testing, std testing kits"/>
	<meta name="description" content="Just answer a few questions below and get a personalized STD testing recommendation, based on national health guidelines and other factors that may increase your risk for specific STDs. 100% confidential." />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script type="text/javascript" src="sliding.form.js"></script>
	
	<script type="text/javascript">
	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-10462432-1']);
	  _gaq.push(['_setDomainName', 'getstdtested.com']);
	  _gaq.push(['_trackPageview']);

	  (function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();
	</script>
	
</head>

<body>

	<div id="content">

<?php
	if (!isset($_POST['Gender'])) {
?>	

		<h1>PHYSICIAN-BACKED STD TEST RECOMMENDER</h1>
		<h2><strong>Not sure which STD tests are right for you? No problem.</strong> Get physician-backed STD test recommendations by answering a few simple questions in under 60 seconds. Recommendations are 100% anonymous.</h2>
		<div id="wrapper">
			<div id="steps">
				<form id="formElem" name="formElem" action="" method="post">
					<fieldset class="step">
						<legend>Tell us a little about yourself...</legend>
						<p>
							<label for="Gender">Are you a male or female?</label>
							<select id="Gender" name="Gender">
								<option value="">Please Select</option>
								<option value="">---</option>
								<option value="Male">Male</option>
								<option value="Female">Female</option>
							</select>
						</p>
						<p>
							<label for="Age">How old are you?</label>
							<select id="Age" name="Age">
								<option value="">Please Select</option>
								<option value="">---</option>
								<option value="under18">Under 18</option>
								<option value="18-24">18-24</option>
								<option value="25-29">25-29</option>
								<option value="30-39">30-39</option>
								<option value="40-49">40-49</option>
								<option value="50-59">50-59</option>
								<option value="60-69">60-69</option>
								<option value="70+">70+</option>
							</select>
						</p>
						<p>
							<span id="next1" style="float: right;"><a href="#" class="button">Next &raquo;</a></span>
						</p>
					</fieldset>
					<fieldset class="step">
						<legend>Tell us a little about your partners...</legend>
						<p>
							<label for="SexualPartner">Are your sex partners generally...</label>
							<select id="SexualPartner" name="SexualPartner">
								<option value="">Please Select</option>
								<option value="">---</option>
								<option value="Male">Male</option>
								<option value="Female">Female</option>
								<option value="Both">Both</option>
							</select>
						</p>
						<p>
							<label for="OneOrMoreSexualPartner">Has it been 6+ months since your last STD test OR have you had more than 1 new partner since the last time you tested?</label>
							<select id="OneOrMoreSexualPartner" name="OneOrMoreSexualPartner">
								<option value="">Please Select</option>
								<option value="">---</option>
								<option value="Yes">Yes</option>
								<option value="No">No</option>
							</select>
						</p>
						<p>
							<label for="ConcernedWithOther">Are you concerned about your partner(s) sexual activity with others?</label>
							<select id="ConcernedWithOther" name="ConcernedWithOther">
								<option value="">Please Select</option>
								<option value="">---</option>
								<option value="Yes">Yes</option>
								<option value="No">No</option>
							</select>
						</p>
						<p>
							<label for="RelationshipWithIVdrug">Have you ever used intravenous drugs or had relations with a drug user?</label>
							<select id="RelationshipWithIVdrug" name="RelationshipWithIVdrug">
								<option value="">Please Select</option>
								<option value="">---</option>
								<option value="Yes">Yes</option>
								<option value="No">No</option>
								<option value="DoNotKnow">Don't Know</option>
							</select>
						</p>
						<p>
							<span id="prev2" style="float: left;"><a href="#" class="button">&laquo; Back</a></span>
							<span id="next2" style="float: right;"><a href="#" class="button">Next &raquo;</a></span>
						</p>
					</fieldset>
					<fieldset class="step">
						<legend>Tell us a little about your health...</legend>
						<p>
							<label for="LastSTDTest">When was your last STD test?</label>
							<select id="LastSTDTest" name="LastSTDTest">
								<option value="">Please Select</option>
								<option value="">---</option>
								<option value="Never">Never</option>
								<option value="+1yr">+1 Year</option>
								<option value="6months">6 Months</option>
								<option value="3months">3 Months</option>
							</select>
						</p>
						<p>
							<label for="VaccinatedForHepatitisB">Have you been vaccinated for Hepatitis B?</label>
							<select id="VaccinatedForHepatitisB" name="VaccinatedForHepatitisB">
								<option value="">Please Select</option>
								<option value="">---</option>
								<option value="Yes">Yes</option>
								<option value="No">No</option>
								<option value="DoNotKnow">Don't Know</option>
							</select>
						</p>
						<p>
							<label for="chkIndi1">Have you tested positive for any of the following STDs in the past?</label>
							<span style="float: left; width: 108px;">
								<input type="checkbox" class="checkbox" name="chkIndi1[4]" id="chkIndi1" value="oral-herpes" /> Oral Herpes<br />
								<input type="checkbox" class="checkbox" name="chkIndi1[5]" id="chkIndi1" value="genital-herpes" /> Genital Herpes<br />
								<input type="checkbox" class="checkbox" name="chkIndi1[6]" id="chkIndi1" value="hiv" /> HIV
							</span>
							<span style="float: left;">
								<input type="checkbox" class="checkbox" name="chkIndi1[2]" id="chkIndi1" value="hepatitis-b" /> Hepatitis B<br />
								<input type="checkbox" class="checkbox" name="chkIndi1[3]" id="chkIndi1" value="hepatitis-c" /> Hepatitis C<br />
								<input type="checkbox" class="checkbox" name="chkIndi1[7]" id="chkIndi1" value="syphilis" /> Syphilis
							</span>
						</p>
						<p>
							<label for="InterestedWithGenitalHerpes">Would you like to know whether or not you have genital herpes?</label>
							<select id="InterestedWithGenitalHerpes" name="InterestedWithGenitalHerpes">
								<option value="">Please Select</option>
								<option value="">---</option>
								<option value="Yes">Yes</option>
								<option value="No">No</option>
							</select>
						</p>
						<p>
							<span id="prev3" style="float: left;"><a href="#" class="button">&laquo; Back</a></span>							
							<span style="float: right;"><a href="#" id="recommendationButton" class="button">Get Recommendation</a></span>
						</p>
					</fieldset>
				</form>
			</div>
			<div id="navigation" style="display:none;">
				<ul>
					<li class="selected">
						<a href="#">Step 1</a>
					</li>
					<li>
						<a href="#">Step 2</a>
					</li>
					<li>
						<a href="#">Step 3</a>
					</li>
				</ul>
			</div>
		</div>
			
<?php
	} else {

		$gender = $_POST['Gender'];
		$age = $_POST['Age'];
		$sexualpartner = $_POST['SexualPartner'];
		$laststdtest = $_POST['LastSTDTest'];
		$oneormoresexualpartner = $_POST['OneOrMoreSexualPartner'];
		$concernedwithother = $_POST['ConcernedWithOther'];
		$vaccinatedforhepatitisb = $_POST['VaccinatedForHepatitisB'];
		$relationshipwithivdrug = $_POST['RelationshipWithIVdrug'];
		$interestedwithgenitalherpes = $_POST['InterestedWithGenitalHerpes'];
		$chkIndi1 = $_POST['chkIndi1'];	
		
		$AddToCDC = array();
		
		if($gender == 'Female' && ($age == 'under18' || $age == '18-24')) {
			$AddToCDC['Chlamydia'] = "chlamydia";
		}
		if($gender == 'Male' && $sexualpartner != 'Female') {
			$AddToCDC['Chlamydia'] = "chlamydia";
			$AddToCDC['Gonorrhea'] = "gonorrhea";
			$AddToCDC['HIV'] = "hiv";
			$AddToCDC['Syphilis'] = "syphilis";
		}
		if($oneormoresexualpartner == 'Yes' || $concernedwithother == 'Yes') {
			$AddToCDC['Chlamydia'] = "chlamydia";
			$AddToCDC['Gonorrhea'] = "gonorrhea";
			$AddToCDC['HIV'] = "hiv";
		}
		if($vaccinatedforhepatitisb == 'No' || $vaccinatedforhepatitisb == 'DoNotKnow')
			$AddToCDC['Hepatitis B'] = "hepatitis-b";
		if($relationshipwithivdrug == 'Yes' || $relationshipwithivdrug == 'DoNotKnow')
			$AddToCDC['Hepatitis C'] = "hepatitis-c";
		if($interestedwithgenitalherpes == 'Yes')
			$AddToCDC['Genital Herpes'] = "genital-herpes";
		
		if(count($chkIndi1) > 0) {
			foreach($AddToCDC as $key=>$val) {
				if (in_array($val,$chkIndi1) == false) {
					//unset($AddToCDC[$key]);
					$AddToCDC[$key] = $val;				
				}
			}
		}

?>

		<div id="results">
			<h1>YOUR STD TEST RECOMMENDATION</h1>
			<h2><strong>Based on your answers, it's recommended that you test for:</strong></h2>
			<ul>
			<?php
				$i = 0;
				foreach($AddToCDC as $key=>$val) {
					echo "<li>".$key."</li>";
					$i++;
					if ($i == 4) echo "</ul><ul>";
				}
			?>
			</ul>

			<p><a onclick="javascript:parent.closeFancyboxAndRedirectToUrl('http://getstdtested.com/std-testing-options');" class="button" title="Get STD Tested today!">START HERE</a></p>

			<h1 style="clear: both; padding-top: 45px; padding-bottom: 0; font-size: 24px;">GET PEACE OF MIND WITH OUR COMPLETE PACKAGE</h1>
			<a onclick="javascript:parent.closeFancyboxAndRedirectToUrl('http://getstdtested.com/std-testing-options');" title="Get STD Tested today!"><img src="std-tests-widget.jpg" width="660" height="340" border="0" alt="" /></a>
		</div>

<?php
	}
?>			

	</div>

		
</body>
</html>