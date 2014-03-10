<?php
/**
 * Created by PhpStorm.
 * User: dimit_000
 * Date: 2/4/14
 * Time: 5:21 PM
 */

namespace Model;


abstract class MapperAbstract {

    abstract public function populate($obj, array $data);

} 