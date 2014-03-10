<?php
/**
 * Created by PhpStorm.
 * User: dimit_000
 * Date: 2/2/14
 * Time: 7:50 PM
 */

namespace Form\Sanitize;


class RemoveHtmlTagSanitizer extends Sanitizer{

    /*
     *
     */
    public function sanitize($content){
        return strip_tags($content, '<a><br><code><i><strike><strong>');
    }

} 