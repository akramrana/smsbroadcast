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
        <div class="col-md-6">  
            <?=
            $form->field($model, 'client_id')->dropDownList(\app\helpers\AppHelper::getAllClients(), [
                'prompt' => 'Please Select',
                'class' => 'form-control'
            ])
            ?> 
        </div>
        <span class="clearfix">&nbsp;</span>
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
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$js = "var newSourceUrl = baseUrl + 'client-campaign/get-numbers';
       jQuery(function ($) {
            var table = $('#phone-listing').DataTable({
                'destroy': true,
                'searching': false,
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
                             var client_number_id = $('<div/>').text(data).html();
                             return '<input type=\"checkbox\" name=\"phone_number[]\" value=\"' + client_number_id + '\">';
                         }
                }],
                'order': [[1, 'asc']],
                'lengthMenu': [[25, 50, 100], [25, 50, 100]],
                'pageLength': 25
            });
            // Handle click on \"Select all\" control
            $('#phone-select-all').on('click', function(){
               // Get all rows with search applied
               var rows = table.rows({ 'search': 'applied' }).nodes();
               // Check/uncheck checkboxes for all rows in the table
               $('input[type=\"checkbox\"]', rows).prop('checked', this.checked);
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
