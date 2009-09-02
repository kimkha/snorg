
	/**
	 * KDialog Script
	 * 
	 * @author KimKha
	 */
	
	var $k;
	
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
	}
	
	function $kconfirm(msg, fn) {
		$k.dialog.title = "SNORG Confirm!";
		msg = "<form id='kInternalForm'><div class='kdialogMessage'>"+msg+"</div>";
		msg += "<div class='kdialogButton'><input name='ok' value='OK' type='submit' id='kButtonOK' size='15' /><input name='cancel' value='Cancel' type='button' id='kButtonCancel' size='15' /></div><form>";
		$k.dialog.content = msg;
		$k.dialog.show();
		
		$("#kInternalForm").submit(function(){
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
	title = '';
	content = '';
	isKbox = false;
	
	// attributes for window
	maxId = 0;
	maxIndex = 1;
	
	ref = this;
	var kdialog = $("#kdialog");
	var koverlay;
	kboxContent = '';
	
	/* Functions */
	show = function () {
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
	
	hide = function () {
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
	
	jQuery = function() {
		return kdialog.find("#kdialogContent");
	}
	
	clickOverlay = function () {
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
	
	createWindow = function(){
		maxId = maxId+1;
		kdialog.after("<div id='kwindow-"+maxId+"' class='kDlg'></div>");
		var kwindow = $("#kwindow-"+maxId);
		kwindow.css("z-index", maxIndex); maxIndex++;
		
		return $kwindow(maxId);
	};
	
	backupKbox = function () {
		kboxContent = kdialog.html();
		kdialog.html("");
	};
	resetKbox = function () {
		kdialog.html(kboxContent);
		kboxContent = '';
		$("#kdialogClose").click(function(){
			$k.dialog.hide();
		});
	};
	
	/* Constructor */
	constructor = function () {
		/* construct overlay */
		kdialog.before("<div id='koverlay'></div>");
		koverlay = $("#koverlay");
		koverlay.height(window.outerHeight);
		
		this.clickOverlay();
	}
	this.constructor();
	return this;
}

function $kwindow(i){
	/* Attributes */
	id = i;
	
	var kwindow;
	
	/* Functions */
	
	/* Constructor */
	constructor = function(){
		kwindow = $("#kwindow-"+id);
		kwindow.css();
	};
	this.constructor();
	return this;
}

function $ktabs() {
	
	/* Attributes */
	tabList = new Array();
	
	var kpanel = null;
	var ktab = null;
	var maxId = 0;
	
	/* Functions */
	open = function(tabpanel){
		tab = findTab(tabpanel.attr('href'));
		if (tab == null) return;
		
		if (tab.content == '') {
			ktab.html($kloading());
			$.get(tab.url, function(data){
				if (typeof(data) != "undefined") {
					tab.content = data;
					ktab.html(tab.content);
					kpanel.find(".tabPanel_active").removeClass("tabPanel_active");
					tabpanel.addClass("tabPanel_active");
				}
			});
		}
		else {
			ktab.html(tab.content);
			kpanel.find(".tabPanel_active").removeClass("tabPanel_active");
			tabpanel.addClass("tabPanel_active");
		}
	};
	
	buildTabs = function(tab){
		tabList[maxId++] = {
			name : tab.html(),
			url : tab.attr('href'),
			content : ''
		};
		tab.click(function(){
			$k.tabs.open($(this));
			return false;
		});
	};
	
	findTab = function(h){
		for (index in tabList) {
			if (tabList[index].url == h) {
				return tabList[index];
			}
		}
		return null;
	}
	
	/* Constructor */
	constructor = function(){
		kpanel = $("#ktabs_panel");
		kpanel.find("a").each(function(){
			buildTabs($(this));
		});
		ktab = $("#ktabs_content");
		open($("#ktabs_panel a:first"));
	};
	this.constructor();
	return this;
}

function $kk() {
	dialog = $kdialog();
	tabs = $ktabs();
	return this;
}

function $kloading() {
	return "<div class=\"ajax_loader\" align=\"center\"></div>";
}

function kdemo(msg) {
	$kalert("kimkha "+msg);
}

$(document).ready(function(){
	$k = $kk();
//	$kprompt("KimKha", 'abc', kdemo);
});