<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Get LAB Tested</title>

	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700,700italic,800italic' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/styles.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="images/favicon.ico" />

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="Content-Language" content="en-us" />

	<meta name="robots" content="all" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>		
	<script type="text/javascript">
		$(document).ready(function() {
		
			// resize hero Image
			function heroImage() {
		
				$bodyWidth = $("body").width();
		
				if ($bodyWidth > 1200) {
					$("#hero-image").css('display', 'block');
				} else {
					$("#hero-image").css('display', 'none');
				}
		
			}

			$(document).ready(heroImage);
		
			var resizeTimer;
			$(window).resize(function() {
				clearTimeout(resizeTimer);
				resizeTimer = setTimeout(heroImage, 25);
			});
		
			// medical advisory board photo rollovers
			$('#medical-advisors-photo1').hover(function() {
				$('#medical-advisors-photos div').each(function() {
					$(this).removeClass('active');
				});
				$('#medical-advisors-info div').each(function() {
					$(this).hide();
				});
				$(this).addClass('active');
				$('#medical-advisors-info1').show();
			});	
			$('#medical-advisors-photo2').hover(function() {
				$('#medical-advisors-photos div').each(function() {
					$(this).removeClass('active');
				});
				$('#medical-advisors-info div').each(function() {
					$(this).hide();
				});
				$(this).addClass('active');
				$('#medical-advisors-info2').show();
			});	
			$('#medical-advisors-photo3').hover(function() {
				$('#medical-advisors-photos div').each(function() {
					$(this).removeClass('active');
				});
				$('#medical-advisors-info div').each(function() {
					$(this).hide();
				});
				$(this).addClass('active');
				$('#medical-advisors-info3').show();
			});	
			$('#medical-advisors-photo4').hover(function() {
				$('#medical-advisors-photos div').each(function() {
					$(this).removeClass('active');
				});
				$('#medical-advisors-info div').each(function() {
					$(this).hide();
				});
				$(this).addClass('active');
				$('#medical-advisors-info4').show();
			});	
			$('#medical-advisors-photo5').hover(function() {
				$('#medical-advisors-photos div').each(function() {
					$(this).removeClass('active');
				});
				$('#medical-advisors-info div').each(function() {
					$(this).hide();
				});
				$(this).addClass('active');
				$('#medical-advisors-info5').show();
			});	
		});
	</script>
	
</head>

<body>


<div id="header">
	<div id="logo"><a href="#" title="Home | Get LAB Tested">Get LAB Tested</a></div>
	<div id="top-links">
		Tests in Cart: <strong>0</php></strong> &nbsp; | &nbsp;
		Subtotal: <strong>$0</strong> &nbsp; | &nbsp;
		<a href="http://getlabtested.com/checkout/cart">View Cart</a> &nbsp; | &nbsp; 
		<a href="https://getlabtested.com/onestepcheckout/index/">Checkout</a>
	</div>
</div>

<div id="banner-wrap">
	<div id="banner">
		<a href="#" class="b-get-tested">Get Tested Today!</a>
	</div>
	<div id="hero-image-wrap"><img src="images/hero-photo-bg.jpg" id="hero-image" border="0" alt="" /></div>
</div>

<div id="how-it-works-wrap">	
	<ul id="how-it-works">
		<li id="how-it-works-1">
			<h2>Call or<br /><strong>Order</strong> Online</h2>
			<p>Quick, secure and&nbsp;confidential.<br /><br /></p>
			<a href="#">LEARN MORE &raquo;</a>
		</li>
		<li id="how-it-works-2">
			<h2>Choose Your<br /><strong>Screening</strong> Method</h2>
			<p>Quickly test at a nearby lab or receive a convenient home&nbsp;testing kit.</p>
			<a href="#">LEARN MORE &raquo;</a>
		</li>
		<li id="how-it-works-3">
			<h2>Fast <strong>Results</strong>,<br />Treatment <strong>Options</strong></h2>
			<p>Results in 2-3 days. Review results with our doctors. Prescriptions available.</p>
			<a href="#">LEARN MORE &raquo;</a>
		</li>
	</ul>
	<div class="cboth"></div>
</div>


<div class="wrap">

	<div id="why">
		<a href="#" class="b-get-tested">Get Tested Today!</a>
		<h2>Why Men’s Wellness<br />Testing Shouldn’t Wait</h2>
		<p id="why-icon-1">Heart disease is the leading cause of death for men in the United States, responsible for 1 in every 4 male deaths in 2009.</p>
		<p id="why-icon-2">13.0 million—or 11.8%—of all men aged 20 years or older have diabetes.</p>
		<p id="why-icon-3">Millions of men have prediabetes, which imposes 50% increased risk for heart disease or stroke.4 Understanding your glucose levels provides insight to make necessary lifestyle changes to avoid diabetes and other health consequences.</p>
		<p id="why-icon-4">Cholesterol testing is recommended once every five years for adult men. More frequent testing is recommended for men over 45.</p>
		<p id="why-icon-5">Hepatitis C affects 1 in 33 baby boomers, those born between 1945 and 1964. High AST/ALT levels can indicate a hepatitis infection in men.</p>
	</div>

	<div id="benefits">
		<a href="#" class="b-get-tested">Get Tested Today!</a>
		<h2>Complete Men’s Wellness Test Details.</h2>
		<p>The Men’s Wellness Panel is designed specifically to evaluate the overall health in men. This panel is comprised of the following tests and panels:</p>
		
		<p class="benefits-checkmark"><strong>CBC.</strong> The complete blood count (CBC) screens for a variety of diseases and conditions. It can also help diagnose anemia, infection, bleeding disorders and certain cancers.</p>
		
		<p class="benefits-checkmark"><strong>CMP.</strong> The comprehensive metabolic panel (CMP) is a broad group of tests used to detect to evaluate organ health and screen for conditions such as diabetes, liver disease and kidney disease. The CMP features the following tests:</p>
		<p class="benefits-bull"><strong>Glucose</strong></p>
		<p class="benefits-bull"><strong>Calcium</strong></p>
		<p class="benefits-bull"><strong>Proteins:</strong> Albumin, total protein</p>
		<p class="benefits-bull"><strong>Electrolytes:</strong> Sodium, potassium, CO2, chloride</p>
		<p class="benefits-bull"><strong>Kidney tests:</strong> BUN (blood urea nitrogen), creatinine</p>
		<p class="benefits-bull"><strong>Liver tests:</strong> ALP, ALT, AST, bilirubin</p>
		
		<p class="benefits-checkmark"><strong>Lipid profile.</strong> This panel measures cholesterol levels and evaluates the risk of developing cardiovascular disease.</p>
		<p class="benefits-bull"><strong>Cholesterol, total.</strong> Too much cholesterol, an essential substance necessary for life, can lead to various heart problems, including heart attack and stroke.</p>
		<p class="benefits-bull"><strong>HDL cholesterol.</strong> HDL is also known as “good cholesterol.” Higher levels of HDL can reduce the risk of developing plaques, as it removed excess cholesterol from the blood.</p>
		<p class="benefits-bull"><strong>Triglycerides.</strong> Triglycerides are a type of fat and a source of energy for the body. High levels can indicate an increased risk for heart disease.</p>
		<p class="benefits-bull"><strong>LDL cholesterol.</strong> LDL is considered “bad cholesterol.” This lipoprotein deposits extra cholesterol into the wall of blood vessels and contributes to hardening of arteries.</p>

		<p class="benefits-checkmark"><strong>A1c.</strong> The hemoglobin A1c test is used to diagnose diabetes and prediabetes. It is also used to monitor previously diagnosed diabetes cases and aid in treatment.</p> 
		<p class="benefits-checkmark"><strong>TSH.</strong> This test measures levels of the thyroid stimulating hormone (TSH) to help diagnose hypothyroidism and hyperthyroidism.</p>
		<p>Fasting is required for the Men’s Wellness panel. Do not eat or drink anything (except water) nine to 12 hours before testing.</p>
	</div>

	<div id="details">
		<a href="#" class="b-get-tested">Get Tested Today!</a>
		<h2>What to Expect When Testing<br />With getLABtested.com</h2>
		<p>Your thyroid test purchase includes everything necessary for testing: a lab order issued by our doctors, lab fees, taxes, a PDF of your test results and a phone consultation with a staff doctor to discussed results and possible treatment options.</p>
		<p id="details-icon-1">Receive everything you need to for testing at one low price. A test order from our doctors, lab fees, a PDF of your test results and a free phone consultation with our doctors are all included.</p>
		<p id="details-icon-2">Visit a local FDA-approved or CLIA-certified diagnostic laboratory. Nearly 2,000 locations nationwide.</p>
		<p id="details-icon-3">Test the same day as ordering. No appointments necessary.</p>
		<p id="details-icon-4">Screen with the most accurate and up-to-date testing. Same tests administered by doctors and hospitals nationwide.</p>
		<p id="details-icon-5">Know your results within 3 business days. Results are emailed and accessible in a password-protected portal.</p>
		<p id="details-icon-6">Talk to a staff physician about your results. Free medical advice and counseling with purchase.</p>
	</div>

	<div id="treatment">
		<h2>Your Diagnosis and Treatment Options.</h2>
		<p>Our service doesn’t stop with testing. When results become available, getLABtested.com offers phone consultations with staff doctors and help interpreting test results.</p>
		<p id="treatment-icon-1">Discuss abnormal test results, follow-up testing and treatment options via phone with a staff physician.</p>
		<p id="treatment-icon-2">Email results directly to your current physician.</p>
	</div>

	<div id="medical-advisors">
		<h2>Our Medical Advisors.</h2>
		<div id="medical-advisors-photos">
			<div id="medical-advisors-photo1" class="active"></div>
			<div id="medical-advisors-photo2"></div>
			<div id="medical-advisors-photo3"></div>
			<div id="medical-advisors-photo4"></div>
			<div id="medical-advisors-photo5"></div>
		</div>
		<div id="medical-advisors-info">
			<div id="medical-advisors-info1">
				<h3>Michael Davidson, MD</h3>
				<h4>Director of Preventative Cardiology at University of Chicago Medical Center</h4>
				<p>Renowned Cardiologist, research investigator, author, lecturer, and business entrepreneur; applies skills in developing new approaches in the advancement of healthcare.  Davidson founded Chicago Center for Clinical Research and sold this business to Radiant Research in 2000; he continues to serve as their Chief Medical Officer. Michael is also the Director of Preventative Cardiology at University of Chicago Medical Center; President of National Lipid Association; and, Founder of Omthera Pharmaceuticals.  He has conducted over 1,000 clinical trials and authored over 250 medical journal publications. In addition to his prolific career, the American Diabetes Association named Michael “Father of the Year” in 2010.</p>
			</div>
			<div id="medical-advisors-info2" style="display:none;">
				<h3>Barry Berger, MD</h3>
				<h4>Medical Director</h4>
				<p>Internist with over 30 years experience; in addition to his own practice, Dr. Berger has entrepreneurial interests and involvement in emerging healthcare businesses. Over 15 years ago, Dr. Berger joined an early stage Corporate Wellness Company as its staff medical director and assisted that company’s growth to an industry leadership position in revenue, profitability, and employee enrollment.</p>
			</div>
			<div id="medical-advisors-info3" style="display:none;">
				<h3>Neil Skolnik, MD</h3>
				<p>Professor of Family and Community Medicine at Temple University School of Medicine in Philadelphia, and practicing physician, Dr. Skolnik is a prolific author including publication of CDC's PDA version of the 2002 and the 2006 CDC Sexually Transmitted Disease Guidelines. He is also the handheld series editor for all of the guidelines published by the Infectious Disease Society of America. Dr. Skolnick recently edited and published the definitive guide to implementing EMRs.  The new book is titled "Electronic Medical Records:  A Practical Guide for Primary Care."</p>
			</div>
			<div id="medical-advisors-info4" style="display:none;">
				<h3>Barbara Jean Van Der Pol, PhD, MPH*</h3>
				<p>International renowned researcher for infectious disease, Dr. Van Der Pol is Director of Indiana University of Medicine Infectious Disease Laboratory and Director of Marion County Department of Health. Dr. Van Der Pol is also a leading expert for CDC and serves as a committee member for the National Chlamydia Coalition.</p>
			</div>
			<div id="medical-advisors-info5" style="display:none;">
				<h3>H. Hunter Handsfield, MD</h3>
				<p>Industry honored professor of medicine at University of Washington and senior research leader at the Battelle Centers for Public Health Research. Dr. Handsfield received the 2010  Thomas Parran Award, named for Dr. Thomas Parran, U.S. Surgeon General from 1936 to 1948 and the chief developer of modern STD prevention. Dr. Handsfield was bestowed this award in recognition of “long and distinguished” contributions to STD research and prevention.</p>
			</div>
		</div>
	</div>

	<div id="customer-reviews">
		<h2><strong>Real</strong> Customer Reviews.</h2>
	</div>

	<div id="quality-testing">
		<h2>Highest <strong>Quality</strong> Lab Testing.</h2>
		<p><strong>getLABtested.com</strong> and its partnering laboratories are backed by several nationally-recognized medical groups and government agencies to ensure the highest quality of pathology and laboratory medicine.</p>
	</div>
	
	<div id="security-certs"></div>
	
</div>

<div id="footer-wrap">
	<div id="footer">
		<p>
			Per the Annotated Code of Maryland, Health-General Article, §17-215, getLABtested.com is unable to provide our service within the state of Maryland.<br />
			If you are a Maryland resident, please call us (866) 236-8491 and we can help you find an alternative testing facility.
		</p>
	</div>
</div>


<!-- Tracking codes will go here -->


</body>
</html>