<?php

namespace U2;
use \U2\Exception as ex;

class Connect {
  private $Config;
  private $BaseUrl;

  // --------------------------------------------------------------------------
  function __construct(Config $Config){
    $this->Config = $Config;
    $this->BaseUrl = 'https://api.telegram.org/bot' . $this->Config->getValue('telegramToken') . '/';
  }

  // --------------------------------------------------------------------------
  function __get($name){
    switch($name){
      default : throw new ex\Property($this, $name);
    }
  }

  // --------------------------------------------------------------------------
  // --------------------------------------------------------------------------
  public function post($Method, array $Params=null): array {
    $Url = $this->BaseUrl. $Method. ( empty($Params) ? null : '?' . http_build_query($Params) );
    $Responce = json_decode( file_get_contents($Url), JSON_OBJECT_AS_ARRAY );
    return $Responce;
  }
}
?>
