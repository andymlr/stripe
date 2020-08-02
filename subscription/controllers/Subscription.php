<?php
class Subscription extends Trongate {

	function _create_subscription_session($item) {
		\Stripe\Stripe::setApiKey(SECRET_STRIPE_API_KEY);
		//SINGLE PAYMENT

		// $price = \Stripe\Price::create([
		//   'product' => 'prod_Hk7HrPzbYAZKT4',
		//   'unit_amount' => 1000,
		//   'currency' => 'usd',
		//   'recurring' => [
		//     'interval' => 'month',
		//   ],
		// ]);

		$session = \Stripe\Checkout\Session::create([
		  'payment_method_types' => ['card'],
		  'line_items' => [[
		    'price' => 'price_1HBkCtDBxAwVek3tMeCwzU7k',
		    'quantity' => 1,
		    ]],
		  'mode' => 'subscription',
		  'success_url' => BASE_URL.'stripe/thankyou',
		  'cancel_url' => BASE_URL.'store_basket/display',
		  'metadata' => ['session_id' => session_id()],
		]);

		return $session;
	}

	function _draw_subscription_button() {
		
		$session = $this->_create_subscription_session($item);
		$data['view_module'] = 'stripe/subscription';
		$this->view('subscription', $data);

		
	}

}