<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;
/**
 * @package Voyage
 * @subpackage Voyage
 * @since Voyage 1.0.4
 */
?>
<?php 	
// return Social Links array
function voyage_social_links() {
	$template_url = get_template_directory_uri();
	$social_links = array(
		'facebook' => array(
			'name'  => 'url_facebook',
			'label' => __( 'Facebook', 'voyage' ),
			'image' => $template_url . '/images/social/facebook.png',
		),
		'linkedin' => array(
			'name'  => 'url_linkedin',
			'label' => __( 'Linkedin', 'voyage' ),
			'image' => $template_url . '/images/social/linkedin.png',
		),		
		'twitter' => array(
			'name'  => 'url_twitter',
			'label' => __( 'Twitter', 'voyage' ),
			'image' => $template_url . '/images/social/twitter.png',
		),
		'gplus' => array(
			'name'  => 'url_gplus',
			'label' => __( 'Google+', 'voyage' ),
			'image' => $template_url . '/images/social/gplus_icon.png',
		),
		'youtube' => array(
			'name'  => 'url_youtube',
			'label' => __( 'YouTube', 'voyage' ),
			'image' => $template_url . '/images/social/youtube.png',
		),
		'vimeo' => array(
			'name'  => 'url_vimeo',
			'label' => __( 'Vimeo', 'voyage' ),
			'image' => $template_url . '/images/social/vimeo.png',
		),
		'rss' => array(
			'name'  => 'url_rss',
			'label' => __( 'RSS Feed', 'voyage' ),
			'image' => $template_url . '/images/social/rss.png',
		),

	);
	return apply_filters( 'voyage_social_links', $social_links );
}

if ( ! function_exists( 'voyage_social_connection' ) ) :
function voyage_social_connection() { 
	global $voyage_options;
	$social_links = voyage_social_links();
	$flag = 0;
	foreach ($social_links as $link ) {
		if (!empty( $voyage_options[$link['name']]) ) {
			$flag = 1;
		}
	}
	if ($flag) {
		echo '<div class="social-links"><ul>';
		if (!empty($voyage_options['sociallink_text'])) {
			printf ('<li class="social-link-text">%s</li>', $voyage_options['sociallink_text']);			
		}
		foreach ($social_links as $link ) {
			if (!empty( $voyage_options[$link['name']]) ) {
				echo '<li>';
				echo '<a href="' . esc_url( $voyage_options[$link['name']] );
				echo '" title="' . esc_attr($link['label']);
				echo '" target="_blank"><img src="' . esc_attr($link['image']);
				echo '" alt="' . esc_attr($link['label']);
				echo '" /></a></li>';
			}			
		}
		echo '</ul></div>';
	}
}
endif;

if ( ! function_exists( 'voyage_social_post_top' ) ) :
function voyage_social_post_top() {
	global $voyage_options;

	if ( $voyage_options['sharesocial'] == 1 && ! has_post_format('aside')
				&&  function_exists( 'sharing_display' ) ) {
		if (is_single() && $voyage_options['share_top'] == 1)
			echo sharing_display();			
		elseif (!is_single() && $voyage_options['share_sum_top'] == 1)
			echo sharing_display();		
	}	
}
endif;

if ( ! function_exists( 'voyage_social_post_bottom' ) ) :
function voyage_social_post_bottom() {
	global $voyage_options;
	if ( $voyage_options['sharesocial'] == 1 && ! has_post_format('aside')
				&&  function_exists( 'sharing_display' ) ) {
		if (is_single()  && $voyage_options['share_bottom'] == 1) 
			echo sharing_display();	
		elseif (!is_single() && $voyage_options['share_sum_bottom'] == 1)
			echo sharing_display();		
	}	
}
endif;
// Check for Jetpack Sharing
function voyage_remove_sharing_filters() {
	global $voyage_options;

	if ( $voyage_options['sharesocial'] == 1 && function_exists( 'sharing_display' ) ) {
			remove_filter( 'the_content', 'sharing_display', 19 );
			remove_filter( 'the_excerpt', 'sharing_display', 19 );
	}
}
add_action('voyage_header_before_main','voyage_remove_sharing_filters');
?>