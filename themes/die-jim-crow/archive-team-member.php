<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Die_Jim_Crow
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title">
					<?php post_type_archive_title(); ?>
				</h1>
			</header><!-- .page-header -->

			<?php //fetch terms
				$terms = get_terms( 'team-member-category', array(
				    'orderby'    => 'term_id',
				    'hide_empty' => 0,
				) );
			?>

			<?php 
			// Get each bio category term
			foreach( $terms as $term ) :

				// Define the query
				$args = array(
					'post_type' => 'team-member',
					'tax_query' => array(
						array(
							'taxonomy' => 'team-member-category',
							'field'    => 'slug',
							'terms'    => $term->slug,
							'posts_per_page' => -1,
						),
					),
				);
				$query = new WP_Query( $args ); ?>

				<h2 class="entry-title"><?php echo $term->name; ?></h2>

			<div class="bio-list">

			<?php
			/* Start the Loop */
			while ( $query->have_posts() ) : $query->the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'bio' );

			endwhile; ?>

			</div>

		<?php endforeach; ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>


		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
