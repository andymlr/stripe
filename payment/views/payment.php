<script src="https://js.stripe.com/v3/"></script>

<p style="text-align: center; margin-top: 3em;">
	<button class="btn btn-success" id="checkout-button" value="<?= $session->id ?>">
    	Checkout
	</button>
</p>
		

<script type="text/javascript">
	var id = document.getElementById("checkout-button").value;
	var stripe = Stripe("<?= PUBLIC_STRIPE_API_KEY ?>");
	var elements = stripe.elements();

	var checkoutButton = document.getElementById("checkout-button");

	checkoutButton.addEventListener("click", function() {
	  stripe.redirectToCheckout({
	    // Make the id field from the Checkout Session creation API response
	    // available to this file, so you can provide it as argument here
	    // instead of the {{CHECKOUT_SESSION_ID}} placeholder.
	    sessionId: id
	  }).then(function (result) {
	    // If `redirectToCheckout` fails due to a browser or network
	    // error, display the localized error message to your customer
	    // using `result.error.message`.
	  });
	});

</script>