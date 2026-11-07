<?php
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) { /* Woocommerce Required Start */ 

defined( 'ABSPATH' ) || exit;
global $woocommerce;
do_action( 'woocommerce_before_mini_cart' ); ?>

<?php 
//    if ( ! WC()->cart->is_empty() ) : 
    $cart = WC()->cart;
    if ( !is_null($cart) && !$cart->is_empty() ):

?>
<ol class="minicart-items">
    <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ): ?>
        <?php $bag_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key ); ?>
        <?php $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key ); ?>

        <?php if ( $bag_product && $bag_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ): ?>

            <?php $product_name = apply_filters( 'woocommerce_cart_item_name', $bag_product->get_title(), $cart_item, $cart_item_key ); ?>
            <?php $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $bag_product->get_image( 'shop_thumbnail' ), $cart_item, $cart_item_key ); ?>
            <?php $product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $bag_product ), $cart_item, $cart_item_key ); ?>
            <li class="product-cart">
                <a class="product-media"
                   href="<?php echo esc_url( get_permalink( $cart_item['product_id'] ) ) ?>">
                    <?php printf( '%s', $bag_product->get_image( array( 100, 100 ) ) ); ?>
                </a>
                <div class="product-detail">
                    <h3 class="product-name">
                        <a href="<?php echo esc_url( get_permalink( $cart_item['product_id'] ) ) ?>"><?php echo esc_html( $product_name ); ?></a>
                    </h3>
                    <div class="product-detail-info">
                        <span class="product-quantity"><?php printf( esc_html__( 'QTY : %1$s', 'royal-addons-for-elementor' ), $cart_item['quantity'] ); ?></span>
                        <?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="product-cost">' . sprintf( '%s', $product_price ) . '</span>', $cart_item, $cart_item_key ); ?>
                    </div>
                </div>
                <div class="product-remove">
                    <?php
                    echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
                        '<a href="%s" class="remove" title="%s" data-product_id="%s" data-product_sku="%s"></a>',
                        esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                        esc_html__( 'Remove this item', 'royal-addons-for-elementor' ),
                        esc_attr( $product_id ),
                        esc_attr( $bag_product->get_sku() )
                    ), $cart_item_key
                    );
                    ?>
                </div>
            </li>
        <?php endif; ?>
    <?php endforeach; ?>
</ol>

<div class="subtotal">
    <span class="total-title">Total: </span>
    <span class="total-price"><?php printf( '%s', $woocommerce->cart->get_cart_subtotal() ); ?></span>
</div>
<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>
<div class="actions">
    <a class="button button-viewcart" href="<?php echo esc_url( wc_get_cart_url() ); ?>">
        <span>View Cart</span>
    </a>
    <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>"
       class="button button-checkout"><span>Checkout</span></a>
</div>
<?php do_action( 'woocommerce_widget_shopping_cart_after_buttons' ); ?>

<?php else : ?>
<div class="minicart-list-items">
    <div class="empty-wrap">
        <div class="empty-title">No products in the cart.</div>
        <a href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>"
           class="to-cart">Start shopping</a>
    </div>
</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>


<?php } /* Woocommerce Required End */ ?>