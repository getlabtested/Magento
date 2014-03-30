<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Confirm Your Order &amp; Purchase Your STD Testing Package</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="robots" content="noindex, nofollow" />
	<meta name="google-site-verification" content="VcxCN5pd-2HSnLTEz6m0sruDv7en2MiKwRLnEFxXt1w" />

	<link rel="icon" href="https://getstdtested.com/media/favicon/default/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" href="https://getstdtested.com/media/favicon/default/favicon.ico" type="image/x-icon" />

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
	<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery("#gst-survey").validate({
				errorPlacement: function(error, element) {
					$(element).prev().prev().after(error);
				}
			});
		});
		jQuery.extend(jQuery.validator.messages, {
			required: "This question is required."
		});
		
		this.imagePreview = function(){	

			/* CONFIG */
			xOffset = 10;
			yOffset = 10;

			jQuery("a.preview").hover(function(e){
				this.t = this.title;
				this.title = "";	
				var c = (this.t != "") ? "<br />" + this.t : "";
				jQuery("body").append("<p id='preview'><img src='"+ this.rel +"' alt='Image preview' />"+ c +"</p>");								 
				jQuery("#preview")
				.css("top",(e.pageY - xOffset) + "px")
				.css("left",(e.pageX + yOffset) + "px")
				.fadeIn("fast");						
			},
			function(){
				this.title = this.t;	
				jQuery("#preview").remove();
				});	
				jQuery("a.preview").mousemove(function(e){
				jQuery("#preview")
				.css("top",(e.pageY - xOffset) + "px")
				.css("left",(e.pageX + yOffset) + "px");
			});			
		};
		jQuery(document).ready(function(){
			imagePreview();
		});
	</script>
	
	<style>		
		* {
			margin: 0;
			padding: 0;
		}

		body {
			color: #646262;
			font-size: 13px;
			font-family: Arial, Helvetica, sans-serif;
			line-height: 24px;
			background: #fff;
		}

		#wrap {
			margin: 15px;
			padding: 0;
		}

		h1 {
			margin: 0;
			padding: 100px; 0 25px 0;
			color: #023A4C;
			font-family: Tahoma,Geneva,sans-serif;
			font-size: 27px;
			line-height: 33px;
			text-align: center;
		}
		h1 strong { color: #E77640; }

		p {
			text-align: center;
		}
		
		#preview {
			position: absolute;
			border: 1px solid #fff;
			background: #ccc;
			padding: 5px 5px 3px 5px;
			display: none;
			color: #fff;
		}
		
		.error { padding-left: 8px; color: red; font-style: italic; }

		.button {
			display: block;
			width: auto;
			height: 32px;
			margin: 0;
			padding: 0 14px;
			color: #FFFFFF;
			font-size: 14px;
			line-height: 31px;
			font-weight: bold;
			text-align: center;
			text-transform: uppercase;
			text-decoration: none;
			background: url("http://getstdtested.com/media/images/btn_orange_32_reflection.png") no-repeat scroll center center transparent;
			border: 1px solid #fff;
			border-radius: 5px 5px 5px 5px;
			cursor: pointer;
		}		
	</style>
</head>


<body>

<?php
	if (!isset($_POST['gst_survey_step'])) {
?>
		<div id="wrap">
			<h1>Fill out this quick survey<br />and help us improve our offer</h1>
			<form action="" name="gst-survey" id="gst-survey" method="POST">
				
				<label for="gst_survey_q1"><strong>When was your last annual physical?</strong></label><br />
				&nbsp; <input type="radio" name="gst_survey_q1" id="gst_survey_q1a" onclick="getElementById('gst_q2').style.display='block';getElementById('gst_q5').style.display='none';getElementById('gst_q3').style.display='none';getElementById('gst_q4').style.display='none';" value="12 months or less" class="required" /> 12 months or less<br />
				&nbsp; <input type="radio" name="gst_survey_q1" id="gst_survey_q1b" onclick="getElementById('gst_q2').style.display='block';getElementById('gst_q5').style.display='none';getElementById('gst_q3').style.display='none';getElementById('gst_q4').style.display='none';" value="+2yr" class="required" /> +2yr<br />
				&nbsp; <input type="radio" name="gst_survey_q1" id="gst_survey_q1c" onclick="getElementById('gst_q5').style.display='block';getElementById('gst_q2').style.display='none';getElementById('gst_q3').style.display='none';getElementById('gst_q4').style.display='none';" value="+5yr" class="required" /> +5yr<br />
				&nbsp; <input type="radio" name="gst_survey_q1" id="gst_survey_q1d" onclick="getElementById('gst_q5').style.display='block';getElementById('gst_q2').style.display='none';getElementById('gst_q3').style.display='none';getElementById('gst_q4').style.display='none';" value="Never" class="required" /> Never<br />				
				<div class="cboth"><br /></div>
				
				<div id="gst_q2" style="display: none;">
					<label for="gst_survey_q2"><strong>Did you receive your lab test results?</strong></label><br />
					&nbsp; <input type="radio" name="gst_survey_q2" id="gst_survey_q2a" onclick="getElementById('gst_q3').style.display='block';getElementById('gst_q4').style.display='none';" value="Yes" /> Yes &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" name="gst_survey_q2" id="gst_survey_q2b" onclick="getElementById('gst_q3').style.display='none';getElementById('gst_q4').style.display='none';" value="No" /> No<br />				
					<div class="cboth"><br /></div>
				</div>
				
				<div id="gst_q3" style="display: none;">
					<label for="gst_survey_q3"><strong>Were the results understandable?</strong></label><br />
					&nbsp; <input type="radio" name="gst_survey_q3" id="gst_survey_q3a" onclick="getElementById('gst_q4').style.display='none';" value="Yes" /> Yes &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" name="gst_survey_q3" id="gst_survey_q3b" onclick="getElementById('gst_q4').style.display='block';" value="No" /> No<br />				
					<div class="cboth"><br /></div>
				</div>
					
				<div id="gst_q4" style="display: none;">
					<label for="gst_survey_q4"><strong>Would you like us to process your results to <a class="preview" href="javascript:void(0);" rel="http://getstdtested.com/media/images/your_results-small.png">look like this</a> for free?</strong></label><br />
					&nbsp; <input type="radio" name="gst_survey_q4" id="gst_survey_q4a" value="Yes" /> Yes (please email us at <a href="mailto:info@getlabtested.net?Subject=Process Test Results">info@getlabtested.net</a>)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" name="gst_survey_q4" id="gst_survey_q4b" value="No" /> No<br />				
					<div class="cboth"><br /></div>
				</div>
					
				<div id="gst_q5" style="display: none;">
					<label for="gst_survey_q5"><strong>Why not?</strong></label><br />
					&nbsp; <input type="checkbox" name="gst_survey_q5[]" id="gst_survey_q5a" value="Cost" /> Cost<br />
					&nbsp; <input type="checkbox" name="gst_survey_q5[]" id="gst_survey_q5b" value="Convenience" /> Convenience<br />
					&nbsp; <input type="checkbox" name="gst_survey_q5[]" id="gst_survey_q5c" value="No Insurance" /> No Insurance<br />
					&nbsp; <input type="checkbox" name="gst_survey_q5[]" id="gst_survey_q5d" value="No Doctor" /> No Doctor<br />
					&nbsp; <input type="checkbox" name="gst_survey_q5[]" id="gst_survey_q5e" value="Feel Healthy/No Need" /> Feel Healthy/No Need<br />
					&nbsp; <input type="checkbox" name="gst_survey_q5[]" id="gst_survey_q5f" value="Other" /> Other <input type="text" name="gst_survey_q5_other" id="gst_survey_q5_other" value="" /><br />				
					<div class="cboth"><br /></div>
				</div>
				
				<label for="gst_survey_q6"><strong>If you could add wellness tests in addition to your STD testing, which would you be interested?</strong></label><br />
				&nbsp; <input type="checkbox" name="gst_survey_q6[]" id="gst_survey_q6a" value="General Wellness / Complete Panel" class="required" /> General Wellness / Complete Panel<br />
				&nbsp; <input type="checkbox" name="gst_survey_q6[]" id="gst_survey_q6b" value="Cholesterol/Heart Health" class="required" /> Cholesterol/Heart Health<br />
				&nbsp; <input type="checkbox" name="gst_survey_q6[]" id="gst_survey_q6c" value="Diabetes" class="required" /> Diabetes<br />
				&nbsp; <input type="checkbox" name="gst_survey_q6[]" id="gst_survey_q6d" value="Kidney" class="required" /> Kidney<br />
				&nbsp; <input type="checkbox" name="gst_survey_q6[]" id="gst_survey_q6e" value="Liver" class="required" /> Liver<br />
				&nbsp; <input type="checkbox" name="gst_survey_q6[]" id="gst_survey_q6f" value="Vitamin Deficiency" class="required" /> Vitamin Deficiency<br />
				&nbsp; <input type="checkbox" name="gst_survey_q6[]" id="gst_survey_q6g" value="Other" class="required" /> Other <input type="text" name="gst_survey_q6_other" id="gst_survey_q6_other" value="" /><br />
				&nbsp; <input type="checkbox" name="gst_survey_q6[]" id="gst_survey_q6h" value="Not Sure" class="required" /> Not Sure<br />
				&nbsp; <input type="checkbox" name="gst_survey_q6[]" id="gst_survey_q6i" value="None" class="required" /> None<br />
				
				<div class="cboth" style="height: 1px; margin: 30px 0 22px 0; background: #ccc;"></div>
				
				<input type="hidden" name="gst_survey_step" id="gst_survey_step" value="1" />
				<input type="submit" name="button" id="button" class="button" value="Submit" />
			</form>
		</div>
<?php
	} else {
		
		$gst_survey_q1 = strip_tags($_POST['gst_survey_q1']);
		if (isset($_POST['gst_survey_q2'])) $gst_survey_q2 = strip_tags($_POST['gst_survey_q2']);
		if (isset($_POST['gst_survey_q3'])) $gst_survey_q3 = strip_tags($_POST['gst_survey_q3']);
		if (isset($_POST['gst_survey_q4'])) $gst_survey_q4 = strip_tags($_POST['gst_survey_q4']);
		if (isset($_POST['gst_survey_q5'])) $gst_survey_q5 = $_POST['gst_survey_q5'];
		if (isset($_POST['gst_survey_q5_other'])) $gst_survey_q5_other = strip_tags($_POST['gst_survey_q5_other']);
		$gst_survey_q6 = $_POST['gst_survey_q6'];
		if (isset($_POST['gst_survey_q6_other'])) $gst_survey_q6_other = strip_tags($_POST['gst_survey_q6_other']);
		
		if (($gst_survey_q1 != "") && ($gst_survey_q6 != "")) {
	
			$headers = "From: GST <info@getstdtested.com>\r\n";
			$headers .= "Reply-To: GST <info@getstdtested.com>\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			
			$email_body = "<html><body style=\"padding: 25px 0; background: #eeeeee;\">";
			$email_body .= "<div style=\"width: 600px; margin: 0 auto; padding: 10px 25px; background: #fff; border: 1px solid #dedede;\">";
			$email_body .= "<h2>GST Survey</h2>";
			$email_body .= "<p>Q1: ". $gst_survey_q1 ."<br />";
			if (isset($gst_survey_q2)) $email_body .= "Q2: ". $gst_survey_q2 ."<br />";
			if (isset($gst_survey_q3)) $email_body .= "Q3: ". $gst_survey_q3 ."<br />";
			if (isset($gst_survey_q4)) $email_body .= "Q4: ". $gst_survey_q4 ."<br />";
			if (isset($gst_survey_q5)) {
				$email_body .= "Q5: ";
				$N = count($gst_survey_q5);
				for($i=0; $i < $N; $i++) {
					$email_body .= $gst_survey_q5[$i] ." & ";
				}
				$email_body .= "<br />";
			}
			if (isset($gst_survey_q5_other)) $email_body .= "Q5 Other: ". $gst_survey_q5_other ."<br />";
			if (isset($gst_survey_q6)) {
				$email_body .= "Q6: ";
				$N = count($gst_survey_q6);
				for($i=0; $i < $N; $i++) {
					$email_body .= $gst_survey_q6[$i] ." & ";
				}
				$email_body .= "<br />";
			}
			if (isset($gst_survey_q6_other)) $email_body .= "Q6 Other: ". $gst_survey_q6_other ."<br />";
			$email_body .= "</p>";
			$email_body .= "<p><br /><br /><em>Best Regards,<br />getSTDtested.com Team</em></p>";
			$email_body .= "</div>";
			$email_body .= "</body></html>";
			
			mail('piotr@bieszk.com', 'GST Survey', $email_body, $headers);
?>
			
			<div id="wrap">
				<h1>Thank You for submitting our survey!</h1>
				<p>You will be redirected to our home page in 5 seconds.</p>
				<script type="text/javascript">
					setTimeout("window.location='http://getstdtested.com/'",4000);
				</script>
			</div>
<?php
		}

	}
?>


</body>
</html>
