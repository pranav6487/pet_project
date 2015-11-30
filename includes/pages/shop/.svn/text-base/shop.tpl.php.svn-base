<?php 
if( isset($_SESSION['error_code']) &&  $_SESSION['error_code'] == 0)
{
	echo $_SESSION['err_msg']."<br />";
	unset($_SESSION['error_code']);
	unset($_SESSION['err_msg']);
}

if( isset($err_msg) && $err_msg != "")
	echo $err_msg;
?>
<section id="left-column">
	<section class="sale">
		<h1>Shop for your product</h1>
		<form method='post' action='' id='shop_form' name='shop_form' onsubmit='return validate_shop_form(this.id);'>
		<ul>
			<li><?php echo $scan_link; ?></li>
			<li>
				Enter a product id to shop:&nbsp;
			</li>
			<li>
				<input type='text' id='shop_pid' name='shop_pid' value='' validate='EMPTY' title='Product ID' />
				<input type='hidden' id='action_shop' name='action_shop' value='' />
				<input type='submit' id='submit_shop' name='submit_shop' value='Shop' />
			</li>
		</ul>
		</form>
	</section>
	
	<aside>
		<!-- Cart incl. Summary, Product List & View Cart Link -->
		<section id="cart">
			<h2><a href="/shop/cart.html" title="View Cart"><img src="<?php echo IMAGE_URL; ?>icon-cart.png" alt="Cart" /></a>Shopping Cart</h2>
			<?php if( isset($str) )
			{
			?>
			<p>Your cart currently contains <b><?php echo count($_SESSION[$session_val]); ?> Item(s)</b> worth <b>Rs<?php echo $total_cost; ?></b></p>
			<?php echo $str; ?>
			<p class="right"><a href="/shop/cart.html" title="View Cart"><b>View Cart</b></a></p>
			<?php 
			}
			else
			{
			?>
			<p>Your cart currently contains no items</p>
			<?php }?>
		</section>
	</aside>
</section>