<?php

namespace U2\Tg;
use \U2\Exception as ex;

/**
 * Class U2\Tg\Webhook
 * 
 * @url https://core.telegram.org/bots/api#setwebhook
 */

class Webhook {
  public  string    $Url;                 // HTTPS URL to send updates to. Use an empty string to remove webhook integration
//public ?InputFile $Certificate;         // Optional Upload your public key certificate so that the root certificate in use can be checked. See our self-signed guide for details.
  public ?string    $IpAddress;           // Optional	The fixed IP address which will be used to send webhook requests instead of the IP address resolved through DNS
  public ?int       $MaxConnections;      // Optional	The maximum allowed number of simultaneous HTTPS connections to the webhook for update delivery, 1-100. Defaults to 40. 
                                          //    Use lower values to limit the load on your bot's server, and higher values to increase your bot's throughput.
  public ?array     $Allowedupdates;      // Optional	A JSON-serialized list of the update types you want your bot to receive. For example, specify ["message", "edited_channel_post", "callback_query"] 
                                          //    to only receive updates of these types. See Update for a complete list of available update types. Specify an empty list to receive all update types except chat_member, 
                                          //    message_reaction, and message_reaction_count (default). If not specified, the previous setting will be used.
  public ?bool      $DropPendingUpdates;  // Optional	Pass True to drop all pending updates
  public ?string    $SecretToken;         // Optional	A secret token to be sent in a header “X-Telegram-Bot-Api-Secret-Token” in every webhook request, 1-256 characters. Only characters A-Z, a-z, 0-9, _ and - are allowed. 
                                          //    The header is useful to ensure that the request comes from a webhook set by you.

  // --------------------------------------------------------------------------
  function __construct(array $Data){
    $this->Url                = $Data['url'];
 // $this->Certificate        = isset($Data['certificate'])          ? $Data['certificate']          : null;
    $this->IpAddress          = isset($Data['ip_address'])           ? $Data['ip_address']           : null;
    $this->MaxConnections     = isset($Data['max_connections'])      ? $Data['max_connections']      : null;
    $this->Allowedupdates     = isset($Data['allowed_updates'])      ? $Data['allowed_updates']      : null;
    $this->DropPendingUpdates = isset($Data['drop_pending_updates']) ? $Data['drop_pending_updates'] : null;
    $this->SecretToken        = isset($Data['secret_token'])         ? $Data['secret_token']         : null;
  }

  // --------------------------------------------------------------------------
  function __get($name){
    switch($name){
      case 'Data' : return $this->getMyData();
      default : throw new ex\Property($this, $name);
    }
  }

  // --------------------------------------------------------------------------
  private function getMyData(){
    $Data = [];
    $Data['url'] = $this->Url;
  //$this->Certificate        ? $Data['certificate']          = $this->Certificate        : null;
    $this->IpAddress          ? $Data['ip_address']           = $this->IpAddress          : null;
    $this->MaxConnections     ? $Data['max_connections']      = $this->MaxConnections     : null;
    $this->Allowedupdates     ? $Data['allowed_updates']      = $this->Allowedupdates     : null;
    $this->DropPendingUpdates ? $Data['drop_pending_updates'] = $this->DropPendingUpdates : null;
    $this->SecretToken        ? $Data['secret_token']         = $this->SecretToken        : null;
    return $Data;
  }

  // --------------------------------------------------------------------------
  // --------------------------------------------------------------------------
  // static function isDefined(){
  //   \U2\Telegram::$CONNECT

  //   $Connect = new \U2\Connect( new \U2\Config() );
  //   $Responce = $Connect->getWebhookInfo();
  //   return ( $Responce['ok'] && $Responce['result'] && strlen($Responce['result']['url']) );
  // }

  // // --------------------------------------------------------------------------
  // static function set(Webhook $Webhook){
  //   $Connect = new \U2\Connect( new \U2\Config() );
  //   return $Connect->setWebhook($Webhook->Data);
  // }

  // // --------------------------------------------------------------------------
  // static function del(){
  //   $Connect = new \U2\Connect( new \U2\Config() );
  //   return $Connect->delWebhook();
  // }

}
?>
