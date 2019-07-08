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

    // Display read time on articles if activated.
    if (true == velox_options.read_time) {
      $.fn.readingtime = function(options) {
        var settings = $.extend(
          {
            wpm: 150,
            round: "round"
          },
          options
        );

        var words = $.trim(this.first().text()).split(/\s+/).length;
        return Math[settings.round](words / settings.wpm);
      };

      // For each blog post
      $("article.post").each(function() {
        // Calculate Reading Time
        var ert = $(this).readingtime();

        // Append it to post header if not zero
        if (ert > 0) {
          $(this)
            .find(".entry-meta")
            .append('<div class="read-time">' + ert + " min reading time</div>");
        }
      });
    }

    // Display article progress bar if activated.
    if (true == velox_options.progress_bar) {
      $("body.single").prognroll({
        color: "#" + velox_options.link_color
      });
    }
    // Allow nightmode if activated.
    if ('default_light' == velox_options.night_mode || 'default_dark' == velox_options.night_mode) {
      const light = __( 'Light', 'velox' );
      const dark = __( 'Dark', 'velox' );
      // Store nightmode value in local storage.
      var localNightMode = localStorage.getItem("nightmode");
      if ("true" == localNightMode || 'default_dark' == velox_options.night_mode) {
        $("body").addClass("night-mode");
        $('#night-mode-track').replaceWith('<span id="night-mode-track" class="night-mode">' + light + ' <span class="night-mode-track-icon">☀️</span></span>');
      } else {
        $("body").removeClass("night-mode");
        $('#night-mode-track').replaceWith('<span id="night-mode-track" class="day-mode">' + dark + ' <span class="night-mode-track-icon">🌖</span></span>');
      }
      // If someone clicks the nightmode checkbox, toggle and store.
      $("#night-mode-check").click(function() {
          $("body").toggleClass("night-mode");
          if ($("body").hasClass("night-mode")) {
            localStorage.setItem("nightmode", "true");
            $('#night-mode-track').replaceWith('<span id="night-mode-track" class="night-mode">' + light + ' <span class="night-mode-track-icon">☀️</span></span>');
          } else {
            localStorage.setItem("nightmode", "false");
            $('#night-mode-track').replaceWith('<span id="night-mode-track" class="day-mode">' + dark + ' <span class="night-mode-track-icon">🌖</span></span>');
          }
      });
    }
  })(jQuery);
}); /* end of as page load scripts */

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

/* PrognRoll | https://mburakerman.github.io/prognroll/ | @mburakerman | License: MIT
 * n(document).height() has been updated to n("article").height() to only scroll content.
 */
!function(s){s.fn.prognroll=function(o){var i=s.extend({height:5,color:"#50bcb6",custom:!1},o);return this.each(function(){if(s(this).data("prognroll"))return!1;s(this).data("prognroll",!0);var o=s("<span>",{class:"progress-bar"});s("body").prepend(o),o.css({position:"fixed",top:0,left:0,width:0,height:i.height,backgroundColor:i.color,zIndex:9999999}),!1===i.custom?s(window).scroll(function(o){o.preventDefault();var r=s(window).scrollTop(),t=s(window).outerHeight(),e=r/(s("article").height()-t)*100;s(".progress-bar").css("width",e+"%")}):s(this).scroll(function(o){o.preventDefault();var r=s(this).scrollTop(),t=s(this).outerHeight(),e=r/(s(this).prop("scrollHeight")-t)*100;s(".progress-bar").css("width",e+"%")});var r=s(window).scrollTop(),t=s(window).outerHeight(),e=r/(s("body").outerHeight()-t)*100;s(".progress-bar").css("width",e+"%")})}}(jQuery);

/*
 * Sticky-kit v1.1.3 | MIT | Leaf Corcoran 2015 | http://leafo.net
 */
(function(){var A,M;A=window.jQuery,M=A(window),A.fn.stick_in_parent=function(t){var w,_,i,o,x,e,P,V,F,C,z,I;for(null==t&&(t={}),I=t.sticky_class,x=t.inner_scrolling,z=t.recalc_every,C=t.parent,V=t.offset_top,P=t.spacer,_=t.bottoming,null==V&&(V=0),null==C&&(C=void 0),null==x&&(x=!0),null==I&&(I="is_stuck"),w=A(document),null==_&&(_=!0),F=function(t){var i;return window.getComputedStyle?(t=window.getComputedStyle(t[0]),i=parseFloat(t.getPropertyValue("width"))+parseFloat(t.getPropertyValue("margin-left"))+parseFloat(t.getPropertyValue("margin-right")),"border-box"!==t.getPropertyValue("box-sizing")&&(i+=parseFloat(t.getPropertyValue("border-left-width"))+parseFloat(t.getPropertyValue("border-right-width"))+parseFloat(t.getPropertyValue("padding-left"))+parseFloat(t.getPropertyValue("padding-right"))),i):t.outerWidth(!0)},i=function(s,r,n,l,a,c,p,u){var d,t,f,g,h,k,y,m,i,b,v,e;if(!s.data("sticky_kit")){if(s.data("sticky_kit",!0),h=w.height(),y=s.parent(),null!=C&&(y=y.closest(C)),!y.length)throw"failed to find stick parent";if(d=f=!1,(v=null!=P?P&&s.closest(P):A("<div />"))&&v.css("position",s.css("position")),(m=function(){var t,i,o;if(!u&&(h=w.height(),t=parseInt(y.css("border-top-width"),10),i=parseInt(y.css("padding-top"),10),r=parseInt(y.css("padding-bottom"),10),n=y.offset().top+t+i,l=y.height(),f&&(d=f=!1,null==P&&(s.insertAfter(v),v.detach()),s.css({position:"",top:"",width:"",bottom:""}).removeClass(I),o=!0),a=s.offset().top-(parseInt(s.css("margin-top"),10)||0)-V,c=s.outerHeight(!0),p=s.css("float"),v&&v.css({width:F(s),height:c,display:s.css("display"),"vertical-align":s.css("vertical-align"),float:p}),o))return e()})(),c!==l)return g=void 0,k=V,b=z,e=function(){var t,i,o,e;if(!u&&(o=!1,null!=b&&(--b<=0&&(b=z,m(),o=!0)),o||w.height()===h||m(),o=M.scrollTop(),null!=g&&(i=o-g),g=o,f?(_&&(e=l+n<o+c+k,d&&!e&&(d=!1,s.css({position:"fixed",bottom:"",top:k}).trigger("sticky_kit:unbottom"))),o<a&&(f=!1,k=V,null==P&&("left"!==p&&"right"!==p||s.insertAfter(v),v.detach()),t={position:"",width:"",top:""},s.css(t).removeClass(I).trigger("sticky_kit:unstick")),x&&((t=M.height())<c+V&&!d&&(k-=i,k=Math.max(t-c,k),k=Math.min(V,k),f&&s.css({top:k+"px"})))):a<o&&(f=!0,(t={position:"fixed",top:k}).width="border-box"===s.css("box-sizing")?s.outerWidth()+"px":s.width()+"px",s.css(t).addClass(I),null==P&&(s.after(v),"left"!==p&&"right"!==p||v.append(s)),s.trigger("sticky_kit:stick")),f&&_&&(null==e&&(e=l+n<o+c+k),!d&&e)))return d=!0,"static"===y.css("position")&&y.css({position:"relative"}),s.css({position:"absolute",bottom:r,top:"auto"}).trigger("sticky_kit:bottom")},i=function(){return m(),e()},t=function(){if(u=!0,M.off("touchmove",e),M.off("scroll",e),M.off("resize",i),A(document.body).off("sticky_kit:recalc",i),s.off("sticky_kit:detach",t),s.removeData("sticky_kit"),s.css({position:"",bottom:"",top:"",width:""}),y.position("position",""),f)return null==P&&("left"!==p&&"right"!==p||s.insertAfter(v),v.remove()),s.removeClass(I)},M.on("touchmove",e),M.on("scroll",e),M.on("resize",i),A(document.body).on("sticky_kit:recalc",i),s.on("sticky_kit:detach",t),setTimeout(e,0)}},o=0,e=this.length;o<e;o++)t=this[o],i(A(t));return this}}).call(this);
