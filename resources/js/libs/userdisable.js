(function ($) {
    $.fn.disableSelection = function () {
        return this.attr("unselectable", "on")
            .css("user-select", "none")
            .on("selectstart dragstart", false);
    };

    $(document)
        .on("contextmenu", function (event) {
            event.preventDefault();
        })
        .on("copy", function (e) {
            e.preventDefault();
            return false;
        });

    $("body").on("copy", function (e) {
        e.preventDefault();
        return false;
    });
})(jQuery);
