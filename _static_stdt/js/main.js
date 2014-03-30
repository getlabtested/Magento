// JavaScript Document

function openBox(id) {
	document.getElementById(id).style.display = 'block';	
}

// frontpage banner rotator
	
function getElementsByClassName(className, tag, elm){
	var testClass = new RegExp("(^|\\\\s)" + className + "(\\\\s|$)");
	var tag = tag || "*";
	var elm = elm || document;
	var elements = (tag == "*" && elm.all)? elm.all : elm.getElementsByTagName(tag);
	var returnElements = [];
	var current;
	var length = elements.length;
	for(var i=0; i<length; i++){
		current = elements[i];
		if(testClass.test(current.className)){
			returnElements.push(current);
		}
	}
	return returnElements;
}

function fade(type, id) {
	var target = document.getElementById(id);
	if(/MSIE/.test(navigator.userAgent)){
		var opacity = target.style.filter;
		opacity = opacity.replace(/alpha\(opacity\=/, " ");
		opacity = parseInt(opacity);
		
	} else {
		var opacity = parseFloat(target.style.opacity) * 100;
		
	}
	
	if(!opacity) opacity = 0;
	
	if(type == 'in') {
		opacity += 5;
	} else {
		opacity -= 5;
	}
	
		
	if(opacity > 100) opacity = 100;
	if(opacity < 0) opacity = 0;
	
	if(/MSIE/.test(navigator.userAgent)){
		target.style.filter = "alpha(opacity=" + opacity + ")";			
		
	} else {
		target.style.opacity = opacity/100;
		
	}
	
}

var current_p = 1;
var total_p = 3;
var timeout_p;

function fade_trigger_p(id) {
	clearTimeout(timeout_p);
	
	var target = document.getElementById(id);
	if(/MSIE/.test(navigator.userAgent)){ 
		var opacity = target.style.filter;
		opacity = opacity.replace(/alpha\(opacity\=/, " ");
		opacity = parseInt(opacity);
		
	} else {
		var opacity = parseFloat(target.style.opacity) * 100;
		
	}
	
	if(isNaN(opacity)) opacity = 0;
	
	
	
	if(opacity == 100) { // next box
		
		if(current_p < total_p) {
			current_p++;
		} else {
			current_p = 1;
		}
		
		timeout_p = setTimeout("fade_trigger_p('banner_'+current_p)", 6000);
		
	} else { // continue animation
		var boxes = getElementsByClassName('banner_item', 'div', document.body);
		for(i=0; i<boxes.length; i++) {
			var box = boxes[i];
			if(box.getAttribute('id') == id) { // fade in
				fade('in', id);
				document.getElementById(id).style.zIndex = 10;
			} else { // fade out
				fade('out', box.getAttribute('id'));
				document.getElementById(box.getAttribute('id')).style.zIndex = 1;
			}
		}
		
		timeout_p  = setTimeout("fade_trigger_p('banner_'+current_p)", 40);
		
	}
	
}
			


function gotoPaczka(id) {
	current_p = id;
	fade_trigger_p('banner_'+current_p);
}

$(document).ready(function() {
	if(/MSIE/.test(navigator.userAgent)){
		document.getElementById('banner_1').style.filter = "alpha(opacity=100)";			
	} else {
		document.getElementById('banner_1').style.opacity = 1;
	}

	gotoPaczka(1);
});


function showUserDash(id) {
	$(".user_dash_menu").each(function(i) {
		$(this).removeClass('active');
	});
	$(".item_ud").each(function(i) {
		$(this).hide();
	});
	
	$("#"+id+"_head").addClass('active');
	$("#"+id+"_ud").show();	
}

function showPayOpt(id) {
	
	$(".pay_opt_head").each(function(i) {
		$(this).removeClass('active');
	});
	$(".pay_opt_content").each(function(i) {
		$(this).hide();
	});
	
	$("#"+id+"_head").addClass('active');
	$("#"+id+"_content").show();	
	
}

function removeFromCart(id) {
	$("#order_"+id).hide();
	updateCartPrice();
}	

function updateCartPrice() {
	
}