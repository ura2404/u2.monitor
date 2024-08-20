<?php

namespace U2;
use \U2\Exception as ex;

class Keyboard {
  private $Name;
    
  // --------------------------------------------------------------------------
  function __construct(string $Name){
    $this->Name = $Name;
  }

  // --------------------------------------------------------------------------
  function __get($name){
    switch($name){
      case 'Data' : return $this->getMyData();
      default : throw new Exception( 'ERROR: property '. $name. ' of class '. get_class(). ' is not found' );
    }
  }

  // --------------------------------------------------------------------------
  private function getMyData(){
    $Config = new Config(ROOT.'/keyboard.json');
    return $Config->getValue($this->Name);
  }
}
?>
