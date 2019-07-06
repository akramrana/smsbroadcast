<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 28-03-2017
 * Time: 09:22
 */

namespace app\models;

use Yii;
use yii\base\Model;

class PasswordForm extends Model {

    public $oldPass;
    public $newPass;
    public $repeatNewPass;
    public $business_name;
    public $representative_name;
    public $business_address;

    //public $country_id;

    public function rules() {
        return [
            ['oldPass', 'findPasswords'],
            [['newPass'], 'string', 'min' => 6],
            [['business_name', 'representative_name','business_address'], 'required'],
            //['newPass', 'match', 'pattern' => '$\S*(?=\S{6,})(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$', 'message' => 'Password should contain at least one upper case letter, one number and one special character'],
            ['repeatNewPass', 'compare', 'compareAttribute' => 'newPass', 'message' => 'Confirm password must match new password.'],
        ];
    }

    public function findPasswords($attribute, $params) {
        $user = \Yii::$app->user->identity;
        $password = $user->password;

        if (!$user->validatePassword($this->oldPass))
            $this->addError($attribute, 'Incorrect password');
    }

}
