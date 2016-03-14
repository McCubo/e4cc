function isValidCallback(form_id, errors, event) {
    $("#" + form_id).find(".has-error").find(".control-label").remove();
    $("#" + form_id).find(".has-error").removeClass("has-error");
    if (errors.length > 0) {
        for (key in errors) {
            var element = $("#" + errors[key].id);
            var parent = element.parent("div");
            parent.addClass("has-error");
            if (errors[key].message.length > 0) {
                parent.prepend("<label class='control-label' for='" + errors[key].id + "'>" + errors[key].message + "</label>");
            }
        }
    }
}

function loadContent(container_id, url) {
    $("#" + container_id).load(url);
}