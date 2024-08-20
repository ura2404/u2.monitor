<?php
namespace U2\Exception;

class Config extends \U2\Exception{

    // --- --- --- --- --- --- ---
    public function __construct($config, $element) {
        $Message = 'U2 Error: config [' .$config->Description. '] element [' .$element. '] is not defined';
        parent::__construct($Message);
	}
}
?>