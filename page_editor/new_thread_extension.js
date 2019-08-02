jQuery.cachedSyncScript = function (url, options) {
    
    options = $.extend( options || {}, {
        dataType: "script",
        async: false,
        cache: true,
        url: url
    });
    
    return jQuery.ajax(options);
};

jQuery.loadPageData = function (data, success, dataType, error) {
    
    options = $.extend( {}, {
        url:'page_editor/ajax/new_thread_load_content.php',
        data: data,
        dataType: dataType || "json",
        type: "post",
        cache: false,
        success: success,
        error: error
    });
    
    return jQuery.ajax(options);
};

jQuery.savePageData = function (data, success, dataType, error) {
    
    options = $.extend( {}, {
        url: 'page_editor/ajax/new_thread_save_content.php',
        data: data,
        dataType: dataType || "json",
        type: "post",
        cache: false,
        success: success,
        error: error
    });
    
    return jQuery.ajax(options);
};

jQuery.getStylesheet = function (url) {
    
    var obj = $( '<link/>', {
        href: url,
        rel: 'stylesheet'
    }).appendTo('head');
    
    return obj;
};

function getQueryVariable(variable)
{
	var query = window.location.search.substring(1);
	var vars = query.split("&");
	for (var i=0;i<vars.length;i++) {
		var pair = vars[i].split("=");
		if(pair[0] == variable){return pair[1];}
	}
	return(false);
}

function setCookie(cname, cvalue)
{
    var d = new Date();
    d.setTime(d.getTime() + (365 * 24 * 60 * 60 * 1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname)
{
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
