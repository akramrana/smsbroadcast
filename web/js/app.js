/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var app = {
    changeClientNumberList: function (client_id) {
        var newSourceUrl = baseUrl + 'client-campaign/get-numbers?client_id=' + client_id;
        var oTable = $('#phone-listing').DataTable();
        oTable.ajax.url(newSourceUrl);
        oTable.draw();
    },
    validation: {
        checkPassword: function ()
        {
            var pass = $('#passwordform-newpass').val();

            if ($.trim(pass) != "")
            {
                app.validation.addvalidation("profile-edit", "passwordform-oldpass", "oldPass", ".field-passwordform-oldpass", "Old password cannot be blank.");
                app.validation.addvalidation("profile-edit", "passwordform-repeatnewpass", "repeatNewPass", ".field-passwordform-repeatnewpass", "Confirm password cannot be blank.");

            } else {
                app.validation.removeValidation("profile-edit", "passwordform-oldpass", ".field-passwordform-oldpass");
                app.validation.removeValidation("profile-edit", "passwordform-repeatnewpass", ".field-passwordform-repeatnewpass");
            }
        },
        addvalidation: function (form_id, id, name, container, message) {

            jQuery('#' + form_id).yiiActiveForm("add", {
                "id": id,
                "name": name,
                "container": container,
                "input": '#' + id,
                "error": '.help-block',
                "validate": function (attribute, value, messages, deferred) {
                    yii.validation.required(value, messages, {"message": message});
                }
            });
        },
        removeValidation: function (form_id, field_id, field_class) {
            $('#' + form_id).yiiActiveForm('remove', field_id);
            $(field_class).removeClass('has-error');
            $(field_class).addClass('has-success');
            $(field_class + " .help-block").html('');
        }
    }
}

