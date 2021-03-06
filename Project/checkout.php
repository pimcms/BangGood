<!DOCTYPE html>
<html lang="en">

<?php    $title = "Check out"; ?>


<!-- top-header -->
<?php
		require_once('model/Product/Product.php'); 
		require_once('model/Cart/Cart.php'); 
		require_once('model/Cart/Order.php'); 
		require_once('header.php');
		require_once("model/Address.php");


		$cart = new Cart($_SESSION["user_id"]);

		$arrCart = $cart->getCart();

		if(count($arrCart) < 1){
			echo "<script>alert('Your Cart Is Empty. You can Check Out our new products'); window.location='product.php';</script>";
		}

		if(isset($_POST["confirm_order"])){
			
			$name = $_POST["name"];
			$mono = $_POST["mono"];
			$orderNote = $_POST["order_note"];
			$add_id = $_POST["address_id"];


			$args = [
				"user_id" => $_SESSION["user_id"],
				"name" => $name,
				"address" => $add_id,
				"contact_num" => $mono,
				"payment_type" => "COD",
				"payment_status" => "Remain",
				"order_note" => $orderNote,
			];


			$order = new Order();
			$order->generateOrder($args);
			$isChecked = $order->checkOutCart($arrCart);

			if($isChecked){
				$cart->removeAllCartProduct();
			}
			
			echo "<script>alert('Order Placed Successfully'); window.location='cart.php';</script>";

		}

		$add = getAllAddress($_SESSION["user_id"]);

	?>
<!-- //top-header -->

<!-- navigation -->
<?php require_once('nevigation.php');?>
<!-- //navigation -->
<?php
//print_r($_POST);
//echo count($_POST);
/*foreach ($_POST as $key => $value) {
	echo "Field ==== ".htmlspecialchars($key)."   is === ".htmlspecialchars($value)."<br>";
}*/
?>


<!-- checkout page -->
<div class="privacy py-sm-5 py-4">
	<div class="container py-xl-4 py-lg-2">
		<!-- tittle heading -->
		<h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">
			<span>C</span>heckout
		</h3>
		<!-- //tittle heading -->
		<div class="checkout-right">
			<h4 class="mb-sm-4 mb-3">Your shopping cart contains:
				<span><?php echo $cart->getTotalProduct();?> Products</span>
			</h4>

		</div>
		<div class="checkout-left">
			<div class="address_form_agile mt-sm-5 mt-4">
				<h4 class="mb-sm-4 mb-3">Add a new Details</h4>
				<form method="post" class="creditly-card-form agileinfo_form">
					<div class="creditly-wrapper wthree, w3_agileits_wrapper">
						<div class="information-wrapper">
							<div class="first-row">

								<?php
        $counter = 0;
        foreach ($add as $address) {
            $counter++;
    ?>
								<div class="wrapper col-md-12 col-xs-12" id="addDiv<?php echo $counter; ?>">
									<div class="product-sec1 px-3  py-3 mb-4">
										<table style="width:100%;" class="table table-striped table-bordered"
											data-page-length='10'>
											<tr>
												<td style="vertical-align: middle; width:1%;">
													
													<input  class="form-control" type="radio"  name="address_id" <?php echo $counter == 1 ? "checked='checked'" : ""; ?> value="<?php echo $address->id; ?>">

												</td>

												<td style="width:22%;vertical-align: middle;">
													<p class="text-info">Address Line 1 :<span
															class="text-dark"><?php echo $address->add_line1; ?></span>
													</p>
													<hr style="margin-top:10px; margin-bottom:10px;" />
													<p class="text-info">Address Line 2 :<span
															class="text-dark "><?php echo $address->add_line2; ?></span>
													</p>

													<hr style="margin-top:10px; margin-bottom:10px;" />
													<p class="text-info">Pincode :<span
															class="text-dark"><?php echo $address->pincode; ?></span>
													</p>
													<hr style="margin-top:10px; margin-bottom:10px;" />
													<p class="text-info">City :<span
															class="text-dark"><?php echo $address->city; ?></span></p>
													<hr style="margin-top:10px; margin-bottom:10px;" />
													<p class="text-info">State :<span
															class="text-dark"><?php echo $address->state; ?></span>
													</p>

												</td>

												
											</tr>
										</table>
									</div>
								</div>


								<?php 
    
        }

    ?>

								<div class="controls form-group">
									<input class="billing-address-name form-control" type="text" name="name"
										placeholder="Full Name" required="">
								</div>
								<div class="w3_agileits_card_number_grids">
									<div class="w3_agileits_card_number_grid_left form-group">
										<div class="controls">
											<input type="text" class="form-control" placeholder="Mobile Number"
												name="mono" required="true" onKeyPress="return isnumkey(this);" maxlength="10">
										</div>
									</div>
									
								</div>

								

								<div class="controls form-group">
									Order Note :
									<textarea name="order_note" class="form-control" required=required></textarea>
								</div>

								
							</div>
							<input type="submit" name="confirm_order" class="btn btn-primary" value="Confirm Order">
						</div>
					</div>
				</form>
				<!--<div class="checkout-right-basket">
						<a href="payment.php">Make a Payment
							<span class="far fa-hand-point-right"></span>
						</a>-->
			</div>
		</div>
	</div>
</div>
</div>
<!-- //checkout page -->

<!-- middle section 
	<div class="join-w3l1 py-sm-5 py-4">
		<div class="container py-xl-4 py-lg-2">
			<div class="row">
				<div class="col-lg-6">
					<div class="join-agile text-left p-4">
						<div class="row">
							<div class="col-sm-7 offer-name">
								<h6>Smooth, Rich & Loud Audio</h6>
								<h4 class="mt-2 mb-3">Branded Headphones</h4>
								<p>Sale up to 25% off all in store</p>
							</div>
							<div class="col-sm-5 offerimg-w3l">
								<img src="images/off1.png" alt="" class="img-fluid">
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6 mt-lg-0 mt-5">
					<div class="join-agile text-left p-4">
						<div class="row ">
							<div class="col-sm-7 offer-name">
								<h6>A Bigger Phone</h6>
								<h4 class="mt-2 mb-3">Smart Phones 5</h4>
								<p>Free shipping order over $100</p>
							</div>
							<div class="col-sm-5 offerimg-w3l">
								<img src="images/off2.png" alt="" class="img-fluid">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>-->
<!-- middle section -->

<!-- footer -->
<?php require_once('footer.php')?>
<!-- //footer -->
<!-- quantity -->
<script>
	$('.value-plus').on('click', function () {
		var divUpd = $(this).parent().find('.value'),
			newVal = parseInt(divUpd.text(), 10) + 1;
		divUpd.text(newVal);
	});

	$('.value-minus').on('click', function () {
		var divUpd = $(this).parent().find('.value'),
			newVal = parseInt(divUpd.text(), 10) - 1;
		if (newVal >= 1) divUpd.text(newVal);
	});
</script>
<!--quantity-->
<script>
	$(document).ready(function (c) {
		$('.close1').on('click', function (c) {
			$('.rem1').fadeOut('slow', function (c) {
				$('.rem1').remove();
			});
		});
	});
</script>
<script>
	$(document).ready(function (c) {
		$('.close2').on('click', function (c) {
			$('.rem2').fadeOut('slow', function (c) {
				$('.rem2').remove();
			});
		});
	});
</script>
<script>
	$(document).ready(function (c) {
		$('.close3').on('click', function (c) {
			$('.rem3').fadeOut('slow', function (c) {
				$('.rem3').remove();
			});
		});
	});
</script>
<!-- //quantity -->

</body>

</html>