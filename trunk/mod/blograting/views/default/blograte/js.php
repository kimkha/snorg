

// JavaScript Document
/*************************************************
Star Rating System
First Version: 21 November, 2006
Second Version: 17 May, 2007
Author: Ritesh Agrawal (http://php.scripts.psu.edu/rja171/widgets/rating.php)
        email: ragrawal [at] gmail (dot) com
Inspiration: Will Stuckey's star rating system (http://sandbox.wilstuckey.com/jquery-ratings/)
Half-Star Addition: Karl Swedberg
Demonstration: http://examples.learningjquery.com/rating/
Usage: $('#rating').rating('url-to-post.php', {maxvalue:5, curvalue:0});

arguments
url : required -- post changes to 
options
  increment : 1, // value to increment by
	maxvalue: number of stars
	curvalue: number of selected stars
	

************************************************/

jQuery.fn.rating = function(url, options) {
	
	if(url == null) return;
	
	var settings = {
    url : url, // post changes to 
    increment : 1, // value to increment by
    maxvalue  : 5,   // max number of stars
    curvalue  : 0,    // number of selected stars
    user: -1,
    entity: -1,
    disable: false
  };
	
  if(options) {
    $.extend(settings, options);
  };
  $.extend(settings, {cancel: (settings.maxvalue > 1) ? true : false});
   
   
  var container = $(this);
	
	$.extend(container, {
    averageRating: settings.curvalue,
    url: settings.url
  });
  settings.increment = (settings.increment < .75) ? .5 : 1;
  
  function reviewRate() {
  	var s = 0;
	for(var i= 0; i <= settings.maxvalue ; i++){
    if (i == 0) {
	    if(settings.cancel == true){
          var div = '<div class="cancel"><a href="#0" title="Cancel Rating">Cancel Rating</a></div>';
          container.empty().append(div);
        }
      } else {
        var $div = $('<div class="star"></div>')
          .append('<a href="#'+i+'" title="Give it '+i+'/'+settings.maxvalue+'">'+i+'</a>')
          .appendTo(container);
        if (settings.increment == .5) {
          if (s%2) {
            $div.addClass('star-left');
          } else {
            $div.addClass('star-right');
          }
        }
      }
      i=i-1+settings.increment;
      s++;
    }
	
	var stars = $(container).children('.star');
  var cancel = $(container).children('.cancel');

		
	  stars
	    .mouseover(function(){
	      event.drain();
	      event.fill(this);
	    })
	    .mouseout(function(){
	      event.drain();
	      event.reset();
	    })
	    .focus(function(){
	      event.drain();
	      event.fill(this);
	    })
	    .blur(function(){
	      event.drain();
	      event.reset();
	    });
	  
	  stars.unbind("dblclick");
	  
	  stars.click(function(){
	  	
	  	if (!settings.disable){
	      settings.disable = true;
			if(settings.cancel == true){
	      $.post(container.url, {
	        rating: $(this).children('a')[0].href.split('#')[1],
			user: settings.user,
			entity: settings.entity 
	      }, function(data){   	
	      		settings.curvalue = rateround(data.average); 
				$("#ratepoint"+settings.entity).html(data.total);
				stars.html("");
				reviewRate();
	      	   },
			 'json'
		  );
				return false;
			} else if (settings.maxvalue == 1) {
				settings.disable = false;
				settings.curvalue = (settings.curvalue == 0) ? 1 : 0;
				$(this).toggleClass('on');
				$.post(container.url, {
	        rating: $(this).children('a')[0].href.split('#')[1],
			user: settings.user,
			entity: settings.entity 
	      });
				return false;
			}
			settings.disable = false;
			return true;
		} else {
			$kalert("<?php echo elgg_echo('blograting:hasrate') ?>")
		}				
	  });
  

  // cancel button events
	if(cancel){
    cancel
    .mouseover(function(){
      event.drain();
      $(this).addClass('on');
    })
    .mouseout(function(){
      event.reset();
      $(this).removeClass('on');
    })
    .focus(function(){
      event.drain();
      $(this).addClass('on');
    })
    .blur(function(){
      event.reset();
      $(this).removeClass('on');
    });
      
    // click events.
    cancel.click(function(){
      event.drain();
      settings.curvalue = 0;
      $.post(container.url, {
        rating: $(this).children('a')[0].href.split('#')[1],
		user: '<?php echo $vars['user']->guid ?>'
      }, function (data){return false;});
      return false;
    });
  }
        
	var event = {
		fill: function(el){ // fill to the current mouse position.
			var index = stars.index(el) + 1;
			stars
				.children('a').css('width', '100%').end()
				.slice(0,index).addClass('hover').end();
		},
		drain: function() { // drain all the stars.
			stars
				.filter('.on').removeClass('on').end()
				.filter('.hover').removeClass('hover').end();
		},
		reset: function(){ // Reset the stars to the default index.
			stars.slice(0,settings.curvalue / settings.increment).addClass('on').end();
		}
	};    
	event.reset();
}
  
  reviewRate();

	return(this);	

};


function rateround(x){
	floorx = Math.floor(x);
	pointx = x - floorx;
	var roundpointx;
	if (pointx < 0.25){
		roundpointx = 0;
	} else if (pointx < 0.75){
		roundpointx = 0.5;
	} else {
		roundpointx = 1;
	}
	
	return floorx + roundpointx;
}
