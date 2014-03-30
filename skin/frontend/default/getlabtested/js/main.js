// JavaScript Document

var $j = jQuery.noConflict(); 


function showPayOpt(id) {
	
	$j(".pay_opt_head").each(function(i) {
		$j(this).removeClass('active');
	});
	$j(".pay_opt_content").each(function(i) {
		$j(this).hide();
	});
	
	$j("#"+id+"_head").addClass('active');
	$j("#"+id+"_content").show();	
	
}

function removeFromCart(id) {
	$j("#order_"+id).hide();
	updateCartPrice();
}	

function updateCartPrice() {
	
}

function showUserDash(id) {
	$j(".user_dash_menu").each(function(i) {
		$j(this).removeClass('active');
	});
	$j(".item_ud").each(function(i) {
		$j(this).hide();
	});
	
	$j("#"+id+"_head").addClass('active');
	$j("#"+id+"_ud").show();	
}

/* google search url parser */

function gup( name )
{
	name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
	var regexS = "[\\?&]"+name+"=([^&#]*)";
	var regex = new RegExp( regexS );
	var results = regex.exec( window.location.href );
	if( results == null )
		return "";
	else
		return results[1];
}

/* PAP */

/*
$j(document).ready(function() {
	if($j("#affiliate").length > 0) {
		var phone = $j("#affiliate").innerHTML;
		if(phone) {
	
			$j("#header_phone").innerHTML = phone;
			$j("#question_side_widget .content p .orange").innerHTML = phone;
			$j("#question_form_side_widget .content p.large .orange").innerHTML = phone;
		}
	}
});
*/

/* PAP */



/* Image preview script */
/* Added by Piotr Bieszk on 12/29/2011 */

jQuery.noConflict();

this.imagePreview = function(){	

	/* CONFIG */
	xOffset = 10;
	yOffset = 30;

	jQuery("a.preview").hover(function(e){
	this.t = this.title;
	this.title = "";	
	var c = (this.t != "") ? "<br />" + this.t : "";
	jQuery("body").append("<p id='preview'><img src='"+ this.href +"' alt='Image preview' />"+ c +"</p>");								 
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

/* EOF: Added by Piotr Bieszk on 12/29/2011 */


/* PAP */

