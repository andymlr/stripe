<?php
class Webhook extends Trongate {
	
	function webhook() {
		// Set your secret key. Remember to switch to your live secret key in production!
		// See your keys here: https://dashboard.stripe.com/account/apikeys
		\Stripe\Stripe::setApiKey(SECRET_STRIPE_API_KEY);

		$payload = @file_get_contents('php://input');
		$event = null;

		try {
		    $event = \Stripe\Event::constructFrom(
		        json_decode($payload, true)
		    );
		} catch(\UnexpectedValueException $e) {
		    // Invalid payload
		    http_response_code(400);
		    exit();
		}

		// Handle the event
		switch ($event->type) {
		    case 'payment_intent.succeeded':
		        $paymentIntent = $event->data->object; // contains a StripePaymentIntent
		        handlePaymentIntentSucceeded($paymentIntent);
		        break;
		    case 'payment_method.attached':
		        $paymentMethod = $event->data->object; // contains a StripePaymentMethod
		        handlePaymentMethodAttached($paymentMethod);
		        break;
		    case 'charge.succeeded':
		        $paymentMethod = $event->data->object; // contains a StripePaymentMethod
		        handleChargeSucceeded($charge);
		        break;
		    // ... handle other event types
		    default:
		        // Unexpected event type
		        http_response_code(400);
		        exit();
		}

		http_response_code(200);
	}

}