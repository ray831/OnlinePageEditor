(function() {
    "use strict";
    $("body").tooltip({
        selector: "[title]"
    });
    $.ajaxSetup({
        url: "REPLACE WITH YOUR AJAX PHP FILE PATH",
        type: "POST",
        dataType: "JSON"
    });

    //your function here
})();