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
        $('input[id=phone-select-all]').prop('checked', false);
        $("#phoneElement").html("");
        $('#phone-listing tbody input[type=checkbox]').prop('checked', false);
        phoneNumberId = [];
    },
    changeClientNumberListGroupWise: function (client_group_id) {
        var client_id = $("#clientcampaigns-client_id").val();
        if (client_id == null) {
            client_id = "";
        }
        var newSourceUrl = baseUrl + 'client-campaign/get-numbers?client_id=' + client_id + "&client_group_id=" + client_group_id;
        var oTable = $('#phone-listing').DataTable();
        oTable.ajax.url(newSourceUrl);
        oTable.draw();
        //
        $("#send-to-all-section").show();
        $('input[id=phone-select-all]').prop('checked', false);
        $("#phoneElement").html("");
        $('#phone-listing tbody input[type=checkbox]').prop('checked', false);
        phoneNumberId = [];
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
    },
    getClientGroupList: function (val, selector)
    {
        if ($.trim(val) != "")
        {
            $.ajax({
                type: "GET",
                url: baseUrl + 'client-number/get-groups',
                data: {
                    id: val
                },
                success: function (res) {
                    var obj = $.parseJSON(res);
                    //console.log(obj);
                    var options = '<option value="">Please Select</option>';
                    if (obj.length > 0 && obj != null)
                    {
                        $.each(obj, function (i, v) {
                            options += '<option value="' + v.id + '">' + v.name + '</option>';
                        })
                    }
                    $(selector).html(options);
                }
            });
        } else {
            $(selector).html('<option value="">Please Select</option>');
        }
    },
    showHidePhoneNumbers: function () {
        if ($('#clientcampaigns-sent_to_all').is(':checked')) {
            $("#phone-number-section").hide();
            $("#clientcampaigns-phone_numbers").val("1").blur();
            $("#phoneElement").html("");
            $('#phone-listing tbody input[type=checkbox]').prop('checked', false);
            phoneNumberId = [];
        } else {
            $("#phone-number-section").show();
            $("#clientcampaigns-phone_numbers").val("").blur();
            $('input[id=phone-select-all]').prop('checked', false);
            $("#phoneElement").html("");
            $('#phone-listing tbody input[type=checkbox]').prop('checked', false);
            phoneNumberId = [];
        }
    }
}

