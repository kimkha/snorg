
	/**
	 * KDialog Script
	 * 
	 * @author KimKha
	 */
	
	var $k;
	
	function $kalert(msg) {
		var kbox = $k;
		$k.title = "SNORG Warning!";
		msg = "<form id='kInternalForm'><div class='kdialogMessage'>"+msg+"</div>";
		msg += "<div class='kdialogButton'><input name='ok' value='OK' type='submit' id='kButtonOK' size='15' /></div></form>";
		$k.content = msg;
		$k.show();
		
		$("#kInternalForm").submit(function(){
			$k.hide();
			return false;
		});
	}
	
	function $kconfirm(msg, fn) {
		var kbox = $k;
		$k.title = "SNORG Confirm!";
		msg = "<form id='kInternalForm'><div class='kdialogMessage'>"+msg+"</div>";
		msg += "<div class='kdialogButton'><input name='ok' value='OK' type='submit' id='kButtonOK' size='15' /><input name='cancel' value='Cancel' type='button' id='kButtonCancel' size='15' /></div><form>";
		$k.content = msg;
		$k.show();
		
		$("#kInternalForm").submit(function(){
			$k.hide();
			fn.call($(this), true);
			return false;
		});
		$("#kButtonCancel").click(function(){
			$k.hide();
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
		var kbox = $k;
		$k.title = "SNORG Prompt!";
		msg = "<form id='kInternalForm'><div class='kdialogMessage'>"+msg+"<br /><input type='text' name='prompt' id='kButtonInput' value='"+val+"' size='47' /></div>";
		msg += "<div class='kdialogButton'><input name='ok' value='OK' type='submit' id='kButtonOK' /><input name='cancel' value='Cancel' type='button' id='kButtonCancel' /></div></form>";
		$k.content = msg;
		$k.show();
		
		$("#kInternalForm").submit(function(){
			$k.hide();
			fn.call($(this),$(this).find("#kButtonInput").val());
			return false;
		});
		$("#kButtonCancel").click(function(){
			$k.hide();
		});
	}
	
	function $kbox(t, c) {
		var kbox = $k;
		$k.title = t;
		$k.content = c;
		$k.show();
		$k.isKbox = true;
		return $k.jQuery();
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
			$k.hide();
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
			$k.hide();
		});
	};
	
	/* Constructor */
	constructor = function () {
		/* construct overlay */
		kdialog.before("<div id='koverlay'></div>");
		koverlay = $("#koverlay");
		koverlay.height(768);
		
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

function kdemo(msg) {
	$kalert("kimkha "+msg);
}

$(document).ready(function(){
	$k = $kdialog();
//	$kprompt("KimKha", 'abc', kdemo);
});