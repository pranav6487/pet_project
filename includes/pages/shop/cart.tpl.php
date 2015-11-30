<script type='text/javascript'>
var json_cart = "<?php echo addslashes($json_cart); ?>";

if(json_cart != '')
{
	var cart_data = $.json.decode(json_cart); //output: object;
	
}
</script>
<?php 
if( isset($err_msg) && $err_msg != "")
	echo $err_msg;
?>
<section id="left-column">
	
	<section class="sale">
	<h1>Shop for your product</h1>
	<form method='post' action='' id='shop_form' name='shop_form' onsubmit='return validate_shop_form(this.id);'>
	<ul>
		<li>
			<?php echo $scan_link; ?>
		</li>
		<li>
			Enter a product id to shop
		</li>
		<li>
			<input type='text' id='shop_pid' name='shop_pid' value='' validate='EMPTY' title='Product ID' />
			<input type='hidden' id='action_shop' name='action_shop' value='' />
			<input type='submit' id='submit_shop' name='submit_shop' value='Shop' />
		</li>
	</ul>
		</form>
		<br />
	</section>
	
	<section id="main">	
		<form id='cart_form' name='cart_form' method='post' action=''>
			
			<?php echo $tbl_str; ?>
			
			<?php if(!$no_data)
			{
			?>
			<input type='hidden' id='action' name='action' value='' />
			<input type="button" id="cancel_cart" name="cancel_cart" value="Cancel Order" onclick="cancel_order('cart_form');"/>
			<input type='button' id='submit_cart' name='submit_cart' value='Order' onclick="validate_cart_form('cart_form');" />
			<?php }?>
		</form>
	</section>
	
	<aside>
		<?php if(!$no_data)
		{
		?>
	<!-- Cart incl. Summary, Product List & View Cart Link -->
		<section id="cart">
			<h2><img src="<?php echo IMAGE_URL; ?>icon-cart.png" alt="Cart" />Cart Summary</h2>
			<p>Your cart currently contains <b><?php echo count($_SESSION[$session_val]); ?> Item(s)</b> worth <b><span class="display_total_cost">Rs.<?php echo $total_cost; ?></span></b></p>
			<p class="right"><a href="javascript:void(0);" onclick="validate_cart_form('cart_form');" title="Proceed to Checkout"><b>Proceed to Checkout</b></a></p>
		</section>
		<?php }?>
	</aside>
</section>