<?php
/**
 * A template to display team member content
 */
global $post;
?>

    <?php
    $user               = esc_attr( get_post_meta( $post->ID, '_user_id', true ) );
    $role               = esc_attr( get_post_meta( $post->ID, '_byline', true ) );
    $url                = esc_attr( get_post_meta( $post->ID, '_url', true ) );
    $location           = esc_attr( get_post_meta( $post->ID, '_location', true ) );
    $prison_id          = esc_attr( get_post_meta( $post->ID, '_prison_id', true ) );
    $address          = esc_attr( get_post_meta( $post->ID, '_mailing_address', true ) );
    ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header class="entry-header">

            <?php if( has_post_thumbnail() ) : ?>

                <div class="entry-thumbnail">
                    <?php the_post_thumbnail( 'full' ); ?>
                </div>

            <?php endif; ?>

            <h3 class="entry-title">

            <?php
                if ( '' != $url && apply_filters( 'woothemes_our_team_member_url', true ) ) : ?>

                <a href="<?php echo $url; ?>"><?php the_title() ?></a>
                  
            <?php else : ?>

                <?php the_title(); ?>

            <?php endif; ?>
            </h3>

            <div class="entry-meta">

            <?php if( isset( $role ) && '' != $role ) : ?>

            	<div class="role" itemprop="jobTitle">
            		<?php echo $role; ?>
            	</div>

	        <?php endif; ?>

	        <?php if ( isset( $location ) && '' != $location ) : ?>

				<div class="location" itemprop="locale">
			        <?php echo $location; ?>
			    </div>

		    <?php endif; ?>

            <?php if ( isset( $prison_id ) && '' != $prison_id ) : ?>

                <div class="prison-id" itemprop="userId">
                     <span class="label"><?php _e( 'Prison ID #:', 'die-jim-crow' ); ?></span> <?php echo $prison_id; ?>
                </div>

            <?php endif; ?>

            <?php if ( isset( $address ) && '' != $address ) : ?>

                <div class="mailing-address" itemprop="address">
                     <span class="label"><?php _e( 'Write to me at:', 'die-jim-crow' ); ?></span> <?php echo $address; ?>
                </div>

            <?php endif; ?>
            	
            </div>

        </header><!-- .entry-header -->

        <div class="entry-content">

            <?php the_content(); ?>

        </div><!-- .entry-content -->

        <footer class="entry-footer">
           
        </footer><!-- .entry-meta -->
    </article><!-- #post -->