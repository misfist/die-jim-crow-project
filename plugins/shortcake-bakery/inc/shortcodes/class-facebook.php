<?php

namespace Shortcake_Bakery\Shortcodes;

class Facebook extends Shortcode {

	public static function get_shortcode_ui_args() {
		return array(
			'label'          => esc_html__( 'Facebook', 'shortcake-bakery' ),
			'listItemImage'  => 'dashicons-facebook',
			'attrs'          => array(
				array(
					'label'        => esc_html__( 'URL', 'shortcake-bakery' ),
					'attr'         => 'url',
					'type'         => 'text',
					'description'  => esc_html__( 'Full URL to the Facebook Post or Video', 'shortcake-bakery' ),
				),
			),
		);
	}

	public static function setup_actions() {
		add_action( 'init', 'Shortcake_Bakery\Shortcodes\Facebook::action_init_register_scripts' );
		add_action( 'shortcode_ui_after_do_shortcode', function( $shortcode ) {
			if ( false !== stripos( $shortcode, '[' . self::get_shortcode_tag() ) ) {
					echo '<script src="' . esc_url( '//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0' ) . '"></script>';
			}
		});
	}

	public static function action_init_register_scripts() {
		wp_register_script( 'facebook-api', '//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0' );
	}

	/**
	 * Facebook requires a bit extra massaging to make the embed responsive
	 */
	public static function action_wp_footer() {
		?>
		<script>
			(function($){
				$('.shortcake-bakery-responsive.fb-post').on('shortcake-bakery-responsive-resize', function(){
					var el = $(this);
					el.attr('data-width',el.css('width'));
					// Plugin has already loaded, so we need to reset the whole iframe.
					if ( el.attr('fb-iframe-plugin-query') ) {
						el.removeAttr('fb-iframe-plugin-query').removeAttr('fb-xfbml-state').empty();
						if ( FB && FB.XFBML && FB.XFBML.parse ) {
							FB.XFBML.parse();
						}
					}
				});
			}(jQuery))
		</script>
		<?php
	}

	public static function reversal( $content ) {
		/* Pattern for normal Facebook embeds */
		if ( preg_match_all( '#<div id="fb-root"></div><script>[^<]+</script><div class="fb-post" [^>]+href=[\'\"]([^\'\"]+)[\'\"].+</div>(</div>)?#', $content, $matches ) ) {
			$replacements = array();
			$shortcode_tag = self::get_shortcode_tag();
			foreach ( $matches[0] as $key => $value ) {
				$replacements[ $value ] = '[' . $shortcode_tag . ' url="' . esc_url( $matches[1][ $key ] ) . '"]';
			}
			$content = str_replace( array_keys( $replacements ), array_values( $replacements ), $content );
		}

		/* Pattern for Facebook video embeds */
		if ( preg_match_all( '#<div id="fb-root"><\/div><script>[^<]+<\/script><div class="fb-video" [^>]+href=[\'\"][^\'\"]+[\'\"]><div class="fb-xfbml-parse-ignore"><blockquote cite=[\'\"][^\'\"]+[\'\"]><a href=[\'\"]([^\'\"]+)[\'\"]+.*?<\/div><\/div>?#', $content, $matches ) ) {
			$replacements = array();
			$shortcode_tag = self::get_shortcode_tag();
			foreach ( $matches[0] as $key => $value ) {
				$replacements[ $value ] = '[' . $shortcode_tag . ' url="' . esc_url( 'https://www.facebook.com' . $matches[1][ $key ] ) . '"]';
			}
			$content = str_replace( array_keys( $replacements ), array_values( $replacements ), $content );
		}
		return $content;
	}

	public static function callback( $attrs, $content = '' ) {

		if ( empty( $attrs['url'] ) ) {
			return '';
		}

		// kses converts & into &amp; and we need to undo this
		// See https://core.trac.wordpress.org/ticket/11311
		$attrs['url'] = str_replace( '&amp;', '&', $attrs['url'] );

		// Our matching URL patterns for Facebook
		$facebook_regex = array(
			'#https?://(www)?\.facebook\.com/[^/]+/posts/[\d]+#',
			'#https?://(www)?\.facebook\.com\/video\.php\?v=[\d]+#',
			'#https?:\/\/www?\.facebook\.com\/+.*?\/videos\/[\d]+\/#',
			'#https?://(www)?\.facebook\.com\/permalink\.php\?story_fbid=[\d]+&id=[\d]+#',
			'#https?:\/\/www?\.facebook\.com\/.*?\/photos\/([^/]+)/([\d])+/#',
			);

		$match = false;
		foreach ( $facebook_regex as $regex ) {
			if ( preg_match( $regex, $attrs['url'] ) ) {
				$match = true;
			}
		}

		if ( ! $match ) {
			if ( current_user_can( 'edit_posts' ) ) {
				return '<div class="shortcake-bakery-error"><p>' . sprintf( esc_html__( 'Invalid Facebook URL: %s', 'shortcake-bakery' ), esc_url( $attrs['url'] ) ) . '</p></div>';
			} else {
				return '';
			}
		}

		wp_enqueue_script( 'facebook-api' );
		if ( ! has_action( 'wp_footer', 'Shortcake_Bakery\Shortcodes\Facebook::action_wp_footer' ) ) {
			add_action( 'wp_footer', 'Shortcake_Bakery\Shortcodes\Facebook::action_wp_footer' );
		}
		$out = '<div id="fb-root"></div>';
		$out .= '<div class="fb-post shortcake-bakery-responsive" data-href="' . esc_url( $attrs['url'] ) . '" data-width="350px" data-true-height="550px" data-true-width="350px"><div class="fb-xfbml-parse-ignore"></div></div>';
		return $out;
	}

}
