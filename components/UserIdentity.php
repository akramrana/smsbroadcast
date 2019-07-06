<?php

namespace app\components;


class UserIdentity{

    const ROLE_ADMIN = 1;
    const ROLE_CLIENT = 2;
    const ROLE_GUEST = 3;

    public function init(){
        
    }

    static public function isUserAuthenticate($userrole) {
        
        if ($userrole==self::ROLE_ADMIN) {
            return true;
        }
        else {

            return false;
        }
    }

}
