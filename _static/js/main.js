// JavaScript Document

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