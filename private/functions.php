<?php

function url_for($script_path) {
  // add the leading '/' if not present
  if($script_path[0] != '/') {
    $script_path = "/" . $script_path;
  }
  return WWW_ROOT . $script_path;
}
function camelCase($string = "", $separator = " ")
{
  $website =  str_replace($separator, '', ucwords($string, $separator));
  return $website;
}

function utf8ize( $mixed ) {
  if (is_array($mixed)) {
      foreach ($mixed as $key => $value) {
          $mixed[$key] = utf8ize($value);
      }
  } elseif (is_string($mixed)) {
      return mb_convert_encoding($mixed, "UTF-8", "UTF-8");
  }
  return $mixed;
}

function removeSpaces($string= "")
{
  return str_replace(' ', '', $string);
}
function u($string="") {
  return urlencode($string);
}

function raw_u($string="") {
  return rawurlencode($string);
}

function h($string="") {
  return htmlspecialchars($string);
}

function error_404() {
  header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
  exit();
}

function error_500() {
  header($_SERVER["SERVER_PROTOCOL"] . " 500 Internal Server Error");
  exit();
}

function redirect_to($location) {
  header("Location: " . $location);
  exit;
}

function is_post_request() {
  return $_SERVER['REQUEST_METHOD'] == 'POST';
}

function is_get_request() {
  return $_SERVER['REQUEST_METHOD'] == 'GET';
}

// PHP on Windows does not have a money_format() function.
// This is a super-simple replacement.
if(!function_exists('money_format')) {
  function money_format($format, $number) {
    return '$' . number_format($number, 2);
  }
}

?>
