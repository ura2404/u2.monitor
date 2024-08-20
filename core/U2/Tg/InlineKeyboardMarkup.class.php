<?php

namespace U2\Tg;
use \U2\Exception as ex;

/**
 * Class U2\Tg\InlineKeyboardMarkup
 * 
 * @url https://core.telegram.org/bots/api#inlinekeyboardmarkup
 * 
 * @properties
 * - inline_keyboard  Array of Array of InlineKeyboardButton  Array of button rows, each represented by an Array of InlineKeyboardButton objects
 */

class InlineKeyboardMarkup {
  public array $InlineKeyboard;   // Array of Array   Array of button rows, each represented by an Array of InlineKeyboardButton objects
    
  // --------------------------------------------------------------------------
  function __construct(array $Markup){
    $this->InlineKeyboard = $Markup['inline_keyboard'];

    foreach ($this->InlineKeyboard as $x=>$Row){
      foreach ($Row as $y=>$Button){
        $this->InlineKeyboard[$x][$y] = new InlineKeyboardButton($Button);
      }
    }
  }

  // --------------------------------------------------------------------------
  function __get($name){
    switch($name){
      case 'Data'     : return [ 'inline_keyboard' => $this->getMyKeyboard() ];
      case 'Keyboard' : return $this->getMyKeyboard();
      default : throw new ex\Property($this, $name);
    }
  }

  // --------------------------------------------------------------------------
  // --------------------------------------------------------------------------
  private function getMyKeyboard(){
    $Keyboard = $this->InlineKeyboard;

    foreach ($Keyboard as $x=>$Row){
      foreach ($Row as $y=>$Button){
        $Keyboard[$x][$y] = $Button->Data;
      }
    }
    return $Keyboard;
  }

  // --------------------------------------------------------------------------
  // --------------------------------------------------------------------------
  static function getMarkup($Name){
  }

}
?>
