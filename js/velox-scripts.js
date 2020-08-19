// String translation constants.
const { __, _x, _n, _nx } = wp.i18n;

// as the page loads, call these scripts
jQuery(document).ready(function($) {
	(function($) {
		"use strict";

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
if ("default_light" == velox_options.night_mode || "default_dark" == velox_options.night_mode) {
	const light = __("Light", "velox");
	const dark = __("Dark", "velox");
	const lightHTML = light + ' <span class="night-mode-track-icon" role="presentation">☀️</span>';
	const darkHTML = dark + ' <span class="night-mode-track-icon" role="presentation">🌖</span>';
	const nightModeTrack = document.getElementById("night-mode-track");
	const nightModeCheck = document.getElementById("night-mode-check");

	// Store nightmode value in local storage.
	let localNightMode = localStorage.getItem("nightmode");
	if ("true" == localNightMode || "default_dark" == velox_options.night_mode) {
		document.body.classList.add("night-mode");
		nightModeTrack.classList.add("night-mode");
		nightModeTrack.classList.remove("day-mode");
		nightModeTrack.innerHTML = lightHTML;
	} else {
		document.body.classList.remove("night-mode");
		nightModeTrack.classList.add("day-mode");
		nightModeTrack.classList.remove("night-mode");
		nightModeTrack.innerHTML = darkHTML;
	}

	// When nightmode is checked
	nightModeCheck.onclick = function() {
		document.body.classList.toggle("night-mode");
		if (document.body.classList.contains("night-mode")) {
			localStorage.setItem("nightmode", "true");
			document.body.classList.add("night-mode");
			nightModeTrack.classList.add("night-mode");
			nightModeTrack.classList.remove("day-mode");
			nightModeTrack.innerHTML = lightHTML;
		} else {
			localStorage.setItem("nightmode", "false");
			document.body.classList.remove("night-mode");
			nightModeTrack.classList.add("day-mode");
			nightModeTrack.classList.remove("night-mode");
			nightModeTrack.innerHTML = darkHTML;
		}
	};
}

// Display article progress bar if activated.
if (true == velox_options.progress_bar && document.body.classList.contains("single-post")) {
	const windowOuterHeight = window.innerHeight;
	const articleHeight = document.querySelector(".post").offsetHeight;

	// Add progress bar
	const progressBar = document.createElement("span");
	progressBar.classList.add("progress-bar");
	document.body.prepend(progressBar);

	// Control the size of the progress bar
	const updateProgressBar = function() {
		let windowScrollTop = window.scrollY;
		(total = (windowScrollTop / (articleHeight - windowOuterHeight)) * 100), (updatedWidth = (total <= 100 ? total : 100) + "%");
		progressBar.style.width = updatedWidth;
	}

	// Update upon scroll
	window.addEventListener("scroll", updateProgressBar);
}

// Display read time on articles if activated.
// 200 words per minute is the average used for calcuation.
if (true == velox_options.read_time) {
	let articlePost = document.querySelector("article.post");
	if (null !== articlePost) {
		const articleText = articlePost.textContent;
		// Count words, divide by 200, and round.
		const readingTime = function() {
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
 * Skip Link Focus Fix
 * Helps with accessibility for keyboard only users.
 * Learn more: https://git.io/vWdr2
 */
( function() {
	var isIe = /(trident|msie)/i.test( navigator.userAgent );

	if ( isIe && document.getElementById && window.addEventListener ) {
		window.addEventListener( 'hashchange', function() {
			var id = location.hash.substring( 1 ),
				element;

			if ( ! ( /^[A-z0-9_-]+$/.test( id ) ) ) {
				return;
			}

			element = document.getElementById( id );

			if ( element ) {
				if ( ! ( /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) ) {
					element.tabIndex = -1;
				}

				element.focus();
			}
		}, false );
	}
}() );

/*
 * Sticky-kit v1.1.3 | MIT | Leaf Corcoran 2015 | http://leafo.net
 */
(function(){var A,M;(A=window.jQuery),(M=A(window)),(A.fn.stick_in_parent=function(t){var w,_,i,o,x,e,P,V,F,C,z,I;for(null==t&&(t={}),I=t.sticky_class,x=t.inner_scrolling,z=t.recalc_every,C=t.parent,V=t.offset_top,P=t.spacer,_=t.bottoming,null==V&&(V=0),null==C&&(C=void 0),null==x&&(x=!0),null==I&&(I="is_stuck"),w=A(document),null==_&&(_=!0),F=function(t){var i;return window.getComputedStyle?((t=window.getComputedStyle(t[0])),(i=parseFloat(t.getPropertyValue("width"))+parseFloat(t.getPropertyValue("margin-left"))+parseFloat(t.getPropertyValue("margin-right"))),"border-box"!==t.getPropertyValue("box-sizing")&&(i+=parseFloat(t.getPropertyValue("border-left-width"))+parseFloat(t.getPropertyValue("border-right-width"))+parseFloat(t.getPropertyValue("padding-left"))+parseFloat(t.getPropertyValue("padding-right"))),i):t.outerWidth(!0)},i=function(s,r,n,l,a,c,p,u){var d,t,f,g,h,k,y,m,i,b,v,e;if(!s.data("sticky_kit")){if((s.data("sticky_kit",!0),(h=w.height()),(y=s.parent()),null!=C&&(y=y.closest(C)),!y.length)){throw "failed to find stick parent"}if(((d=f=!1),(v=null!=P?P&&s.closest(P):A("<div />"))&&v.css("position",s.css("position")),(m=function(){var t,i,o;if(!u&&((h=w.height()),(t=parseInt(y.css("border-top-width"),10)),(i=parseInt(y.css("padding-top"),10)),(r=parseInt(y.css("padding-bottom"),10)),(n=y.offset().top+t+i),(l=y.height()),f&&((d=f=!1),null==P&&(s.insertAfter(v),v.detach()),s.css({position:"",top:"",width:"",bottom:""}).removeClass(I),(o=!0)),(a=s.offset().top-(parseInt(s.css("margin-top"),10)||0)-V),(c=s.outerHeight(!0)),(p=s.css("float")),v&&v.css({width:F(s),height:c,display:s.css("display"),"vertical-align":s.css("vertical-align"),float:p}),o)){return e()}})(),c!==l)){return((g=void 0),(k=V),(b=z),(e=function(){var t,i,o,e;if(!u&&((o=!1),null!=b&& --b<=0&&((b=z),m(),(o=!0)),o||w.height()===h||m(),(o=M.scrollTop()),null!=g&&(i=o-g),(g=o),f?(_&&((e=l+n<o+c+k),d&&!e&&((d=!1),s.css({position:"fixed",bottom:"",top:k}).trigger("sticky_kit:unbottom"))),o<a&&((f=!1),(k=V),null==P&&(("left"!==p&&"right"!==p)||s.insertAfter(v),v.detach()),(t={position:"",width:"",top:""}),s.css(t).removeClass(I).trigger("sticky_kit:unstick")),x&&(t=M.height())<c+V&&!d&&((k-=i),(k=Math.max(t-c,k)),(k=Math.min(V,k)),f&&s.css({top:k+"px"}))):a<o&&((f=!0),((t={position:"fixed",top:k}).width="border-box"===s.css("box-sizing")?s.outerWidth()+"px":s.width()+"px"),s.css(t).addClass(I),null==P&&(s.after(v),("left"!==p&&"right"!==p)||v.append(s)),s.trigger("sticky_kit:stick")),f&&_&&(null==e&&(e=l+n<o+c+k),!d&&e))){return(d=!0),"static"===y.css("position")&&y.css({position:"relative"}),s.css({position:"absolute",bottom:r,top:"auto"}).trigger("sticky_kit:bottom")}}),(i=function(){return m(),e()}),(t=function(){if(((u=!0),M.off("touchmove",e),M.off("scroll",e),M.off("resize",i),A(document.body).off("sticky_kit:recalc",i),s.off("sticky_kit:detach",t),s.removeData("sticky_kit"),s.css({position:"",bottom:"",top:"",width:""}),y.position("position",""),f)){return null==P&&(("left"!==p&&"right"!==p)||s.insertAfter(v),v.remove()),s.removeClass(I)}}),M.on("touchmove",e),M.on("scroll",e),M.on("resize",i),A(document.body).on("sticky_kit:recalc",i),s.on("sticky_kit:detach",t),setTimeout(e,0))}}},o=0,e=this.length;o<e;o+=1){(t=this[o]),i(A(t))}return this})}.call(this));

/*
 * MicroModal v0.4.6 | MIT | https://micromodal.now.sh/
 */
!function(e,t){"object"==typeof exports&&"undefined"!=typeof module?module.exports=t():"function"==typeof define&&define.amd?define(t):(e=e||self).MicroModal=t()}(this,(function(){"use strict";function e(e,t){for(var o=0;o<t.length;o++){var n=t[o];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}function t(e){return function(e){if(Array.isArray(e))return o(e)}(e)||function(e){if("undefined"!=typeof Symbol&&Symbol.iterator in Object(e))return Array.from(e)}(e)||function(e,t){if(!e)return;if("string"==typeof e)return o(e,t);var n=Object.prototype.toString.call(e).slice(8,-1);"Object"===n&&e.constructor&&(n=e.constructor.name);if("Map"===n||"Set"===n)return Array.from(n);if("Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n))return o(e,t)}(e)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function o(e,t){(null==t||t>e.length)&&(t=e.length);for(var o=0,n=new Array(t);o<t;o++)n[o]=e[o];return n}var n,i,a,r,s,l=(n=["a[href]","area[href]",'input:not([disabled]):not([type="hidden"]):not([aria-hidden])',"select:not([disabled]):not([aria-hidden])","textarea:not([disabled]):not([aria-hidden])","button:not([disabled]):not([aria-hidden])","iframe","object","embed","[contenteditable]",'[tabindex]:not([tabindex^="-"])'],i=function(){function o(e){var n=e.targetModal,i=e.triggers,a=void 0===i?[]:i,r=e.onShow,s=void 0===r?function(){}:r,l=e.onClose,c=void 0===l?function(){}:l,d=e.openTrigger,u=void 0===d?"data-micromodal-trigger":d,f=e.closeTrigger,h=void 0===f?"data-micromodal-close":f,v=e.openClass,m=void 0===v?"is-open":v,g=e.disableScroll,b=void 0!==g&&g,y=e.disableFocus,p=void 0!==y&&y,w=e.awaitCloseAnimation,E=void 0!==w&&w,k=e.awaitOpenAnimation,M=void 0!==k&&k,C=e.debugMode,A=void 0!==C&&C;!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,o),this.modal=document.getElementById(n),this.config={debugMode:A,disableScroll:b,openTrigger:u,closeTrigger:h,openClass:m,onShow:s,onClose:c,awaitCloseAnimation:E,awaitOpenAnimation:M,disableFocus:p},a.length>0&&this.registerTriggers.apply(this,t(a)),this.onClick=this.onClick.bind(this),this.onKeydown=this.onKeydown.bind(this)}var i,a,r;return i=o,(a=[{key:"registerTriggers",value:function(){for(var e=this,t=arguments.length,o=new Array(t),n=0;n<t;n++)o[n]=arguments[n];o.filter(Boolean).forEach((function(t){t.addEventListener("click",(function(t){return e.showModal(t)}))}))}},{key:"showModal",value:function(){var e=this,t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null;if(this.activeElement=document.activeElement,this.modal.setAttribute("aria-hidden","false"),this.modal.classList.add(this.config.openClass),this.scrollBehaviour("disable"),this.addEventListeners(),this.config.awaitOpenAnimation){var o=function t(){e.modal.removeEventListener("animationend",t,!1),e.setFocusToFirstNode()};this.modal.addEventListener("animationend",o,!1)}else this.setFocusToFirstNode();this.config.onShow(this.modal,this.activeElement,t)}},{key:"closeModal",value:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null,t=this.modal;if(this.modal.setAttribute("aria-hidden","true"),this.removeEventListeners(),this.scrollBehaviour("enable"),this.activeElement&&this.activeElement.focus&&this.activeElement.focus(),this.config.onClose(this.modal,this.activeElement,e),this.config.awaitCloseAnimation){var o=this.config.openClass;this.modal.addEventListener("animationend",(function e(){t.classList.remove(o),t.removeEventListener("animationend",e,!1)}),!1)}else t.classList.remove(this.config.openClass)}},{key:"closeModalById",value:function(e){this.modal=document.getElementById(e),this.modal&&this.closeModal()}},{key:"scrollBehaviour",value:function(e){if(this.config.disableScroll){var t=document.querySelector("body");switch(e){case"enable":Object.assign(t.style,{overflow:""});break;case"disable":Object.assign(t.style,{overflow:"hidden"})}}}},{key:"addEventListeners",value:function(){this.modal.addEventListener("touchstart",this.onClick),this.modal.addEventListener("click",this.onClick),document.addEventListener("keydown",this.onKeydown)}},{key:"removeEventListeners",value:function(){this.modal.removeEventListener("touchstart",this.onClick),this.modal.removeEventListener("click",this.onClick),document.removeEventListener("keydown",this.onKeydown)}},{key:"onClick",value:function(e){e.target.hasAttribute(this.config.closeTrigger)&&this.closeModal(e)}},{key:"onKeydown",value:function(e){27===e.keyCode&&this.closeModal(e),9===e.keyCode&&this.retainFocus(e)}},{key:"getFocusableNodes",value:function(){var e=this.modal.querySelectorAll(n);return Array.apply(void 0,t(e))}},{key:"setFocusToFirstNode",value:function(){var e=this;if(!this.config.disableFocus){var t=this.getFocusableNodes();if(0!==t.length){var o=t.filter((function(t){return!t.hasAttribute(e.config.closeTrigger)}));o.length>0&&o[0].focus(),0===o.length&&t[0].focus()}}}},{key:"retainFocus",value:function(e){var t=this.getFocusableNodes();if(0!==t.length)if(t=t.filter((function(e){return null!==e.offsetParent})),this.modal.contains(document.activeElement)){var o=t.indexOf(document.activeElement);e.shiftKey&&0===o&&(t[t.length-1].focus(),e.preventDefault()),!e.shiftKey&&t.length>0&&o===t.length-1&&(t[0].focus(),e.preventDefault())}else t[0].focus()}}])&&e(i.prototype,a),r&&e(i,r),o}(),a=null,r=function(e){if(!document.getElementById(e))return console.warn("MicroModal: ❗Seems like you have missed %c'".concat(e,"'"),"background-color: #f8f9fa;color: #50596c;font-weight: bold;","ID somewhere in your code. Refer example below to resolve it."),console.warn("%cExample:","background-color: #f8f9fa;color: #50596c;font-weight: bold;",'<div class="modal" id="'.concat(e,'"></div>')),!1},s=function(e,t){if(function(e){e.length<=0&&(console.warn("MicroModal: ❗Please specify at least one %c'micromodal-trigger'","background-color: #f8f9fa;color: #50596c;font-weight: bold;","data attribute."),console.warn("%cExample:","background-color: #f8f9fa;color: #50596c;font-weight: bold;",'<a href="#" data-micromodal-trigger="my-modal"></a>'))}(e),!t)return!0;for(var o in t)r(o);return!0},{init:function(e){var o=Object.assign({},{openTrigger:"data-micromodal-trigger"},e),n=t(document.querySelectorAll("[".concat(o.openTrigger,"]"))),r=function(e,t){var o=[];return e.forEach((function(e){var n=e.attributes[t].value;void 0===o[n]&&(o[n]=[]),o[n].push(e)})),o}(n,o.openTrigger);if(!0!==o.debugMode||!1!==s(n,r))for(var l in r){var c=r[l];o.targetModal=l,o.triggers=t(c),a=new i(o)}},show:function(e,t){var o=t||{};o.targetModal=e,!0===o.debugMode&&!1===r(e)||(a&&a.removeEventListeners(),(a=new i(o)).showModal())},close:function(e){e?a.closeModalById(e):a.closeModal()}});return window.MicroModal=l,l}));

MicroModal.init({
  onShow: modal => 'menu-toggle', // [1]
  onClose: modal => console.info(`${modal.id} is hidden`), // [2]
  disableScroll: true,
});
