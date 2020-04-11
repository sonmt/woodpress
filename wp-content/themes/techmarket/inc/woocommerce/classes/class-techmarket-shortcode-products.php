<?php
/**
 * Techmarket Products shortcode
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( class_exists( 'WC_Shortcode_Products' ) ) {
	/**
	 * Products shortcode class.
	 */
	class Techmarket_Shortcode_Products extends WC_Shortcode_Products {

		/**
		 * Generate and return the transient name for this shortcode based on the query args.
		 *
		 * @since 3.3.0
		 * @return string
		 */
		protected function get_transient_name() {
			$transient_name = 'tm_wc_loop' . substr( md5( wp_json_encode( $this->query_args ) . $this->type ), 28 );
			
			if ( 'rand' === $this->query_args['orderby'] ) {
				// When using rand, we'll cache a number of random queries and pull those to avoid querying rand on each page load.
				$rand_index      = rand( 0, max( 1, absint( apply_filters( 'woocommerce_product_query_max_rand_cache_count', 5 ) ) ) );
				$transient_name .= $rand_index;
			}
			
			$transient_name .= WC_Cache_Helper::get_transient_version( 'product_query' );
			
			return $transient_name;
		}

		/**
		 * Get products.
		 *
		 * @since  3.2.0
		 * @return WP_Query
		 */
		public function get_products() {
			$transient_name = $this->get_transient_name();
			$products       = get_transient( $transient_name );
			
			if ( false === $products || ! is_a( $products, 'WP_Query' ) ) {
				if ( 'top_rated_products' === $this->type ) {
					add_filter( 'posts_clauses', array( __CLASS__, 'order_by_rating_post_clauses' ) );
					$products = new WP_Query( $this->query_args );
					remove_filter( 'posts_clauses', array( __CLASS__, 'order_by_rating_post_clauses' ) );
				} else {
					$products = new WP_Query( $this->query_args );
				}
				set_transient( $transient_name, $products, DAY_IN_SECONDS * 30 );
			}
			
			// Remove ordering query arguments.
			if ( ! empty( $this->attributes['category'] ) ) {
				WC()->query->remove_ordering_args();
			}
			
			return $products;
		}
	}
}