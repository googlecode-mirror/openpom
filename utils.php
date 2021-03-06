<?php
/*
  OpenPOM

  Copyright 2010, Exosec
  Licensed under GPL Version 2.
  http://www.gnu.org/licenses/
*/

/* special_char functions
 * fix data, in particular if magic_quotes is on
 *
 * we choose here to replace special html characters by their html
 * entities in both keys and values
 */
function special_char_array(&$in) {
  $keys = array_keys($in);

  foreach ($keys as $k) {
    $v = $in[$k];
    unset($in[$k]);

    //$k = htmlspecialchars($k);
    if (get_magic_quotes_gpc()) {
      $k = stripslashes($k);
    }

    if (is_array($v)) {
      special_char_array($v);

    } else {
      //$v = htmlspecialchars($v);
      if (get_magic_quotes_gpc()) {
        $v = stripslashes($v);
      }
    }

    $in[$k] = $v;
  }
  reset($in);
}

function special_char() {
  special_char_array($_GET);
  special_char_array($_POST);
}

function printtime($t) {
  $day    = (int)     ( $t / 86400 );
  $hour   = (int)   ( ( $t % 86400 ) / 3600 );
  $minute  = (int) ( ( ( $t % 86400 ) % 3600 ) / 60 );
  $second = (int) ( ( ( $t % 86400 ) % 3600 ) % 60 );
  if ($minute == 0 and $hour == 0 and $day == 0)
    return sprintf("%02ds", $second);
  else if ($hour == 0 and $day == 0)
    return sprintf("%02dm %02ds", $minute, $second);
  else if ($day == 0)
    return sprintf("%02dh %02dm", $hour, $minute);
  else
    return sprintf("%dd %02dh", $day, $hour);
}

function select_level($LEVEL) {
  global $MY_HOSTFILT;
  global $MY_SVCFILT;
  global $MY_HOSTACKLIST;
  global $MY_SVCACKLIST;
  global $MY_HOSTDOWNOP;
  global $MY_HOSTDOWNVAL;
  global $MY_SVCDOWNOP;
  global $MY_SVCDOWNVAL;
  global $MY_ACKLISTOP;
  global $MY_ACKLISTVAL;
  global $MY_DISABLE;
  global $MY_NOSVC;
  global $MY_SOFT;
  global $MY_TRACK_ANY;

  if ($LEVEL == 1) {
    $MY_SVCFILT       = "2";
    $MY_SOFT          = "1";
  }
  else if ($LEVEL == 2) {
    $MY_SOFT          = "1";
  }
  else if ($LEVEL == 3) {
    $MY_SOFT          = "0";
  }
  else if ($LEVEL == 4) {
    $MY_HOSTACKLIST   = "0,1";
    $MY_SVCACKLIST    = "0,1";
    $MY_HOSTDOWNOP    = '>=';
    $MY_HOSTDOWNVAL   = 0;
    $MY_SVCDOWNOP     = '>=';
    $MY_SVCDOWNVAL    = 0;
    $MY_DISABLE       = "0,1";
  }
  else if ($LEVEL == 5) {
    $MY_HOSTFILT      = "1,2";
    $MY_HOSTACKLIST   = "0,1";
    $MY_SVCACKLIST    = "0,1";
    $MY_HOSTDOWNOP    = '>=';
    $MY_HOSTDOWNVAL   = 0;
    $MY_SVCDOWNOP     = '>=';
    $MY_SVCDOWNVAL    = 0;
    $MY_DISABLE       = "0,1";
  }
  else if ($LEVEL == 6) {
    $MY_HOSTFILT      = "1,2";
    $MY_HOSTACKLIST   = "0,1";
    $MY_SVCACKLIST    = "0,1";
    $MY_HOSTDOWNOP    = '>=';
    $MY_HOSTDOWNVAL   = 0;
    $MY_SVCDOWNOP     = '>=';
    $MY_SVCDOWNVAL    = 0;
    $MY_ACKLISTOP     = '>=';
    $MY_ACKLISTVAL    = 0;
    $MY_NOSVC         = "0";
    $MY_DISABLE       = "0,1";
  }
  else if ($LEVEL == 7) {
    $MY_SVCFILT       = "0,1,2,3";
    $MY_HOSTFILT      = "0,1,2";
    $MY_HOSTACKLIST   = "0,1";
    $MY_SVCACKLIST    = "0,1";
    $MY_HOSTDOWNOP    = '>=';
    $MY_HOSTDOWNVAL   = 0;
    $MY_SVCDOWNOP     = '>=';
    $MY_SVCDOWNVAL    = 0;
    $MY_ACKLISTOP     = '>=';
    $MY_ACKLISTVAL    = 0;
    $MY_NOSVC         = "0";
    $MY_DISABLE       = "0,1";
  }
  else if ($LEVEL == 8) {       /* ACK */
    $MY_SVCFILT       = "0,1,2,3";
    $MY_HOSTFILT      = "0,1,2";
    $MY_HOSTACKLIST   = "1";
    $MY_SVCACKLIST    = "1";
    $MY_HOSTDOWNOP    = '>=';
    $MY_HOSTDOWNVAL   = 0;
    $MY_SVCDOWNOP     = '>=';
    $MY_SVCDOWNVAL    = 0;
    $MY_ACKLISTOP     = '>=';
    $MY_ACKLISTVAL    = 0;
    $MY_NOSVC         = "0";
    $MY_DISABLE       = "0,1";
    $MY_TRACK_ANY     = 0;
  }
  else if ($LEVEL == 9) {       /* DOWNTIME */
    $MY_SVCFILT       = "0,1,2,3";
    $MY_HOSTFILT      = "0,1,2";
    $MY_HOSTACKLIST   = "0,1";
    $MY_SVCACKLIST    = "0,1";
    $MY_HOSTDOWNOP    = '>';
    $MY_HOSTDOWNVAL   = 0;
    $MY_SVCDOWNOP     = '>';
    $MY_SVCDOWNVAL    = 0;
    $MY_ACKLISTOP     = '>=';
    $MY_ACKLISTVAL    = 0;
    $MY_NOSVC         = "0";
    $MY_DISABLE       = "0,1";
    $MY_TRACK_ANY     = 0;
  }
  else if ($LEVEL == 10) {      /* NOTIF DISABLED */
    $MY_SVCFILT       = "0,1,2,3";
    $MY_HOSTFILT      = "0,1,2";
    $MY_HOSTACKLIST   = "0,1";
    $MY_SVCACKLIST    = "0,1";
    $MY_HOSTDOWNOP    = '>=';
    $MY_HOSTDOWNVAL   = 0;
    $MY_SVCDOWNOP     = '>=';
    $MY_SVCDOWNVAL    = 0;
    $MY_ACKLISTOP     = '>=';
    $MY_ACKLISTVAL    = 0;
    $MY_NOSVC         = "0";
    $MY_DISABLE       = "0";
    $MY_TRACK_ANY     = 0;
  }
  else if ($LEVEL == 11) {      /* CRITICAL */
    $MY_SVCFILT       = "2";
    $MY_HOSTFILT      = "1";
    $MY_HOSTACKLIST   = "0,1";
    $MY_SVCACKLIST    = "0,1";
    $MY_HOSTDOWNOP    = '>=';
    $MY_HOSTDOWNVAL   = 0;
    $MY_SVCDOWNOP     = '>=';
    $MY_SVCDOWNVAL    = 0;
    $MY_ACKLISTOP     = '>=';
    $MY_ACKLISTVAL    = 0;
    $MY_NOSVC         = "0";
    $MY_DISABLE       = "0,1";
    $MY_TRACK_ANY     = 0;
  }
  else if ($LEVEL == 12) {      /* WARNING */
    $MY_SVCFILT       = "1";
    $MY_HOSTFILT      = "10";
    $MY_HOSTACKLIST   = "0,1";
    $MY_SVCACKLIST    = "0,1";
    $MY_HOSTDOWNOP    = '>=';
    $MY_HOSTDOWNVAL   = 0;
    $MY_SVCDOWNOP     = '>=';
    $MY_SVCDOWNVAL    = 0;
    $MY_ACKLISTOP     = '>=';
    $MY_ACKLISTVAL    = 0;
    $MY_NOSVC         = "0";
    $MY_DISABLE       = "0,1";
    $MY_TRACK_ANY     = 0;
  }
  else if ($LEVEL == 13) {      /* UNKNOWN */
    $MY_SVCFILT       = "3";
    $MY_HOSTFILT      = "10";
    $MY_HOSTACKLIST   = "0,1";
    $MY_SVCACKLIST    = "0,1";
    $MY_HOSTDOWNOP    = '>=';
    $MY_HOSTDOWNVAL   = 0;
    $MY_SVCDOWNOP     = '>=';
    $MY_SVCDOWNVAL    = 0;
    $MY_ACKLISTOP     = '>=';
    $MY_ACKLISTVAL    = 0;
    $MY_NOSVC         = "0";
    $MY_DISABLE       = "0,1";
    $MY_TRACK_ANY     = 0;
  }
  else if ($LEVEL == 14) {      /* OK */
    $MY_SVCFILT       = "0";
    $MY_HOSTFILT      = "0";
    $MY_HOSTACKLIST   = "0,1";
    $MY_SVCACKLIST    = "0,1";
    $MY_HOSTDOWNOP    = '>=';
    $MY_HOSTDOWNVAL   = 0;
    $MY_SVCDOWNOP     = '>=';
    $MY_SVCDOWNVAL    = 0;
    $MY_ACKLISTOP     = '>=';
    $MY_ACKLISTVAL    = 0;
    $MY_NOSVC         = "0";
    $MY_DISABLE       = "0,1";
    $MY_TRACK_ANY     = 0;
  }
}

/*******************************************************************************
 * ACTIONS ON EVENTS: common utility functions (any action type)
 ******************************************************************************/

/* validate_comment_value
 * check if a valid comment has been posted
 */
function validate_comment_value(&$out) {
  global $ILLEGAL_CHAR;

  /* require comment */
  if (!isset($_POST['comment'])) {
    return false;
  }

  /* this has to do with function special_char calling
   * htmlspecialchars */
  $out = html_entity_decode($_POST['comment'], ENT_QUOTES);

  return !empty($out)
    && !preg_match('/' . preg_quote($ILLEGAL_CHAR) . '/', $out);
}

/* validate_downtime_range
 * check if a valid start/end date range has been posted
 */
function validate_downtime_range(&$start, &$end) {
  /* fixed start/end dates */
  if (isset($_POST['start']) && isset($_POST['end'])) {
    $pat = '/[0-9]{1,2}[-]{1}[0-9]{1,2}[-]{1}[0-9]{4} [0-9]{1,2}:[0-9]{1,2}/';
    if (preg_match($pat, $_POST['start']) && preg_match($pat, $_POST['end'])) {
      $start = strtotime($_POST['start']);
      $end = strtotime($_POST['end']);
    }
  }

  /* fixed from now */
  $endf = 0;
  if (isset($_POST['hour']) || isset($_POST['minute'])) {
    if (is_numeric($_POST['hour'])) {
      $start = time();
      $endf = $start + ($_POST['hour'] * 3600);
    }

    if (is_numeric($_POST['minute'])) {
      $start = time();

      if ($endf != 0) {
        $endf = $endf + $_POST['minute'] * 60;
      } else {
        $endf = $start + $_POST['minute'] * 60;
      }
    }
  }

  /* check dates */
  if ($endf != 0) $end = $endf;
  return isset($start) && isset($end);
}

/*******************************************************************************
 * Functions to get per-type action templates
 ******************************************************************************/

function __get_del_host_comment_commands($ts, $host)
{
  global $QUERY_COMMENT_MIXED_ID;
  global $dbconn;
  $out = '';

  $qhost = "'" . mysql_real_escape_string($host, $dbconn) . "'";
  $query = str_replace('define_host', $qhost, $QUERY_COMMENT_MIXED_ID);
  $query = preg_replace('/([^\s]*[\s]*)=[\s]*define_svc/i', '\1 is null', $query);

  if (($result = mysql_query($query, $dbconn))) {
    while (($id = mysql_fetch_row($result))) {
        $id = $id[0];
        $out .= "[$ts] DEL_HOST_COMMENT;$id\n";
    }
    mysql_free_result($result);
  }

  return $out;
}

function __get_del_host_downtime_commands($ts, $host)
{
  global $QUERY_DOWNTIME_MIXED_ID;
  global $dbconn;
  $out = '';

  $qhost = "'" . mysql_real_escape_string($host, $dbconn) . "'";
  $query = str_replace('define_host', $qhost, $QUERY_DOWNTIME_MIXED_ID);
  $query = preg_replace('/([^\s]*[\s]*)=[\s]*define_svc/i', '\1 is null', $query);

  if (($result = mysql_query($query, $dbconn))) {
    while (($id = mysql_fetch_row($result))) {
        $id = $id[0];
        $out .= "[$ts] DEL_HOST_DOWNTIME;$id\n";
    }
    mysql_free_result($result);
  }

  return $out;
}

function __get_del_svc_downtime_commands($ts, $host, $svc)
{
  global $QUERY_DOWNTIME_MIXED_ID;
  global $dbconn;
  $out = '';

  $qhost = "'" . mysql_real_escape_string($host, $dbconn) . "'";
  $qsvc = "'" . mysql_real_escape_string($svc, $dbconn) . "'";
  $query = str_replace('define_host', $qhost, $QUERY_DOWNTIME_MIXED_ID);
  $query = str_replace('define_svc', $qsvc, $query);

  if (($result = mysql_query($query, $dbconn))) {
    while (($id = mysql_fetch_row($result))) {
        $id = $id[0];
        $out .= "[$ts] DEL_SVC_DOWNTIME;$id\n";
    }
    mysql_free_result($result);
  }

  return $out;
}

/* get_nagios_cmd_template
 * return "nagios" command template
 */
function get_nagios_cmd_template($action, $ts, $target, $ignore_track = false) {
  global $EXT_CMD;
  global $HOST_SERVICE;
  $out = '';

  if ($action == 'track') {
    $ignore_track = true;
  }

  if (isset($EXT_CMD[$action])) {

    /* the key host is inappropriate, don't modify that and
     * keep it for backward compatibility of config variables */
    if (empty($target)
          && isset($EXT_CMD[$action]['host'])) {

      foreach ($EXT_CMD[$action]['host'] AS $n => $array ) {
        $out .= "[$ts] " . implode(';', $array) . "\n";
      }
    }

    /* target has 2+ elements, host and svc are present and svc is
     * not denoting a host, so this is a service template */
    else if (count($target) > 1
              && !empty($target[1])
              && $target[1] != $HOST_SERVICE
              && isset($EXT_CMD[$action]['svc'])) {

      foreach ($EXT_CMD[$action]['svc'] AS $n => $array ) {
        if (isset($array[0]) && $array[0] == 'DEL_SVC_DOWNTIME')
          $out .= __get_del_svc_downtime_commands($ts, $target[0], $target[1]);
        else
          $out .= "[$ts] " . str_replace(array('$host', '$svc'),
                                         array($target[0], $target[1]),
                                         implode(';', $array)) . "\n";
      }
    }

    /* otherwise if target has 1+ element, this is a host template */
    else if (count($target) > 0
              && isset($EXT_CMD[$action]['host'])) {

      foreach ($EXT_CMD[$action]['host'] AS $n => $array ) {
        if (isset($array[0]) && $array[0] == 'DEL_HOST_DOWNTIME')
          $out .= __get_del_host_downtime_commands($ts, $target[0]);
        else if (isset($array[0]) && $array[0] == 'DEL_ALL_HOST_COMMENTS')
          $out .= __get_del_host_comment_commands($ts, $target[0]);
        else
          $out .= "[$ts] " . str_replace('$host', $target[0], implode(';', $array)) . "\n";
      }
    }

    /* handle track option here
     * put the track before the actual commands so it appear faster */
    if (!$ignore_track && !empty($out) && isset($_POST['track'])) {
      $out = get_nagios_cmd_template('track', $ts, $target, true) . $out;
    }
  }

  return $out;
}

/*******************************************************************************
 * Actions on Nagios: prepare action function for type "nagios"
 ******************************************************************************/

/* prepare_action_nagios__down
 * prepare command for "nagios" action "downtime"
 */
function prepare_action_nagios__down($ts, $target) {
  /* this action requires at least one element in target, the host name */
  if (count($target) < 1) {
    return false;
  }

  /* this action requires a valid comment */
  if (!validate_comment_value($c)) {
    return false;
  }

  /* this action requires a valid start/end date range */
  if (!validate_downtime_range($start, $end)) {
    return false;
  }

  /* build command */
  $prepared = str_replace(
    array('$start_time', '$end_time', '$user', '$comment'),
    array($start, $end, $_SESSION['USER'], $c),
    get_nagios_cmd_template('down', $ts, $target));

  return cache_action_nagios($prepared);
}

/* prepare_action_nagios__ack
 * prepare command for "nagios" action "acknowledge"
 */
function prepare_action_nagios__ack($ts, $target) {
  /* this action requires at least one element in target, the host name */
  if (count($target) < 1) {
    return false;
  }

  /* this action requires a valid comment */
  if (!validate_comment_value($c)) {
    return false;
  }

  /* build command */
  $prepared = str_replace(
    array('$user', '$comment'),
    array($_SESSION['USER'], $c),
    get_nagios_cmd_template('ack', $ts, $target));

  return cache_action_nagios($prepared);
}

/* prepare_action_nagios__comment_persistent
 * prepare command for "nagios" action "comment_persistent"
 */
function prepare_action_nagios__comment_persistent($ts, $target) {
  /* this action requires at least one element in target, the host name */
  if (count($target) < 1) {
    return false;
  }

  /* this action requires a valid comment */
  if (!validate_comment_value($c)) {
    return false;
  }

  /* build command */
  $prepared = str_replace(
    array('$user', '$comment'),
    array($_SESSION['USER'], $c),
    get_nagios_cmd_template('comment_persistent', $ts, $target));

  return cache_action_nagios($prepared);
}

/* prepare_action_nagios__disable
 * prepare command for "nagios" action "disable"
 */
function prepare_action_nagios__disable($ts, $target) {
  /* this action requires at least one element in target, the host name */
  if (count($target) < 1) {
    return false;
  }

  /* this action requires a valid comment */
  if (!validate_comment_value($c)) {
    return false;
  }

  /* build command */
  $prepared = str_replace(
    array('$user', '$comment'),
    array($_SESSION['USER'], $c),
    get_nagios_cmd_template('disable', $ts, $target));

  return cache_action_nagios($prepared);
}

/* prepare_action_nagios__ena_notif
 * prepare command for "nagios" action "ena_notif" (global)
 */
function prepare_action_nagios__ena_notif($ts, $target) {
  $prepared = get_nagios_cmd_template('ena_notif', $ts, $target);
  return cache_action_nagios($prepared);
}

/* prepare_action_nagios__disa_notif
 * prepare command for "nagios" action "disa_notif" (global)
 */
function prepare_action_nagios__disa_notif($ts, $target) {
  $prepared = get_nagios_cmd_template('disa_notif', $ts, $target);
  return cache_action_nagios($prepared);
}

/* prepare_action_nagios__recheck
 * prepare command for "nagios" action "recheck"
 */
function prepare_action_nagios__recheck($ts, $target) {
  $prepared = str_replace(
    '$next', $ts, get_nagios_cmd_template('recheck', $ts, $target, true));
  return cache_action_nagios($prepared);
}

/* prepare_action_nagios__reset
 * prepare command for "nagios" action "reset"
 */
function prepare_action_nagios__reset($ts, $target) {
  $prepared = get_nagios_cmd_template('reset', $ts, $target);
  return cache_action_nagios($prepared);
}

/*******************************************************************************
 * Functions for caching prepared action
 ******************************************************************************/

/* cache_action_nagios
 * append a pepared "nagios" action to the cache
 */
function cache_action_nagios($prepared) {
  global $handle_action_cache;

  if (empty($prepared)) {
    return false;
  }

  /* init cache */
  if (!isset($handle_action_cache['nagios'])) {
    $handle_action_cache['nagios'] = '';
  }

  /* add prepared action if not already present */
  if (!strstr($handle_action_cache['nagios'], $prepared)) {
    $handle_action_cache['nagios'] .= $prepared;
  }

  return true;
}

/*******************************************************************************
 * Functions for executing prepared actions
 ******************************************************************************/

/* execute_prepared_actions_nagios
 * execute prepared actions of type "nagios"
 */
function execute_prepared_actions_nagios($actions) {
  global $CMD_FILE;
  global $EXEC_CMD;
  global $EXEC_PARAM;
  global $SUDO_EXEC;
  global $SUDO_PARAM;
  global $ENCODING;

  if (!empty($actions) && !empty($EXEC_CMD)) {
    $args = array();

    /* sudo command path, if set */
    if (isset($SUDO_EXEC)) {
      $args[] = escapeshellarg($SUDO_EXEC);
    }

    /* sudo parameters, if any */
    if (isset($SUDO_PARAM) && is_array($SUDO_PARAM)) {
      foreach ($SUDO_PARAM as $p) {
        $args[] = escapeshellarg($p);
      }
    }

    /* actual command path to execute */
    $args[] = escapeshellarg($EXEC_CMD);

    /* script parameters, if any */
    if (isset($EXEC_PARAM) && is_array($EXEC_PARAM)) {
      foreach ($EXEC_PARAM as $p) {
        $args[] = escapeshellarg($p);
      }
    }

    $args[] = escapeshellarg($CMD_FILE);
    setlocale(LC_CTYPE, "en_US.".$ENCODING); /* DON'T REMOVE ACCENTS ! */
    $args[] = escapeshellarg($actions);
    $args[] = '>/dev/null 2>&1 &';

    /* execute */
    exec(implode(' ', $args));
  }
}

/*******************************************************************************
 * Main action handling function
 ******************************************************************************/

/* handle_action
 * process requested action, send a command to nagios pipe
 * in most of the cases
 */
function handle_action($action, $target) {
  global $handle_action_cache;

  $handle_action_cache = array();
  $ts = time();

  /* loop on targets */
  foreach ($target as $t) {

    /* field 0: type (required)
     * field 1: host
     * field 2: svc
     * field 3: check_name */
    $t = explode(';', $t);
    $tlen = count($t);

    if ($tlen > 0) {
      $type = $t[0];
      $fct = 'prepare_action_' . $type . '__' . $action;
      array_shift($t);
      $tlen--;
      $done = false;

      /* per service override */
      if ($tlen > 1) {
        $override_fct = $fct . '_svc_' . preg_replace('/[^a-z0-9]/', '_', strtolower($t[1]));
        if (function_exists($override_fct)) {
          call_user_func($override_fct, $ts, $t);
          $done = true;
        }
      }

      /* per check name override */
      if (!$done && $tlen > 2) {
        $override_fct = $fct . '_checkname_' . preg_replace('/[^a-z0-9]/', '_', strtolower($t[2]));
        if (function_exists($override_fct)) {
          call_user_func($override_fct, $ts, $t);
          $done = true;
        }
      }

      /* fallback to default action */
      if (!$done && function_exists($fct))
          call_user_func($fct, $ts, $t);
    }
  }

  /* execute cached actions */
  foreach ($handle_action_cache as $type => $actions) {
    $fct = 'execute_prepared_actions_' . $type;
    if (function_exists($fct)) {
      call_user_func($fct, $actions);
    }
  }
}

function getmicrotime(){
  list($usec, $sec) = explode(" ",microtime());
  return ((float)$usec + (float)$sec);
}

function get_graph($type, $host, $svc = null) {
  global $HOST_SERVICE;

  if ($type == 'status') {
    $type = 'GRAPH';
  } else if ($type == 'popup') {
    $type = 'GRAPH_POPUP';
  } else {
    return null;
  }

  if (empty($svc) || $svc == $HOST_SERVICE) {
    $type .= '_HOST';
  } else {
    $type .= '_SVC';
  }

  global $$type;
  $type = $$type;
  $type = str_replace('@@define_host@@', $host, $type);
  $type = str_replace('@@define_service@@', $svc, $type);
  return $type;
}

function die_refresh($message, $timeout = 10, $url = null) {
  /* json output mode */
  if (isset($_GET['json']))
    json_error($message, 'ISO-8859-1');

  global $CODENAME;
  global $ENCODING;

  if (is_null($url)) {
    $url = $_SERVER['PHP_SELF'];
  }

  $js_timeout = json_encode($timeout);
  $js_url = json_encode($url);

  echo <<<__EOFEOF__
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
  <head>
    <title>$CODENAME - Error</title>
    <meta http-equiv="Content-Type" content="text/html; charset=$ENCODING" />
    <meta http-equiv="CACHE-CONTROL" content="NO-CACHE" />
    <meta http-equiv="PRAGMA" content="NO-CACHE" />
    <link rel="stylesheet" type="text/css" href="style.css" />
    <style type="text/css">
      body { margin: 20px;     }
      h1   { font-size: 16px;  }
      div  { fonct-size: 12px; }
    </style>
    <script type="text/javascript">
      var interval = null;
      var timeout = $js_timeout;
      var url = $js_url;
      function refresh_countdown() {
        if (interval == null) {
          return;
        }

        timeout--;
        document.getElementById('timeout').innerHTML = timeout;

        if (timeout <= 0) {
          clearInterval(interval);
          interval = null;
          window.location.href = url;
        }
      }
    </script>
  </head>
  <body onload="interval = window.setInterval(refresh_countdown, 1000);">
    <h1>An error as occurred</h1>
    <div>Error: $message</div>
    <div>Refresh in <span id="timeout">$timeout</span> sec.</div>
  </body>
</html>
__EOFEOF__;

  /* terminates here */
  exit(1);
}

function json_error($errmsg = '', $charset = '')
{
  if (!empty($charset))
    $charset = "; charset={$charset}";

  @header('Status', true, 400);
  @header("Content-Type: application/json{$charset}");

  if (empty($errmsg))
    $errmsg = 'An error has occured';

  echo json_encode(array(
    'success' => false,
    'message' => $errmsg
  ));

  exit(1);
}

function json_success($data, $charset = '')
{
  if (!empty($charset))
    $charset = "; charset={$charset}";

  @header("Content-Type: application/json{$charset}");

  echo json_encode(array(
    'success' => true,
    'result' => $data
  ));

  exit(0);
}

?>
