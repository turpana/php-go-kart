<?php
$tpl_suggestions =  array();
$query_args = array();
if (isset($_GET['q'])) {
  // use query params to add template suggestions
  $query_args = explode('/', $_GET['q']);
  $i = 0;
  foreach ($query_args as $query_arg) {
    if (0 == $i) {
      $sugg = $query_arg; 
    } else {
      $sugg =  $tpl_suggestions[$i - 1] . '--' . $query_arg;
    }
    $tpl_suggestions[$i] = $sugg;
    $i ++;
  }
}
$active_templates = array();
// Scan templates files for each overridable template
$overridables = array(
  'html',
  'head',
  'body',
  'vars'
);
$overrides = scandir( APPROOT . 'app/templates');
foreach ($overridables as $overridable) {
  $override_found = FALSE;
  $needles = array($overridable . '.php');
  foreach ($tpl_suggestions as $tpl_suggestion) {
    $needles[]  = $overridable . '--' . $tpl_suggestion . '.php';
  }
  foreach ($needles as $needle) {
    if (array_search($needle, $overrides)) {
      $override_found =  APPROOT . 'app/templates/' . $needle;
    }
  }
  if ($override_found) {
    $active_templates[$overridable] = $override_found;
  } else {
    $active_templates[$overridable] = APPROOT . 'core/basetemplates/' . $overridable . '.php';
  }
}

// provide tpl array
include( APPROOT . 'core/tpl.php' );
// Load active templates
include( $active_templates['vars'] );
include( $active_templates['html'] );
?>
