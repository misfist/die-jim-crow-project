<?php
/**
 * Custom Theme Functions
 *
 * @package Die_Jim_Crow
 */

/**
 * Bio Functions
 * Functions affecting the `team-member` post type
 */

/**
 * Remove Fields
 * Removed `tel`, `contact_email`, `twitter`, and `user_id` fields from `team-member` post type
 * @link https://docs.woothemes.com/document/our-team-plugin/#i-do-not-need-the-role-field-can-i-disable-that
 */
add_filter( 'woothemes_our_team_member_tel', '__return_false' );

add_filter( 'woothemes_our_team_member_url', '__return_false' );

add_filter( 'woothemes_our_team_member_role', '__return_false' );

add_filter( 'woothemes_our_team_member_contact_email', '__return_false' );

add_filter( 'woothemes_our_team_member_twitter', '__return_false' );

add_filter( 'woothemes_our_team_member_user_id', '__return_false' );

add_filter( 'woothemes_our_team_member_user_search', '__return_false' );

/**
 * Add Field
 * Add `location` fields to `team-member` post type
 * @param array $fields
 * @link https://docs.woothemes.com/document/our-team-plugin/#i-need-to-add-another-field-can-i-do-it-without-touching-core-files
 */
function djc_team_add_fields( $fields ) {
    $fields['byline'] = array(
        'name'          => __( 'Role', 'die-jim-crow' ),
        'description'   => __( 'Enter person\'s role in the project (e.g. "vocals")', 'die-jim-crow' ),
        'type'          => 'text',
        'default'       => '',
        'section'       => 'info'
    );
    $fields['location'] = array(
        'name'          => __( 'Location', 'die-jim-crow' ),
        'type'          => 'text',
        'description'   => __( 'Enter person\'s location' ),
        'default'       => '',
        'section'       => 'info'
    );
    $fields['prison_id'] = array(
        'name'          => __( 'Prison #', 'die-jim-crow' ),
        'type'          => 'text',
        'description'   => __( 'Enter person\'s prison #' ),
        'default'       => '',
        'section'       => 'info'
    );
    $fields['url'] = array(
        'name'          => __( 'Website URL', 'die-jim-crow' ),
        'description'   => __( 'Enter person\'s website address (e.g. http://www.dieartwork.com/)', 'die-jim-crow' ),
        'type'          => 'url',
        'default'       => '',
        'section'       => 'info'
    );
    $fields['mailing_address'] = array(
        'name'          => __( 'Mailing Address', 'die-jim-crow' ),
        'description'   => __( 'Enter person\'s mailing address', 'die-jim-crow' ),
        'type'          => 'text',
        'default'       => '',
        'section'       => 'info'
    );
    $fields['user_search'] = array(
        'name'          => __( 'Username', 'die-jim-crow' ),
        'description'   => sprintf( __( 'Map this person to a user on this site. See the %sdocumentation%s for more info.', 'die-jim-crow' ), '<a href="' . esc_url( 'http://docs.woothemes.com/document/our-team-plugin/' ) . '" target="_blank">', '</a>' ),
        'type'          => 'text',
        'default'       => '',
        'section'       => 'info'
    );
    $fields['gravatar_email'] = array(
        'name'              => __( 'Gravatar Email', 'die-jim-crow' ),
        'description'       => '',
        'type'              => 'hidden',
        'default'           => '',
        'section'           => 'info'
    );
    return $fields;
}

add_filter( 'woothemes_our_team_member_fields', 'djc_team_add_fields' );

/**
 * Change Label Text
 * Change text displayed for `team-member` post type
 * @param array $args
 * @link https://codex.wordpress.org/Function_Reference/register_post_type#Arguments
 * 
 */
function djc_team_labels( $args ) {
    $labels['name']             = __( 'Bios', 'die-jim-crow' );
    $labels['singular_name']    = _x( 'Bio', 'post type singular name' );
    $labels['add_new_item']     = sprintf( __( 'Add New %s' ), __( 'Bio' ) );
    $labels['add_new']          = _x( 'Add New', 'bio' );
    $labels['edit_item']        = sprintf( __( 'Edit %s', 'die-jim-crow' ), __( 'Bio', 'die-jim-crow' ) );
    $labels['new_item']        = sprintf( __( 'New %s', 'die-jim-crow' ), __( 'Bio', 'die-jim-crow' ) );
    $labels['all_items']        = sprintf( __( 'All %s', 'die-jim-crow' ), __( 'Bios', 'die-jim-crow' ) );
    $labels['view_item']        = sprintf( __( 'View %s', 'die-jim-crow' ), __( 'Bio', 'die-jim-crow' ) );
    $labels['search_items']        = sprintf( __( 'Search %s', 'die-jim-crow' ), __( 'Bios', 'die-jim-crow' ) );
    $labels['not_found']        = __( 'None Found', 'die-jim-crow' );
    $labels['not_found_in_trash']        = __( 'None Found in Trash', 'die-jim-crow' );
    $labels['menu_name']        = __( 'Bios', 'die-jim-crow' );
    $args['labels']             = $labels;

    return $args;
}

add_filter( 'woothemes_our_team_post_type_args', 'djc_team_labels' );

/**
 * Change Single Slug
 *
 * Change the post slug for single `team-member` posts to `bio`
 * @link https://codex.wordpress.org/Function_Reference/register_post_type#rewrite
 * 
 */
function djc_team_single_slug() {
    return _x( 'bio', 'single post url slug', 'die-jim-crow' );
}

add_filter( 'woothemes_our_team_single_slug', 'djc_team_single_slug' );

/**
 * Change Archive Slug
 *
 * Change the slug for `team-member` post archive to `bios`
 * @link https://codex.wordpress.org/Function_Reference/register_post_type#rewrite
 * 
 */
function djc_team_archive_slug() {
    return _x( 'bios', 'post archive url slug', 'die-jim-crow' );
}

add_filter( 'woothemes_our_team_archive_slug', 'djc_team_archive_slug' );

/**
 * Remove Extra Fields from `the_content`
 *
 * Change `the_content` to only display `post_content` for `team-member` posts
 * @param string $content
 * @link https://codex.wordpress.org/Plugin_API/Filter_Reference/the_content
 * 
 */
function djc_our_team_content( $content ) {

    global $post;

    if( is_post_type_archive( 'team-member' ) ) {

        $content = $post->post_content;
        return $content;
    }

    return $content;

}

add_filter( 'the_content', 'djc_our_team_content' );

/**
 * Customise the "Enter title here" text
 *
 * Customize the text that appears in the `title` field on the post edit screen
 * @param string $title
 * @return void
 */
function djc_team_enter_title_here( $title ) {
    $screen = get_current_screen();

    if ( 'team-member' == $screen->post_type ) {
        $title = __( 'Enter person\'s name here', 'die-jim-crow' );
    }
    return $title;
}

add_filter( 'enter_title_here', 'djc_team_enter_title_here' );

/**
 * Change Message Text for Bios
 * Change the message text for `team-member` posts
 *
 * @param string $translated_text
 * @return void
 * @link https://codex.wordpress.org/Plugin_API/Filter_Reference/gettext
 */
function djc_team_message_text( $translated_text ) {
    if( 'Team Member' == $translated_text ) :
        $translated_text = 'Bio';
    elseif( 'Team Members' == $translated_text  ) :
        $translated_text = 'Bios';
    elseif( 'Team Member updated' == $translated_text  ) :
        $translated_text = 'Bio updated';
    elseif( 'Team Member Details' == $translated_text ) :
        $translated_text = 'Bio Details';
    endif;
    return $translated_text;
}

add_filter( 'gettext', 'djc_team_message_text', 20 );

/**
 * Enable Shortcodes in Widgets
 *
 * @link https://codex.wordpress.org/Shortcode#Shortcodes_in_Widgets
 */
add_filter('widget_text', 'do_shortcode');

/**
 * Photo Album Shortcode
 * @link https://codex.wordpress.org/Shortcode
 */

/**
 * Register Shortcode
 *
 * This is a simple example for a pullquote with a citation.
 */
    add_shortcode( 'photo-album', function( $attr, $content = '' ) {
    
    $attr = wp_parse_args( $attr, array(
        'url' => '',
        'img' => '',
    ) );
    ob_start();
    ?>

    <ul class="photo-albums" role="navigation">
        <li>
            <a href="<?php echo esc_url( $attr['url'] ); ?>" class="photo-album-link" style="background-image: url(<?php echo $attr['img']; ?>)"><?php echo esc_html( $content ); ?></a>
        </li>
    </ul>

    <?php
    return ob_get_clean();
} );


/**
 * Page Link Shortcode
 *
 */
function djc_page_link_shortcode( $atts ) {
    $output = '';
    $atts = shortcode_atts( array( 
        'ids' => '',
    ), $atts );
    
    $ids = array_map( 'intval', explode( ',', $atts['ids'] ) );
    if( $ids ) {
        $output .= '<div class="photo-album-links">';
        foreach( $ids as $id ) {
        
            $style = has_post_thumbnail( $id ) ? ' style="background-image: url(' . wp_get_attachment_image_url( get_post_thumbnail_id( $id ), 'page_link' ) . ');"' : '';
            $output .= '<div class="item-link"' . $style . '><a href="' . get_permalink( $id ) . '" title="' . get_the_title( $id ) . '"><h2 class="entry-title">' . get_the_title( $id ) . '</h2></a></div>';
        }
        $output .= '</div>';
    }
    
    return $output;
}
add_shortcode( 'photo-album-link', 'djc_page_link_shortcode' );


/**
 * Page Link Shortcode UI
 *
 */
function djc_page_link_shortcode_ui() {
    
    if( ! function_exists( 'shortcode_ui_register_for_shortcode' ) )
        return;
        
    shortcode_ui_register_for_shortcode( 'photo-album-link', array( 
        'label'         => 'Photo Album Links',
        'listItemImage' => 'dashicons-format-image',
        'attrs'         => array(
            array(
                'label'    => 'Pages',
                'attr'     => 'ids',
                'type'     => 'post_select',
                'query'    => array( 'post_type' => 'page'),
                'multiple' => true,
            )
        )
    ) );
}
add_action( 'init', 'djc_page_link_shortcode_ui' );

/**
 * Page Link Shortcode UI
 *
 */
function djc_add_form_shortcode() {
    
    if( ! function_exists( 'shortcode_ui_register_for_shortcode' ) )
        return;
        
    shortcode_ui_register_for_shortcode( 'contact-form-7', array( 
        'label'         => 'Add Form',
        'listItemImage' => 'dashicons-format-image',
        'attrs'         => array(
            array(
                'label'    => 'Title',
                'attr'     => 'title',
                'type'     => 'text',
            ),
            array(
                'label'    => 'Select Form',
                'attr'     => 'id',
                'type'     => 'post_select',
                'query'    => array( 'post_type' => 'wpcf7_contact_form'),
                'multiple' => false,
            ),
        )
    ) );
}
add_action( 'init', 'djc_add_form_shortcode' );



/**
 * Hide Password Protected Pages
 *
 * @param string
 * @return query string
 * @link https://codex.wordpress.org/Using_Password_Protection#Hiding_Password_Protected_Posts
 */
function djc_exclude_protected( $where ) {
    global $wpdb;
    return $where .= " AND {$wpdb->posts}.post_password = '' ";
}

/**
 * Hide Password Protected Pages
 *
 * @param query string
 * @return void
 * @uses @wp-hook pre_get_posts
 * @link https://codex.wordpress.org/Using_Password_Protection#Hiding_Password_Protected_Posts
 */
// Decide where to display them
function djc_exclude_protected_action( $query ) {
    if( !is_single() && !is_page() && !is_admin() ) {
        add_filter( 'posts_where', 'djc_exclude_protected' );
    }
}

// Action to queue the filter at the right time
add_action('pre_get_posts', 'djc_exclude_protected_action');

/**
 * Change Password Protected Page Text
 *
 * @uses @wp-hook the_password_form
 * @param n/a
 * @return string
 * @link https://codex.wordpress.org/Using_Password_Protection#Customize_the_Protected_Text
 */
function djc_passcode_form() {
    global $post;
    $label = 'password-' . ( empty( $post->ID ) ? rand() : $post->ID );
    $output = '<form class="protected-post-form" action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">
    ' . __( "Enter the passcode to download the EP", 'die-jim-crow' ) . '
    <label class="password-label" for="' . $label . '">' . __( "Passcode", 'die-jim-crow' ) . '</label> <input name="post_password" id="' . $label . '" type="password" class="password" size="20" /> <input type="submit" name="Submit" class="button" value="' . esc_attr__( "Submit" ) . '" />
    </form>
    ';
    return $output;
}

add_filter( 'the_password_form', 'djc_passcode_form' );

/**
 * Add a message to the password form.
 *
 * @wp-hook the_password_form
 * @param string $form
 * @return string
 */
function djc_passcode_password_msg( $form ) {
    // No cookie, the user has not sent anything until now.
    if ( ! isset ( $_COOKIE[ 'wp-postpass_' . COOKIEHASH ] ) )
        return $form;

    // Translate and escape.
    $msg = esc_html__( 'That passcode is not correct.', 'die-jim-crow' );

    // We have a cookie, but it doesn’t match the password.
    $msg = "<p class='custom-password-message'>$msg</p>";

    return $msg . $form;
}

add_filter( 'the_password_form', 'djc_passcode_password_msg' );


/**
 * Change Contact Form 7 admin menu label
 *
 * @return void
 * @uses admin_menu
 */
function djc_edit_contact_7_menu() {
    global $menu;
    $menu[27][0] = 'Forms'; // Change Posts to Recipes
}

add_action( 'admin_menu', 'djc_edit_contact_7_menu' );

function edit_admin_menus() {
    global $menu;
    $menu[27][0] = 'Forms'; // Change Posts to Recipes
}
add_action( 'admin_menu', 'edit_admin_menus' );


/**
 * Move Contact Form DB menu into Contact Form 7 menu
 *
 * @return void
 * @uses admin_menu
 */
if( class_exists( 'CF7DBPlugin' ) ) {

    if( !function_exists( 'djc_remove_contact_7_db_menu' ) ) {

        /**
         * Remove the menu
         */
        function djc_remove_contact_7_db_menu() {
            remove_menu_page( 'CF7DBPluginSubmissions' );
        }

        add_action( 'admin_menu', 'djc_remove_contact_7_db_menu' );

    }

    if( !function_exists( 'djc_add_contact_7_db_submenu' ) ) {

        /**
         * Add the menus under Contact Form 7 menu
         */
        function djc_add_contact_7_db_submenu() {

            add_submenu_page(
                'wpcf7', 
                __( 'Submissions', 'die-jim-crow' ), 
                __( 'Submissions', 'die-jim-crow' ), 
                'wpcf7_admin_management_page', 
                'CF7DBPluginSubmissions'
            );

            add_submenu_page(
                'wpcf7', 
                __( 'Submission Shortcodes', 'die-jim-crow' ), 
                __( 'Submission Shortcodes', 'die-jim-crow' ), 
                'wpcf7_admin_management_page', 
                'admin.php?page=CF7DBPluginShortCodeBuilder'
            );

            add_submenu_page(
                'wpcf7', 
                __( 'Submission Settings', 'die-jim-crow' ), 
                __( 'Submission Settings', 'die-jim-crow' ), 
                'wpcf7_admin_management_page', 
                'admin.php?page=CF7DBPluginSettings'
            );
        }

        add_action( 'admin_menu', 'djc_add_contact_7_db_submenu' );

    }

}


?>