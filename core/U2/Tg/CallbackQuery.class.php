<?php

namespace U2\Tg;
use \U2\Exception as ex;

/**
 * Class U2\Tg\CallbackQuery
 * 
 * @url https://core.telegram.org/bots/api#callbackquery
 */

class CallbackQuery {
  public  string  $Id;              // String. Unique identifier for this query
  public ?User    $From;            // Sender
  public ?Message $Message;         // MaybeInaccessibleMessage. Optional. Message sent by the bot with the callback button that originated the query
  public ?string  $InlineMessageId; // Optional. Identifier of the message sent via the bot in inline mode, that originated the query.
  public ?string  $ChatInstance;    // Global identifier, uniquely corresponding to the chat to which the message with the callback button was sent. Useful for high scores in games.
  public ?string  $Data;            // Optional. Data associated with the callback button. Be aware that the message originated the query can contain no callback buttons with this data.
  public ?string  $GameShortName;   // Optional. Short name of a Game to be returned, serves as the unique identifier for the game

  // --------------------------------------------------------------------------
  function __construct(array $CallbackQuery){
    _log( ROOT.'/log/update00', $CallbackQuery );
    
    $this->Id              = $CallbackQuery['id'];
    $this->From            = isset($CallbackQuery['from'])              ? new User( $CallbackQuery['from'] )       : null;
    $this->Message         = isset($CallbackQuery['message'])           ? new Message( $CallbackQuery['message'] ) : null;
    $this->InlineMessageId = isset($CallbackQuery['inline_message_id']) ? $CallbackQuery['inline_message_id']      : null;
    $this->ChatInstance    = isset($CallbackQuery['chat_instance'])     ? $CallbackQuery['chat_instance']          : null;
    $this->Data            = isset($CallbackQuery['data'])              ? $CallbackQuery['data']                   : null;
    $this->GameShortName   = isset($CallbackQuery['game_short_name'])   ? $CallbackQuery['game_short_name']        : null;
  }

  // --------------------------------------------------------------------------
  function __get($name){
    switch($name){
      default : throw new ex\Property($this, $name);
    }
  }

}
?>
