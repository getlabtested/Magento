<?php
	function get_title($val)
	{
		if($val == 'm' or $val == '03' or $val == 'index')
			$title = 'Welcome to the mobile version of getSTDtested.com';
		else if($val == 'how-our-service-works')
			$title = 'How getSTDtested.com Works';
		else if($val == 'std-tests-and-pricing')
			$title = 'STD Tests';
		else if($val == 'find-a-testing-center')
			$title = 'Choose Your Testing Center';
		else if($val == 'who-should-get-tested')
			$title = 'Should you get tested for STDs?';
		else if($val == 'chlamydia-and-gonorrhea-home-test-kit')
			$title = 'About the Chlamydia and Gonorrhea At-Home TestPackage';
		else if($val == 'expert-recommended-package')
			$title = 'Expert Recommended Test Package';
		else if($val == 'herpes-ii-test')
			$title = 'About the Herpes 2 (Genital Herpes or HSV2) Test';
		else if($val == 'herpes-i-test')
			$title = 'About the Herpes 1 (Oral Herpes or HSV1) Test';
		else if($val == 'gonorrhea-test')
			$title = 'About the Gonorrhea Test';
		else if($val == 'chlamydia-test')
			$title = 'About the Chlamydia Test';
		else if($val == 'hepatitis-b-test')
			$title = 'About the Hepatitis B Test';
		else if($val == 'hepatitis-c-test')
			$title = 'About the Hepatitis C Test';
		else if($val == 'hiv')
			$title = 'About the HIV/AIDS Test';
		else if($val == 'syphils')
			$title = 'About the Syphilis Test';
		else if($val == 'compete-std-package')
			$title = 'Compete STD Testing Package';
		else if($val == 'home-std-package')
			$title = 'Home Test for Chlamydia &amp; Gonorrhea';
		else if($val == 'privacy-policy')
			$title = 'Privacy Policy';
		else if($val == 'terms-of-service')
			$title = 'Terms of Service';
      			
		return $title;
			
	}
?>