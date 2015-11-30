<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
ini_set("display_errors",true);

//Directory constants
define("COMMON_DIR",realpath(dirname(__FILE__).'/../../../'));
define("BASE_PATH", realpath(dirname(__FILE__).'/../../'));
define("HTTP_BASE_PATH", "http://{$_SERVER['HTTP_HOST']}/");
define("INCLUDE_DIR", BASE_PATH . '/includes/');
define("FUNCTIONS_DIR",  INCLUDE_DIR . 'functions/');
define("TEMPLATE_DIR",  INCLUDE_DIR . 'templates/');
define("PAGES_DIR", INCLUDE_DIR . 'pages/');
define("CONFIG_DIR", INCLUDE_DIR . 'config/');
define("CLASS_DIR", INCLUDE_DIR . 'classes/');
define("IMAGE_URL", "/images/");
define("CSS_URL", "/css/");
define("JS_URL", "/js/");
define("LIB_DIR", INCLUDE_DIR . 'lib/');
define("HTTP_HOST_NAME",$_SERVER['HTTP_HOST']); // server host name

//Database connection URL
define("DB_URL","mysqli://root:test@123@localhost:/restaurant_db");
//Cart Cookie Const
define("CART_SESSION","cart_session_val");
define("CART_COOKIE","vst");

//Pattern Constants
define("INVALID_CHARS","/[\~\`\_\!\@\#\$\%\^\&\*\(\)\+\=\[\]\\\'\;\,\.\/\{\}\|\"\:\<\>\?]+/");
define("ALLOWED_NAMES_START_WITH","/^[\dA-Za-z]+/");
define("ALLOWED_NAMES","/^[a-zA-Z0-9]+[a-zA-Z 0-9 \- \_ ]*$/");// OLD - /^[a-zA-Z0-9]+[a-zA-Z 0-9 \- ]*$/
define("ALLOWED_NUMERIC","/^\d*(\.\d+)?$/");
define("ALLOWED_DECIMAL","/^(\d|-)?(\d|,)*\.?\d*$/");
define("ALLOWED_ALPHABETIC","/^([a-z A-Z]+)$/");
define("ALLOWED_URL","/^(((ht|f)tp(s?))\:\/\/)([0-9a-zA-Z\-]+\.)+[a-zA-Z]{2,6}(\:[0-9]+)?(\/\S*)?$/");
define("ALLOWED_TEXT","/^[^\~\`\_\!\@\#\$\%\^\&\*\(\)\+\=\-\[\]\\\'\;\,\.\/\{\}\|\"\:\<\>\?]+([a-z A-Z \,\-\.]*)[^\~\`\_\!\@\#\$\%\^\&\*\(\)\+\=\-\[\]\\\'\;\,\.\/\{\}\|\"\:\<\>\?]+$/");
define("ALLOWED_EMAIL","/^[a-z0-9]+([\.\_a-z0-9\-]+)*@[a-z0-9\-]+(\.[a-z0-9\-]+)*(\.([a-z]){2,4})$/");
define("ALLOWED_NUMERIC_UNSIGNED",'/^[0-9]+$/');
define("ALLOWED_NUMERIC_SIGNED",'/^[-]{0,1}[0-9]+$/');
define("ALLOWED_CHARACTER_REGION",'/^[a-zA-Z\(\)\s\-]+$/');
define("ALLOWED_CHARACTER_ZIP",'/^[a-zA-Z\d]+$/');
define("ALLOWED_ALPHABETIC_WITHOUT_SPACE","/^([a-zA-Z]+)$/");
define("ALLOWED_DECIMAL_HYPHEN","/^(\d|-)?(\d)*\d*$/");

define("NAME_START_WITH_ALPHA","/^[a-zA-Z]+/");
define("ACCOUNT_NAME_PATTERN","/^[a-zA-Z 0-9]+[a-zA-Z 0-9 \- \_ \& \( \)]*$/");
define("BUDGET_PATTERN","/^\d+(\.\d+)?$/");
define("COUNTRY_PATTERN","/^([a-z A-Z]+)$/");
define("COMPANY_NAME_PATTERN","/^[a-zA-Z]+[a-zA-Z 0-9 \-\_ ]*$/");
define("URL_CHECK_PATTERN","/^((http[s]?)\:\/\/)?([0-9a-zA-Z\-]+\.)+([a-zA-Z]{2,6}(\:[0-9]+)?)?(\/[^\{\}\s]*)?$/");
define("EMAIL_CHECK_PATTERN","/^[a-zA-Z0-9]+([\.\_a-zA-Z0-9\-]+)*@[a-zA-Z0-9\-]+(\.[a-zA-Z0-9\-]+)*(\.([a-zA-Z]){2,4})$/");
define("ALLOWED_USER_NAMES","/^[a-zA-Z]+[a-zA-Z0-9\-\_\.]*$/");
define("ALLOWED_FEED_DETAILS",'/^[a-zA-Z0-9\(\)\s\-\.\:\{\}\\\&\=\-\/]+$/');
define("ALLOWED_ALPHANUM","/^[a-zA-Z0-9]+[a-zA-Z 0-9 \- \_ \, ]*$/");
define("ALLOWED_DECIMAL_WITHOUT_HYPHEN","/^(\d)?(\d|,)*\.?\d*$/");

require_once CONFIG_DIR."pages.inc.php";
require_once FUNCTIONS_DIR . "common.functions.inc.php";

global $global_params;
global $page_params;
$global_params = array();
$page_params = array();

get_page_arguments();
?>