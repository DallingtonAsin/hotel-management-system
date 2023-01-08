function Numberize(i) {
    $(document).on("keyup", i, function() {
        if (this.value.length > 0) {
            let n = parseInt(this.value.replace(/\D/g, ''), 10);
            $(this).val(n.toLocaleString());
        }
    });
}


function displayResponse(area, message, errorType = 'error') {
    $(area).notify(message, {
        className: errorType,
        autoHide: true,
        clickToHide: true,
        autoHideDelay: 5000,
    });
}