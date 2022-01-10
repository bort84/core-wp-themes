function nsDisclaimerResize (isModal) {

  var w = Math.round(jQuery(window).width() * 0.75);
  var h = Math.round(jQuery(window).height() * 0.75);

  if (!isModal)
	  jQuery('#idDisclaimerContainer').css({
		'top':Math.round(jQuery(window).height() / 2),
		'left':Math.round(jQuery(window).width() / 2),
		'width':w,
		'height':h,
		'marginTop':-(h / 2),
		'marginLeft':-(w / 2)
	  });

  jQuery('#idDisclaimerOverlay').css({
    'top':0,
    'left':0,
    'width':jQuery(document).width(),
    'height':jQuery(document).height()
  })
  
  jQuery('#idDisclaimerContainer,#idDisclaimerOverlay').show();
  
  // resize main body
  var pad = Number(jQuery('#idDisclaimerBody').css('paddingTop').replace(/[^0-9]+/, '')) + Number(jQuery('#idDisclaimerBody').css('paddingBottom').replace(/[^0-9]+/, ''));
  if (nsDisclaimer.title != '') {
    pad += jQuery('#idDisclaimerTitle').outerHeight(true);
  }
  
  if (!isModal)
	  jQuery('#idDisclaimerBody').css({
		'height':(h - jQuery('#idDisclaimerButtons').outerHeight(true) - pad)
	  });


    checkScroll();

    function checkScroll() {
      var scrollHeight = jQuery("#idDisclaimerInnerBody").height();
      var scrollBuffer = jQuery("#idDisclaimerBody").height();
      var scrollPosition = jQuery("#idDisclaimerBody").scrollTop();

      if (scrollPosition > (scrollHeight - scrollBuffer)) {
          jQuery('a.disabled').removeClass('disabled');
      }
    }


    jQuery("#idDisclaimerBody").on("scroll", checkScroll);


}

function setCookie() {

    if ((nsDisclaimer.interval == 'session') && (typeof sessionStorage === 'object')) {
        try {
            sessionStorage.setItem("nsDisclaimer", "true"); 
        } catch (e) {
            // sessionStorage isn't support, so let's default to time instead
            nsDisclaimer.interval = 'time';
            nsDisclaimer.d = 0;
            nsDisclaimer.h = 0;
            nsDisclaimer.m = 1;
        }
    }

	  /* If set to session, we're not actually using a cookie, 
	  but sessionStorage which is destroyed on TAB close. */
	  if (nsDisclaimer.interval == 'time') {
	  	// Standard time-based cookie in this scenario
		var date = new Date();
		date.setTime(date.getTime() + ( (nsDisclaimer.d*24*60*60*1000) + (nsDisclaimer.h*60*60*1000) + (nsDisclaimer.m*60*1000) ) ); 

		var expires = "; expires="+date.toGMTString();

		document.cookie = nsDisclaimer.cookie + "=1" + expires + "; path=/";
	  }	
}


jQuery().ready(function ($) {

	isModal = $('body').hasClass('modal');
	//document.cookie = nsDisclaimer.cookie + "=1" + expires + "; path=/";
	
	$('div.load-overlay').remove();

	/* Only show disclaimer if there is no nsDisclaimer cookie AND 
	the sessionStorage varibable nsDisclaimer is not set to true. 

  Also make sure sessionStorage is actually available. */
  try {
      sessionDisclaimer = sessionStorage.getItem("nsDisclaimer");
  } catch (e) {
      sessionDisclaimer = "false";
  }
  
  if (typeof(Storage) !== "undefined") {
		sessionDisclaimer = sessionStorage.getItem("nsDisclaimer");
	}

  if ((typeof nsDisclaimer !== 'undefined') && (sessionDisclaimer != "true") ) { 

    var agreeDesc = '';
    var disagreeDesc = '';
    var buttonWrapClass = '';

    if ((nsDisclaimer.agreeDesc == '') && (nsDisclaimer.disagreeDesc == ''))
      buttonWrapClass = ' class="inline"';

    if (nsDisclaimer.agreeDesc != '') 
      agreeDesc = '<p>'+nsDisclaimer.agreeDesc+'</p>';

    if (nsDisclaimer.disagreeDesc != '') 
      disagreeDesc = '<p>'+nsDisclaimer.disagreeDesc+'</p>';    

    var readFullDisclaimerClass = (nsDisclaimer.readFullDisclaimer ? ' class="disabled" ' : '');

    var html = '<div id="idDisclaimerOverlay" style="display: none;"></div><div id="idDisclaimerContainer" style="display: none;">';
    
    if (nsDisclaimer.title != '') {
      html += '<div id="idDisclaimerTitle">'+nsDisclaimer.title+'</div>';
    }
    html += '<div id="idDisclaimerBody"><div id="idDisclaimerInnerBody">'+nsDisclaimer.text+'</div></div><div id="idDisclaimerButtons"'+buttonWrapClass+'><div id="idDisclaimerAgreeSection"><a id="idDisclaimerAgree"'+readFullDisclaimerClass+'title="'+nsDisclaimer.agree+'">'+nsDisclaimer.agree+'</a></a>'+agreeDesc+'</div>';
    if (nsDisclaimer.redir == 1) {
      html += '<div id="idDisclaimerDisagreeSection"><a id="idDisclaimerDisagree"'+readFullDisclaimerClass+'title="'+nsDisclaimer.disagree+'">'+nsDisclaimer.disagree+'</a>'+disagreeDesc+'</p></div>';
    }
    html += '</div></div>';
    $('body').prepend(html);
    
    nsDisclaimerResize(isModal);
    
    $('#idDisclaimerAgree').click(function () {

      if ($(this).hasClass('disabled')) {
        alert(nsDisclaimer.readFullDisclaimerAlert);
        return;
      }
      setCookie();

      $('#idDisclaimerContainer,#idDisclaimerOverlay').remove();
      if(isModal) {
        // We've got to reload since we cleared out the actual content via the php file
        location.reload();
      }
      // scroll page to top
      window.scrollTo(0, 0);
    });
    $('#idDisclaimerDisagree').click(function () {
      if ($(this).hasClass('disabled')) {
        alert(nsDisclaimer.readFullDisclaimerAlert);
        return;
      }
      
      if (nsDisclaimer.redir == 1) {
        window.location.href = nsDisclaimer.url;
      }
    });
    
    $(window).resize(function () {
      if (!isModal)
    	nsDisclaimerResize();
    });
  }
});




