<?php

namespace U2\Tg;
use \U2\Exception as ex;

/**
 * Class U2\Tg\Bot
 * 
 */

class Bot {
    
  // --------------------------------------------------------------------------
  function __construct(){
  }

  // --------------------------------------------------------------------------
  function __get($name){
    switch($name){
      default : throw new ex\Property($this, $name);
    }
  }
 
  // --------------------------------------------------------------------------
  /**
   * @url https://core.telegram.org/bots/api#getwebhookinfo
   * Describes the current status of a webhook.
   * 
   * @return 
   * - url                              String                    Webhook URL, may be empty if webhook is not set up
   * - has_custom_certificate           Boolean                   True, if a custom certificate was provided for webhook certificate checks
   * - pending_update_count             Integer                   Number of updates awaiting delivery
   * - ip_address                       String          Optional  Currently used webhook IP address
   * - last_error_date                  Integer         Optional  Unix time for the most recent error that happened when trying to deliver an update via webhook
   * - last_error_message               String          Optional  Error message in human-readable format for the most recent error that happened when trying to deliver an update via webhook
   * - last_synchronization_error_date  Integer         Optional  Unix time of the most recent error that happened when trying to synchronize available updates with Telegram datacenters
   * - max_connections                  Integer         Optional  The maximum allowed number of simultaneous HTTPS connections to the webhook for update delivery
   * - allowed_updates                  Array of String Optional  A list of update types the bot is subscribed to. Defaults to all update types except chat_member
   */

  public function getWebHookInfo(): array {
    $Responce = \U2\Telegram::$CONNECT->post('getWebhookInfo');
    _log( ROOT.'/log/webhookinfo', $Responce );
    isset($Responce['result']['last_error_date']) ? $Responce['result']['last_error_date'] = gmdate( "Y-m-d H:i:s", $Responce['result']['last_error_date'] ) : null;
    return $Responce;
  }

  // --------------------------------------------------------------------------
  // --------------------------------------------------------------------------
  /**
   * @url https://core.telegram.org/bots/api#setwebhook
   * 
   * @param array $Params
   * - url                  String          Yes       HTTPS URL to send updates to. Use an empty string to remove webhook integration
   * - certificate          InputFile       Optional  Upload your public key certificate so that the root certificate in use can be checked. See our self-signed guide for details.
   * - ip_address           String          Optional  The fixed IP address which will be used to send webhook requests instead of the IP address resolved through DNS
   * - max_connections      Integer         Optional  The maximum allowed number of simultaneous HTTPS connections to the webhook for update delivery, 1-100. Defaults to 40. Use lower values to limit the load on your bot's server, 
   *                                                  and higher values to increase your bot's throughput.
   * - allowed_updates      Array of String Optional  A JSON-serialized list of the update types you want your bot to receive. For example, specify ["message", "edited_channel_post", "callback_query"] 
   *                                                  to only receive updates of these types. See Update for a complete list of available update types. Specify an empty list to receive all update types except chat_member, 
   *                                                  message_reaction, and message_reaction_count (default). If not specified, the previous setting will be used.
   * - drop_pending_updates Boolean         Optional  Pass True to drop all pending updates
   * - secret_token         String          Optional  A secret token to be sent in a header “X-Telegram-Bot-Api-Secret-Token” in every webhook request, 1-256 characters. Only characters A-Z, a-z, 0-9, _ and - are allowed. 
   *                                                  The header is useful to ensure that the request comes from a webhook set by you.
   */
  public function setWebHook( array $Params): array {
    return \U2\Telegram::$CONNECT->post( 'setWebhook', $Params );
  }

  // --------------------------------------------------------------------------
  /**
   * @url https://core.telegram.org/bots/api#deletewebhook
   * 
   * @param array $Params
   *  - drop_pending_updates  Boolean Optional  Pass True to drop all pending updates
   */
  public function deleteWebHook( array $Params=null): array {
    return \U2\Telegram::$CONNECT->post( 'deleteWebhook', $Params );
  }

  // --------------------------------------------------------------------------
  /**
   * @url https://core.telegram.org/bots/api#sendmessage
   * 
   * @param array $Params
   * - business_connection_id String                  Optional  Unique identifier of the business connection on behalf of which the message will be sent
   * - chat_id                Integer or String       Yes       Unique identifier for the target chat or username of the target channel (in the format @channelusername)
   * - message_thread_id      Integer                 Optional  Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
   * - text                   String                  Yes       Text of the message to be sent, 1-4096 characters after entities parsing
   * - parse_mode             String                  Optional  Mode for parsing entities in the message text. See formatting options for more details.
   * - entities               Array of MessageEntity	Optional  A JSON-serialized list of special entities that appear in message text, which can be specified instead of parse_mode
   * - link_preview_options	  LinkPreviewOptions      Optional  Link preview generation options for the message
   * - disable_notification   Boolean                 Optional  Sends the message silently. Users will receive a notification with no sound.
   * - protect_content        Boolean                 Optional  Protects the contents of the sent message from forwarding and saving
   * - message_effect_id      String                  Optional  Unique identifier of the message effect to be added to the message; for private chats only
   * - reply_parameters       ReplyParameters	        Optional  Description of the message to reply to
   * - reply_markup	          InlineKeyboardMarkup or 
   *                          ReplyKeyboardMarkup or 
   *                          ReplyKeyboardRemove or 
   *                          ForceReply              Optional  Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove a reply keyboard or to force a reply from the user
   */
  public function sendMessage( array $Params ): array {
    return \U2\Telegram::$CONNECT->post( 'sendMessage', $Params );
  }

  // --------------------------------------------------------------------------
  /**
   * @url https://core.telegram.org/bots/api#deletemessage
   * 
   * @param array $Params
   * - chat_id      Integer or String   Yes   Unique identifier for the target chat or username of the target channel (in the format @channelusername)
   * - message_id   Integer             Yes   Identifier of the message to delete
   */
  public function deleteMessage( array $Params ): array {
    return \U2\Telegram::$CONNECT->post( 'deleteMessage', $Params );
  }


  // --------------------------------------------------------------------------
  /**
   * @url https://core.telegram.org/bots/api#editmessagetext
   * 
   * @param array $Params
   * - business_connection_id	String	                Optional  Unique identifier of the business connection on behalf of which the message to be edited was sent
   * - chat_id	              Integer or String	      Optional  Required if inline_message_id is not specified. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
   * - message_id	            Integer                 Optional  Required if inline_message_id is not specified. Identifier of the message to edit
   * - inline_message_id  	  String	                Optional  Required if chat_id and message_id are not specified. Identifier of the inline message
   * - text	                  String      	          Yes       New text of the message, 1-4096 characters after entities parsing
   * - parse_mode	            String                  Optional  Mode for parsing entities in the message text. See formatting options for more details.
   * - entities	              Array of MessageEntity  Optional  A JSON-serialized list of special entities that appear in message text, which can be specified instead of parse_mode
   * - link_preview_options  	LinkPreviewOptions      Optional  Link preview generation options for the message
   * - reply_markup	          InlineKeyboardMarkup    Optional  A JSON-serialized object for an inline keyboard.
   */
  public function editMessageText( array $Params ): array {
    return \U2\Telegram::$CONNECT->post( 'editMessageText', $Params );
  }

  // --------------------------------------------------------------------------
  public function getUpdate(): array {
    $Responce = file_get_contents('php://input');

    // _log( ROOT.'/log/respoce.txt', json_decode($Responce,true) );

    $Update = json_decode( $Responce, JSON_OBJECT_AS_ARRAY ); 
    $Update = new Update($Update); 
    return [ $Update ];
  }
  
  // --------------------------------------------------------------------------
  /**
   * @url https://core.telegram.org/bots/api#getupdates
   * Use this method to receive incoming updates using long polling (wiki). Returns an Array of Update objects.
   * 
   * @param array $Params
   * - offset           Integer           Optional  Identifier of the first update to be returned. Must be greater by one than the highest among the identifiers of previously received updates. By default, updates starting with the earliest unconfirmed update are returned. An update is considered confirmed as soon as getUpdates is called with an offset higher than its update_id. The negative offset can be specified to retrieve updates starting from -offset update from the end of the updates queue. All previous updates will be forgotten.
   * - limit            Integer           Optional  Limits the number of updates to be retrieved. Values between 1-100 are accepted. Defaults to 100.
   * - timeout          Integer           Optional  Timeout in seconds for long polling. Defaults to 0, i.e. usual short polling. Should be positive, short polling should be used for testing purposes only.
   * - allowed_updates  Array of String   Optional  A JSON-serialized list of the update types you want your bot to receive. For example, specify ["message", "edited_channel_post", "callback_query"] to only receive updates of these types. See Update for a complete list of available update types. Specify an empty list to receive all update types except chat_member, message_reaction, and message_reaction_count (default). If not specified, the previous setting will be used.
   */
  public function getUpdates( array $Params=null): array {
    $Response = \U2\Telegram::$CONNECT->post( 'getUpdates', [
      'offset' => $this->Config->LastUpdateId
    ] );

    if ( $Response['ok'] && isset($Response['result']) ) {
      foreach ($Response['result'] as $Key=>$Update ){
        $Response['result'][$Key] = new Update($Update);
      }
    }

    // 'offset' => $LastupdateId,
    // 'limit'  => 100

    if ( count($Response['result']) > 0 ) {
      $LastUpdateId = $Response['result'][ count($Response['result'])-1 ];
      $this->Config->setValue( 'lastUpdateId', $LastUpdateId->Id + 1 );
    }

    return $Response['result'];    
  }
}
?>
