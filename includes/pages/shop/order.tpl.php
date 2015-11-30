<?php 
if( isset($err_flag) )
{
	echo $err_msg."<br />";
}
?>
<section id="left-column">
	<section class="sale">
		<div class="product-cart">
			<h1>Checkout <a href='/shop/cart.html' style="align:right;">Show cart</a></h1>
			<form method='post' action='' id='order_form' name='order_form' onsubmit='return validate_order_form(this.id);'>
			
			<ul>
				<li>
					Total Cost: <h2>Rs <?php echo $total_cost; ?></h2>
				</li>
				<li>
					Name:<br /><input type='text' id='cust_name' name='cust_name' validate='EMPTY:NAME' title='Name' value='' />
				</li>
				<li>
					Mobile No:<br /><input type='text' class='numeric' id='cust_no' name='cust_no' validate='EMPTY:NUMBER' title='Mobile No' value='' />
				</li>
				<li>
					Street Address:<br /><textarea id='cust_add' name='cust_add' value='' validate='EMPTY' title='Address'></textarea>
				</li>
				<li>
					Pincode:<br /><input type='text' class='numeric' id='cust_pincode' validate='EMPTY:NUMBER' title='Pincode' name='cust_pincode' value='' />
				</li>
				<li>
					Email id:<br /><input type='text' id='cust_email' name='cust_email' validate='EMPTY:EMAIL' title='Email' value='' />
				</li>
				<li>
					<input type='hidden' id='action' name='action' value='' />
					<input type='submit' id='submit_order' name='submit_order' value='Order' />
				</li>
			</ul>
			
			</form>
		</div>
	</section>
</section>