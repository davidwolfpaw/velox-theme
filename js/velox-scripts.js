// as the page loads, call these scripts
jQuery(document).ready(function($) {
  (function($) {
    "use strict";

    // String translation constants.
    const { __, _x, _n, _nx } = wp.i18n;

    // Get viewport width.
    var responsive_viewport = $(window).width();

    // Stick header in sidebar.
    $(".site-header-wrap").stick_in_parent({
      offset_top: 48,
      spacer: false
    });

  })(jQuery);
}); /* end of as page load scripts */


// Allow nightmode if activated.
if ('default_light' == velox_options.night_mode || 'default_dark' == velox_options.night_mode) {
  // const light = __( 'Light', 'velox' );
  // const dark = __( 'Dark', 'velox' );
  const light = 'Light <span class="night-mode-track-icon">☀️</span>';
  const dark = 'Dark <span class="night-mode-track-icon">🌖</span>';
  const nightModeTrack = document.getElementById('night-mode-track');
  const nightModeCheck = document.getElementById('night-mode-check');

  // Store nightmode value in local storage.
  var localNightMode = localStorage.getItem("nightmode");
  if ("true" == localNightMode || 'default_dark' == velox_options.night_mode) {
      document.body.classList.add("night-mode");
      nightModeTrack.classList.add("night-mode");
      nightModeTrack.classList.remove("day-mode");
      nightModeTrack.innerHTML = light;
  } else {
      document.body.classList.remove("night-mode");
      nightModeTrack.classList.add("day-mode");
      nightModeTrack.classList.remove("night-mode");
      nightModeTrack.innerHTML = dark;
  }

  // When nightmode is checked
  nightModeCheck.onclick = function() {
    document.body.classList.toggle("night-mode");
    if (document.body.classList.contains("night-mode")) {
      localStorage.setItem("nightmode", "true");
      document.body.classList.add("night-mode");
      nightModeTrack.classList.add("night-mode");
      nightModeTrack.classList.remove("day-mode");
      nightModeTrack.innerHTML = light;
    } else {
      localStorage.setItem("nightmode", "false");
      document.body.classList.remove("night-mode");
      nightModeTrack.classList.add("day-mode");
      nightModeTrack.classList.remove("night-mode");
      nightModeTrack.innerHTML = dark;
    }
  };
}


// Display article progress bar if activated.
if (true == velox_options.progress_bar) {
  const windowOuterHeight = window.innerHeight;
  const articleHeight = document.querySelector( '.post' ).offsetHeight;

  // Add progress bar
  const progressBar = document.createElement( 'span' );
  progressBar.classList.add( 'progress-bar' );
  document.body.prepend( progressBar );

  // Update upon scroll
  window.addEventListener( 'scroll', updateProgressBar );

  // Control the size of the progress bar
  function updateProgressBar() {
    let windowScrollTop = window.scrollY;
    total = ( windowScrollTop / ( articleHeight - windowOuterHeight ) ) * 100,
    updatedWidth = (total <= 100 ? total : 100) + '%';
    progressBar.style.width = updatedWidth;
  }
}


// Display read time on articles if activated.
// 200 words per minute is the average used for calcuation.
if (true == velox_options.read_time) {
  let articlePost = document.querySelector("article.post");
  if (null !== articlePost) {
    const articleText = articlePost.textContent;
    // Count words, divide by 200, and round.
    readingTime = function() {
      var words = articleText.split(/\W+/).length;
      return Math.round(words / 200);
    };

    // Calculate Reading Time
    var ert = readingTime();

    // Append it to post header if not zero
    if (ert > 0) {
      let entryMeta = document.querySelector("article.post .entry-meta");
      entryMeta.innerHTML += "<div class='read-time'>" + ert + " min reading time</div>";
    }
  }
}


/**
 * File navigation.js.
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
!(function() {
  var e, a, t, s, n, i;
  if ((e = document.getElementById("main-navigation")) && void 0 !== (a = e.getElementsByTagName("button")[0]))
    if (void 0 !== (t = e.getElementsByTagName("ul")[0])) {
      for (
        t.setAttribute("aria-expanded", "false"),
          -1 === t.className.indexOf("nav-menu") && (t.className += " nav-menu"),
          a.onclick = function() {
            -1 !== e.className.indexOf("toggled")
              ? ((e.className = e.className.replace(" toggled", "")), a.setAttribute("aria-expanded", "false"), t.setAttribute("aria-expanded", "false"))
              : ((e.className += " toggled"), a.setAttribute("aria-expanded", "true"), t.setAttribute("aria-expanded", "true"));
          },
          n = 0,
          i = (s = t.getElementsByTagName("a")).length;
        n < i;
        n++
      )
        s[n].addEventListener("focus", l, !0), s[n].addEventListener("blur", l, !0);
      !(function(a) {
        var t,
          s,
          n = e.querySelectorAll(".menu-item-has-children > a, .page_item_has_children > a");
        if ("ontouchstart" in window)
          for (
            t = function(e) {
              var a,
                t = this.parentNode;
              if (t.classList.contains("focus")) t.classList.remove("focus");
              else {
                for (e.preventDefault(), a = 0; a < t.parentNode.children.length; ++a) t !== t.parentNode.children[a] && t.parentNode.children[a].classList.remove("focus");
                t.classList.add("focus");
              }
            },
              s = 0;
            s < n.length;
            ++s
          )
            n[s].addEventListener("touchstart", t, !1);
      })();
    } else a.style.display = "none";
  function l() {
    for (var e = this; -1 === e.className.indexOf("nav-menu"); ) "li" === e.tagName.toLowerCase() && (-1 !== e.className.indexOf("focus") ? (e.className = e.className.replace(" focus", "")) : (e.className += " focus")), (e = e.parentElement);
  }
})();


/**
 * Skip Link Focus Fix
 * Helps with accessibility for keyboard only users.
 * Learn more: https://git.io/vWdr2
 */
/(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())},!1);


/*
 * Sticky-kit v1.1.3 | MIT | Leaf Corcoran 2015 | http://leafo.net
 */
(function(){var A,M;A=window.jQuery,M=A(window),A.fn.stick_in_parent=function(t){var w,_,i,o,x,e,P,V,F,C,z,I;for(null==t&&(t={}),I=t.sticky_class,x=t.inner_scrolling,z=t.recalc_every,C=t.parent,V=t.offset_top,P=t.spacer,_=t.bottoming,null==V&&(V=0),null==C&&(C=void 0),null==x&&(x=!0),null==I&&(I="is_stuck"),w=A(document),null==_&&(_=!0),F=function(t){var i;return window.getComputedStyle?(t=window.getComputedStyle(t[0]),i=parseFloat(t.getPropertyValue("width"))+parseFloat(t.getPropertyValue("margin-left"))+parseFloat(t.getPropertyValue("margin-right")),"border-box"!==t.getPropertyValue("box-sizing")&&(i+=parseFloat(t.getPropertyValue("border-left-width"))+parseFloat(t.getPropertyValue("border-right-width"))+parseFloat(t.getPropertyValue("padding-left"))+parseFloat(t.getPropertyValue("padding-right"))),i):t.outerWidth(!0)},i=function(s,r,n,l,a,c,p,u){var d,t,f,g,h,k,y,m,i,b,v,e;if(!s.data("sticky_kit")){if(s.data("sticky_kit",!0),h=w.height(),y=s.parent(),null!=C&&(y=y.closest(C)),!y.length)throw"failed to find stick parent";if(d=f=!1,(v=null!=P?P&&s.closest(P):A("<div />"))&&v.css("position",s.css("position")),(m=function(){var t,i,o;if(!u&&(h=w.height(),t=parseInt(y.css("border-top-width"),10),i=parseInt(y.css("padding-top"),10),r=parseInt(y.css("padding-bottom"),10),n=y.offset().top+t+i,l=y.height(),f&&(d=f=!1,null==P&&(s.insertAfter(v),v.detach()),s.css({position:"",top:"",width:"",bottom:""}).removeClass(I),o=!0),a=s.offset().top-(parseInt(s.css("margin-top"),10)||0)-V,c=s.outerHeight(!0),p=s.css("float"),v&&v.css({width:F(s),height:c,display:s.css("display"),"vertical-align":s.css("vertical-align"),float:p}),o))return e()})(),c!==l)return g=void 0,k=V,b=z,e=function(){var t,i,o,e;if(!u&&(o=!1,null!=b&&(--b<=0&&(b=z,m(),o=!0)),o||w.height()===h||m(),o=M.scrollTop(),null!=g&&(i=o-g),g=o,f?(_&&(e=l+n<o+c+k,d&&!e&&(d=!1,s.css({position:"fixed",bottom:"",top:k}).trigger("sticky_kit:unbottom"))),o<a&&(f=!1,k=V,null==P&&("left"!==p&&"right"!==p||s.insertAfter(v),v.detach()),t={position:"",width:"",top:""},s.css(t).removeClass(I).trigger("sticky_kit:unstick")),x&&((t=M.height())<c+V&&!d&&(k-=i,k=Math.max(t-c,k),k=Math.min(V,k),f&&s.css({top:k+"px"})))):a<o&&(f=!0,(t={position:"fixed",top:k}).width="border-box"===s.css("box-sizing")?s.outerWidth()+"px":s.width()+"px",s.css(t).addClass(I),null==P&&(s.after(v),"left"!==p&&"right"!==p||v.append(s)),s.trigger("sticky_kit:stick")),f&&_&&(null==e&&(e=l+n<o+c+k),!d&&e)))return d=!0,"static"===y.css("position")&&y.css({position:"relative"}),s.css({position:"absolute",bottom:r,top:"auto"}).trigger("sticky_kit:bottom")},i=function(){return m(),e()},t=function(){if(u=!0,M.off("touchmove",e),M.off("scroll",e),M.off("resize",i),A(document.body).off("sticky_kit:recalc",i),s.off("sticky_kit:detach",t),s.removeData("sticky_kit"),s.css({position:"",bottom:"",top:"",width:""}),y.position("position",""),f)return null==P&&("left"!==p&&"right"!==p||s.insertAfter(v),v.remove()),s.removeClass(I)},M.on("touchmove",e),M.on("scroll",e),M.on("resize",i),A(document.body).on("sticky_kit:recalc",i),s.on("sticky_kit:detach",t),setTimeout(e,0)}},o=0,e=this.length;o<e;o++)t=this[o],i(A(t));return this}}).call(this);
