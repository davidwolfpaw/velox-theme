// String translation constants.
const { __, _x, _n, _nx } = wp.i18n;
const bodyMode = getComputedStyle(document.documentElement).getPropertyValue('content').replace(/"/g, '');

// Get body width for responsive elements
function getWidth() {
	return Math.max(
		document.body.scrollWidth,
		document.documentElement.scrollWidth,
		document.body.offsetWidth,
		document.documentElement.offsetWidth,
		document.documentElement.clientWidth
	);
}

// Allow darkmode if activated.
if ("default_light" == velox_options.dark_mode || "default_dark" == velox_options.dark_mode) {
	const light = __("Light", "velox");
	const dark = __("Dark", "velox");
	const lightHTML = light + ' <span class="dark-mode-track-icon" role="presentation">☀️</span>';
	const darkHTML = dark + ' <span class="dark-mode-track-icon" role="presentation">🌖</span>';
	const darkModeTrack = document.getElementById("dark-mode-track");
	const darkModeCheck = document.getElementById("dark-mode-check");
	let preference = window.matchMedia('(prefers-color-scheme: dark)');

	// Store darkmode value in local storage.
	let localDarkMode = localStorage.getItem("darkmode");

	// If we've set dark mode, we are default dark mode, or user prefers dark mode and we set dark mode (to avoid changing on reload)
	if ("true" == localDarkMode || "default_dark" == velox_options.dark_mode || (preference.matches && "true" == localDarkMode)) {
		document.body.classList.add("dark-mode");
		darkModeTrack.classList.add("dark-mode");
		darkModeTrack.classList.remove("light-mode");
		darkModeTrack.innerHTML = lightHTML;
	} else {
		document.body.classList.remove("dark-mode");
		darkModeTrack.classList.add("light-mode");
		darkModeTrack.classList.remove("dark-mode");
		darkModeTrack.innerHTML = darkHTML;
	}

	// When darkmode is checked
	darkModeCheck.onclick = function() {
		document.body.classList.toggle("dark-mode");
		if (document.body.classList.contains("dark-mode")) {
			localStorage.setItem("darkmode", "true");
			document.body.classList.add("dark-mode");
			darkModeTrack.classList.add("dark-mode");
			darkModeTrack.classList.remove("light-mode");
			darkModeTrack.innerHTML = lightHTML;
		} else {
			localStorage.setItem("darkmode", "false");
			document.body.classList.remove("dark-mode");
			darkModeTrack.classList.add("light-mode");
			darkModeTrack.classList.remove("dark-mode");
			darkModeTrack.innerHTML = darkHTML;
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
	// Add pride class if active
	if (true == velox_options.progress_bar_pride) {
		progressBar.classList.add("pride");
	}
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
 * MicroModal v0.4.6 | MIT | https://micromodal.now.sh/
 */
!function(e,t){"object"==typeof exports&&"undefined"!=typeof module?module.exports=t():"function"==typeof define&&define.amd?define(t):(e=e||self).MicroModal=t()}(this,(function(){"use strict";function e(e,t){for(var o=0;o<t.length;o++){var n=t[o];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}function t(e){return function(e){if(Array.isArray(e))return o(e)}(e)||function(e){if("undefined"!=typeof Symbol&&Symbol.iterator in Object(e))return Array.from(e)}(e)||function(e,t){if(!e)return;if("string"==typeof e)return o(e,t);var n=Object.prototype.toString.call(e).slice(8,-1);"Object"===n&&e.constructor&&(n=e.constructor.name);if("Map"===n||"Set"===n)return Array.from(n);if("Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n))return o(e,t)}(e)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function o(e,t){(null==t||t>e.length)&&(t=e.length);for(var o=0,n=new Array(t);o<t;o++)n[o]=e[o];return n}var n,i,a,r,s,l=(n=["a[href]","area[href]",'input:not([disabled]):not([type="hidden"]):not([aria-hidden])',"select:not([disabled]):not([aria-hidden])","textarea:not([disabled]):not([aria-hidden])","button:not([disabled]):not([aria-hidden])","iframe","object","embed","[contenteditable]",'[tabindex]:not([tabindex^="-"])'],i=function(){function o(e){var n=e.targetModal,i=e.triggers,a=void 0===i?[]:i,r=e.onShow,s=void 0===r?function(){}:r,l=e.onClose,c=void 0===l?function(){}:l,d=e.openTrigger,u=void 0===d?"data-micromodal-trigger":d,f=e.closeTrigger,h=void 0===f?"data-micromodal-close":f,v=e.openClass,m=void 0===v?"is-open":v,g=e.disableScroll,b=void 0!==g&&g,y=e.disableFocus,p=void 0!==y&&y,w=e.awaitCloseAnimation,E=void 0!==w&&w,k=e.awaitOpenAnimation,M=void 0!==k&&k,C=e.debugMode,A=void 0!==C&&C;!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,o),this.modal=document.getElementById(n),this.config={debugMode:A,disableScroll:b,openTrigger:u,closeTrigger:h,openClass:m,onShow:s,onClose:c,awaitCloseAnimation:E,awaitOpenAnimation:M,disableFocus:p},a.length>0&&this.registerTriggers.apply(this,t(a)),this.onClick=this.onClick.bind(this),this.onKeydown=this.onKeydown.bind(this)}var i,a,r;return i=o,(a=[{key:"registerTriggers",value:function(){for(var e=this,t=arguments.length,o=new Array(t),n=0;n<t;n++)o[n]=arguments[n];o.filter(Boolean).forEach((function(t){t.addEventListener("click",(function(t){return e.showModal(t)}))}))}},{key:"showModal",value:function(){var e=this,t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null;if(this.activeElement=document.activeElement,this.modal.setAttribute("aria-hidden","false"),this.modal.classList.add(this.config.openClass),this.scrollBehaviour("disable"),this.addEventListeners(),this.config.awaitOpenAnimation){var o=function t(){e.modal.removeEventListener("animationend",t,!1),e.setFocusToFirstNode()};this.modal.addEventListener("animationend",o,!1)}else this.setFocusToFirstNode();this.config.onShow(this.modal,this.activeElement,t)}},{key:"closeModal",value:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null,t=this.modal;if(this.modal.setAttribute("aria-hidden","true"),this.removeEventListeners(),this.scrollBehaviour("enable"),this.activeElement&&this.activeElement.focus&&this.activeElement.focus(),this.config.onClose(this.modal,this.activeElement,e),this.config.awaitCloseAnimation){var o=this.config.openClass;this.modal.addEventListener("animationend",(function e(){t.classList.remove(o),t.removeEventListener("animationend",e,!1)}),!1)}else t.classList.remove(this.config.openClass)}},{key:"closeModalById",value:function(e){this.modal=document.getElementById(e),this.modal&&this.closeModal()}},{key:"scrollBehaviour",value:function(e){if(this.config.disableScroll){var t=document.querySelector("body");switch(e){case"enable":Object.assign(t.style,{overflow:""});break;case"disable":Object.assign(t.style,{overflow:"hidden"})}}}},{key:"addEventListeners",value:function(){this.modal.addEventListener("touchstart",this.onClick),this.modal.addEventListener("click",this.onClick),document.addEventListener("keydown",this.onKeydown)}},{key:"removeEventListeners",value:function(){this.modal.removeEventListener("touchstart",this.onClick),this.modal.removeEventListener("click",this.onClick),document.removeEventListener("keydown",this.onKeydown)}},{key:"onClick",value:function(e){e.target.hasAttribute(this.config.closeTrigger)&&this.closeModal(e)}},{key:"onKeydown",value:function(e){27===e.keyCode&&this.closeModal(e),9===e.keyCode&&this.retainFocus(e)}},{key:"getFocusableNodes",value:function(){var e=this.modal.querySelectorAll(n);return Array.apply(void 0,t(e))}},{key:"setFocusToFirstNode",value:function(){var e=this;if(!this.config.disableFocus){var t=this.getFocusableNodes();if(0!==t.length){var o=t.filter((function(t){return!t.hasAttribute(e.config.closeTrigger)}));o.length>0&&o[0].focus(),0===o.length&&t[0].focus()}}}},{key:"retainFocus",value:function(e){var t=this.getFocusableNodes();if(0!==t.length)if(t=t.filter((function(e){return null!==e.offsetParent})),this.modal.contains(document.activeElement)){var o=t.indexOf(document.activeElement);e.shiftKey&&0===o&&(t[t.length-1].focus(),e.preventDefault()),!e.shiftKey&&t.length>0&&o===t.length-1&&(t[0].focus(),e.preventDefault())}else t[0].focus()}}])&&e(i.prototype,a),r&&e(i,r),o}(),a=null,r=function(e){if(!document.getElementById(e))return console.warn("MicroModal: ❗Seems like you have missed %c'".concat(e,"'"),"background-color: #f8f9fa;color: #50596c;font-weight: bold;","ID somewhere in your code. Refer example below to resolve it."),console.warn("%cExample:","background-color: #f8f9fa;color: #50596c;font-weight: bold;",'<div class="modal" id="'.concat(e,'"></div>')),!1},s=function(e,t){if(function(e){e.length<=0&&(console.warn("MicroModal: ❗Please specify at least one %c'micromodal-trigger'","background-color: #f8f9fa;color: #50596c;font-weight: bold;","data attribute."),console.warn("%cExample:","background-color: #f8f9fa;color: #50596c;font-weight: bold;",'<a href="#" data-micromodal-trigger="my-modal"></a>'))}(e),!t)return!0;for(var o in t)r(o);return!0},{init:function(e){var o=Object.assign({},{openTrigger:"data-micromodal-trigger"},e),n=t(document.querySelectorAll("[".concat(o.openTrigger,"]"))),r=function(e,t){var o=[];return e.forEach((function(e){var n=e.attributes[t].value;void 0===o[n]&&(o[n]=[]),o[n].push(e)})),o}(n,o.openTrigger);if(!0!==o.debugMode||!1!==s(n,r))for(var l in r){var c=r[l];o.targetModal=l,o.triggers=t(c),a=new i(o)}},show:function(e,t){var o=t||{};o.targetModal=e,!0===o.debugMode&&!1===r(e)||(a&&a.removeEventListeners(),(a=new i(o)).showModal())},close:function(e){e?a.closeModalById(e):a.closeModal()}});return window.MicroModal=l,l}));

MicroModal.init({
  onShow: modal => 'menu-toggle', // [1]
  disableScroll: true,
});

/* ========================================================================
 * Simple Sticky Sidebar
 * @version 0.1
 * @author Ismail Farooq <ismail_farooq@yahoo.com>
 * @license The MIT License (MIT) (https://github.com/ismailfarooq/simple-sticky-sidebar/blob/master/LICENSE)
 * ======================================================================== */
function setStyle(element,cssProperty){for(var property in cssProperty){element.style[property]=cssProperty[property]}}function destroySticky(element){setStyle(element,{top:'',left:'',bottom:'',width:'',position:''})}function getOffset(el){el=el.getBoundingClientRect();return{left:el.left+window.scrollX,top:el.top+window.scrollY}}function simpleStickySidebar(element,options){var sticky=document.querySelector(element);var container=document.querySelector(options.container);var topSpace=options.topSpace?options.topSpace:0;var bottomSpace=options.bottomSpace?options.bottomSpace:0;var $window=window;var stickyHeight=sticky.getBoundingClientRect().height;var stickyOffsetTop=getOffset(sticky).top;var stickyOffsetBottom=getOffset(sticky).top+sticky.getBoundingClientRect().height;var stickyOffsetLeft=getOffset(sticky).left;var topFixed=false;var bottomFixed=false;var lastScrollVal=0;var getStickyHeight=function(){return document.querySelector(element).getBoundingClientRect().height};window.addEventListener('scroll',function(event){var scrollTop=window.scrollY;if(scrollTop>stickyOffsetTop-topSpace){if(getStickyHeight()<=$window.innerHeight-topSpace){setStyle(sticky,{top:topSpace+"px",left:stickyOffsetLeft+"px",bottom:'',width:sticky.getBoundingClientRect().width+"px",position:'fixed'})}else{if(scrollTop>lastScrollVal){if(topFixed){var absoluteStickyOffsetTop=getOffset(sticky).top;setStyle(sticky,{top:absoluteStickyOffsetTop-getOffset(container).top+"px",left:'',bottom:'',width:'',position:'absolute'});topFixed=false}if(scrollTop>stickyOffsetBottom-$window.innerHeight){setStyle(sticky,{top:'',left:stickyOffsetLeft+"px",bottom:bottomSpace+"px",width:sticky.getBoundingClientRect().width+"px",position:'fixed'});bottomFixed=true}}else{var absoluteStickyOffsetTop=getOffset(sticky).top;if(bottomFixed){setStyle(sticky,{top:absoluteStickyOffsetTop-getOffset(container).top+"px",left:'',bottom:'',width:'',position:'absolute'});bottomFixed=false}if(scrollTop<absoluteStickyOffsetTop-topSpace){setStyle(sticky,{top:topSpace+"px",left:stickyOffsetLeft+"px",bottom:'',width:sticky.getBoundingClientRect().width+"px",position:'fixed'});topFixed=true}}lastScrollVal=scrollTop}}else{destroySticky(sticky)}})}

// Put an offset on top if admin bar is visible
if ( document.body.classList.contains( 'admin-bar' ) && 768 < getWidth() ) {
	var topMargin = 32;
} else if ( document.body.classList.contains( 'admin-bar' ) ) {
	var topMargin = 46;
} else {
	var topMargin = 0;
}

simpleStickySidebar( '.site-header-wrap', {
	container: '.site-wrap',
	topSpace: topMargin,
	bottomSpace: 0
} );
