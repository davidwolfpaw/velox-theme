// as the page loads, call these scripts
jQuery(document).ready(function($) {
  (function($) {
    "use strict";

    /* Get viewport width */
    var responsive_viewport = $(window).width();

    let siteTop = 0;
    const alignWideBlocks = document.querySelectorAll(".alignwide");
    const alignFullBlocks = document.querySelectorAll(".alignfull");
    const coverImageBlocks = document.querySelectorAll(".wp-block-cover-image");

    if ($(".primary-sidebar").length) {
      const sidebar = $(".primary-sidebar");
      let sidebarTop = sidebar.position().top;
      let sidebarBottom = sidebarTop + sidebar.outerHeight(true);
    }

    function getPosition(element) {
      var yPosition = 0;

      while (element) {
        yPosition += element.offsetTop - element.scrollTop + element.clientTop;
        element = element.offsetParent;
      }

      return yPosition;
    }

    $(".site-header-wrap").stick_in_parent({
      offset_top: 48,
      spacer: false
    });

    function fadeSidebarOnScroll() {
      siteTop = $(window).scrollTop();

      alignWideBlocks.forEach(element => {
        const alignWide = $(element);
        const alignWideTop = alignWide.position().top;
        const alignWideBottom = alignWide.position().top + alignWide.outerHeight(true);
        let dalignWideTop = alignWideTop - siteTop;
        let dalignWideBottom = alignWideBottom - siteTop;

        if (sidebarBottom > dalignWideTop) {
          sidebar.addClass("fade-out");
        } else if (sidebarBottom < dalignWideTop) {
          sidebar.removeClass("fade-out");
        }
      });
    }

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

    // Display article progress bar if activated
    if (true == velox_options.progress_bar) {
      $("body.single").prognroll({
        color: "#" + velox_options.link_color
      });
    }

    // Allow nightmode if activated.
    if (true == velox_options.night_mode) {
      $("#night-mode").on("click", function() {
        $(document.body).toggleClass("night-mode");
      });
    }
  })(jQuery);
}); /* end of as page load scripts */

/**
 * Sticky Menu Header
 *
 * Handles whether the header and header menu are sticky or not
 */
jQuery(document).ready(function($) {
  (function($) {
    "use strict";

    /* Get viewport width */
    var responsive_viewport = $(window).width();

    const siteHeader = $(".site-header");
    const siteHeaderTop = $(".site-header-content");
    const siteNavigation = $(".site-navigation");
    const siteContent = $(".site-content");
    let headerHeight = siteHeader.height();

    // Set scrolling variables
    let scrolling = false;
    let previousTop = 0;
    let currentTop = 0;
    let scrollDelta = 1;
    let scrollOffset = 50;

    if ("top" === sideOrTop()) {
      // Push the site content below the fixed header.
      siteContent.css("margin-top", headerHeight);

      calculateHeaderTop();
    }

    $(window).on("resize", function() {
      headerHeight = siteHeader.height();
    });

    $(window).on("scroll", function() {
      if (!scrolling) {
        scrolling = true;
        !window.requestAnimationFrame ? setTimeout(autoHideHeader, 250) : requestAnimationFrame(autoHideHeader);
      }
    });

    function calculateHeaderTop() {
      // Calculate the current distance to the top of the document.
      currentTop = $(window).scrollTop();

      // If we're at the top of the document, add a class to the header.
      if (0 === currentTop) {
        siteHeader.addClass("top");
      } else {
        siteHeader.removeClass("top");
      }
    }

    function sideOrTop() {
      // If header is on the side and screen is wide enough, ignore header stickiness.
      if (("side" === velox_options.header_location && responsive_viewport < 768) || "top" === velox_options.header_location) {
        return "top";
      } else {
        return "side";
      }
    }

    function autoHideHeader() {
      calculateHeaderTop();

      if ("top" === sideOrTop()) {
        if (true == velox_options.hide_header && true == velox_options.hide_header_menu) {
          hideHeaderAndMenu(currentTop);
        } else if (true == velox_options.hide_header || responsive_viewport < 768) {
          hideHeader(currentTop);
        } else if (true == velox_options.hide_header_menu) {
          hideMenu(currentTop);
        }
      } else if ("side" === sideOrTop()) {
        if (true == velox_options.hide_header) {
          sideHide(currentTop);
        }
      }

      previousTop = currentTop;
      scrolling = false;
    }

    function hideHeaderAndMenu(currentTop) {
      // Header menu and header hides on scroll
      if (previousTop - currentTop > scrollDelta) {
        // Scrolling up.
        siteHeader.removeClass("is-hidden");
      } else if (currentTop - previousTop > scrollDelta && currentTop > scrollOffset) {
        // Scrolling down.
        siteHeader.addClass("is-hidden");
      }
    }

    function hideHeader(currentTop) {
      // Header menu is sticky on scroll
      var secondaryNavOffsetTop = siteNavigation.height() - siteHeader.height();

      if (previousTop >= currentTop) {
        // Scrolling up.
        if (currentTop < secondaryNavOffsetTop) {
          siteHeader.removeClass("is-hidden");
          siteNavigation.removeClass("fixed");
        } else if (previousTop - currentTop > scrollDelta) {
          siteHeader.removeClass("is-hidden");
          siteNavigation.addClass("fixed");
        }
      } else {
        // Scrolling down.
        if (currentTop > secondaryNavOffsetTop + scrollOffset) {
          // Hide navigation.
          siteHeader.addClass("is-hidden");
          siteNavigation.addClass("fixed");
        } else if (currentTop > secondaryNavOffsetTop) {
          // Once the secondary nav is fixed, do not hide primary nav if you haven't scrolled more than scrollOffset.
          siteHeader.removeClass("is-hidden");
          siteNavigation.addClass("fixed");
        }
      }
    }

    function hideMenu(currentTop) {
      // Header menu is hidden on scroll.
      var secondaryNavOffsetTop = siteNavigation.height() - siteHeader.height();

      if (previousTop >= currentTop) {
        // Scrolling up.
        if (currentTop < secondaryNavOffsetTop) {
          // Secondary nav is not fixed.
          siteNavigation.removeClass("is-hidden");
        } else if (previousTop - currentTop > scrollDelta) {
          // Secondary nav is fixed.
          siteNavigation.removeClass("is-hidden");
        }
      } else {
        // Scrolling down.
        if (currentTop > secondaryNavOffsetTop + scrollOffset) {
          // Hide header navigation.
          siteNavigation.addClass("is-hidden");
        } else if (currentTop > secondaryNavOffsetTop) {
          siteNavigation.removeClass("is-hidden");
        }
      }
    }

    function sideHide(currentTop) {
      // Header menu and header hides on scroll
      if (previousTop - currentTop > scrollDelta) {
        // Scrolling up.
        siteHeader.removeClass("fade");
      } else if (currentTop - previousTop > scrollDelta && currentTop > scrollOffset) {
        // Scrolling down.
        siteHeader.addClass("fade");
      }
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
 * File skip-link-focus-fix.js.
 * Helps with accessibility for keyboard only users.
 * Learn more: https://git.io/vWdr2
 */
/(trident|msie)/i.test(navigator.userAgent) &&
  document.getElementById &&
  window.addEventListener &&
  window.addEventListener(
    "hashchange",
    function() {
      var t,
        e = location.hash.substring(1);
      /^[A-z0-9_-]+$/.test(e) && (t = document.getElementById(e)) && (/^(?:a|select|input|button|textarea)$/i.test(t.tagName) || (t.tabIndex = -1), t.focus());
    },
    !1
  );

/* PrognRoll | https://mburakerman.github.io/prognroll/ | @mburakerman | License: MIT */
!(function(n) {
  n.fn.prognroll = function(o) {
    var e = n.extend({ height: 5, color: "#50bcb6", custom: !1 }, o);
    return this.each(function() {
      if (n(this).data("prognroll")) return !1;
      n(this).data("prognroll", !0);
      var o = n("<span>", { class: "progress-bar" });
      n("body").prepend(o),
        o.css({ position: "fixed", top: 0, left: 0, width: 0, height: e.height, backgroundColor: e.color, zIndex: 9999999 }),
        !1 === e.custom
          ? n(window).scroll(function(o) {
              o.preventDefault();
              var t = n(window).scrollTop(),
                r = n(window).outerHeight(),
                i = (t / (n(document).height() - r)) * 100;
              n(".progress-bar").css("width", i + "%");
            })
          : n(this).scroll(function(o) {
              o.preventDefault();
              var t = n(this).scrollTop(),
                r = n(this).outerHeight(),
                i = (t / (n(this).prop("scrollHeight") - r)) * 100;
              n(".progress-bar").css("width", i + "%");
            });
      var t = n(window).scrollTop(),
        r = n(window).outerHeight(),
        i = (t / (n("body").outerHeight() - r)) * 100;
      n(".progress-bar").css("width", i + "%");
    });
  };
})(jQuery);

/*
 Sticky-kit v1.1.3 | MIT | Leaf Corcoran 2015 | http://leafo.net
*/
(function() {
  var c, f;
  c = window.jQuery;
  f = c(window);
  c.fn.stick_in_parent = function(b) {
    var A, w, J, n, B, K, p, q, L, k, E, t;
    null == b && (b = {});
    t = b.sticky_class;
    B = b.inner_scrolling;
    E = b.recalc_every;
    k = b.parent;
    q = b.offset_top;
    p = b.spacer;
    w = b.bottoming;
    null == q && (q = 0);
    null == k && (k = void 0);
    null == B && (B = !0);
    null == t && (t = "is_stuck");
    A = c(document);
    null == w && (w = !0);
    L = function(a) {
      var b;
      return window.getComputedStyle
        ? ((a = window.getComputedStyle(a[0])),
          (b = parseFloat(a.getPropertyValue("width")) + parseFloat(a.getPropertyValue("margin-left")) + parseFloat(a.getPropertyValue("margin-right"))),
          "border-box" !== a.getPropertyValue("box-sizing") &&
            (b += parseFloat(a.getPropertyValue("border-left-width")) + parseFloat(a.getPropertyValue("border-right-width")) + parseFloat(a.getPropertyValue("padding-left")) + parseFloat(a.getPropertyValue("padding-right"))),
          b)
        : a.outerWidth(!0);
    };
    J = function(a, b, n, C, F, u, r, G) {
      var v, H, m, D, I, d, g, x, y, z, h, l;
      if (!a.data("sticky_kit")) {
        a.data("sticky_kit", !0);
        I = A.height();
        g = a.parent();
        null != k && (g = g.closest(k));
        if (!g.length) throw "failed to find stick parent";
        v = m = !1;
        (h = null != p ? p && a.closest(p) : c("<div />")) && h.css("position", a.css("position"));
        x = function() {
          var d, f, e;
          if (
            !G &&
            ((I = A.height()),
            (d = parseInt(g.css("border-top-width"), 10)),
            (f = parseInt(g.css("padding-top"), 10)),
            (b = parseInt(g.css("padding-bottom"), 10)),
            (n = g.offset().top + d + f),
            (C = g.height()),
            m && ((v = m = !1), null == p && (a.insertAfter(h), h.detach()), a.css({ position: "", top: "", width: "", bottom: "" }).removeClass(t), (e = !0)),
            (F = a.offset().top - (parseInt(a.css("margin-top"), 10) || 0) - q),
            (u = a.outerHeight(!0)),
            (r = a.css("float")),
            h && h.css({ width: L(a), height: u, display: a.css("display"), "vertical-align": a.css("vertical-align"), float: r }),
            e)
          )
            return l();
        };
        x();
        if (u !== C)
          return (
            (D = void 0),
            (d = q),
            (z = E),
            (l = function() {
              var c, l, e, k;
              if (
                !G &&
                ((e = !1),
                null != z && (--z, 0 >= z && ((z = E), x(), (e = !0))),
                e || A.height() === I || x(),
                (e = f.scrollTop()),
                null != D && (l = e - D),
                (D = e),
                m
                  ? (w && ((k = e + u + d > C + n), v && !k && ((v = !1), a.css({ position: "fixed", bottom: "", top: d }).trigger("sticky_kit:unbottom"))),
                    e < F &&
                      ((m = !1),
                      (d = q),
                      null == p && (("left" !== r && "right" !== r) || a.insertAfter(h), h.detach()),
                      (c = { position: "", width: "", top: "" }),
                      a
                        .css(c)
                        .removeClass(t)
                        .trigger("sticky_kit:unstick")),
                    B && ((c = f.height()), u + q > c && !v && ((d -= l), (d = Math.max(c - u, d)), (d = Math.min(q, d)), m && a.css({ top: d + "px" }))))
                  : e > F &&
                    ((m = !0),
                    (c = { position: "fixed", top: d }),
                    (c.width = "border-box" === a.css("box-sizing") ? a.outerWidth() + "px" : a.width() + "px"),
                    a.css(c).addClass(t),
                    null == p && (a.after(h), ("left" !== r && "right" !== r) || h.append(a)),
                    a.trigger("sticky_kit:stick")),
                m && w && (null == k && (k = e + u + d > C + n), !v && k))
              )
                return (v = !0), "static" === g.css("position") && g.css({ position: "relative" }), a.css({ position: "absolute", bottom: b, top: "auto" }).trigger("sticky_kit:bottom");
            }),
            (y = function() {
              x();
              return l();
            }),
            (H = function() {
              G = !0;
              f.off("touchmove", l);
              f.off("scroll", l);
              f.off("resize", y);
              c(document.body).off("sticky_kit:recalc", y);
              a.off("sticky_kit:detach", H);
              a.removeData("sticky_kit");
              a.css({ position: "", bottom: "", top: "", width: "" });
              g.position("position", "");
              if (m) return null == p && (("left" !== r && "right" !== r) || a.insertAfter(h), h.remove()), a.removeClass(t);
            }),
            f.on("touchmove", l),
            f.on("scroll", l),
            f.on("resize", y),
            c(document.body).on("sticky_kit:recalc", y),
            a.on("sticky_kit:detach", H),
            setTimeout(l, 0)
          );
      }
    };
    n = 0;
    for (K = this.length; n < K; n++) (b = this[n]), J(c(b));
    return this;
  };
}.call(this));
