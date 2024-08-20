<?php

namespace App;
use Exception as ex;

class Message {
    private $Params;

  // --------------------------------------------------------------------------
  function __construct( $Params ){
    $this->Params = $Params;
  }

  // --------------------------------------------------------------------------
  function __get($name){
    switch($name){
      case 'Data' : return $this->Params;
      default : throw new ex\Property($this, $name);
    }
  }

  // --------------------------------------------------------------------------
  function __set($name, $value){
    switch($name){
      default : throw new ex\Property($this, $name);
    }
  }

}
?>
