var $j = jQuery.noConflict();
jQuery().ready(function($j){

/*jQuery(document).ready(function ($){*/
			
var qno = 11; // enter the number of questions here for the progress bar
var wide = $j("div.progresso").parent().width();
var increment = parseInt(wide/qno);

var wizard = $j("#wizard").accordion({
	header: '.title',
	event: false
});
	
var wizardButtons = $j([]);
$j("div.title", wizard).each(function(index) {
	wizardButtons = wizardButtons.add($j(this)
	.next()
	.children("#navigator")
	.filter(".next, .previous")
	.click(function() {
	wizard.accordion("activate", index + ($j(this).is(".next") ? 1 : -1));
	if($j(this).is(".next"))
	{
	((($j(this).parent()).parent()).children(".title")).children(".uncheck").removeClass("uncheck").addClass("check");
	$j("div.progresso").animate({    
		width: '+='+increment
	}, 800, function() {
	// Animation complete.
	});	
}
if($j(this).is(".previous")){
	((($j(this).parent()).parent()).children(".title")).children(".check").removeClass("check").addClass("uncheck");
	$j("div.progresso").animate({    
		width: '-='+increment
	}, 800, function() {
	// Animation complete.
	});	
}
}));
});
	
// bind to change event of select to control first and seconds accordion
// similar to tab's plugin triggerTab(), without an extra method
var accordions = jQuery('#wizard');	
});
function showres(){
	$j("div.progresso").width($j("div.progresso").parent().width());
	$j("div.uncheck").removeClass("uncheck").addClass("check");
	alert("test finished!! do something with the response");
}
function checkmenow()
{
if(document.frmRecommandation.Zipcode.value == '')
{
alert('Zipcode cannot be left empty..');
}
}


 




