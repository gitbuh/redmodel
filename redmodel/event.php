<?php
/**
    RedModel Exception
*/
class RedModel_Event {

  public static $listeners;

  public static function register ($eventName, $sender, $callback) {
    self::$listeners[$eventName][] = array($sender, $callback);
  }
  
  public static function dispatch ($eventName, $sender=null, $extra=null) {
    foreach (@self::$listeners[$eventName] as $a) {
      if ($a[0] && $a[0] != $sender) continue;
      call_user_func($a[1], $eventName, $sender, $extra);
    }
  }

}

