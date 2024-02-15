<?php
// custom plugin by yusuf eko n.
/**
 * Plugin Name: Malika Update
 * Plugin URI: http://malika.id/
 * Description: Custom Update Management for Product Woocommerce
 * Version: 0.0.5
 * Author: Yusuf Eko N.
 * Author URI: http://malika.id/
 */
 
  function plugin_malika_update_product(){
	 return '';
 }
 
 add_action( 'wp_ajax_update_stock_malika','plugin_malika_update_product');

 function update_stock_malika(){
	if(!isset($_POST['type'])){
		return '';
	}
	
	if(!isset($_POST['sku'])){
		return '';
	}
	
	if(!isset($_POST['data'])){
		return '';
	}
	
	$type = $_POST['type'];
	$sku = $_POST['sku'];
	$dt = $_POST['data'];
	$dt = json_decode($dt,true);
	malika_callback_update($type,$sku,$dt);
}

function malika_callback_update($tp,$sku,$dt){
	$dt = $dt['name'];
	switch($tp){
		case 'update':
			update_data($sku,$dt);
			break;
		case 'add':
			//add_data($sku,$dt);
			break;
		case 'remove':
			//remove_data($sku,$dt);
			break;
		default:
			break;
	}
}

function update_data($sku,$dt){
$pid = wc_get_product_id_by_sku($sku);
$tp = 'all';
	switch($tp){
		case 'all':
/*		
		case 'nama':
			$name_product = array(
				'ID'           => $pid,
				'post_title'   => $dt['name']
			);
			wp_update_post($name_product);

		case 'harga':
			update_post_meta($pid, '_regular_price', $dt['price']);
*/			
		case 'stock':
			print_r($dt['total_stock']);
			wc_update_product_stock($pid,$dt['total_stock']);
			break;
			
		default:
			break;
	}
}

add_action('wp_enqueue_scripts', 'malika_script');
function malika_script() {
    wp_enqueue_script(
        'firebase',
        'https://www.gstatic.com/firebasejs/4.12.1/firebase.js'
    );
	wp_enqueue_script(
        'malika_firebase',
       plugin_dir_url(__FILE__).'asset/js/conn_firebase.js'
    );
}

add_action('wp_footer','malika_conn_firebase');
function malika_conn_firebase(){ ?>
		<script>
			conn_firebase();
			var db_fire = firebase.database();
			malika_update_data(db_fire);
		</script>
<?php
}