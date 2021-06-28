function ajax(url, type, dataType, data, async, loading, callBack) {
    if (loading) $('.loader-wrapper').show();
    return $.ajax({
        url: url,
        type: type,
        dataType: dataType,
        data: data,
        async: async,
        success: function(response) {
            if (loading) $('.loader-wrapper').hide();
            return callBack(response);
        }
    }).responseText;
}

function redirect(url, target) {
    target = target || '_self';
    if (navigator.userAgent.match(/MSIE\s(?!9.0)/)) {
        var referLink = document.createElement('a');
        referLink.href = url;
        referLink.target = target;
        document.body.appendChild(referLink);
        referLink.click();
    } else {
        window.open(url, target);
    }
}

function switchLanguage(lang) {
    ajax("../switchLanguage.php", "POST", "json", ({ lang: lang }), true, false, function() {
        window.location.reload();
    });
}

function setCHKValue(chkid, chkValue) {
    var chk = document.getElementById(chkid);
    if (chk.value == chkValue.toString()) {
        chk.checked = true;
    } else {
        chk.checked = false;
    }
    return null;
}