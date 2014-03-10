<?php
/**
 * Created by PhpStorm.
 * User: dimit_000
 * Date: 2/2/14
 * Time: 7:34 PM
 */

namespace Form\Validate;


class UrlValidator extends Validator {

    /*
     *
     */
    public function validate($url){
        if(!filter_var($url, FILTER_VALIDATE_URL)){
            $this->setError('Url is not correct');
            return false;
        }
        return true;
    }

} 