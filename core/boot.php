<?php
// setup tpl array to store variables
include( APPROOT . 'core/tpl.php' );

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
// Scan templates files for each overridable templates
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
// Scan js directory for files
$js_files_dir = scandir( APPROOT . 'app/js' );
$js_files = array();
foreach ( $js_files_dir as $js_files_dir_entry ) {
  if (preg_match('/\.js$/', $js_files_dir_entry)) {
    $js_files[] = $js_files_dir_entry;
  }
}
// add js file
foreach ( $js_files as $js_file ) {
  foreach ($tpl_suggestions as $sugg) {
    $js_sugg = $sugg . '.js';
    if ($js_file === $js_sugg) {
      $tpl['js'] .= '<script type="text/javascript" src="app/js/' . $js_sugg . '"></script>';
    }
  }
}

// Load active templates
include( $active_templates['vars'] );
include( $active_templates['html'] );
?>
