<?php
/**
 * Products Carousel Tabs
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( empty( $args['tabs'] ) ) {
	return;
}

$section_class = empty( $section_class ) ? 'section-products-carousel-tabs' : $section_class . ' section-products-carousel-tabs';
$section_class = ( isset( $carousel_args['slidesPerRow'] ) && $carousel_args['slidesPerRow'] > 1 ) ? $section_class . ' row-multiple' : $section_class;

if ( ! empty( $animation ) ) {
	$section_class .= ' animate-in-view';
}

$header_nav_align = empty( $header_nav_align ) ? 'justify-content-end' : $header_nav_align;

$default_active_tab = empty( $default_active_tab ) ? 0 : $default_active_tab;

$tab_uniqid = 'tab-' . uniqid();
?>
<section class="<?php echo esc_attr( $section_class ); ?>" <?php if ( ! empty( $animation ) ): ?>data-animation="<?php echo esc_attr( $animation );?>"<?php endif; ?>>

	<div class="section-products-carousel-tabs-wrap">

		<header class="section-header">
			<?php if( ! empty( $section_title ) ) : ?>
				<h2 class="section-title"><?php echo wp_kses_post ( $section_title ); ?></h2>
			<?php endif; ?>
			<ul class="nav <?php echo esc_attr( $header_nav_align ); ?>" role="tablist">
				<?php foreach( $args['tabs'] as $key => $tab ) :

					$tab_id = $tab_uniqid . $key; ?>

					<?php if ( !empty( $tab['title'] ) ) : ?>

					<li class="nav-item">
						<a data-toggle="tab" href="#<?php echo esc_attr( $tab_id ); ?>" class="nav-link <?php if ( $key == $default_active_tab ) echo esc_attr( 'active' ); ?>"><?php echo wp_kses_post ( $tab['title'] ); ?></a>
					</li>

					<?php endif; ?>

				<?php endforeach; ?>
			</ul>
		</header>

		<div class="tab-content">

			<?php foreach( $args['tabs'] as $key => $tab ) :

				$tab_id = $tab_uniqid . $key; ?>

				<?php if ( !empty( $tab['title'] ) ) : ?>

				<div class="tab-pane <?php if ( $key == $default_active_tab ) echo esc_attr( 'active' ); ?>" id="<?php echo esc_attr( $tab_id ); ?>" role="tabpanel">
					<?php techmarket_get_products_carousel( $tab['shortcode_tag'], $tab['shortcode_atts'], $carousel_args ) ?>
				</div>

				<?php endif; ?>

			<?php endforeach; ?>

		</div>

	</div>

</section>
