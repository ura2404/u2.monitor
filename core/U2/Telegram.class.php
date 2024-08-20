<?php

namespace U2;
use \U2\Exception as ex;

class Telegram {
  static $CONNECT;

  private Tg\Bot $Bot;
  private Config $Config;
  private  ?bool $IsWebHook;

  //private $Connect;
  //private $Updates = [];

  // --------------------------------------------------------------------------
  function __construct(Config $Config){
    $this->Config    = $Config;
    $this->IsWebHook = $Config->getValue('isWebHook');

    $this->Bot = new Tg\Bot();

    self::$CONNECT = new Connect( $Config );
  }

  // --------------------------------------------------------------------------
  function __get($name){
    switch($name){
      case 'IsWebHook' : return $this->IsWebHook;
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
  // -- WebHook ---------------------------------------------------------------
  // --------------------------------------------------------------------------
  private function getMyIsWebHook(){
    $WebHookInfo = $this->Bot->getWebhookInfo();
    return ( $WebHookInfo['ok'] && $WebHookInfo['result'] && strlen($WebHookInfo['result']['url']) );
  }

  // --------------------------------------------------------------------------
  public function checkWebHookSecret(): bool {
    $SecretToken = isset( $_SERVER['HTTP_X_TELEGRAM_BOT_API_SECRET_TOKEN'] ) ? $_SERVER['HTTP_X_TELEGRAM_BOT_API_SECRET_TOKEN'] : null;
    return $this->Config->getValue('secretToken') == $SecretToken;
  }

  // --------------------------------------------------------------------------
  public function setWebHook(): array {
    $s1 = md5(rand(1,999999).time().microtime());
    $s2 = md5(rand(1,999999).time().microtime());

    $this->Config->setValue( 'secretToken', $s1 . '-' . $s2 );

    $Webhook = new Tg\Webhook([
      'url'          => $this->Config->getValue('webhookUrl'),
      'secret_token' => $this->Config->getValue('secretToken'),
    ]);

    return $this->Bot->setWebHook($Webhook->Data);
  }

  // --------------------------------------------------------------------------
  public function deleteWebHook(): array {
    return $this->Bot->deleteWebHook();
  }

  // --------------------------------------------------------------------------
  // -- AboutMe ---------------------------------------------------------------
  // --------------------------------------------------------------------------
  public function aboutMe( ): ?array {
    return $this->Bot->sendMessage( $Params );
  }

  
  // --------------------------------------------------------------------------
  // -- Updates ---------------------------------------------------------------
  // --------------------------------------------------------------------------
  public function getUpdates(bool $IsPurge=false): array {
    $Connect = new Connect( new Config() );

    if($this->IsWebHook){
      $Responce = $this->Bot->getUpdate();
      return $Responce;
    }
    else{
      $Responce = $this->Bot->getUpdates($IsPurge);
      return $Responce;
    }
  }

  // --------------------------------------------------------------------------
  // -- Keyboard --------------------------------------------------------------
  // --------------------------------------------------------------------------
  public function createInlineKeyboard( string $Name, array $Keyboard ): array {
    $Markup = new Tg\InlineKeyboardMarkup([
      'inline_keyboard' => $Keyboard
    ]);

    $Config = new Config(ROOT.'/keyboard.json');
    $Config->setValue($Name, $Markup->Keyboard);

    return $Markup->Keyboard;
  }

  // --------------------------------------------------------------------------
  // -- Message ---------------------------------------------------------------
  // --------------------------------------------------------------------------
  public function sendMessage( array $Params ): ?array {
    return $this->Bot->sendMessage( $Params );
  }

  // --------------------------------------------------------------------------
  public function deleteMessage(array $Params ): ?array {
    return $this->Bot->deleteMessage( $Params );
  }

  // --------------------------------------------------------------------------
  public function editMessageText( Tg\Message $Message, array $Params ): ?array{
    if (
      ( !empty($Params['text'])         && ( strip_tags( $Params['text'] ) == $Message->Text  ) ) &&
      ( !empty($Params['reply_markup']) && ( $Params['reply_markup']       == $Message->ReplyMarkup->Data ) )
    ) return null;

    return $this->Bot->editMessageText( [
      'chat_id' 	   => $Message->Chat->Id,
      'message_id'   => $Message->Id,
      'text'         => $Params['text'],
      'parse_mode'   => 'HTML',
      'reply_markup' => empty($Params['reply_markup']) ? json_encode( $Message->ReplyMarkup->Data ) : json_encode( $Params['reply_markup'] ),
    ] );
  }

}
?>
