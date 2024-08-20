<?php

namespace U2\Tg;
use \U2\Exception as ex;

/**
 * Class U2\Tg\User
 * 
 * @url https://core.telegram.org/bots/api#user
 * 
 * @properties 
 * - id                           Integer             Unique identifier for this user or bot. This number may have more than 32 significant bits and some programming languages may have difficulty/silent defects in interpreting it. But it has at most 52 significant bits, so a 64-bit integer or double-precision float type are safe for storing this identifier.
 * - is_bot                       Boolean             True, if this user is a bot
 * - first_name                   String              User's or bot's first name
 * - last_name                    String    Optional  User's or bot's last name
 * - username                     String    Optional  User's or bot's username
 * - language_code                String    Optional  IETF language tag of the user's language
 * - is_premium                   True      Optional  True, if this user is a Telegram Premium user
 * - added_to_attachment_menu     True      Optional  True, if this user added the bot to the attachment menu
 * - can_join_groups              Boolean   Optional  True, if the bot can be invited to groups. Returned only in getMe.
 * - can_read_all_group_messages  Boolean   Optional  True, if privacy mode is disabled for the bot. Returned only in getMe.
 * - supports_inline_queries      Boolean   Optional  True, if the bot supports inline queries. Returned only in getMe.
 * - can_connect_to_business      Boolean   Optional  True, if the bot can be connected to a Telegram Business account to receive its messages. Returned only in getMe.
 */

class User {
  public  int    $Id;        // Unique identifier for this user or bot. This number may have more than 32 significant bits and some programming languages may have difficulty/silent defects in interpreting it. 
                             //   But it has at most 52 significant bits, so a 64-bit integer or double-precision float type are safe for storing this identifier.
  public ?bool   $IsBot;     // True, if this user is a bot
  public  string $FirstName; // User's or bot's first name
  public ?string $LastName;  // Optional. User's or bot's last name
  public ?string $UserName;  // Optional. User's or bot's username
    
  // --------------------------------------------------------------------------
  function __construct(array $Data){
    $this->Id        = $Data['id'];
    $this->IsBot     = isset($Data['is_bot']) ? $Data['is_bot'] : null;
    $this->FirstName = $Data['first_name'];
    $this->LastName  = isset($Data['last_name']) ? $Data['last_name'] : null;
    $this->UserName  = isset($Data['username']) ? $Data['username'] : null;
  }

  // --------------------------------------------------------------------------
  function __get($name){
    switch($name){
      case 'UserInfo' : return $this->getMyUserInfo();
      default : throw new ex\Property($this, $name);
    }
  }

  // --------------------------------------------------------------------------
  // --------------------------------------------------------------------------
  private function getMyUserInfo(){
    return [
      'id'        => $this->Id,
      'firstName' => $this->FirstName,
      'lastName'  => $this->LastName,
      'userName'  => $this->UserName,
    ];
  }

}
?>
