#!/usr/bin/env php
<?php
  $Config = json_decode( file_get_contents('../config.json'), JSON_OBJECT_AS_ARRAY );
  //print_r($Config);

  $GetUrl  = 'https://api.telegram.org/bot' . $Config['telegramToken'] . '/getUpdates';
  $SendUrl = 'https://api.telegram.org/bot' . $Config['telegramToken'] . '/sendMessage';
  
  $LastupdateId = 795723485+1;

  $Params = [
    'offset' => $LastupdateId,
    'limit'  => 100
  ];

  //$GetUrl = $GetUrl . '?' . http_build_query($Params);

  $Responce = json_decode( file_get_contents($GetUrl), JSON_OBJECT_AS_ARRAY );
  print_r($Responce) . PHP_EOL;
  //var_dump($Responce);

  if ($Responce['ok'] && isset($Responce['result'])) {
    foreach ($Responce['result'] as $result) {
      echo '----------------------------------------------------------------'.PHP_EOL;
      echo 'update_id = '.$result['update_id'].PHP_EOL;
      echo '---------'.PHP_EOL;
      //echo 'chat_id= '. ($result['message']['chat']['id']).PHP_EOL;
      echo 'messgae= '. ( !empty($result['message']) ? $result['message']['text'] : $result['callback_query']['message']['text'] ).PHP_EOL;

      $Params = [
        'chat_id' => !empty($result['message']) ? $result['message']['chat']['id'] : $result['callback_query']['message']['chat']['id'],
        'text' => 'Ответ'
      ];

      $Url = $SendUrl . '?' . http_build_query($Params);
      //echo 'URL= '.$Url.PHP_EOL;

      $Responce = json_decode( file_get_contents($Url), JSON_OBJECT_AS_ARRAY );
      print_r($Responce) . PHP_EOL;
  
    }
  }

  if ($Responce['ok'] === false) {
    echo '---------'.PHP_EOL;
    echo $Responce['description'];
  }

  

?>