<?php
class Payment extends Trongate {

	function _create_checkout_session($data) {
		\Stripe\Stripe::setApiKey(SECRET_STRIPE_API_KEY);
		//SINGLE PAYMENT

		$item_list = [
		  'payment_method_types' => ['card', 'ideal', 'bancontact', 'giropay', 'p24', 'eps'],
		  'line_items' => [],
		  'mode' => 'payment',
		  'success_url' => BASE_URL.'stripe/thanks',
		  'cancel_url' => BASE_URL.'store_basket/display',
		  'metadata' => ['session_id' => session_id()],
		  'billing_address_collection' => 'required',
		  'shipping_address_collection' => [
		    'allowed_countries' => ['AC','AD','AE','AF','AG','AI','AL','AM','AO','AQ','AR','AT','AU','AW','AX','AZ','BA','BB','BD','BE','BF','BG','BH','BI','BJ','BL','BM','BN','BO','BQ','BR','BS','BT','BV','BW','BY','BZ','CA','CD','CF','CG','CH','CI','CK','CL','CM','CN','CO','CR','CV','CW','CY','CZ','DE','DJ','DK','DM','DO','DZ','EC','EE','EG','EH','ER','ES','ET','FI','FJ','FK','FO','FR','GA','GB','GD','GE','GF','GG','GH','GI','GL','GM','GN','GP','GQ','GR','GS','GT','GU','GW','GY','HK','HN','HR','HT','HU','ID','IE','IL','IM','IN','IO','IQ','IS','IT','JE','JM','JO','JP','KE','KG','KH','KI','KM','KN','KR','KW','KY','KZ','LA','LB','LC','LI','LK','LR','LS','LT','LU','LV','LY','MA','MC','MD','ME','MF','MG','MK','ML','MM','MN','MO','MQ','MR','MS','MT','MU','MV','MW','MX','MY','MZ','NA','NC','NE','NG','NI','NL','NO','NP','NR','NU','NZ','OM','PA','PE','PF','PG','PH','PK','PL','PM','PN','PR','PS','PT','PY','QA','RE','RO','RS','RU','RW','SA','SB','SC','SE','SG','SH','SI','SJ','SK','SL','SM','SN','SO','SR','SS','ST','SV','SX','SZ','TA','TC','TD','TF','TG','TH','TJ','TK','TL','TM','TN','TO','TR','TT','TV','TW','TZ','UA','UG','US','UY','UZ','VA','VC','VE','VG','VN','VU','WF','WS','XK','YE','YT','ZA','ZM','ZW','ZZ'],
		  ],
		];

		foreach ($data['rows'] as $item) {

			  //SINGLE PAYMENT
			$item_list['line_items'][] = [
				'price_data' => [
			      'currency' => 'eur',
			      'product_data' => [
			        'name' => $item->item_title,
			        'description' => $item->item_color,
			      ],
			      'unit_amount' => str_replace('.', '', $item->item_price),
			    ],
			    'quantity' => $item->item_qty,
			  ];
		}

		$session = \Stripe\Checkout\Session::create($item_list);

		return $session;
	}

	function _draw_button($data) {
		
		$data['session'] = $this->_create_checkout_session($data);
		$data['view_module'] = 'stripe/payment';
		$this->view('payment', $data);
	}

}


