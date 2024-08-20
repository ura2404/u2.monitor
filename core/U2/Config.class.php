<?php

namespace U2;
use \U2\Exception as ex;

class Config {
  private $Config;
  private $ConfigFilePath;
  public  $Description;

  // --------------------------------------------------------------------------
  function __construct($FilePath=ROOT.'/config.json'){
    $this->ConfigFilePath = $FilePath;
    $this->Config         = $this->get();
    $this->Description    = basename($this->ConfigFilePath);
  }

  // --------------------------------------------------------------------------
  function __get($name){
    switch($name){
      // case 'TelegramToken' : return $this->getMyTelegramToken();
      // case 'SecretToken'   : return $this->getMySecretToken();
      // case 'WebhookUrl'    : return $this->getMyWebhookUrl();
      // case 'LastUpdateId'  : return $this->getMyLastUpdateId();
      default : throw new ex\Property($this, $name);
    }
  }

  // --------------------------------------------------------------------------
  function __set($name, $value){
    switch($name){
      //case 'SecretToken' : return $this->setMySecretToken($value);
      default : throw new ex\Property($this, $name);
    }
  }

  // // --------------------------------------------------------------------------
  // // --------------------------------------------------------------------------
  // private function getMyTelegramToken(): string {
  //   return $this->Config['telegramToken'];
  // }

  // // --------------------------------------------------------------------------
  // private function getMySecretToken(): string {
  //   return $this->Config['secretToken'];
  // }

  // --------------------------------------------------------------------------
  // private function setMySecretToken($Value): void {
  //   // TODO:: добавить проверку $Value
  //   //        - есть ли хоть что-то
  //   //        - допустимые символы
  //   $this->Config['secretToken'] = $Value;
  //   $this->put();
  // }
  
  // // --------------------------------------------------------------------------
  // private function getMyWebhookUrl(): string {
  //   return $this->Config['webhookUrl'];
  // }

  // private function getMyLastUpdateId(): int {
  //   return isset($this->Config['lastUpdateId']) ? $this->Config['lastUpdateId'] : 0;
  // }

  // --------------------------------------------------------------------------
  private function get(): array {
    return file_exists($this->ConfigFilePath) ? json_decode( file_get_contents($this->ConfigFilePath), JSON_OBJECT_AS_ARRAY ) : [];
  }

  // --------------------------------------------------------------------------
  private function put(): void {
    file_put_contents( $this->ConfigFilePath, json_encode(
      $this->Config, JSON_PRETTY_PRINT           // форматирование пробелами
                   | JSON_UNESCAPED_SLASHES      // не экранировать '/'
                   | JSON_UNESCAPED_UNICODE      // не кодировать текст
    ));
  }

  // --------------------------------------------------------------------------
  // --------------------------------------------------------------------------
  public function setValue( $name, $value ): void {
    $this->Config[$name] = $value;
    $this->put();
  }

  // --------------------------------------------------------------------------
  public function getValue( $name ) {
    if ( !isset($this->Config[$name]) ) throw new ex\Config($this, $name);
    return $this->Config[ $name ];
  }

}
// {
//   "botId"         : "u2ddns_bot",
//   "webhookUrl"    : "https://ddns.u2.urx.su/webhook.php",
//   "telegramToken" : "7314278910:AAGPRvhrPKpiObIEDA8Oy4yNFDOJ5iQN6bA",
//   "secretToken"   : "ec8df00f9d3bbd4fa78c152c1ec3eee7-1a488d19b17d8dfcad788f84136c0404"
// }

?>
