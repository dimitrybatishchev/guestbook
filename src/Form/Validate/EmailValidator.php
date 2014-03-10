<?php
/**
 * Created by PhpStorm.
 * User: dimit_000
 * Date: 2/2/14
 * Time: 7:24 PM
 */

namespace Form\Validate;


class EmailValidator extends Validator{

    /*
     *
     */
    public function validate($email){
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->setError('Email is not correct');
            return false;
        }
        return true;
    }

} 