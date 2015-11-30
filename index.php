<?php
ob_start();
require_once "includes/config/config.inc.php";

$global_params['template'] = 'default';

_init();
display_template();
?>
