<?php
date_default_timezone_set('Europe/Moscow');

define( 'ROOT', realpath(__DIR__.'/..') );

spl_autoload_register(function($ClassName){
  if(class_exists($ClassName)) return;

  $ClassFilePath = ROOT.'/core/'.str_replace('\\','/',$ClassName).'.class.php';
  // echo $ClassFilePath.PHP_EOL;

  if(file_exists($ClassFilePath)) require_once($ClassFilePath);
},true,true);

function dump($Data){
  if($Data === true)      echo 'TRUE' . PHP_EOL;
  elseif($Data === false) echo 'FALSE'. PHP_EOL;
  elseif($Data === null)  echo 'NULL' . PHP_EOL;
  else echo print_r($Data,1). PHP_EOL;
}

function _log($FilePath, $Data){
  file_put_contents( $FilePath, date('Y-m-d H:i') . PHP_EOL . print_r($Data,1) );  
}
?>