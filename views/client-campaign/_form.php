<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

\app\assets\DataTableAsset::register($this);
/* @var $this yii\web\View */
/* @var $model app\models\ClientCampaigns */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="client-campaigns-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <?php
        if (\Yii::$app->session['_smsbroadcastAuth'] == 1) {
            ?>
            <div class="col-md-6">  
                <?=
                $form->field($model, 'client_id')->dropDownList(\app\helpers\AppHelper::getAllClients(), [
                    'prompt' => 'Please Select',
                    'class' => 'form-control',
                    'onchange' => 'app.changeClientNumberList(this.value)'
                ])
                ?> 
            </div>
            <span class="clearfix">&nbsp;</span>
            <?php
        }
        ?>
        <div class="col-md-6">  
            <?= $form->field($model, 'campaign_name')->textInput(['maxlength' => true]) ?> 

            <?= $form->field($model, 'message')->textarea(['rows' => 6, 'maxlength' => 140]) ?> 
        </div>
        <div class="col-md-6">  
            <?= $form->field($model, 'from_number')->textInput(['maxlength' => true]) ?> 
        </div>
        <span class="clearfix">&nbsp;</span>
        <div class="col-md-12">
            <label class="control-label" for="">Phone Number</label>
            <?php
            echo $form->field($model, 'phone_numbers')->hiddenInput()->label(false);
            ?>
            <hr/>
            <table id="phone-listing" class="display select table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>
                            <input name="select_all" value="1" id="phone-select-all" type="checkbox">
                        </th>
                        <th>Phone Number</th>
                        <th>Name</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div id="dynamicElement">
        <div id="phoneElement">
            <?php
            if (!$model->isNewRecord) {
                if (!empty($model->clientCampaignNumbers)) {
                    foreach ($model->clientCampaignNumbers as $ccn) {
                        ?>
                        <input id="phone_number_<?php echo $ccn->client_number_id; ?>" type="hidden" name="ClientCampaignNumbers[client_number_id][]" value="<?php echo $ccn->client_number_id; ?>"/>
                        <?php
                    }
                }
            }
            ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$phoneNumberIds = 0;
if (!$model->isNewRecord) {
    if (!empty($model->clientCampaignNumbers)) {
        $numberList = [];
        foreach ($model->clientCampaignNumbers as $ccn) {
            array_push($numberList, $ccn->client_number_id);
            $phoneNumberIds = implode(',', $numberList);
        }
    }
}
$js = "var phoneNumberId = [" . $phoneNumberIds . "];
       jQuery(function ($) {
            var client_id = $('#clientcampaigns-client_id').val(); 
            var newSourceUrl = baseUrl + 'client-campaign/get-numbers?client_id='+client_id;
            var table = $('#phone-listing').DataTable({
                'destroy': true,
                'searching': true,
                'processing': true,
                'serverSide': true,
                'ajax': {
                    'url': newSourceUrl
                },
                'bSort': false,
                'columnDefs': [{
                        'targets': 0,
                        'searchable': false,
                        'orderable': false,
                        'className': 'dt-body-left',
                        'render': function (data, type, full, meta){
                             $('#phoneElement input').each(function(i,v){
                                var selectedVal = parseInt(v.value);
                                //console.log(selectedVal);
                                if(jQuery.inArray(selectedVal, phoneNumberId) ==-1){
                                   phoneNumberId.push(selectedVal);
                                }
                             });
                             var client_number_id = $('<div/>').text(data).html();
                             var checkId = parseInt(client_number_id);
                             var str = '';
                             if(jQuery.inArray(checkId, phoneNumberId) !==-1){
                               str = 'checked=\"checked\"';
                               $('#clientcampaigns-phone_numbers').val(1).blur();
                             }
                             return '<input '+str+' type=\"checkbox\" value=\"' + client_number_id + '\">';
                         }
                }],
                'order': [[1, 'asc']],
                'lengthMenu': [[10, 25, 50, 100], [10, 25, 50, 100]],
                'pageLength': 10
            });
            // Handle click on \"Select all\" control
            $('#phone-select-all').on('click', function(){
               // Get all rows with search applied
               var rows = table.rows({ 'search': 'applied' }).nodes();
               // Check/uncheck checkboxes for all rows in the table
               $('input[type=\"checkbox\"]', rows).prop('checked', this.checked);
               if ($('#phone-select-all').is(':checked')) {
                    $('#phone-listing tbody :checkbox:checked').each(function (i) {
                        var hasIdTop = $('#phoneElement').find('#phone_number_'+$(this).val()).length;
                        if(hasIdTop < 1){
                            var htm = '<input id=\"phone_number_'+$(this).val()+'\" type=\"hidden\" name=\"ClientCampaignNumbers[client_number_id][]\" value=\"'+$(this).val()+'\"/>';
                            $('#phoneElement').append(htm);
                        }
                    })
                    $('#clientcampaigns-phone_numbers').val(1).blur();
                }
                else{
                     $('#phone-listing tbody input[type=checkbox]').each(function (i,v) {
                          phId = $(this).val();
                          $('#phone_number_'+phId).remove();
                          phoneNumberId.splice($.inArray(phId, phoneNumberId), 1);
                     });
                     var phoneNumLen = $('#phoneElement input[type=hidden]').length;
                     if(phoneNumLen < 1)
                     {
                        $('#clientcampaigns-phone_numbers').val('').blur();
                     }
                }
            });

            // Handle click on checkbox to set state of \"Select all\" control
            $('#phone-listing tbody').on('change', 'input[type=\"checkbox\"]', function(){
               var id = $(this).val();
               // If checkbox is not checked
               if(!this.checked){
                  var el = $('#phone-select-all').get(0);
                  // If \"Select all\" control is checked and has 'indeterminate' property
                  if(el && el.checked && ('indeterminate' in el)){
                     // Set visual state of \"Select all\" control 
                     // as 'indeterminate'
                     $('input[id=phone-select-all]').prop('checked', false);
                  }
                  $('#phone_number_'+id).remove();
                  phoneNumberId.splice($.inArray(id, phoneNumberId), 1);
                  //
                  var phoneNumLen = $('#phoneElement input[type=hidden]').length;
                  if(phoneNumLen < 1)
                  {
                      $('#clientcampaigns-phone_numbers').val('').blur();
                  }
               }
               else{
                    var hasId = $('#phoneElement').find('#phone_number_'+id).length;
                    if(hasId < 1)
                    {
                       var htm = '<input id=\"phone_number_'+id+'\" type=\"hidden\" name=\"ClientCampaignNumbers[client_number_id][]\" value=\"'+id+'\"/>';
                       $('#phoneElement').append(htm);
                    }
                    $('#clientcampaigns-phone_numbers').val(1).blur();
               }
               var checkboxLen = $('#phone-listing tbody input[type=checkbox]').length;
               var checkboxCheckedLen = $('#phone-listing tbody input[type=checkbox]:checked').length;
               if(checkboxLen===checkboxCheckedLen)
               {
                    $('input[id=phone-select-all]').prop('checked', true);
               }
            });
       });";
$this->registerJs($js, \yii\web\View::POS_END);
