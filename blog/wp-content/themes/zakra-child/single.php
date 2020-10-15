<?php
/**
 * The template for displaying all single posts
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package zakra
 */

get_header();
?>

	<div id="primary" class="content-area">
		<?php echo apply_filters( 'zakra_after_primary_start_filter', false ); // WPCS: XSS OK. ?>
		
		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content-single', get_post_type() );

			do_action( 'zakra_after_single_post_content' );
			?>
				<div class="share-outer-wrapper">
					<h5 class="share">Share</h5>
					<div class="addthis_inline_share_toolbox"></div>
				</div>
			<!-- // If comments are open or we have at least one comment, load up the comment template. -->
			<?php if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>
		
		<?php echo apply_filters( 'zakra_after_primary_end_filter', false ); // // WPCS: XSS OK. ?>
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
