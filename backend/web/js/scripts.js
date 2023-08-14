function cloneElements(dupEle, frmEle, mainEle) {
    if ($("#" + dupEle).length) {
        var l = $("#" + dupEle).length + 1;
        $("#" + mainEle).clone().replace(frmEle, l).appendTo("#" + dupEle);
    }
}