/*======================================================================*\
|| #################################################################### ||
|| # vBulletin 3.8.7 Patch Level 2
|| # ---------------------------------------------------------------- # ||
|| # Copyright �2000-2011 vBulletin Solutions, Inc. All Rights Reserved. ||
|| # This file may not be redistributed in whole or significant part. # ||
|| # ---------------- VBULLETIN IS NOT FREE SOFTWARE ---------------- # ||
|| # http://www.vbulletin.com | http://www.vbulletin.com/license.html # ||
|| #################################################################### ||
\*======================================================================*/
function vB_AJAX_NameSuggest(C,A,D){var B=userAgent.match(/applewebkit\/([0-9]+)/);if(AJAX_Compatible&&!(is_saf&&!(B[1]>=412))){this.menuobj=fetch_object(D+"_menu");this.textobj=fetch_object(A);this.textobj.setAttribute("autocomplete","off");this.textobj.onfocus=function(E){this.obj.active=true};this.textobj.onblur=function(E){this.obj.active=false};this.textobj.obj=this;this.varname=C;this.menukey=D;this.fragment="";this.donenames="";this.selected=0;this.menuopen=false;this.timeout=null;this.names=new Array();this.active=false;this.ajax_req=null;this.allow_multiple=false;this.min_chars=3;this.get_text=function(){if(this.allow_multiple){var E=this.textobj.value.lastIndexOf(";");if(E==-1){this.donenames=new String("");this.fragment=new String(this.textobj.value)}else{this.donenames=new String(this.textobj.value.substring(0,E+1));this.fragment=new String(this.textobj.value.substring(E+1))}}else{this.fragment=new String(this.textobj.value)}this.fragment=PHP.trim(this.fragment)};this.set_text=function(E){if(this.allow_multiple){this.textobj.value=PHP.ltrim(this.donenames+" "+PHP.unhtmlspecialchars(this.names[E])+" ; ")}else{this.textobj.value=PHP.unhtmlspecialchars(this.names[E])}this.textobj.focus();this.menu_hide();return false};this.move_row_selection=function(E){var F=parseInt(this.selected,10)+parseInt(E,10);if(F<0){F=this.names.length-1}else{if(F>=this.names.length){F=0}}this.set_row_selection(F);return false};this.set_row_selection=function(E){var F=fetch_tags(this.menuobj,"td");F[this.selected].className="vbmenu_option";this.selected=E;F[this.selected].className="vbmenu_hilite"};this.key_event_handler=function(E){E=E?E:window.event;if(this.menuopen){switch(E.keyCode){case 38:this.move_row_selection(-1);return false;case 40:this.move_row_selection(1);return false;case 27:this.menu_hide();return false;case 13:this.set_text(this.selected);return false}}this.get_text();if(this.fragment.length>=this.min_chars){clearTimeout(this.timeout);this.timeout=setTimeout(this.varname+".name_search();",500)}else{this.menu_hide()}};this.name_search=function(){if(this.active){this.names=new Array();if(YAHOO.util.Connect.isCallInProgress(this.ajax_req)){YAHOO.util.Connect.abort(this.ajax_req)}this.ajax_req=YAHOO.util.Connect.asyncRequest("POST","ajax.php?do=usersearch",{success:this.handle_ajax_request,failure:vBulletin_AJAX_Error_Handler,timeout:vB_Default_Timeout,scope:this},SESSIONURL+"securitytoken="+SECURITYTOKEN+"&do=usersearch&fragment="+PHP.urlencode(this.fragment))}};this.handle_ajax_request=function(F){if(F.responseXML){var G=F.responseXML.getElementsByTagName("user");for(var E=0;E<G.length;E++){this.names[E]=G[E].firstChild.nodeValue}if(this.names.length>0){this.menu_build();this.menu_show()}else{this.menu_hide()}}};this.menu_build=function(){this.menu_empty();var F=new RegExp("^("+PHP.preg_quote(this.fragment)+")","i");var G=document.createElement("table");G.cellPadding=4;G.cellSpacing=1;G.border=0;for(var E in this.names){if(YAHOO.lang.hasOwnProperty(this.names,E)){var H=G.insertRow(-1).insertCell(-1);H.className=(E==this.selected?"vbmenu_hilite":"vbmenu_option");H.title="nohilite";H.innerHTML='<a onclick="return '+this.varname+".set_text("+E+')">'+this.names[E].replace(F,"<strong>$1</strong>")+"</a>"}}this.menuobj.appendChild(G);if(this.vbmenu==null){if(typeof (vBmenu.menus[this.menukey])!="undefined"){this.vbmenu=vBmenu.menus[this.menukey]}else{this.vbmenu=vBmenu.register(this.menukey,true)}}else{this.vbmenu.init_menu_contents()}};this.menu_empty=function(){this.selected=0;while(this.menuobj.firstChild){this.menuobj.removeChild(this.menuobj.firstChild)}};this.menu_show=function(){if(this.active){this.vbmenu.show(fetch_object(this.menukey),this.menuopen);this.menuopen=true}};this.menu_hide=function(){try{this.vbmenu.hide()}catch(E){}this.menuopen=false};this.textobj.onkeyup=function(E){return this.obj.key_event_handler(E)};this.textobj.onkeypress=function(E){E=E?E:window.event;if(E.keyCode==13){return(this.obj.menuopen?false:true)}}}};