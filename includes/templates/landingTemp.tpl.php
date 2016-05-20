<?php
global $global_params;
global $page_params;

$init_path = PAGES_DIR.$page_params['page_dir_file_name']."_init.php";
$tpl_path = PAGES_DIR.$page_params['page_dir_file_name'].".tpl.php";

if( file_exists($init_path) )
{ 
	require_once $init_path;
}

if(file_exists($tpl_path))
{
	require_once $tpl_path;
}
?>