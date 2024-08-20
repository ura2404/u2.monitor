<?php

namespace App;
use Exception as ex;

class Application {
    static array $ACTIONS = [];
    private \U2\Telegram $Telegram;

  // --------------------------------------------------------------------------
  function __construct( \U2\Telegram $Telegram ){
    $this->Telegram = $Telegram;
  }

  // --------------------------------------------------------------------------
  function __get($name){
    switch($name){
      default : throw new ex\Property($this, $name);
    }
  }

  // --------------------------------------------------------------------------
  function __set($name, $value){
    switch($name){
      default : throw new ex\Property($this, $name);
    }
  }

  // --------------------------------------------------------------------------
  // --------------------------------------------------------------------------
  public function registryAction(string $Command, ?string $Data=null, $Action) {
    if( !isset(self::$ACTIONS[ $Command ]) ) self::$ACTIONS[ $Command ] = [];
    self::$ACTIONS[ $Command ][ $Data ] = $Action;
    return $this;
  }

  // --------------------------------------------------------------------------
  public function go(){
    foreach ($this->Telegram->getUpdates() as $Update){
      $Message = $Update->getMessage();
      $Text    = $Message->Text;
      $Data    = $Update->isCallbackQuery ? $Update->CallbackQuery->Data : null;
      
      $ChatId    = $Message->Chat->Id;
      $MessageId = $Message->Id;

      _log( ROOT.'/log/updates', $Update );      

      if( isset( self::$ACTIONS[ $Text ][ $Data ] ) ){
        $Action = self::$ACTIONS[ $Text ][ $Data ];

        if( $Action == '$aboutMe()' ) {
          $UserInfo = $Message->From->UserInfo;
          $Info = [
            '<b>Информация об аккаунте:</b>',
            '<blockquote expandable>'.$UserInfo['userName']."\n".$UserInfo['firstName'].' '.$UserInfo['lastName'].'</blockquote>'
          ];
          $D = [ 'text' => implode('',$Info) ] ;
        }
        elseif( get_class($Action) == 'App\Message') {
          $D = $Action->Data;
        }

        $this->Telegram->sendMessage( array_merge([
          'chat_id'      => $ChatId,
          'parse_mode'   => 'HTML',
        ], $D) ) ;
      }
      else $this->Telegram->deleteMessage( [
        'chat_id'    => $ChatId,
        'message_id' => $MessageId,
      ] );
    }
  }
}
?>
