<?php
class Stripe extends Trongate {

	function thanks() {
		$sql = '
				SELECT
				store_item_colors.item_color,
				store_item_sizes.item_size,
				store_items.item_title,
				store_items.item_price,
				store_basket.*
				FROM
				store_basket
				LEFT JOIN store_items
				ON store_basket.item_id = store_items.id 
				LEFT JOIN store_item_colors
				ON store_basket.item_color_id = store_item_colors.id 
				LEFT JOIN store_item_sizes
				ON store_basket.item_size_id = store_item_sizes.id
				WHERE store_basket.session_id = :session_id';

		$query_data['session_id'] = session_id();
		$items = $this->model->query_bind($sql, $query_data, 'object');


		$sql2 = 'delete from store_basket where session_id = :session_id';
		$params['session_id'] = session_id();
		$this->model->query_bind($sql2, $params);

		$data['view_module'] = 'stripe';
		$data['view_file'] = 'thanks';
		$this->template('public_defiant', $data);
	}
	
}