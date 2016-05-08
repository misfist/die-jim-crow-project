<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Die_Jim_Crow
 */

if ( ! function_exists( 'die_jim_crow_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function die_jim_crow_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		esc_html_x( 'Posted on %s', 'post date', 'die-jim-crow' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		esc_html_x( 'by %s', 'post author', 'die-jim-crow' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

}
endif;

if ( ! function_exists( 'die_jim_crow_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function die_jim_crow_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'die-jim-crow' ) );
		if ( $categories_list && die_jim_crow_categorized_blog() ) {
			printf( '<span class="cat-links"><i class="tag"></i>' . esc_html__( 'More %1$s', 'die-jim-crow' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'die-jim-crow' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'die-jim-crow' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		/* translators: %s: post title */
		comments_popup_link( sprintf( wp_kses( __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'die-jim-crow' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
		echo '</span>';
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'die-jim-crow' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>'
	);
}
endif;


if ( ! function_exists( 'die_jim_crow_categorized_blog' ) ) :
/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function die_jim_crow_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'die_jim_crow_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'die_jim_crow_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so die_jim_crow_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so die_jim_crow_categorized_blog should return false.
		return false;
	}
}
endif;

/**
 * Flush out the transients used in die_jim_crow_categorized_blog.
 */
function die_jim_crow_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'die_jim_crow_categories' );
}
add_action( 'edit_category', 'die_jim_crow_category_transient_flusher' );
add_action( 'save_post',     'die_jim_crow_category_transient_flusher' );

/**
 * Add home class to homepage
 */
if ( ! function_exists( 'die_jim_crow_class_names' ) ) :

	function die_jim_crow_class_names( $classes ) {
		if( is_home() ) {
			$classes[] = 'home';
		}
		return $classes;
	}

add_filter( 'body_class', 'die_jim_crow_class_names' );

endif;


/**
 * Remove 'Category' from category archive pages
 */
if ( ! function_exists( 'die_jim_crow_the_archive_title' ) ) :

	function die_jim_crow_the_archive_title( $title ) {

		if( is_category() ) {
			$title = single_cat_title( '', false );
		}
		if( is_post_type_archive() ) {
			$title = post_type_archive_title( '', false );
		}

		return $title;

	}

	add_filter( 'get_the_archive_title', 'die_jim_crow_the_archive_title' );

endif;


/**
 * Filter the except length to 20 characters.
 *
 * @param int $length Excerpt length.
 * @return int (Maybe) modified excerpt length.
 */
if ( ! function_exists( 'die_jim_crow_custom_excerpt' ) ) :
	function die_jim_crow_custom_excerpt( $text ) {
		$raw_excerpt = $text;

		if ( '' == $text ) {
		    //Retrieve the post content. 
		    $text = get_the_content( '' );
		 
		    //Delete all shortcode tags from the content. 
		    // $text = strip_shortcodes( $text );
		 
		    $text = apply_filters( 'the_content', $text );
		    $text = str_replace( ']]>', ']]&gt;', $text );
		     
		    $allowed_tags = 'iframe, a, p'; 
		    $text = strip_tags( $text, $allowed_tags );
		     
		    $excerpt_word_count = 20;
		    $excerpt_length = apply_filters( 'excerpt_length', $excerpt_word_count ); 
		     
		    $excerpt_end = ' Read More'; 
		    $excerpt_more = apply_filters( 'excerpt_more', ' ' . $excerpt_end );
		     
		    $words = preg_split( "/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY );
		    if ( count( $words ) > $excerpt_length ) {
		        array_pop( $words );
		        $text = implode( ' ', $words );
		        $text = $text . $excerpt_more;
		    } else {
		        $text = implode( ' ', $words );
		    }
		}
		return apply_filters( 'wp_trim_excerpt', $text, $raw_excerpt );
	}
	remove_filter( 'get_the_excerpt', 'wp_trim_excerpt' );
	add_filter( 'get_the_excerpt', 'die_jim_crow_custom_excerpt' );
endif;


/**
 * Filter the "read more" excerpt string link to the post.
 *
 * @param string $more "Read more" excerpt string.
 * @return string (Maybe) modified "read more" excerpt string.
 */
if ( ! function_exists( 'die_jim_crow_excerpt_more' ) ) :
	function die_jim_crow_excerpt_more( $more ) {
	    return sprintf( '<a class="read-more" href="%1$s">%2$s</a>',
	        get_permalink( get_the_ID() ),
	        __( ' Read More', 'die-jim-crow' )
	    );
	}
	add_filter( 'excerpt_more', 'die_jim_crow_excerpt_more' );
endif;