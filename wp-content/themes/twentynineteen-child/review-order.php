<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

defined( 'ABSPATH' ) || exit;
?>
<table border="0" cellpadding="0" cellspacing="0" class="shop_table woocommerce-checkout-review-order-table">
	<!-- <thead>
<tr>
<th class="product-name"><?php// esc_html_e( 'Product', 'woocommerce' ); ?></th>
<th class="product-total"> </th>
</tr>
</thead> -->
	<tbody>
		<?php
		do_action( 'woocommerce_review_order_before_cart_contents' );

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
		?>
		<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
			<td class="product-name">


				<span class="item-thumb-review">

					<?php 
				$get_image = get_the_post_thumbnail_url($_product->get_id(),'full'); 

				if (!$get_image) {
					$main_product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
					$get_image = get_the_post_thumbnail_url($main_product_id,'full'); 
				}
				if(!isset($get_image)|| $get_image == ''){
					$get_image = get_stylesheet_directory_uri().'/woocommerce/inc/images/check-out-holder.png';
				}
					?>


					<img src="<?php echo get_stylesheet_directory_uri().'/woocommerce/inc/images/check-out-holder.png' ?>" style=" background-repeat: no-repeat;  background-position: center center; background-image:url(<?php echo $get_image; ?>);  ">

				</span>

			</td>
			<td class="product-total">



				<ul class="ckeck-txt">
					<li class="li-a1">


						<?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ) . '&nbsp;'; ?> <?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf( '&times;&nbsp;%s', $cart_item['quantity'] ) . '</strong>', $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</li>
					<li class="li-a2">

						<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

					</li>	
				</ul>

			</td>
		</tr>
		<?php
			}
		}

		do_action( 'woocommerce_review_order_after_cart_contents' );
		?>
	</tbody>
	<tfoot>


		<tr class="cart-subtotal">

			<td colspan="2">
				<span class="lable-txt"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></span>
				<?php wc_cart_totals_subtotal_html(); ?>
			</td>
		</tr>



		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
		<tr class="fee">
			<th><?php echo esc_html( $fee->name ); ?></th>
			<td><?php wc_cart_totals_fee_html( $fee ); ?></td>
		</tr>
		<?php endforeach; ?>



		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
		<tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">

			<td colspan="2"><span class="lable-txt"><?php wc_cart_totals_coupon_label( $coupon ); ?></span><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
		</tr>
		<?php endforeach; ?>

		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

		<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

		<?php wc_cart_totals_shipping_html(); ?>

		<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

		<?php endif; ?>



		<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

		<tr class="order-total">

			<td colspan="2" ><span class="lable-txt"><?php esc_html_e( 'Total', 'woocommerce' ); ?></span><?php wc_cart_totals_order_total_html(); ?>
			</td>
		</tr>

		<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

	</tfoot>
</table>
