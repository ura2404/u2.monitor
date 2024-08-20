<?php

namespace U2\Tg;
use \U2\Exception as ex;

/**
 * Class U2\Tg\Update
 * 
 * @url https://core.telegram.org/bots/api#update
 */

class Update {
    public  int           $Id;            // The update's unique identifier. Update identifiers start from a certain positive number and increase sequentially. This identifier becomes especially handy if you're using webhooks, since it allows you to ignore repeated updates or to restore the correct update sequence, should they get out of order. If there are no new updates for at least a week, then identifier of the next update will be chosen randomly instead of sequentially.
    public ?Message       $Message;       // Optional. New incoming message of any kind - text, photo, sticker, etc.
    public ?CallbackQuery $CallbackQuery; // Optional. New incoming callback query

  // --------------------------------------------------------------------------
  function __construct(array $Update){
    $this->Id            = $Update['update_id'];
    $this->Message       = isset($Update['message'])        ? new Message($Update['message'])              : null;
    $this->CallbackQuery = isset($Update['callback_query']) ? new CallbackQuery($Update['callback_query']) : null;
  }

  // --------------------------------------------------------------------------
  function __get($name){
    switch($name){
      case 'isMessage'       : return !!$this->Message;
      case 'isCallbackQuery' : return !!$this->CallbackQuery;
      default : throw new ex\Property($this, $name);
    }
  }

  // --------------------------------------------------------------------------
  // --------------------------------------------------------------------------
  public function getMessage(){
    if($this->isMessage)       return $this->Message;
    if($this->isCallbackQuery) return $this->CallbackQuery->Message;
  }
}
?>
