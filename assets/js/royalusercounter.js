!(function () {
    "use strict";	
    function L(n, o) {
        n.find(".royalusercounter").each(function () {
            var n = o(this),
                a = n.children(".royal-uc-number"),
                e = n.data("roles"),
                t = n.find("#royal_user_counter_nonce");
            setInterval(function () {
                o.post(royalAjax.ajaxURL, { action: "royal_user_counter", roles: e, nonce: t.val() }, function (n, e, t) {
                    "success" == e && a.html(n);
                });
            }, 5e3);
        });
    }

    jQuery(window).on("elementor/frontend/init", function () {
            elementorFrontend.hooks.addAction("frontend/element_ready/royal_user_counter.default", L),
    });
})();
