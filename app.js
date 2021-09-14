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
        },
        error: function(response) {
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

function rand(min, max) {
    return parseInt(Math.random() * (max - min + 1), 10) + min;
}

function get_random_color() {
    var h = rand(1, 360); // color hue between 1 and 360
    var s = rand(50, 100); // saturation 30-100%
    var l = rand(30, 70); // lightness 30-70%
    return 'hsl(' + h + ',' + s + '%,' + l + '%)';
}