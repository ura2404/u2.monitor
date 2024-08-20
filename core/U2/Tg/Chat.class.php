<?php

namespace U2\Tg;
use \U2\Exception as ex;

/**
 * Class U2\Tg\Chat
 * 
 * @url https://core.telegram.org/bots/api#chat
 */

class Chat {
  public  int    $Id;      // Unique identifier for this chat. This number may have more than 32 significant bits and some programming languages may have difficulty/silent defects in interpreting it. But it has at most 52 significant bits, so a signed 64-bit integer or double-precision float type are safe for storing this identifier.
  public  string $Type;    // Type of the chat, can be either “private”, “group”, “supergroup” or “channel”
  public ?string $Title;   // Optional. Title, for supergroups, channels and group chats
  public ?bool   $IsForum; // Optional. True, if the supergroup chat is a forum (has topics enabled)
  public ?USer   $User;
    
  // --------------------------------------------------------------------------
  function __construct(array $Chat){
    $this->Id      = $Chat['id'];
    $this->Type    = $Chat['type'];
    $this->Title   = isset($Chat['title'])    ? $Chat['title']    : null;
    $this->IsForum = isset($Chat['is_forum']) ? $Chat['is_forum'] : null;
    $this->User    = new User($Chat);
  }

  // --------------------------------------------------------------------------
  function __get($name){
    switch($name){
      default : throw new ex\Property($this, $name);
    }
  }

}
?>
