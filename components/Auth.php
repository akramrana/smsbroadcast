<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\components;

use Yii;

/**
 * Description of Auth
 *
 * @author Akram Hossain <akram.hossain@lezasolutions.com>
 */
class Auth {

    //put your code here
    public $admin_menu = [
        '/admin/index',
        '/client/index',
        '/client-campaign/index',
        '/client-number/index',
        '/client-subscription/index',
    ];
    
    public $client_menu = [
        '/client-campaign/index',
        '/client-number/index',
        '/client-subscription/index',
        '/profile/edit',
    ];

    public function checkAccess($role, $menu = '', $controller = null) {
        if ($role == 1) {
            if (in_array($menu, $this->admin_menu)) {
                return true;
            } else {
                return false;
            }
        } 
        else if ($role == 2) {
            if (in_array($menu, $this->client_menu)) {
                return true;
            } else {
                return false;
            }
        } 
        else {
            return false;
        }
    }

}
