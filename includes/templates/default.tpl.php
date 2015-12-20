<?php
global $global_params;
global $page_params;
//ppr($global_params);
//ppr($page_params);

$init_path = PAGES_DIR.$page_params['page_dir_file_name']."_init.php";
$tpl_path = PAGES_DIR.$page_params['page_dir_file_name'].".tpl.php";

if( file_exists($init_path) )
{ 
	require_once $init_path;
}

?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<title><?php echo $page_params['page_title'];?></title>
<!--  CSS Includes In pages -->
<?php
print "<link rel=\"stylesheet\" type=\"text/css\" href=\"".CSS_URL.PAGE_CSS_STYLE."\" media=\"screen\">\n";
for($i=0; $i < count($page_params['css']); $i++){
	print "<link rel=\"stylesheet\" type=\"text/css\" href=\"".CSS_URL."{$page_params['css'][$i]}\">\n";
}
?>
<script type="text/javascript" src="<?php echo JS_URL.PAGE_JS_JQUERY;?>"></script>
<script type="text/javascript" src="<?php echo JS_URL.PAGE_JS_JSON;?>"></script>
<script type="text/javascript" src="<?php echo JS_URL.PAGE_JS_COMMON;?>"></script>
<script type="text/javascript" src="<?php echo JS_URL.PAGE_JS_FORM_VALIDATION;?>"></script>
<?php

for($i=0; $i < count($page_params['js']); $i++) {
	print "<script type=\"text/javascript\" src=\"".JS_URL."{$page_params['js'][$i]}\"> </script>\n";

}

?>
<script>
window.HOSTURL="<?php echo $adminUrl;?>";
window.BETAHOSTURL="<?php echo $betaAdminUrl;?>";
window.COMPANYURL="<?php echo "COMPANY_URL";?>";
window.ALLOWED_URL=<?php echo ALLOWED_URL;?>;
window.ALLOWED_ALPHANUM=<?php echo ALLOWED_ALPHANUM;?>;
window.ALLOWED_EMAIL=<?php echo ALLOWED_EMAIL;?>;
window.ALLOWED_ALPHABETIC=<?php echo ALLOWED_ALPHABETIC;?>;
window.ALLOWED_USER_NAMES=<?php echo ALLOWED_USER_NAMES;?>;
window.ALLOWED_NUMERIC_UNSIGNED=<?php echo ALLOWED_NUMERIC_UNSIGNED;?>;
window.ALLOWED_FEED_DETAILS=<?php echo ALLOWED_FEED_DETAILS;?>;
window.ACCOUNT_NAME_PATTERN=<?php echo ACCOUNT_NAME_PATTERN;?>;
window.ALLOWED_DECIMAL_WITHOUT_HYPHEN=<?php echo ALLOWED_DECIMAL_WITHOUT_HYPHEN;?>;
</script>
</head>

<body>
    <?php
    if( $global_params['page_arguments']['gtp'][0] != "login" ) {
    ?>
<!-- Header incl. Navigation & Search -->
	<header>
		<div class="wrap">
			<nav>
				<ul>
                                        <li><a href="/hotels/waitTime.html" title="Wait Time">Wait Time</a></li>
					<li><a href="/hotels/manageRest.html" title="Manage">Manage</a></li>
					<li><a href="/shop/cart.html" title="Cart">Cart</a></li>
					<li><a href="javascript:void(0);" title="Contact">Contact</a></li>
				</ul>
			</nav>
		</div>
	</header>
	
	<!-- Title incl. Logo & Social Media Buttons -->
	<section id="title">
		<h1><a href="/shop/shop.html" title="Logo"><img src="<?php echo IMAGE_URL;?>logo.png" alt="Logo" /></a></h1>
		<ul>
			<li class="twitter"><a href="http://twitter.com/" title="Twitter">Twitter</a></li>
			<li class="facebook"><a href="http://facebook.com/" title="Facebook">Facebook</a></li>
		</ul>
	</section>
    <?php } ?>
	<section id="content">
<?php 
if(file_exists($tpl_path))
{
	require_once $tpl_path;
}
?>
	</section>
		<!-- Footer incl. Copyright and Secondary Navigation -->
	<footer>
		<p><b>Copyright &copy; 2012 Pranav Thakker</b> All Rights Reserved.</p>
		<nav>
			<ul>
				<li><a href="/shop/shop.html" title="Shop">Shop</a></li>
				<li><a href="/shop/cart.html" title="Cart">Cart</a></li>
				<li><a href="javascrip:void(0);" title="Blog">Blog</a></li>
				<li><a href="javascrip:void(0);" title="About">About</a></li>
			</ul>
		</nav>
	</footer>
</body>
</html>