	/**
	 * Add translation tool
	 * @author KimKha
	 * @package snorg
	 */
/* CUSTOM by SNORG */
if(jQuery) (function(){
	
	$.extend($.fn, {
		
		rightClick: function(handler) {
			$(this).each( function() {
				$(this).mousedown( function(e) {
					var evt = e;
					$(this).mouseup( function() {
						$(this).unbind('mouseup');
						if( evt.button == 2 ) {
							handler.call( $(this), evt );
							return false;
						} else {
							return true;
						}
					});
				});
				$(this)[0].oncontextmenu = function() {
					return false;
				}
			});
			return $(this);
		}
	});
	
})(jQuery);	
/* End CUSTOM by SNORG */

$(document).ready(function () {

	// COLLAPSABLE WIDGETS (on Dashboard & Profile pages)
	// toggle widget box contents
	$('a.toggle_box_contents').bind('click', toggleContent);
	
	// toggle widget box edit panel
	$('a.toggle_box_edit_panel').click(function () {
		$(this.parentNode.parentNode).children("[class=collapsable_box_editpanel]").slideToggle("fast");
		return false;
	});
	
	// toggle customise edit panel
	$('a.toggle_customise_edit_panel').click(function () {
		$('div#customise_editpanel').slideToggle("fast");
		return false;
	}); 
	
	// toggle plugin's settings nad more info on admin tools admin
	$('a.pluginsettings_link').click(function () {
		$(this.parentNode.parentNode).children("[class=pluginsettings]").slideToggle("fast");
		return false;
	});
	$('a.manifest_details').click(function () {
		$(this.parentNode.parentNode).children("[class=manifest_file]").slideToggle("fast");
		return false;
	});
	// reusable generic hidden panel
	$('a.collapsibleboxlink').click(function () {
		$(this.parentNode.parentNode).children("[class=collapsible_box]").slideToggle("fast");
		return false;
	});
	
	// WIDGET GALLERY EDIT PANEL
	// Sortable widgets
	var els = ['#leftcolumn_widgets', '#middlecolumn_widgets', '#rightcolumn_widgets', '#widget_picker_gallery' ];
	var $els = $(els.toString());
	
	$els.sortable({
		items: '.draggable_widget',
		handle: '.drag_handle',
		cursor: 'move',
		revert: true,
		opacity: 1.0,
		appendTo: 'body',
		placeholder: 'placeholder',
		connectWith: els,
		start:function(e,ui) {
	
		},
		stop: function(e,ui) {	
			// refresh list before updating hidden fields with new widget order		
			$(this).sortable( "refresh" );
			
			var widgetNamesLeft = outputWidgetList('#leftcolumn_widgets');
			var widgetNamesMiddle = outputWidgetList('#middlecolumn_widgets');
			var widgetNamesRight = outputWidgetList('#rightcolumn_widgets');
			
			document.getElementById('debugField1').value = widgetNamesLeft;
			document.getElementById('debugField2').value = widgetNamesMiddle;
			document.getElementById('debugField3').value = widgetNamesRight;
		}
	});
	
	// bind more info buttons - called when new widgets are created
	widget_moreinfo();
	
	// set-up hover class for dragged widgets
	$("#rightcolumn_widgets").droppable({
		accept: ".draggable_widget",
		hoverClass: 'droppable-hover'
	});
	$("#middlecolumn_widgets").droppable({
		accept: ".draggable_widget",
		hoverClass: 'droppable-hover'
	});
	$("#leftcolumn_widgets").droppable({
		accept: ".draggable_widget",
		hoverClass: 'droppable-hover'
	});
	
	/* CUSTOM by SNORG */
	checkTranslator();
/*	$("span.p_t").rightClick(function (e) {
		a = $(this).html();
		r = a;
		do {
			r=prompt("Dịch đoạn văn bản:\n\n"+a, r);
			if (!r || r=='' || r==a) return false;
		} while (!confirm(a+"\n\n Tương ứng với \n\n"+r));
		
		$.ajax({
			type: 'POST',
			url: 'http://localhost/elgg/trans.php',
			data: 'key='+ $(this).attr('title') +'&message='+r,
			dataType: 'json',
			success: function (progress) {
				return true;
			},
			error: function (xmlhttp) {
				return false;
			}
		});
		$("span.p_t[title='"+$(this).attr('title')+"']").html(r);
		$("span.p_t[title='"+$(this).attr('title')+"']").addClass('f_t');
		$("span.p_t[title='"+$(this).attr('title')+"']").removeClass('p_t');
		return false;
	});*/
	/* End CUSTOM by SNORG */
}); /* end document ready function */

/* CUSTOM by SNORG */
var trans_default;
var trans_input;
var trans_key;
var alreadyCheckTranslator = false;
function checkTranslator() {
	var admin = '<?php if (isadminloggedin()) echo '1'; else echo '0'; ?>';
	if (admin == '' || parseInt(admin) <= 0) {
		return;
	}
	$("span.p_t").rightClick(function(e){
		$(this).bind("contextmenu", function() { return false; });
		enableTranslator($(this), e);
		return false;
	});
	if (!alreadyCheckTranslator) {
		alreadyCheckTranslator = true;
		setTimeout("checkTranslator()", 5000);
	}
}
function enableTranslator(ptr, evt){
	trans_default = ptr.html();
	trans_key = ptr.attr('title');
	trans_input = trans_default;
	$kprompt("Dịch đoạn văn bản:<br /><br /><div style=\"color:#1E57AC;padding:5px;border:1px dashed #1E57AC;\">"+trans_default+"</div>", trans_input, translate_step1);
}
function translate_step1(d){
	trans_input = d;
	if (!trans_input || trans_input=='' || trans_input == trans_default) {
		return false;
	}
	else {
		$kconfirm("<div style=\"color:#1E57AC;padding:5px;border:1px dashed #1E57AC;\">" +trans_default+ "</div><br /><center><b>Tương ứng với</b></center><br /><div style=\"color:#962323;padding:5px;border:1px dashed #962323;\">"+trans_input+"</div>", translate_step2);
	}
}
function translate_step2(c){
	if(!c) {
		$kprompt("Dịch đoạn văn bản:<br /><br /><div style=\"color:#1E57AC;padding:5px;border:1px dashed #1E57AC;\">"+trans_default+"</div>", trans_input, translate_step1);
	}
	else {
		$.post("<?php echo $CONFIG->wwwroot; ?>/trans.php", {key:trans_key, message:trans_input}, translate_step3);
	}
}
function translate_step3(d){
	$("span.p_t[title='"+trans_key+"']").html(trans_input);
	$("span.p_t[title='"+trans_key+"']").addClass('f_t');
	$("span.p_t[title='"+trans_key+"']").removeClass('p_t');
}
/* End CUSTOM by SNORG */

// List active widgets for each page column
function outputWidgetList(forElement) {
	return( $("input[@name='handler'], input[@name='guid']", forElement ).makeDelimitedList("value") );	
}

// Make delimited list
jQuery.fn.makeDelimitedList = function(elementAttribute) {

	var delimitedListArray = new Array();
	var listDelimiter = "::";
	
	// Loop over each element in the stack and add the elementAttribute to the array
	this.each(function(e) {
			var listElement = $(this);
			// Add the attribute value to our values array
			delimitedListArray[delimitedListArray.length] = listElement.attr(elementAttribute);
		}
	);
	
	// Return value list by joining the array
	return(delimitedListArray.join(listDelimiter));
}


// Read each widgets collapsed/expanded state from cookie and apply
function widget_state(forWidget) {

	var thisWidgetState = $.cookie(forWidget);

	if (thisWidgetState == 'collapsed') {
		forWidget = "#" + forWidget;
		$(forWidget).find("div.collapsable_box_content").hide();
		$(forWidget).find("a.toggle_box_contents").html('+');
		$(forWidget).find("a.toggle_box_edit_panel").fadeOut('medium');
	};	
}


// Toggle widgets contents and save to a cookie
var toggleContent = function(e) {
var targetContent = $('div.collapsable_box_content', this.parentNode.parentNode);
	if (targetContent.css('display') == 'none') {
		targetContent.slideDown(400);
		$(this).html('-');
		$(this.parentNode).children("[class=toggle_box_edit_panel]").fadeIn('medium');
		
		// set cookie for widget panel open-state
		var thisWidgetName = $(this.parentNode.parentNode.parentNode).attr('id');
		$.cookie(thisWidgetName, 'expanded', { expires: 365 });
		
	} else {
		targetContent.slideUp(400);
		$(this).html('+');
		$(this.parentNode).children("[class=toggle_box_edit_panel]").fadeOut('medium');
		// make sure edit pane is closed
		$(this.parentNode.parentNode).children("[class=collapsable_box_editpanel]").hide();
		
		// set cookie for widget panel closed-state
		var thisWidgetName = $(this.parentNode.parentNode.parentNode).attr('id');
		$.cookie(thisWidgetName, 'collapsed', { expires: 365 });			
	}
	return false;
};

// More info tooltip in widget gallery edit panel
function widget_moreinfo() {

	$("img.more_info").hover(function(e) {										  
	var widgetdescription = $("input[@name='description']", this.parentNode.parentNode.parentNode ).attr('value');
	$("body").append("<p id='widget_moreinfo'><b>"+ widgetdescription +" </b></p>");
	
		if (e.pageX < 900) {
			$("#widget_moreinfo")
				.css("top",(e.pageY + 10) + "px")
				.css("left",(e.pageX + 10) + "px")
				.fadeIn("medium");	
		}	
		else {
			$("#widget_moreinfo")
				.css("top",(e.pageY + 10) + "px")
				.css("left",(e.pageX - 210) + "px")
				.fadeIn("medium");		
		}			
	},
	function() {
		$("#widget_moreinfo").remove();
	});	
	
	$("img.more_info").mousemove(function(e) {
		// action on mousemove
	});	
};

// COOKIES
jQuery.cookie = function(name, value, options) {
	if (typeof value != 'undefined') { // name and value given, set cookie
    options = options || {};
	    if (value === null) {
	        value = '';
	        options.expires = -1;
	    }
    var expires = '';
    if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
        var date;
        if (typeof options.expires == 'number') {
            date = new Date();
            date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
        } else {
            date = options.expires;
        }
        expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE
    }
    // CAUTION: Needed to parenthesize options.path and options.domain
    // in the following expressions, otherwise they evaluate to undefined
    // in the packed version for some reason.
    var path = options.path ? '; path=' + (options.path) : '';
    var domain = options.domain ? '; domain=' + (options.domain) : '';
    var secure = options.secure ? '; secure' : '';
    document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
    
	} else { // only name given, get cookie
	    var cookieValue = null;
	    if (document.cookie && document.cookie != '') {
	        var cookies = document.cookie.split(';');
	        for (var i = 0; i < cookies.length; i++) {
	            var cookie = $.trim(cookies[i]);
	            // Does this cookie string begin with the name we want?
	            if (cookie.substring(0, name.length + 1) == (name + '=')) {
	                cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
	                break;
	            }
	        }
	    }
	    return cookieValue;
	}
};

// ELGG TOOLBAR MENU
$.fn.elgg_topbardropdownmenu = function(options) {
    
  options = $.extend({speed: 350}, options || {});
  
  this.each(function() {
    
    var root = this, zIndex = 5000;
    
    function getSubnav(ele) {
      if (ele.nodeName.toLowerCase() == 'li') {
        var subnav = $('> ul', ele);
        return subnav.length ? subnav[0] : null;
      } else {
	      
        return ele;
      }
    }
    
    function getActuator(ele) {
      if (ele.nodeName.toLowerCase() == 'ul') {
        return $(ele).parents('li')[0];
      } else {
        return ele;
      }
    }
    
    function hide() {
      var subnav = getSubnav(this);
      if (!subnav) return;
      $.data(subnav, 'cancelHide', false);
      setTimeout(function() {
        if (!$.data(subnav, 'cancelHide')) {
          $(subnav).slideUp(100);
        }
      }, 250);
    }
  
    function show() {
      var subnav = getSubnav(this);
      if (!subnav) return;
      $.data(subnav, 'cancelHide', true);
      $(subnav).css({zIndex: zIndex++}).slideDown(options.speed);
      if (this.nodeName.toLowerCase() == 'ul') {
        var li = getActuator(this);
        $(li).addClass('hover');
        $('> a', li).addClass('hover');
      }
    }
    
    $('ul, li', this).hover(show, hide);
    $('li', this).hover(
      function() { $(this).addClass('hover'); $('> a', this).addClass('hover'); },
      function() { $(this).removeClass('hover'); $('> a', this).removeClass('hover'); }
    );
    
  });
  
};


	/* Cookie Functions */
	function createCookie(name, value, days) {
		if (days) {
			var date = new Date();
			date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
			var expires = "Expires=" + date.toGMTString() + "; ";
		} else {
			var expires = "";
		}
		
		document.cookie = name + "=" + value + "; " + expires + "Path=/;";
	}

	function readCookie(name) {
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');

		for(var i = 0; i < ca.length; i++) {
			var c = ca[i];

			while (c.charAt(0) == ' '){
				c = c.substring(1, c.length);
			}
			
			if (c.indexOf(nameEQ) == 0){
				return c.substring(nameEQ.length, c.length);
			}
		}
		return null;
	}

	function eraseCookie(name) {
		createCookie(name, "", -1);
	}	



