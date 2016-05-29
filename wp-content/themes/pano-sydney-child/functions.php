<?php

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

}

// remove comments from the Jetpack Carosel (on the photography page)
function filter_media_comment_status( $open, $post_id ) {
	$post = get_post( $post_id );
	if( $post->post_type == 'attachment' ) {
		return false;
	}
	return $open;
}
add_filter( 'comments_open', 'filter_media_comment_status', 10 , 2 );

// "Our Team" shortcode for the About page
function our_team_function() {
  
	$r = new WP_Query(array(
	'no_found_rows'       => true,
	'post_status'         => 'publish',
	'post_type' 		  		=> 'employees',
	'posts_per_page'	  	=> $number,
	'category_name'		  	=> $category			
	) );

	ob_start();
	?>
	
	<div class="row">
	<h3 class="our-team-headline">Our Team</h3>

		<?php if ($r->have_posts()) : while ( $r->have_posts() ) : $r->the_post(); 
			$position = get_post_meta( get_the_ID(), 'wpcf-position', true );
		?>

		<div class="team-member col-md-3 col-sm-6">
			<div class="avatar">
				<?php the_post_thumbnail('sydney-medium-thumb'); ?>
			</div>
			<div class="name"><?php the_title(); ?></div>
			<div class="pos"><?php echo esc_html($position); ?></div>
		</div>

		<?php endwhile; endif; ?>
	</div><!-- /.row -->

<?php

	return ob_get_clean();

}

add_shortcode('our_team', 'our_team_function');

function pricing_packages_function() {

	ob_start();
	?>

	<div class="pricing-packages">
		<div class="pricing-col">
			Column 1

		</div>

		<div class="pricing-col">
			Column 2

		</div>

		<div class="pricing-col">
			Column 3

		</div>
	</div>
	
	<?php
		return ob_get_clean();


}

add_shortcode('pricing_packages', 'pricing_packages_function');
