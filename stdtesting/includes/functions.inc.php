<?php

function genStateContent($stateID, $state, $type) {

	if (isset($stateID) && isset($state) && ($type == "intro")) {
	
		$facts = array();
		$facts['Alaska'] = "<p>4,357 new cases of chlamydia (Alaska, 2010)<br />601 new cases of gonorrhea (Alaska, 2010)<br />9 new cases of P&S syphilis (Alaska, 2010)<br />607 people are HIV-positive (Alaska, 2008)</p>";
		$facts['Alabama'] = "<p>13,886 new cases of chlamydia (Alabama, 2010)<br />7,457 new cases of gonorrhea (Alabama, 2010)<br />1,113 new cases of P&S syphilis (Alabama, 2010)<br />10,316 people are HIV-positive (Alabama, 2008)</p>";
		$facts['Arkansas'] = "<p>15,423 new cases of chlamydia (Arkansas, 2010)<br />4,765 new cases of gonorrhea (Arkansas, 2010)<br />407 new cases of syphilis (Arkansas, 2010)<br />4,976 people are HIV-positive (Arkansas, 2008)</p>";
		$facts['Arizona'] = "<p>26,008 new cases of chlamydia (Arizona, 2010)<br />3,251 new cases of gonorrhea (Arizona, 2010)<br />429 new cases of syphilis (Arizona, 2010)<br />11,815 people are HIV-positive (Arizona, 2008)</p>";
		$facts['California'] = "<p>146,796 new cases of chlamydia (California, 2009)<br />23,228 new cases of gonorrhea (California, 2009)<br />6,031 new cases of syphilis (California, 2009)<br />109,000 Californians are HIV-positive, 69,728 of whom are living with AIDS.</p>";
		$facts['Colorado'] = "<p>350.2 people per 100,000 are positive with chlamydia (Colorado, 2007)<br />3,396 people are positive with gonorrhea (2007)<br />57 cases of syphilis reported (2007)<br />10,678 people are living with HIV in Colorado</p>";
		$facts['Connecticut'] = "<p>12,136 new cases of chlamydia (Connecticut, 2009)<br />2,554 new cases of gonorrhea (Connecticut, 2009)<br />54 new cases of syphilis (Connecticut, 2009)<br />10,930 people living with HIV (Connecticut, 2009)</p>";
		$facts['District Of Columbia'] = "<p>20,116 annual cases of chlamydia (Washington, DC Metro Area, 2009)<br />5,321 cases of gonorrhea (Washington, DC Metro Area, 2009)<br />324 cases of P&S syphilis (Washington, DC Metro Area, 2009)<br />9,475 people living with AIDS (Washington, DC, 2008)</p>";
		$facts['Delaware'] = "<p>4,718 new cases of chlamydia (Delaware, 2009)<br />1,045 new cases of gonorrhea (Delaware, 2009)<br />27 new cases of syphilis (Delaware, 2009)<br />157 new cases of HIV (Delaware, 2009)</p>";
		$facts['Florida'] = "<p>74,713 new cases of chlamydia (Florida, 2010)<br />20,164 new cases of gonorrhea (Florida, 2010)<br />1,184 new cases of syphilis (Florida, 2010)<br />90,909 people living with HIV (Florida, 2008)</p>";
		$facts['Georgia'] = "<p>39,828 annual cases of chlamydia (Georgia, 2009)<br />13,687 cases of gonorrhea (Georgia, 2009)<br />2,717 cases of P&S syphilis (Georgia, 2009)<br />35,220 people living with HIV (Georgia, 2008)</p>";
		$facts['Hawaii'] = "<p>Coming soon.</p>";
		$facts['Iowa'] = "<p>9,406 annual cases of chlamydia (Iowa, 2009)<br />1,658 cases of gonorrhea (Iowa, 2009)<br />65 cases of P&S syphilis (Iowa, 2009)<br />1,549 cases of HIV (Iowa, 2008)</p>";
		$facts['Idaho'] = "<p>3,842 new cases of chlamydia (Idaho, 2009)<br />110 new cases of gonorrhea (Idaho, 2009)<br />31 new cases of syphilis (Idaho, 2009)<br />744 people are HIV-positive (Idaho, 2008)</p>";
		$facts['Illinois'] = "<p>60,542 annual cases of chlamydia (Illinois, 2009)<br />19,962 cases of gonorrhea (Illinois, 2009)<br />1,915 cases of P&S syphilis (Illinois, 2009)<br />32,962 people living with HIV (Illinois, 2008)</p>";
		$facts['Indiana'] = "<p>21,759 new cases of chlamydia (Indiana, 2009)<br />6,812 new cases of gonorrhea (Indiana, 2009)<br />152 new cases of P&S syphilis (Indiana, 2009)<br />9,646 people are HIV-positive(Indiana, 2009)</p>";
		$facts['Kansas'] = "<p>10,510 annual cases of chlamydia (Kansas, 2009)<br />2,505 cases of gonorrhea (Kansas, 2009)<br />151 cases of P&S syphilis (Kansas, 2009)<br />2,597 people living with HIV (Kansas, 2008)</p>";
		$facts['Kentucky'] = "<p>13,293 annual cases of chlamydia (Kentucky, 2009)<br />3,827 cases of gonorrhea (Kentucky, 2009)<br />239 cases of P&S syphilis (Kentucky, 2009)<br />4,403 people living with HIV (Kentucky, 2008)</p>";
		$facts['Louisiana'] = "<p>2653 reported cases of chlamydia (Orleans Parish, 2008)<br />1297 reported cases of gonorrhea (Orleans Parish, 2008)<br />99 reported cases of P&S syphilis (Orleans Parish, 2008)<br />16,210 documented people living with HIV (Louisiana, 2008)</p>";
		$facts['Massachusetts'] = "<p>19,315 annual cases of chlamydia (Massachusetts, 2009)<br />996 cases of gonorrhea (Massachusetts, 2009)<br />473 cases of P&S syphilis (Massachusetts, 2009)<br />18,045 people living with HIV (Massachusetts, 2009)</p>";
		$facts['Maryland'] = "<p>23,747 annual cases of chlamydia (Maryland, 2009)<br />6,395 cases of gonorrhea (Maryland, 2009)<br />993 cases of P&S syphilis (Maryland, 2009)<br />1,134 people diagnosed with HIV (Maryland, 2009)</p>";
		$facts['Maine'] = "<p>Coming soon.</p>";
		$facts['Michigan'] = "<p>45,714 annual cases of chlamydia (Michigan, 2009)<br />6,004 cases of gonorrhea (Michigan, 2009)<br />635 cases of P&S syphilis (Michigan, 2009)<br />14,122 people living with HIV (Michigan, 2008)</p>";
		$facts['Minnesota'] = "<p>14,197 annual cases of chlamydia (Minnesota, 2009)<br />2,303 cases of gonorrhea (Minnesota, 2009)<br />217 cases of P&S syphilis (Minnesota, 2009)<br />6,086 people living with HIV (Minnesota, 2008)</p>";
		$facts['Missouri'] = "<p>25,868 annual cases of chlamydia (Missouri, 2009)<br />6,488 cases of gonorrhea (Missouri, 2009)<br />514 cases of P&S syphilis (Missouri, 2009)<br />11,137 people living with HIV (Missouri, 2008)</p>";
		$facts['Mississippi'] = "<p>23,589 annual cases of chlamydia (Mississippi, 2009)<br />7,241 cases of gonorrhea (Mississippi, 2009)<br />745 cases of P&S syphilis (Mississippi, 2009)<br />7,761 people living with HIV (Mississippi, 2008)</p>";
		$facts['Montana'] = "<p>2,998 annual cases of chlamydia (Montana, 2009)<br />80 cases of gonorrhea (Montana, 2009)<br />5 cases of P&S syphilis (Montana, 2009)<br />31 cases of HIV (Montana, 2009)</p>";
		$facts['North Carolina'] = "<p>2,503 new cases of chlamydia (Forsyth County, 2010)<br />774 new cases of gonorrhea (Forsyth County, 2010)<br />68 new cases of syphilis (Forsyth County, 2010)<br />22,369 people living with HIV (North Carolina, 2008)</p>";
		$facts['North Dakota'] = "<p>Coming soon.</p>";
		$facts['Nebraska'] = "<p>5,443 annual cases of chlamydia (Nebraska, 2009)<br />553 cases of gonorrhea (Nebraska, 2009)<br />45 cases of P&S syphilis (Nebraska, 2009)<br />1,553people living with HIV (Nebraska, 2008)</p>";
		$facts['New Hampshire'] = "<p>2,102 annual cases of chlamydia (New Hampshire, 2009)<br />59 cases of gonorrhea (New Hampshire, 2009)<br />37 cases of P&S syphilis (New Hampshire, 2009)<br />1,196 people living with HIV (New Hampshire, 2008)</p>";
		$facts['New Jersey'] = "<p>23,974 annual cases of chlamydia (New Jersey, 2009)<br />4,762 cases of gonorrhea (New Jersey, 2009)<br />890 cases of P&S syphilis (New Jersey, 2009)<br />36,974 people living with HIV (New Jersey, 2008)</p>";
		$facts['New Mexico'] = "<p>364.1 cases of chlamydia per 100,000<br />117.1 cases of gonorrhea per 100,000<br />3.8 cases of syphilis per 100,000<br />2,252 people are HIV-positive in New Mexico</p>";
		$facts['New York'] = "<p>92,069 annual cases of chlamydia (New York, 2009)<br />9,072 cases of gonorrhea (New York, 2009)<br />4,643 cases of P&S syphilis (New York, 2009)<br />135,018 people living with HIV (New York, 2008)</p>";
		$facts['Nevada'] = "<p>10,045 annual cases of chlamydia (Nevada, 2009)<br />900 cases of gonorrhea (Nevada, 2009)<br />306 cases of P&S syphilis (Nevada, 2009)<br />6,692 people living with HIV (Nevada, 2008)</p>";
		$facts['Ohio'] = "<p>48,239 annual cases of chlamydia (Ohio, 2009)<br />15,988 cases of gonorrhea (Ohio, 2009)<br />794 cases of P&S syphilis (Ohio, 2009)<br />16,283 people living with HIV (Ohio, 2008)</p>";
		$facts['Oklahoma'] = "<p>26,008 new cases of chlamydia (Oklahoma, 2010)<br />3,251 new cases of gonorrhea (Oklahoma, 2010)<br />429 new cases of syphilis (Oklahoma, 2010)<br />11,815 people are HIV-positive (Oklahoma, 2008)</p>";
		$facts['Oregon'] = "<p>15,023 annual cases of chlamydia (Ohio, 2009)<br />608 cases of gonorrhea (Ohio, 2009)<br />132 cases of P&S syphilis (Ohio, 2009)<br />4,740 people living with HIV (Ohio, 2008)</p>";
		$facts['Pennsylvania'] = "<p>30,449 annual cases of chlamydia (Philadelphia Metro Area, 2009)<br />7,407 cases of gonorrhea (Philadelphia Metro Area, 2009)<br />289 cases of P&S syphilis (Philadelphia Metro Area, 2009)<br />31,220 people living with HIV (Pennsylvania, 2008)</p>";
		$facts['Rhode Island'] = "<p>3,615 annual cases of chlamydia (Rhode Island, 2010)<br />176 cases of gonorrhea (Rhode Island, 2010)<br />64 cases of P&S syphilis (Rhode Island, 2010)<br />1,416 people living with AIDS (Rhode Island, 2010)</p>";
		$facts['South Carolina'] = "<p>26,654 annual cases of chlamydia (South Carolina, 2010)<br />3,289 cases of gonorrhea (South Carolina, 2010)<br />507 cases of P&S syphilis (South Carolina, 2010)<br />13,700 people living with HIV (South Carolina, 2008)</p>";
		$facts['South Dakota'] = "<p>Coming soon.</p>";
		$facts['Tennessee'] = "<p>29,711 annual cases of chlamydia (Tennessee, 2009)<br />3,560 cases of gonorrhea (Tennessee, 2009)<br />1,317 cases of P&S syphilis (Tennessee, 2009)<br />14,530 people living with HIV (Tennessee, 2008)</p>";
		$facts['Texas'] = "<p>105,910 annual cases of chlamydia (Texas, 2009)<br />29,295 cases of gonorrhea (Texas, 2009)<br />6,973 cases of P&S syphilis (Texas, 2009)<br />61,595 people living with HIV (Texas, 2008)</p>";
		$facts['Utah'] = "<p>6,145 annual cases of chlamydia (Utah, 2009)<br />271 cases of gonorrhea (Utah, 2009)<br />55 cases of P&S syphilis (Utah, 2009)<br />2,245 people living with HIV (Utah, 2008)</p>";
		$facts['Virginia'] = "<p>30,903 annual cases of chlamydia (Virginia, 2009)<br />7,789 cases of gonorrhea (Virginia, 2009)<br />755 cases of P&S syphilis (Virginia, 2009)<br />20,477 people living with HIV (Virginia, 2008)</p>";
		$facts['Vermont'] = "<p>1,186 annual cases of chlamydia (Vermont, 2009)<br />21 cases of gonorrhea (Vermont, 2009)<br />1 cases of P&S syphilis (Vermont, 2009)<br />260 people living with AIDS (Vermont, 2008)</p>";
		$facts['Washington'] = "<p>21,387 annual cases of chlamydia (Washington, 2008)<br />2,285 cases of gonorrhea (Washington, 2008)<br />322 cases of P&S syphilis (Washington, 2008)<br />At least 11,000 people are HIV-positive in Washington</p>";
		$facts['Wisconsin'] = "<p>20,904 annual cases of chlamydia (Wisconsin, 2009)<br />5,201 cases of gonorrhea (Wisconsin, 2009)<br />166 cases of P&S syphilis (Wisconsin, 2009)<br />4,814 people living with HIV (Wisconsin, 2008)</p>";
		$facts['West Virginia'] = "<p>3,604 annual cases of chlamydia (West Virginia, 2008)<br />475 cases of gonorrhea (West Virginia, 2008)<br />32 cases of P&S syphilis (West Virginia, 2008)<br />1,416 people living with HIV (West Virginia, 2008)</p>";
		$facts['Wyoming'] = "<p>1,963 annual cases of chlamydia (Wyoming, 2008)<br />74 cases of gonorrhea (Wyoming, 2008)<br />7 cases of P&S syphilis (Wyoming, 2008)<br />205 people living with HIV (Wyoming, 2008)</p>";
		
		$contentVariation1 = '
			<p>Place an order for your STD test in '. $state .' and test today. All labs operate on a walk-in basis, so appointments are never necessary. Our premium service allows you to test for STD in '. $state .' at your convenience, even on Saturdays at select locations.</p>
			<img src="http://c1470.r70.cf1.rackcdn.com/std-testing-states/'. str_replace(" ", "-", strtolower($state)) .'-std-testing.jpg" width="312" height="180" alt="'. $state .' STD Testing" border="0" style="margin: 8px 0 32px 0;" />
			<h3 style="clear: none;">STD statistics for '. $state .'</h3>
		'. $facts[$state] .'
			<h4 style="clear: none;">STD Treatment in '. $state .'</h4>
			<p>Treatment is available for the most common STDs.  If positive for chlamydia, gonorrhea or herpes, our on-staff physicians can phone in a prescription to the local pharmacy of your choice. We also offer a free phone consultation with our doctor.</p>
		';
		$contentVariation2 = '
			<p>Test for STDs in '. $state .' today and get on with life! No appointments are needed; all labs function on a walk-in basis. Simply place your order and test at your convenience. Many locations are even open on Saturday for quick, easy STD testing in '. $state .'.</p>
			<img src="http://c1470.r70.cf1.rackcdn.com/std-testing-states/'. str_replace(" ", "-", strtolower($state)) .'-std-testing.jpg" width="312" height="180" alt="'. $state .' STD Testing" border="0" style="margin: 8px 0 32px 0;" />
			<h3 style="clear: none;">STD Data in '. $state .'</h3>
		'. $facts[$state] .'
			<h4 style="clear: none;">Treating an STD Infection</h4>
			<p>If you test positive for an STD, we can help. Our in-house doctors can prescribe antibiotics for chlamydia and gonorrhea&ndash;two of the most common, curable STDs. Antiviral medication is also available to treat herpes.</p>
		';
		$contentVariation3 = '
			<p>Get a '. $state .' STD test today! Test for STDs in '. $state .' without an appointment; just place your order and visit the lab any time during operating hours. Several labs are even open on Saturdays for convenient STD testing in '. $state .'.</p>
			<img src="http://c1470.r70.cf1.rackcdn.com/std-testing-states/'. str_replace(" ", "-", strtolower($state)) .'-std-testing.jpg" width="312" height="180" alt="'. $state .' STD Testing" border="0" style="margin: 8px 0 32px 0;" />
			<h3 style="clear: none;">'. $state .' STD Rates</h3>
		'. $facts[$state] .'
			<h4 style="clear: none;">Post-STD Testing Treatment Options</h4>
			<p>Post-STD testing counseling and treatment options are available. Trained STD counselors can help interpret results, while a free phone consultation with our physician is included with every purchase. On-staff doctors can also prescribe prescriptions for chlamydia, gonorrhea and herpes.</p>
		';
		$contentVariation4 = '
			<p>Need STD testing in '. $state .'? Test today! No appointments are necessary; just place your order and walk in to the lab of your choice any time during operating hours. Many labs even have Saturday hours for convenient STD testing in '. $state .'.</p>
			<img src="http://c1470.r70.cf1.rackcdn.com/std-testing-states/'. str_replace(" ", "-", strtolower($state)) .'-std-testing.jpg" width="312" height="180" alt="'. $state .' STD Testing" border="0" style="margin: 8px 0 32px 0;" />
			<h3 style="clear: none;">Notable '. $state .' STD Statistics</h3>
		'. $facts[$state] .'
			<h4 style="clear: none;">'. $state .' STD Treatment</h4>
			<p>Our services don\'t stop at STD testing. Trained STD counselors are standing by to answer any questions. We also offer a free phone consultation with our staff doctors to discuss positive STD test results. Our doctors can also prescribe medication for chlamydia, gonorrhea and herpes.</p>
		';
	
		if ($stateID % 4 == 0) { 
			return $contentVariation4;
		} else {
			if ($stateID % 3 == 0) { 
				return $contentVariation3;
			} else {
				if ($stateID % 2 == 0) { 
					return $contentVariation2;
				} else {
					if ($stateID % 1 == 0) { 
						return $contentVariation1;
					}								
				}							
			}
		}

	} elseif (isset($stateID) && isset($state) && ($type == "how-it-works")) {
	
		$contentVariation1 = '<strong style="color: red;">State how it works paragraph variation 1</strong> --- ';
		$contentVariation2 = '<strong style="color: red;">State how it works paragraph variation 2</strong> --- ';
		$contentVariation3 = '<strong style="color: red;">State how it works paragraph variation 3</strong> --- ';
		$contentVariation4 = '<strong style="color: red;">State how it works paragraph variation 4</strong> --- ';
	
		if ($stateID % 4 == 0) { 
			return $contentVariation4;
		} else {
			if ($stateID % 3 == 0) { 
				return $contentVariation3;
			} else {
				if ($stateID % 2 == 0) { 
					return $contentVariation2;
				} else {
					if ($stateID % 1 == 0) { 
						return $contentVariation1;
					}								
				}							
			}
		}

	} elseif (isset($stateID) && isset($state) && ($type == "benefits")) {
	
		$contentVariation1 = '<strong style="color: red;">State benefits paragraph variation 1</strong> --- ';
		$contentVariation2 = '<strong style="color: red;">State benefits paragraph variation 2</strong> --- ';
		$contentVariation3 = '<strong style="color: red;">State benefits paragraph variation 3</strong> --- ';
		$contentVariation4 = '<strong style="color: red;">State benefits paragraph variation 4</strong> --- ';
	
		if ($stateID % 4 == 0) { 
			return $contentVariation4;
		} else {
			if ($stateID % 3 == 0) { 
				return $contentVariation3;
			} else {
				if ($stateID % 2 == 0) { 
					return $contentVariation2;
				} else {
					if ($stateID % 1 == 0) { 
						return $contentVariation1;
					}								
				}							
			}
		}
	}

}

function genCityContent($cityID, $city, $type) {

	if (isset($cityID) && isset($city) && ($type == "intro")) {
	
		$contentVariation1 = '
			<p>STD testing in '. $city .' has never been easier or faster. Order your test online, and test for STDs in '. $city .' as early as today; no appointments necessary.  '. $city .' STD testing provides answers and peace of mind quickly, without the embarrassment or hassle associated with a doctor\'s office or free STD clinic.</p>
			<h3 style="clear: none;">How STD testing in '. $city .' Works</h3>
			<p>The '. $city .' STD Testing process is quick and easy. Simply order your STD test online, and then test at the local lab of your choice. Tests are performed via blood or urine and the entire process takes about 15 to 20 minutes once you arrive at the lab. Results come back within 3 to 5 days and can be viewed online in our secure, password-protected portal.</p>
			<h4 style="clear: none;">STD Tests Available in '. $city .'</h4>
			<p>The following tests are available for STD testing in '. $city .': <em>chlamydia, gonorrhea, hepatitis B, hepatitis C, oral herpes, genital herpes, HIV and syphilis</em>.</p>
		';
		$contentVariation2 = '
			<p>STD testing in '. $city .' offers comprehensive, private STD testing without hassle or embarrassment. STD testing in '. $city .' is available as early as today without an appointment; just place your order online and walk in to the lab at your convenience. All testing takes place at FDA-approved labs and uses the most accurate tests on the market.</p>
			<h3 style="clear: none;">'. $city .' STD Testing Process</h3>
			<p>For STD testing in '. $city .', schedule your test online or over the phone. Then visit the local lab of your choice for testing. Testing at the lab takes 15 to 20 minutes and is performed through blood or urine samples (no painful swabbing!). Your results will be available 3 to 5 days after testing and are accessible through our online, password-protected portal.</p>
			<h4 style="clear: none;">Types of STD Tests Available</h4>
			<p>STD testing is available for eight of the most common STDs: <em>chlamydia, gonorrhea, hepatitis B, hepatitis C, oral herpes, genital herpes, HIV and syphilis</em>.</p>
		';
		$contentVariation3 = '
			<p>Test for STDs in '. $city .' without the embarrassment! Avoid the hassle of a doctor\'s office, and test without painful swabbing or an invasive physical exam. Simply order your STD test online and test at a private lab in '. $city .' any time during operating hours. Testing is performed with a simple urine or blood sample, so there\'s no need to undress.</p>
			<h3 style="clear: none;">'. $city .' STD Testing Details</h3>
			<p>To test for STDs in '. $city .', simply schedule your STD test online or over the phone. Then, visit the lab of your choice for STD testing in '. $city .'. Appointments are never required; all labs function on a walk-in basis. STD tests are performed via blood and/or urine, and the entire process is completed within 20 minutes. Results are ready 3 to 5 days after testing.</p>
			<h4 style="clear: none;">Eight Different STD Tests Options</h4>
			<p>STD testing in '. $city .' offers private testing for eight different STDs: <em>chlamydia, gonorrhea, oral herpes, genital herpes, HIV, syphilis, hepatitis B and hepatitis C</em>.</p>
		';
		$contentVariation4 = '
			<p>STD testing in '. $city .' provides a wide range of STD tests in a secure and private environment. Unlike testing at a doctor\'s office, your privacy is fully protected, and there are no invasive exams or questions about your sexual history. Our '. $city .' STD test service allows you to test quickly and privately so you can get tested and get on with your day!</p>
			<h3 style="clear: none;">How '. $city .' STD Testing Works</h3>
			<p>Get an STD test in '. $city .' in four simple steps: First, order '. $city .' STD testing online or over the phone. Second, test at the local '. $city .' STD test clinic of your choice. Third, view your results online within 3 to 5 days after testing. And lastly, talk to an STD counselor about your results and get treatment, if necessary.</p>
			<h4 style="clear: none;">Test for 8 of the Most Common STDs</h4>
			<p>Test as early as today for eight of the most common STDs: <em>chlamydia, gonorrhea, oral herpes, genital herpes, HIV, syphilis, hepatitis B and hepatitis C</em>.</p>
		';
	
		if ($cityID % 4 == 0) { 
			return $contentVariation4;
		} else {
			if ($cityID % 3 == 0) { 
				return $contentVariation3;
			} else {
				if ($cityID % 2 == 0) { 
					return $contentVariation2;
				} else {
					if ($cityID % 1 == 0) { 
						return $contentVariation1;
					}								
				}							
			}
		}

	} elseif (isset($cityID) && isset($city) && ($type == "benefits")) {
	
		$contentVariation1 = '
			<h5>Benefits of STD Testing in '. $city .'</h5>
			<p>STD and HIV testing is recommended for all sexually active adults once a year. Since these infections can be present even without symptoms, STD testing can provide answers. Our services are quick, private and offer the most accurate tests on the market.</p>
		';
		$contentVariation2 = '
			<h5>Reasons to Test for STDs</h5>
			<p>There are dozens of reasons to test for STDs in '. $city .'. Knowing your status enables you to make informed decisions about your health and sex life. Plus, many STDs are asymptomatic. A routine STD test allows you to diagnose and treat STDs before permanent damage occurs.</p>
		';
		$contentVariation3 = '
			<h5>Why STD Testing is Important</h5>
			<p>STD testing in '. $city .' is easy and painless. There really isn\'t a reason not to test. Sexually active adults should test for STDs annually, whether symptoms are present or not. Many STDs can be present without symptoms, but an STD test in '. $city .' can diagnose these infections early before irreversible damage occurs.</p>
		';
		$contentVariation4 = '
			<h5>Benefits of '. $city .' STD Testing</h5>
			<p>Getting an STD test in '. $city .' offers peace of mind. Knowing your status protects you and your partners and also allows you to make informed decisions about your health. Since all STDs can be present without symptoms, STD testing in '. $city .' can diagnose STDs early before damage occurs.</p>
		';
	
		if ($cityID % 4 == 0) { 
			return $contentVariation4;
		} else {
			if ($cityID % 3 == 0) { 
				return $contentVariation3;
			} else {
				if ($cityID % 2 == 0) { 
					return $contentVariation2;
				} else {
					if ($cityID % 1 == 0) { 
						return $contentVariation1;
					}								
				}							
			}
		}

	} elseif (isset($cityID) && isset($city) && ($type == "privacy")) {
	
		$contentVariation1 = '
			<h5>Your Privacy is Guaranteed</h5>
			<p>STD testing in '. $city .' is fully confidential, from start to finish. All STD testing in '. $city .' is performed at private labs that offer more than STD testing, so no one will know the nature of your visit. Billing is always discreet and your personal information is never shared with a third party or insurance. When STD testing in '. $city .', your privacy is guaranteed.</p>
		';
		$contentVariation2 = '
			<h5>Confidential STD Testing in '. $city .'</h5>
			<p>All labs are fully confidential and offer a wide array of services beyond STD testing, so no one will know why you are there. Credit cards are billed under a non-traceable pseudonym for discretion, and your information is never shared with another party. Results are securely housed in an online, password-protected portal for maximum privacy.</p>
		';
		$contentVariation3 = '
			<h5>Test for STDs in '. $city .' with Privacy</h5>
			<p>We value your privacy. With online set-up and discreet billing, your privacy is protected at all stages of the testing process. When STD testing in '. $city .', all labs fully confidential and offer a full range of diagnostic testing, so no one will know the purpose of your visit. Results are available online in a secure, password-protected portal.</p>
		';
		$contentVariation4 = '
			<h5>STD Testing in '. $city .' is Fully Confidential</h5>
			<p>We place extra emphasis on your privacy. STD testing in '. $city .' takes place at private labs that offer a wide range of diagnostic services, so no one will know you are getting an STD test. Your personal information is never shared, billing is always discreet, and results are house on our website in a secure, password-protected portal.</p>
		';
	
		if ($cityID % 4 == 0) { 
			return $contentVariation4;
		} else {
			if ($cityID % 3 == 0) { 
				return $contentVariation3;
			} else {
				if ($cityID % 2 == 0) { 
					return $contentVariation2;
				} else {
					if ($cityID % 1 == 0) { 
						return $contentVariation1;
					}								
				}							
			}
		}
	}

}

function stateExists($input){

    $input = str_replace("-", " ", $input);
    
    //reset found
    $found = 0;
    //list states
    $states = "Alaska,Alabama,Arkansas,Arizona,California,Colorado,Connecticut,District Of Columbia,Delaware,Florida,Georgia,Hawaii,Iowa,Idaho,Illinois,Indiana,Kansas,Kentucky,Louisiana,Massachusetts,Maryland,Maine,Michigan,Minnesota,Missouri,Mississippi,Montana,North Carolina,North Dakota,Nebraska,New Hampshire,New Jersey,New Mexico,Nevada,New York,Ohio,Oklahoma,Oregon,Pennsylvania,Rhode Island,South Carolina,South Dakota,Tennessee,Texas,Utah,Virginia,Vermont,Washington,Wisconsin,West Virginia,Wyoming";
    //list abbreviations
    $abb = "AK,AL,AR,AZ,CA,CO,CT,DC,DE,FL,GA,HI,IA,ID,IL,IN,KS,KY,LA,MA,MD,ME,MI,MN,MO,MS,MT,NC,ND,NE,NH,NJ,NM,NV,NY,OH,OK,OR,PA,RI,SC,SD,TN,TX,UT,VA,VT,WA,WI,WV,WY";
    //create arrays
    $states_array = explode(",", $states);
    $abb_array = explode(",", $abb);
    
    //run test
    for ($i = 0; $i < count($states_array); $i++){
        if (strtolower($input) == strtolower($states_array[$i])){
            $found = 1;
        }
    }
    for ($i = 0; $i < count($abb_array); $i++){
        if (strtolower($input) == strtolower($abb_array[$i])){
            $found = 1;
        }
    }
    if ($found == 1) {
        return true;
    }
}

function genStateURL($state) {

	global $urlForLinks, $urlVariation1, $urlVariation2, $urlVariation3, $urlVariation4;

	if (stateExists($state)) {
		$stateDashed = strtolower(str_replace(' ', '-', $state));

		if (stateID($state) % 4 == 0) { 
			return $urlForLinks.$stateDashed.$urlVariation4;
		} else {
			if (stateID($state) % 3 == 0) { 
				return $urlForLinks.$urlVariation3.$stateDashed;
			} else {
				if (stateID($state) % 2 == 0) { 
					return $urlForLinks.$stateDashed.$urlVariation2;
				} else {
					if (stateID($state) % 1 == 0) { 
						return $urlForLinks.$urlVariation1.$stateDashed;
					}								
				}							
			}
		}
	}
}

function stateID($input){
    $input = str_replace("-", " ", $input);
    
    //reset found
    $found = 0;
    //list states
    $states = "Alaska,Alabama,Arkansas,Arizona,California,Colorado,Connecticut,District Of Columbia,Delaware,Florida,Georgia,Hawaii,Iowa,Idaho,Illinois,Indiana,Kansas,Kentucky,Louisiana,Massachusetts,Maryland,Maine,Michigan,Minnesota,Missouri,Mississippi,Montana,North Carolina,North Dakota,Nebraska,New Hampshire,New Jersey,New Mexico,Nevada,New York,Ohio,Oklahoma,Oregon,Pennsylvania,Rhode Island,South Carolina,South Dakota,Tennessee,Texas,Utah,Virginia,Vermont,Washington,Wisconsin,West Virginia,Wyoming";
    //list abbreviations
    $abb = "AK,AL,AR,AZ,CA,CO,CT,DC,DE,FL,GA,HI,IA,ID,IL,IN,KS,KY,LA,MA,MD,ME,MI,MN,MO,MS,MT,NC,ND,NE,NH,NJ,NM,NV,NY,OH,OK,OR,PA,RI,SC,SD,TN,TX,UT,VA,VT,WA,WI,WV,WY";
    //create arrays
    $states_array = explode(",", $states);
    $abb_array = explode(",", $abb);
    
    //run test
    for ($i = 0; $i < count($states_array); $i++){
        if (strtolower($input) == strtolower($states_array[$i])){
            $found = 1;
			$id = $i;
        }
    }
    for ($i = 0; $i < count($abb_array); $i++){
        if (strtolower($input) == strtolower($abb_array[$i])){
            $found = 1;
			$id = $i;
        }
    }
    if ($found == 1) {
        return $id;
    }
}

function stateToAbb($input){
    $input = str_replace("-", " ", $input);
    
    //reset found
    $found = 0;
    //list states
    $states = "Alaska,Alabama,Arkansas,Arizona,California,Colorado,Connecticut,District Of Columbia,Delaware,Florida,Georgia,Hawaii,Iowa,Idaho,Illinois,Indiana,Kansas,Kentucky,Louisiana,Massachusetts,Maryland,Maine,Michigan,Minnesota,Missouri,Mississippi,Montana,North Carolina,North Dakota,Nebraska,New Hampshire,New Jersey,New Mexico,Nevada,New York,Ohio,Oklahoma,Oregon,Pennsylvania,Rhode Island,South Carolina,South Dakota,Tennessee,Texas,Utah,Virginia,Vermont,Washington,Wisconsin,West Virginia,Wyoming";
    //list abbreviations
    $abb = "AK,AL,AR,AZ,CA,CO,CT,DC,DE,FL,GA,HI,IA,ID,IL,IN,KS,KY,LA,MA,MD,ME,MI,MN,MO,MS,MT,NC,ND,NE,NH,NJ,NM,NV,NY,OH,OK,OR,PA,RI,SC,SD,TN,TX,UT,VA,VT,WA,WI,WV,WY";
    //create arrays
    $states_array = explode(",", $states);
    $abb_array = explode(",", $abb);
    
    //run test
    for ($i = 0; $i < count($states_array); $i++){
        if (strtolower($input) == strtolower($states_array[$i])){
            $found = 1;
            $output = $abb_array[$i];
            return $output;
        }
    }
    if ($found != 1){
        $output = $input;
        return $output;
    }
    return $output;
}

function stateToFull($input){
    $input = str_replace("-", " ", $input);
    
    //reset found
    $found = 0;
    //list states
    $states = "AK,AL,AR,AZ,CA,CO,CT,DC,DE,FL,GA,HI,IA,ID,IL,IN,KS,KY,LA,MA,MD,ME,MI,MN,MO,MS,MT,NC,ND,NE,NH,NJ,NM,NV,NY,OH,OK,OR,PA,RI,SC,SD,TN,TX,UT,VA,VT,WA,WI,WV,WY";
    //list abbreviations
    $abb = "Alaska,Alabama,Arkansas,Arizona,California,Colorado,Connecticut,District Of Columbia,Delaware,Florida,Georgia,Hawaii,Iowa,Idaho,Illinois,Indiana,Kansas,Kentucky,Louisiana,Massachusetts,Maryland,Maine,Michigan,Minnesota,Missouri,Mississippi,Montana,North Carolina,North Dakota,Nebraska,New Hampshire,New Jersey,New Mexico,Nevada,New York,Ohio,Oklahoma,Oregon,Pennsylvania,Rhode Island,South Carolina,South Dakota,Tennessee,Texas,Utah,Virginia,Vermont,Washington,Wisconsin,West Virginia,Wyoming";
    //create arrays
    $states_array = explode(",", $states);
    $abb_array = explode(",", $abb);
    
    //run test
    for ($i = 0; $i < count($states_array); $i++){
        if (strtolower($input) == strtolower($states_array[$i])){
            $found = 1;
            $output = $abb_array[$i];
            return $output;
        }
    }
    if ($found != 1){
        $output = $input;
        return $output;
    }
    return $output;
}

?>