
	/**
	 * KDialog Script
	 * 
	 * Function:
	 *         -  $ksimpleForm(thisForm, id)
	 *         -  $kalert(msg)
	 *         -  $kconfirm(msg, fn)
	 *         -  $kprompt(msg, val, fn)
	 *         -  $kbox(t, c)
	 *         -  $kloading()
	 * 
	 * @author KimKha
	 */
	
	$k = null;
	var max_ksimpleForm_id = 0;
	
	function $ksimpleForm(thisForm, id) {
		myForm = $(thisForm);
		url = myForm.attr('action');
		$.post(url, myForm.serializeArray(), function(data){
			$('#'+id).append(data);
			myForm.find("textarea").val("");
			myForm.find("textarea").blur();
			
			myForm.find("input[type='text']").val("");
			myForm.find("input[type='text']").blur();
			
			myForm.find("input[type='submit']").blur();
		});
		return false;
	}
	
	function $kconfirmlink(link, msg, fn, id) {
		url = $(link).attr("href");
		$kconfirm(msg, function(re){
			if(re){
				if (typeof(fn) != "undefined" && fn != 'none') {
					$.get(url, function(data){
						eval(fn+"('"+id+"');");
					});
				}
				else {
					window.location.href = link;
				}
			}
		});
		return false;
	}
	
	function $kalert(msg) {
		$k.dialog.title = "SNORG Warning!";
		msg = "<form id='kInternalForm'><div class='kdialogMessage'>"+msg+"</div>";
		msg += "<div class='kdialogButton'><input name='ok' value='OK' type='submit' id='kButtonOK' size='15' /></div></form>";
		$k.dialog.content = msg;
		$k.dialog.show();
		
		$("#kInternalForm").submit(function(){
			$k.dialog.hide();
			return false;
		});
		$("#kButtonOK").focus();
	}
	
	function $kconfirm(msg, fn) {
		$k.dialog.title = "SNORG Confirm!";
		msg = "<form id='kInternalForm' onsubmit='return false;'><div class='kdialogMessage'>"+msg+"</div>";
		msg += "<div class='kdialogButton'><input name='ok' value='OK' type='submit' id='kButtonOK' size='15' /><input name='cancel' value='Cancel' type='button' id='kButtonCancel' size='15' /></div><form>";
		$k.dialog.content = msg;
		$k.dialog.show();
		
		$("#kButtonOK").click(function(){
			$k.dialog.hide();
			fn.call($(this), true);
			return false;
		});
		$("#kButtonCancel").click(function(){
			$k.dialog.hide();
			fn.call($(this), false);
			return false;
		});
		$("#kdialogClose").click(function(){
			fn.call($(this), false);
			return false;
		});
		$("#kButtonOK").focus();
	}
	
	function $kprompt(msg, val, fn) {
		if (typeof(fn) == 'undefined') {
			fn = val;
			val = '';
		}
		$k.dialog.title = "SNORG Prompt!";
		msg = "<form id='kInternalForm'><div class='kdialogMessage'>"+msg+"<br /><input type='text' name='prompt' id='kButtonInput' value='"+val+"' size='47' /></div>";
		msg += "<div class='kdialogButton'><input name='ok' value='OK' type='submit' id='kButtonOK' /><input name='cancel' value='Cancel' type='button' id='kButtonCancel' /></div></form>";
		$k.dialog.content = msg;
		$k.dialog.show();
		
		$("#kInternalForm").submit(function(){
			$k.dialog.hide();
			fn.call($(this),$(this).find("#kButtonInput").val());
			return false;
		});
		$("#kButtonCancel").click(function(){
			$k.dialog.hide();
		});
		$("#kButtonOK").focus();
	}
	
	function $kbox(t, c) {
		var kbox = $k;
		$k.dialog.title = t;
		$k.dialog.content = c;
		$k.dialog.show();
		$k.dialog.isKbox = true;
		return $k.dialog.jQuery();
	}
	

function $kdialog() {
	
	/* Attributes */
	this.title = '';
	this.content = '';
	this.isKbox = false;
	
	this.ref = this;
	var kdialog = $("#kdialog");
	var koverlay;
	this.kboxContent = '';
	
	/* Functions */
	this.show = function () {
		if(this.isKbox) {
			this.backupKbox();
		}
		
		kdialog.append("<div class='kdialogTitle'>"+this.title+"<div class='kdialogPanel'><div id='kdialogClose'>&nbsp;</div></div></div>");
		kdialog.append("<div class='kdialogContent'>"+this.content+"</div>");
		
		kdialog.css('display', 'block');
		koverlay.css('display', 'block');
		
		$("#kdialogClose").click(function(){
			$k.dialog.hide();
		});
		this.clickOverlay();
	}
	
	this.hide = function () {
		if (this.kboxContent == '') this.isKbox = false;
		else {
			this.resetKbox();
			return false;
		}
		koverlay.css('display', 'none');
		kdialog.css('display', 'none');
		kdialog.html("");
		koverlay.html("");
		title = '';content = '';
	}
	
	this.jQuery = function() {
		return kdialog.find("#kdialogContent");
	}
	
	this.clickOverlay = function () {
		// shake dialog
		koverlay.unbind('click');
		koverlay.click(function(){
			kdialog.animate( { left:"390px" }, { queue:false, duration:60 } ) 
				.animate( { left:"430px" }, 50 ) 
				.animate( { left:"385px" }, 40 )
				.animate( { left:"415px" }, 40 ) 
				.animate( { left:"385px" }, 40 )
				.animate( { left:"415px" }, 40 ) 
				.animate( { left:"385px" }, 40 )
				.animate( { left:"415px" }, 40 ) 
				.animate( { left:"395px" }, 20 )
				.animate( { left:"405px" }, 20 ) 
				.animate( { left:"400px" }, 100 );
			
		});
	};
	
	this.createWindow = function(){
		maxId = maxId+1;
		kdialog.after("<div id='kwindow-"+maxId+"' class='kDlg'></div>");
		var kwindow = $("#kwindow-"+maxId);
		kwindow.css("z-index", maxIndex); maxIndex++;
		
		return $kwindow(maxId);
	};
	
	this.backupKbox = function () {
		kboxContent = kdialog.html();
		kdialog.html("");
	};
	this.resetKbox = function () {
		kdialog.html(kboxContent);
		kboxContent = '';
		$("#kdialogClose").click(function(){
			$k.dialog.hide();
		});
	};
	
	/* Constructor */
	this.constructor = function () {
		/* construct overlay */
		kdialog.before("<div id='koverlay'></div>");
		koverlay = $("#koverlay");
		
		koverlay.height($(window).height());
		koverlay.width($(window).width());
		koverlay.height(window.outerHeight);
		koverlay.width(window.outerWidth);
		
		this.clickOverlay();
	};
}

function $ktabs() {
	
	/* Attributes */
	this.tabList = new Array();
	this.curr = -1;
	this.isLoad = false;
	
	var kpanel = null;
	var ktab = null;
	var maxId = 0;
	
	/* Functions */
	this.open = function(tabpanel){
		tab = $k.tabs.findTab(tabpanel.attr('href'));
		if (tab == null) return;
		
		ktab.find("div.contentOfTabs").css("display", "none");
		tab.content.css("display","block");
		kpanel.find(".tabPanel_active").removeClass("tabPanel_active");
		tabpanel.addClass("tabPanel_active");
		
		if (!tab.exist) {
			$k.tabs.isLoad = true;
			$.get(tab.url, function(data){
				if (typeof(data) != "undefined") {
					tab.content.html(data);
					tab.exist = true;
				}
				$k.tabs.isLoad = false;
			});
		}
	};
	
	this.findTab = function(h){
		tl = $k.tabs.tabList
		for (index in tl) {
			if (tl[index].url == h) {
				return tl[index];
			}
		}
		return null;
	}
	
	this.buildTabs = function(tab){
		ktab.append("<div class='contentOfTabs' id='tab-content-"+maxId+"'>"+$kloading()+"</div>");
		t = ktab.find("#tab-content-"+maxId);
		t.css("display", "none");
		
		$k.tabs.tabList[maxId++] = {
			name : tab.html(),
			url : tab.attr('href'),
			content : t,
			exist : false
		};
		
		tab.click(function(){
			if ($k.tabs.isLoad) return false;
			
			$k.tabs.open($(this));
			return false;
		});
	};
	
	/* Constructor */
	this.constructor = function(){
		kpanel = $("#ktabs_panel");
		ktab = $("#ktabs_content");
		kpanel.find("a").each(function(){
			$k.tabs.buildTabs($(this));
		});
		$k.tabs.open($("#ktabs_panel a:first"));
	};
}

function $kk() {
	this.dialog = new $kdialog();
	this.tabs = new $ktabs();
	this.constructor = function(){
		this.dialog.constructor();
		this.tabs.constructor();
	};
}

function $kloading() {
	return "<div class=\"ajax_loader\" align=\"center\"></div>";
}

$(document).ready(function(){
	$k = new $kk();
	$k.constructor();
});