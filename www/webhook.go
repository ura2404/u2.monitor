<?php
  require_once __DIR__.'/../core/common.php';

  $Config   = new U2\Config( ROOT.'/config.json' );
  $Telegram = new U2\Telegram( $Config );

  if ( !$Telegram->checkWebHookSecret() ) die ('Fuck off !!!');
    
  $M = 0;

  if( $M == 0 ){
    $App = ( new App\Application($Telegram) )
      ->registryAction( '/start', null, new App\Message([ 'text' => '$aboutMe()' ]) )
      ->registryAction( '/about', null, '$aboutMe()' )
      ->go();
  }




  // ============================================================================================  
  if( $M == 1 ){
    $Config   = new U2\Config( ROOT.'/config.json' );
    $Telegram = new U2\Telegram( $Config );

    if ( !$Telegram->checkWebHookSecret() ) die ('Fuck off !!!');
    
    $Keyboard1 = [
      [
        [ 'text' => '1', 'callback_data' => 'k=1' ],
        [ 'text' => '2', 'callback_data' => 'k=2' ],
        [ 'text' => '3', 'callback_data' => 'k=3' ],
      ],
      [
        [ 'text' => '4', 'callback_data' => 'k=4' ],
        [ 'text' => '5', 'callback_data' => 'k=5' ],
        [ 'text' => '6', 'callback_data' => 'k=6' ],
      ],
      [
        [ 'text' => '7', 'callback_data' => 'k=7' ],
        [ 'text' => '8', 'callback_data' => 'k=8' ],
        [ 'text' => '9', 'callback_data' => 'k=9' ],
      ],
      [
        [ 'text' => '0', 'callback_data' => 'k=0' ],
      ],
      [
        [ 'text' => 'Назад', 'callback_data' => '/back' ],
      ],
    ];

    $Keyboard2 = [
      [
        [ 'text' => '1', 'callback_data' => 'ak=1' ],
        [ 'text' => '2', 'callback_data' => 'ak=2' ],
        [ 'text' => '3', 'callback_data' => 'ak=3' ],
      ],
      [
        [ 'text' => 'Назад', 'callback_data' => '/back' ],
      ],
    ];

    $Telegram->createInlineKeyboard('keyboard1', $Keyboard1);
    $Telegram->createInlineKeyboard('keyboard2', $Keyboard2);

    _log( ROOT.'/log/updates', $Telegram->getUpdates() );
    //exit;


    // try{
      foreach ($Telegram->getUpdates() as $Update){
        $Message = $Update->getMessage();
        if(!$Message) continue;

        $ChatId    = $Update->getMessage()->Chat->Id;
        $Text      = $Update->getMessage()->Text;
        $MessageId = $Update->getMessage()->Id;
        $Data      = $Update->isCallbackQuery ? $Update->CallbackQuery->Data : 'no data';

        _log( ROOT.'/log/update'             , $Update );
        // _log( ROOT.'/log/update_message'     , $Update->getMessage() );
        _log( ROOT.'/log/update_data'        , $Update->isCallbackQuery ? $Update->CallbackQuery->Data : 'no data');
        // _log( ROOT.'/log/update_char_id'     , $ChatId );
        // _log( ROOT.'/log/update_text'        , $Text );
        // _log( ROOT.'/log/update_message_id'  , $MessageId );
        // _log( ROOT.'/log/update_message_type', $Update->isMessage ? 'message' : 'callbackquery' );

        if($Update->isMessage){
          _log( ROOT.'/log/update_response', $Telegram->sendMessage( [
            'chat_id'      => $ChatId,
          //'text'         => date('Y-m-d H:i') . ' <b>' . $Text .'</b>',
            'text'         => $Text,
            'parse_mode'   => 'HTML',
            'reply_markup' => json_encode( [ 'inline_keyboard' => (new \U2\Keyboard('keyboard1'))->Data ] )
          ] ));    
        }

        if($Update->isCallbackQuery){
          if($Data == 'k=9') $KB = new \U2\Keyboard('keyboard2');
          else $KB = new \U2\Keyboard('keyboard1');


          // _log( ROOT.'/log/update_response', $Telegram->editMessageText( [
          //   'chat_id' 	   => $ChatId,
          //   'message_id'   => $MessageId,
          //   'text'         => '<blockquote expandable>Expandable block quotation started\nExpandable block quotation continued\nExpandable block quotation continued\nHidden by default part of the block quotation started\nExpandable block quotation continued\nThe last line of the block quotation</blockquote>',
          //   'parse_mode'   => 'HTML',
          //   'reply_markup' => json_encode( [ 'inline_keyboard' => $KB->Data ] ),
      
          // ] ));    

          _log( ROOT.'/log/update_response', $Telegram->editMessageText( $Message, [
            'text'         => '<blockquote expandable>Expandable block quotation started\nExpandable block quotation continued\nExpandable block quotation continued\nHidden by default part of the block quotation started\nExpandable block quotation continued\nThe last line of the block quotation</blockquote>',
            'reply_markup' => [ 'inline_keyboard' => $KB->Data ],
          ] ));

        }
      }
//      '_text'         => $Data. '<b><i> 100</i></b><span class="tg-spoiler">qaz</span>',

    // }
    // catch( Throwable $e ){
    //   echo $e->getMessage();
    // }
  }

  // ============================================================================================
  if( $M == 2 ){
    $Ts = date('Y-m-d H:i');

    $Config = json_decode( file_get_contents(ROOT.'/config.json'), JSON_OBJECT_AS_ARRAY );
    $BaseUrl = 'https://api.telegram.org/bot' . $Config['telegramToken'] . '/';

    // --------------------------------------------------------------------------
    $_sendMessage = function($ChatId, $MessageText, $ReplyMarkup) use($BaseUrl){
      // $Reply_markup = json_encode([
      //   //'keyboard' => [$Btn],
      //   //'resize_keyboard' => true,
      //   'inline_keyboard' => $BtnI,
      // ]);
    
      $Method = 'sendMessage';
      $Params = [
        'chat_id' 	   => $ChatId,
        'text'         => $MessageText,
        'reply_markup' => json_encode($ReplyMarkup)
      ];
    
      $Url = $BaseUrl . $Method. '?' . http_build_query($Params);
      _log( ROOT.'/log/responce2', json_decode(file_get_contents($Url),JSON_OBJECT_AS_ARRAY) );
    };

    // --------------------------------------------------------------------------
    $_deleteMessage = function($ChatId, $MessageId) use($BaseUrl){
      $Method = 'deleteMessage';
      $Params = [
        'chat_id' 	 => $ChatId,
        'message_id' => $MessageId,
      ];

      $Url = $BaseUrl . $Method. '?' . http_build_query($Params);
      _log( ROOT.'/log/responce2', json_decode(file_get_contents($Url),JSON_OBJECT_AS_ARRAY) );
    };

    // --------------------------------------------------------------------------
    $_editMessage = function($ChatId, $MessageId, $MessageText, $ReplyMarkup) use($BaseUrl){
      $Method = 'editMessageText';
      $Params = [
        'chat_id' 	   => $ChatId,
        'message_id'   => $MessageId,
        'text'         => $MessageText,
        'reply_markup' => json_encode($ReplyMarkup),
      ];

      $Url = $BaseUrl . $Method. '?' . http_build_query($Params);
      _log( ROOT.'/log/responce2', json_decode(file_get_contents($Url),JSON_OBJECT_AS_ARRAY) );
    };

    // --------------------------------------------------------------------------
    // --------------------------------------------------------------------------
    // --------------------------------------------------------------------------
    $Responce = file_get_contents('php://input');
    $Update = json_decode( $Responce, JSON_OBJECT_AS_ARRAY );

    _log( ROOT.'/log/update2', $Ts . PHP_EOL . print_r($Update,1) );

    $Message  = isset($Update['message'])        ? $Update['message']       : null;
    $Callback = isset($Update['callback_query']) ? $Update['callback_query'] : null;

    // --- inline menu -----------------------
    $BtnI = [
      [
        [ 'text' => '1', 'callback_data' => 'k=1' ],
        [ 'text' => '2', 'callback_data' => 'k=2' ],
        [ 'text' => '3', 'callback_data' => 'k=3' ],
      ],
      [
        [ 'text' => '4', 'callback_data' => 'k=4' ],
        [ 'text' => '5', 'callback_data' => 'k=5' ],
        [ 'text' => '6', 'callback_data' => 'k=6' ],
      ],
      [
        [ 'text' => '7', 'callback_data' => 'k=7' ],
        [ 'text' => '8', 'callback_data' => 'k=8' ],
        [ 'text' => '9', 'callback_data' => 'k=9' ],
      ],
      [
        [ 'text' => '0', 'callback_data' => 'k=0' ],
      ],
      [
        [ 'text' => 'Назад', 'callback_data' => '/back' ],
      ],
    ];

    // -------------------------------------------
    if($Message){
      $MessageText = $Message['text'];
      $ChatId      = $Message['chat']['id'];
      $ReplyMarkup = [
        //'keyboard' => [$Btn],
        //'resize_keyboard' => true,
        'inline_keyboard' => $BtnI,
      ];
    }

    if($Callback){
      //$MessageText = $Callback['message']['text'];
      $MessageText = $Callback['data'];
      $MessageId   = $Callback['message']['message_id'];
      $ChatId      = $Callback['message']['chat']['id'];
      $ReplyMarkup = $Callback['message']['reply_markup'];
    }

    /*
    // --- menu -----------------------
    $Btn[] = [ 'text' => 'Информация обо мне'     , 'callback_data' => '/whoami'   ];
    $Btn[] = [ 'text' => 'Список устройств'       , 'callback_data' => '/list'     ];
    $Btn[] = [ 'text' => 'Регистрпация устройства', 'callback_data' => '/registry' ];

    // $Reply_markup = json_encode([
    //   'keyboard' => [$Btn],
    //   'resize_keyboard' => true
    // ]);

    // $Params = array_merge($Params, [
    //    //'parse_mode'   => 'HTML',
    //    //'parse_mode'   => 'Markdown',
    //    'reply_markup' => $Reply_markup,
    // ]);
    */

    // --- отправка --------------------------
    if($Message){
      $_sendMessage( $ChatId, $MessageText, $ReplyMarkup );
    }

    if($Callback){
      // $_deleteMmessage( $ChatId, $MessageId );
      $_editMessage( $ChatId, $MessageId, $MessageText, $ReplyMarkup );
    }
  }
  
?>