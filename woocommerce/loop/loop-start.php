 <?php
/**
 * Product Loop Start
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */
global $woocommerce, $woocommerce_loop, $bigcloudcms_premium;
if(isset($bigcloudcms_premium['bigcloudcms_animate_in']) && $bigcloudcms_premium['bigcloudcms_animate_in'] == 1) {$animate = 1;} else {$animate = 0;}
if(isset($bigcloudcms_premium['product_fitrows']) && $bigcloudcms_premium['product_fitrows'] == 1) {$style = 'fitRows';} else {$style = 'masonry';}
 if ( empty( $woocommerce_loop['columns'] ) ) {
 	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
 }
 $woocommerce_loop['rand'] = $woocommerce_loop['columns'];

  if(bigcloudcms_display_sidebar()) {
            $columns = "shopcolumn".$woocommerce_loop['columns']." shopsidebarwidth"; 
      } else {
			$columns = "shopcolumn".$woocommerce_loop['columns']." shopfullwidth"; 
      }
?>
<div id="product_wrapper<?php echo $woocommerce_loop['rand'];?>" class="products kad_product_wrapper rowtight <?php echo esc_attr($columns); ?> init-isotope" data-fade-in="<?php echo esc_attr($animate);?>" data-iso-selector=".kad_product" data-iso-style="<?php echo esc_attr($style);?>" data-iso-filter="true">