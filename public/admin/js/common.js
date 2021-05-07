"use strict";

$(function () {
    var common = new Common();
    common.Notify();
});

function Common() {}

Common.prototype.Notify = function () {
    if (typeof _successMessage !== "undefined" && _successMessage !== "") {
        toastr.success(_successMessage);
    }

    if (typeof _errorMessage !== "undefined" && _errorMessage !== "") {
        toastr.error(_errorMessage);
    }

    if (typeof _warningMessage !== "undefined" && _warningMessage !== "") {
        toastr.warning(_warningMessage);
    }
};

Common.prototype.ProcessAjax = function (
    router,
    method,
    data,
    token,
    callbackSuccess = null,
    callbackError = null
) {
    $.ajax({
        url: router,
        type: method,
        data: {
            data: data,
            _token: token,
        },
        success: function (data) {
            if (!callbackSuccess) {
                if (typeof data.successMessage != "undefined" || typeof data.warningMessage != "undefined") {
                    _successMessage = data.successMessage;
                    _warningMessage = data.warningMessage;
                    Common.prototype.Notify();
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                } else {
                    _successMessage = '';
                    _warningMessage = '';
                    _errorMessage = data.errorMessage;
                    Common.prototype.Notify();
                    _errorMessage = '';
                }
                return;
            }
            return callbackSuccess(data);
        },
        error: function (response) {
            if (!callbackError) {
                const obj = JSON.parse(response.responseText);
                const errors = obj.errors;
                let messages = [];
                _successMessage = '';
                _warningMessage = '';
                for (let key in errors) {
                    if (Array.isArray(errors[key])) {
                        errors[key].forEach((value) => {
                            if (!messages.includes(value)) {
                                messages.push(value);
                            }
                        });
                    }
                }
                $.each(messages, function (index, message) {
                    _errorMessage = message;
                    Common.prototype.Notify();
                    _errorMessage = '';
                });
                return;
            }
            return callbackError(response);
        },
    });
};

function trans(key, replace = {}) {
    let translation = key.split('.').reduce((t, i) => t[i] || null, window.translations);

    for (var placeholder in replace) {
        translation = translation.replace(`:${placeholder}`, replace[placeholder]);
    }

    return translation;
}

Common.prototype.checkDisabledBtnSave = function() {
    const result = $('.table-checkable').find('input[type="text"]').toArray().findIndex((input) => {
        return $(input).prop('disabled') === false;
    })

    if (result > -1) {
        $('.btn-save').prop('disabled', false);
    } else {
        $('.btn-save').prop('disabled', true);
    }
}