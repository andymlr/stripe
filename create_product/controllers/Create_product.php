<?php
class Create_product extends Trongate {

	function stripe_client() {
		$stripe = new \Stripe\StripeClient(
		  SECRECT_STRIPE_API_KEY
		);

		return $stripe;
	}

	//$data coming from store_items/create
	function _create_product($data) {
		$this->stripe_client();

		$product = $stripe->products->create([
		  'name' => 'Blue banana',
		]);

		$product_id = $product_id->id;

		$price = $stripe->prices->create([
		  'product' => $product_id,
		  'unit_amount' => $item_price,
		  'currency' => 'usd',
		  'recurring' => [
		    'interval' => 'month',
		  ],
		]);
	}

	function _update_product($data) {
		$this->stripe_client();

		$stripe->products->update(
		  $product_id,
		  'descritpion' => $descritpion,
		  'name' => $item_title,
		  'images' => $picture,
		  'url' => $url_string,
		);
	}

}