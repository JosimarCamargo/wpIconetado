<?php
/**
 * Theme Options
 *
 * @package Voyage
 * @subpackage Voyage
 * @since Voyage 1.0
 */
if ( !defined('ABSPATH')) exit;

add_action('admin_init', 'voyage_theme_options_init');
add_action('admin_menu', 'voyage_theme_options_admin_menu');
function voyage_admin_enqueue_scripts( $hook_suffix ) {
	$template_uri = get_template_directory_uri();
	wp_enqueue_style('voyage-grid', $template_uri . '/css/grid.css', false, '1.0');	
	wp_enqueue_style('voyage-theme-options', $template_uri . '/css/theme-options.css', false, '1.0');
	wp_enqueue_script('voyage-theme-options', $template_uri . '/js/theme-options.js', array('jquery'), '1.0');
}
add_action('admin_print_styles-appearance_page_theme_options', 'voyage_admin_enqueue_scripts');

/**
 * Register voyage theme options
 */
function voyage_theme_options_init() {
    register_setting('voyage_options', 'voyage_theme_options', 'voyage_theme_options_validate');
}

/**
 * Diplay admn menu
 */
function voyage_theme_options_admin_menu() {
    add_theme_page(__('Theme Options', 'voyage'), __('Theme Options', 'voyage'), 'edit_theme_options', 'theme_options', 'voyage_theme_options_display_page');
}

/**
 * Grid CSS and Custom CSS
 */
function voyage_custom_css() {
    global $voyage_options;

//	$voyage_options = voyage_get_options();
	echo '<!-- Voyage CSS Style (Theme Options) -->' . "\n";
    echo '<style type="text/css" media="screen">' . "\n";
	
    if ($voyage_options['grid_pixel'] != 960 ) {
        echo '.container_12, .container_16 {' . "\n";
		echo ' width: ' . $voyage_options['grid_pixel'] . "px; }\n";
		
		global $content_width;
		$content_width = $voyage_options['grid_pixel'];
	}
	
	// Fluid
    if ($voyage_options['grid_style'] == "1" ) {
        echo '@media screen and (max-width: ' . $voyage_options['grid_pixel'] . "px ){";
		echo '.container_12, .container_16 { width: auto } }' . "\n";
	}
    else {
		if ($voyage_options['mobile_style'] == "1" ) {
			echo "@media screen and (max-width: 767px) {" . "\n";
			echo '.container_12, .container_16 { width: auto } }' . "\n";
		}
		else {
	        echo '#wrapper {' . "\n";
			echo ' min-width: ' . $voyage_options['grid_pixel'] . "px; }\n";
		}
	} 
	
	if ($voyage_options['fp_height'] > 0 ) {
    	echo '.featured .carousel-inner .small-thumbnail,' . "\n";	
    	echo '.featured .carousel-inner .no-thumbnail,' . "\n";	
		echo '.featured .carousel-inner .item {height:' . "\n";	
		echo $voyage_options['fp_height'] . "px;}\n";
	}
	if ($voyage_options['fb_height'] > 0 ) {
		echo '.featured-blog .carousel-inner .item { height: ';	
		echo $voyage_options['fb_height'] . "px; }\n";
	}

	echo '</style>' . "\n";	
	// Slider JQuery Script
	if ($voyage_options['fp_interval'] > 0)
		$slider_interval = $voyage_options['fp_interval'] * 1000;
	else
		$slider_interval = 5000;
	echo '<script>jQuery(document).ready(function($){';
	echo '$(".carousel").carousel({interval:' . $slider_interval . '})';
	echo "});</script>\n";
	
	// Inline CSS
    if (!empty($voyage_options['voyage_inline_css'])) {
		echo '<!-- Custom CSS Styles -->' . "\n";
        echo '<style type="text/css" media="screen">' . "\n";
		echo $voyage_options['voyage_inline_css'] . "\n";
		echo '</style>' . "\n";
	}
}
add_action('wp_head', 'voyage_custom_css');

/**
 * Create the options page
 */
 
function voyage_theme_options_array() {
	$theme_options = array(
		'currenttab'	=> array(
			'name'	=> 'currenttab',
			'type'	=> 'hidden',			
			'default' => 0	
		),	
// Home Page Options
		'homepage'	=> array(
			'name'	=> 'homepage',
			'label'	=> __( 'Home Page Style', 'voyage' ),
			'type'	=> 'radio',
			'desc'  => '',
			'helptext' => '',			
			'default' => 2,
			'values' => array(
						array('key' => 1,'label' => __('Featured Home','voyage') ),
						array('key' => 2,'label' => __('Landing Page','voyage') ),
						array('key' => 3,'label' => __('Blog Full Posts','voyage') ),
						array('key' => 4,'label' => __('Blog Summaries','voyage') ),
						array('key' => 5,'label' => __('Featured Blog','voyage') ),
						),		
		),	
		'fp_image'	=> array(
			'name'	=> 'fp_image',
			'label'	=> __( 'Featured Image Style', 'voyage' ),
			'type'	=> 'radio',
			'desc'  => '',
			'helptext' => 'Use centered image only if Carousel Height is fixed',			
			'default' => 1,
			'values' => array(
						array('key' => 1,'label' => __('Normal','voyage') ),
						array('key' => 2,'label' => __('Centered','voyage') ),
						array('key' => 3,'label' => __('Full Screen','voyage') ),
						),		
		),	

// Landing Page
		'headline'	=> array(
			'name'	=> 'headline',
			'label'	=> __( 'H1 Headline', 'voyage' ),
			'type'	=> 'text',
			'desc'  => '',
			'helptext' => '',	
			'default' => __( 'Hello, World!', 'voyage' ),
		),		
		'tagline'	=> array(
			'name'	=> 'tagline',
			'label'	=> __( 'Tag lines', 'voyage' ),
			'type'	=> 'textarea',
			'desc'  => '',
			'helptext' => '',	
			'row'   => 2,
			'default' => __( 'This is your landing page. The headline, tagline and media content can be changed in theme options.', 'voyage' ),
		),
		'mediacontent'	=> array(
			'name'	=> 'mediacontent',
			'label'	=> __( 'Media Content', 'voyage' ),
			'type'	=> 'textarea',
			'desc'  => '',
			'row'   => 5,
			'helptext'  => __('Use HTML or shortcode to add content.', 'voyage'),
			'default' => '<img src="' . get_template_directory_uri() . '/images/theme-landing.png" alt="" />',
		),
		'actionlabel' => array(
			'name'	=> 'actionlabel',
			'label'	=> __( 'Action Button', 'voyage' ),
			'type'	=> 'text',
			'desc'  => '',	
			'default' => __( 'Learn More', 'voyage' ),
			'helptext'  => __('Label for action button on Landing Page.', 'voyage'),	
		),
		'actionurl' => array(
			'name'	=> 'actionurl',
			'label'	=> __( 'Action URL', 'voyage' ),
			'type'	=> 'url',
			'desc'  => '',
			'helptext' => '',	
			'default' => '',
		),
// Carousel
		'fp_interval'	=> array(
			'name'	=> 'fp_interval',
			'label'	=> __( 'Carousel Interval', 'voyage' ),
			'type'	=> 'number',
			'desc' => __( 'Seconds', 'voyage' ),
			'helptext' => '',	
			'default' => 8,
		),
		'fp_effect'	=> array(
			'name'	=> 'fp_effect',
			'label'	=> __( 'Carousel Transition Effect', 'voyage' ),
			'type'	=> 'radio',
			'default' => 2,
			'values' => array(
						array('key' => 1,'label' => __('None','voyage') ),
						array('key' => 2,'label' => __('Slide','voyage') ),
						array('key' => 3,'label' => __('Fade','voyage') ),
						),	
			'desc'  => '',		
			'helptext'  => __('For better fading effect, make sure interval is greater than 7 seconds. The transition effects are not supported in IE.', 'voyage'),	

		),
// Featured Home
		'fp_height'	=> array(
			'name'	=> 'fp_height',
			'label'	=> __( 'Carousel Height', 'voyage' ),
			'type'	=> 'number',
			'desc' => __( 'Pixels', 'voyage' ),
			'default' => 300,
			'helptext'  => __('Enter 0 to adjust height automatically.', 'voyage'),	
		),	
		'fp_postnum'	=> array(
			'name'	=> 'fp_postnum',
			'label'	=> __( 'Number of Posts', 'voyage' ),
			'type'	=> 'number',
			'desc'  => '',
			'helptext' => '',
			'default' => 10,
		),
		'fp_category'	=> array(
			'name'	=> 'fp_category',
			'label'	=> __( 'Category', 'voyage' ),
			'type'	=> 'category',
			'desc'  => '',
			'helptext' => '',
			'default' => 0,
		),
		'fp_sticky'	=> array(
			'name'	=> 'fp_sticky',
			'label'	=> __( 'Sticky Posts Only?', 'voyage' ),
			'desc'	=> __( 'Check to display sticky posts only.', 'voyage' ),
			'type'	=> 'checkbox',
			'helptext' => '',	
			'default' => 1,
		),
		'fp_headline'	=> array(
			'name'	=> 'fp_headline',
			'label'	=> __( 'Headline Banner', 'voyage' ),
			'desc'	=> __( 'Check to display H1 headline and tagline below Carousel.', 'voyage' ),
			'type'	=> 'checkbox',
			'helptext' => '',	
			'default' => 0,
		),
		'fp_action' => array(
			'name'	=> 'fp_action',
			'label'	=> __( 'Read More Button', 'voyage' ),
			'type'	=> 'text',
			'desc'  => '',
			'default' => __( 'Learn More', 'voyage' ),
			'helptext'  => __('Label for action button on Featured Posts.', 'voyage'),	
		),

//Featured Blog
		'fb_height'	=> array(
			'name'	=> 'fb_height',
			'label'	=> __( 'Carousel Height', 'voyage' ),
			'type'	=> 'number',
			'desc' => __( 'Pixels', 'voyage' ),
			'default' => 300,
			'helptext'  => __('Enter 0 to adjust height automatically.', 'voyage'),	
		),	
//Header	
		'fixed_menu'	=> array(
			'name'	=> 'fixed_menu',
			'label'	=> __( 'Fixed Top Menu', 'voyage' ),
			'desc'	=> __( 'Check to fix the top menu.', 'voyage' ),
			'type'	=> 'checkbox',
			'helptext' => '',	
			'default' => 0,
		),
		'logopos'	=> array(
			'name'	=> 'logopos',
			'label'	=> __( 'Logo/Header Image Position', 'voyage' ),
			'type'	=> 'radio',
			'default' => 1,
			'values' => array(
						array('key' => 1,'label' => __('Inside Navigation Bar','voyage') ),
						array('key' => 2,'label' => __('Above Navigation Bar','voyage') ),
						),	
			'desc'  => '',		
			'helptext'  => __('If Logo is above navigation bar, site title & descriptio will NOT be displayed. Prefered size is 300 x 100.', 'voyage'),	

		),
		'searchform'	=> array(
			'name'	=> 'searchform',
			'label'	=> __( 'Search Form', 'voyage' ),
			'type'	=> 'radio',
			'default' => 1,
			'values' => array(
						array('key' => 1,'label' => __('Inside Navigation Bar','voyage') ),
						array('key' => 4,'label' => __('Above Navigation Bar','voyage') ),
						array('key' => 2,'label' => __('Display on phone only','voyage') ),
						array('key' => 3,'label' => __('Hide','voyage') ),

						),
			'desc'  => '',		
			'helptext'  => '',	

		),
		'navbarcolor'	=> array(
			'name'	=> 'navbarcolor',
			'label'	=> __( 'Inverted Navigation Bar', 'voyage' ),
			'desc'	=> 'Check to have drak/black background.',
			'type'	=> 'checkbox',
			'helptext' => '',	
			'default' => 0,
		),
		'nonavbar'	=> array(
			'name'	=> 'nonavbar',
			'label'	=> __( 'Remove Navigation Bar', 'voyage' ),
			'desc'	=> 'Check to remove navigation bar.',
			'type'	=> 'checkbox',
			'helptext' => '',	
			'default' => 0,
		),
//Addons	
		'ao_pprint'	=> array(
			'name'	=> 'ao_pprint',
			'label'	=> __( 'Prettify', 'voyage' ),
			'desc'	=> __( 'Uncheck to disable code prettifier', 'voyage' ),
			'type'	=> 'checkbox',
			'helptext' => '',	
			'default' => 1,
		),
		'ao_colorbox'	=> array(
			'name'	=> 'ao_colorbox',
			'label'	=> __( 'ColorBox', 'voyage' ),
			'desc'	=> __( 'Uncheck to disable the Colorbox JQuery Plugin', 'voyage' ),
			'type'	=> 'checkbox',
			'helptext' => '',	
			'default' => 1,
		),
// Posts
		'pp_commoff'	=> array(
			'name'	=> 'pp_commoff',
			'label'	=> __( 'Suppress "Comments Closed"', 'voyage' ),
			'desc'	=> __( 'Check to suppress the message.', 'voyage' ),
			'type'	=> 'checkbox',
			'helptext' => '',	
			'default' => 0,
		),
// Skins
		'colorscheme'	=> array(
			'name'	=> 'colorscheme',
			'label'	=> __( 'Color Scheme', 'voyage' ),
			'desc'	=> '',
			'type'	=> 'select',
			'helptext' => '',	
			'default' => '0',
			'values' => apply_filters( 'voyage_colorscheme_array',
							array( array(
								'key' => '0',
				   				'label' => __('Default','voyage'),
								'css' => '',
								'demoimg' => '',
								'options' => array() ) )
						),
		),
		'schemecss'	=> array(
			'name'	=> 'schemecss',
			'label'	=> '',
			'desc'	=> '',
			'type'	=> 'hidden',
			'helptext' => '',	
			'default' => '',
		),
	);

	return apply_filters( 'voyage_theme_options_array', $theme_options);
}

function voyage_option_display( $theme_option, $options ) {
	if ($theme_option['type'] != 'hidden') {
		if (isset($theme_option['label'])) {
			echo '<div class="grid_3 alpha">';	
			echo '<p><b>' . $theme_option['label'] . '</b></p></div>';		
		}
		echo '<div class="grid_9"><p>';		
	}
	switch ($theme_option['type']) {
		case 'radio':
			$values = $theme_option['values'];
			foreach ($values as $value) {
				printf( '<input name="voyage_theme_options[%s]" type="radio" value="%s" %s />',
					$theme_option['name'],
				 	$value['key'],
				 	checked( $value['key'], $options[$theme_option['name']], false ) );
				printf( '<label class="description">%s</label>', $value['label']);
			}
			break;
		case 'checkbox':
			printf( '<input name="voyage_theme_options[%s]" type="checkbox" value="1" %s />',
					$theme_option['name'],
				 	checked( '1', $options[$theme_option['name']], false ) );
			if (!empty($theme_option['desc']))
				printf( '<label class="description">%s</label>', $theme_option['desc']);
			break;				
		case 'url':
		case 'text':
			printf( '<input name="voyage_theme_options[%s]" type="text" value="%s" size="80" />',
					$theme_option['name'],
				 	esc_attr($options[$theme_option['name']]) );
			break;
		case 'textarea':
			printf( '<textarea name="voyage_theme_options[%s]" cols="80" rows="%s">%s</textarea>',
					$theme_option['name'],
					$theme_option['row'], 
				 	esc_textarea($options[$theme_option['name']]) );
			break;
		case 'number':
			printf( '<input name="voyage_theme_options[%s]" type="text" value="%s" size="4" />',
					$theme_option['name'],
				 	esc_attr($options[$theme_option['name']]) );
			if (!empty($theme_option['desc']))
				printf( '<label class="description">%s</label>', $theme_option['desc']);
			break;
		case 'select':
			printf( '<select name="voyage_theme_options[%s]" >',
				$theme_option['name'] );
			foreach ($theme_option['values'] as $value) {
				if ($options[$theme_option['name']] == $value['key'])
					$selected = 'selected="selected"';
				else
					$selected = '';
				printf ('<option value="%1$s" %2$s>%3$s</option>',
					$value['key'],
					$selected,
					$value['label']);
			}
			echo '</select>';
			break;
		case 'category':
			printf( '<select name="voyage_theme_options[%s]" >',
				$theme_option['name'] );

			$selected = '';
			$selected_category = $options[$theme_option['name']];
			if 	($options[$theme_option['name']] == 0)	
				$selected = 'selected="selected"';
			printf ('<option value="0" %1$s>%2$s</option>',
					$selected,
					__('All Categories','voyage') );

			$selected = '';
			foreach ( voyage_categories() as $option ) {
				if ( $selected_category == $option->term_id ) {
					$selected = 'selected="selected"';
				} else {
					$selected = '';
				} 
				printf ('<option value="%1$s" %2$s>%3$s</option>',
					$option->term_id,
					$selected,
					$option->name );
			}
			echo '</select>';
			break;
		case 'hidden':
			printf( '<input id="%1$s" name="voyage_theme_options[%1$s]" type="hidden" value="%2$s" />',
					$theme_option['name'],
				 	esc_attr($options[$theme_option['name']]) );
			break;
		default:
			echo 'Not Availavle Yet';			
	}
	if ($theme_option['type'] != 'hidden') {
		echo '</p>';
		if (!empty($theme_option['helptext']))
			printf( '<p><label class="helptext">%s</label></p>', $theme_option['helptext']);
		echo '</div><div class="clear"></div>';	
	}
}

function voyage_theme_options_display_page() {

	if (!isset($_REQUEST['settings-updated']))
		$_REQUEST['settings-updated'] = false;
	?>
    
    <div class="wrap">
        <?php screen_icon(); echo "<h2>" . __('Voyage Theme Options', 'voyage') . "</h2>"; ?>
		<?php if (false !== $_REQUEST['settings-updated']) : ?>
		<div class="updated fade"><p><strong><?php _e('Options Saved', 'voyage'); ?></strong></p></div>
		<?php endif; ?>
		<p><a class="btn btn-primary" href="<?php _e('http://www.voyagebc.com/voyage-theme-documentation/','voyage'); ?>" target="_blank"><strong><?php _e('Documentation','voyage'); ?></strong></a>&nbsp;&nbsp;
		<a class="btn btn-warning" href="<?php _e('http://www.voyagebc.com/voyage-theme-change-log/','voyage'); ?>" target="_blank"><strong><?php _e('Change Log','voyage'); ?></strong></a>&nbsp;&nbsp;
		<a class="btn btn-success" href="<?php _e('http://www.voyagebc.com/support/','voyage'); ?>" target="_blank"><strong><?php _e('Support Forum','voyage'); ?></strong></a>&nbsp;&nbsp;
		<a class="btn btn-info" href="<?php _e('http://www.voyagebc.com/stephen/','voyage'); ?>" target="_blank"><strong><?php _e('Donate','voyage'); ?></strong></a></p>
		<p style="font-size:14px">The shortcodes are moved to a theme-independent plugin: Voyage+. Please <a href="http://www.wordpress.org/extend/plugins/voyage-plus">Download Voyage+</a> in plugin directory.</p>                
        <form method="post" action="options.php">
<?php	
		$theme_options = voyage_theme_options_array();
		$options = voyage_get_options();
		settings_fields('voyage_options');
		$tab_index = 0;
?>
		<div id="voyage-wrapper" class="container_12">
			<input id="save-button" type="submit" class="button-primary" value="<?php _e('Save Options','voyage'); ?>" />
			<div id="voyage-tabs">
				<a <?php if ($tab_index == $options['currenttab']) echo 'class="voyage-current"'; $tab_index++; ?>><?php _e('Layout','voyage'); ?></a>
				<a <?php if ($tab_index == $options['currenttab']) echo 'class="voyage-current"'; $tab_index++; ?>><?php _e('Home Page','voyage'); ?></a>
				<a <?php if ($tab_index == $options['currenttab']) echo 'class="voyage-current"'; $tab_index++; ?>><?php _e('Header','voyage'); ?></a>
				<a <?php if ($tab_index == $options['currenttab']) echo 'class="voyage-current"'; $tab_index++; ?>><?php _e('Post','voyage'); ?></a>
				<a <?php if ($tab_index == $options['currenttab']) echo 'class="voyage-current"'; $tab_index++; ?>><?php _e('Skinning','voyage'); ?></a>
				<a <?php if ($tab_index == $options['currenttab']) echo 'class="voyage-current"'; $tab_index++; ?>><?php _e('Social','voyage'); ?></a>
				<a <?php if ($tab_index == $options['currenttab']) echo 'class="voyage-current"'; $tab_index++; ?>><?php _e('Addon','voyage'); ?></a>
				<a <?php if ($tab_index == $options['currenttab']) echo 'class="voyage-current"'; $tab_index++; ?>><?php _e('Custom CSS','voyage'); ?></a>
<?php //Allow child them to add options.
				do_action('voyage_options_tab_link'); ?>
			</div>
<?php
/*********************************************************************************
*  Theme Options related to site layout
**********************************************************************************/
?>
			<div class="voyage-pane clearfix"><div class="grid_12"><!-- Layout -->
			<h3><?php _e('Site Layout','voyage'); ?></h3>
			<div class="grid_3 alpha"><p><b><?php _e('Grid Width', 'voyage'); ?></b></p></div>
			<div class="grid_9">
				<p><input id="voyage_theme_options[grid_pixel]" name="voyage_theme_options[grid_pixel]" type="text" size="4" value="<?php echo esc_attr($options['grid_pixel']); ?>" />
				<label class="description" ><?php _e('Pixels', 'voyage'); ?></label></p>
			</div>

			<div class="grid_3 alpha"><p><b><?php _e('Grid Column', 'voyage'); ?></b></p></div>
			<div class="grid_9">
				<p><input id="voyage_theme_options[grid_column]" name="voyage_theme_options[grid_column]" type="radio" value="12" <?php checked( '12', $options['grid_column'] ); ?> />
				<label class="description"><?php _e('12 Columns', 'voyage'); ?></label>	
				
				<input id="voyage_theme_options[grid_column]" name="voyage_theme_options[grid_column]" type="radio" value="16" <?php checked( '16', $options['grid_column'] ); ?> />
				<label class="description"><?php _e('16 Columns', 'voyage'); ?></label></p>	
			</div>			

			<div class="grid_3 alpha"><p><b><?php _e('Grid Style', 'voyage'); ?></b></p></div>
			<div class="grid_9">
				<p><input id="voyage_theme_options[grid_style]" name="voyage_theme_options[grid_style]" type="radio" value="1" <?php checked( '1', $options['grid_style'] ); ?> />
				<label class="description"><?php _e('Fluid', 'voyage'); ?></label>	
				
				<input id="voyage_theme_options[grid_style]" name="voyage_theme_options[grid_style]" type="radio" value="2" <?php checked( '2', $options['grid_style'] ); ?> />
				<label class="description"><?php _e('Fixed', 'voyage'); ?></label></p>	
			</div>	

			<div class="grid_3 alpha">
				<p><b><?php _e('Mobile Style', 'voyage'); ?></b></p>
			</div>
			<div class="grid_9">
				<p><input id="voyage_theme_options[mobile_style]" name="voyage_theme_options[mobile_style]" type="radio" value="1" <?php checked( '1', $options['mobile_style'] ); ?> />
				<label class="description"><?php _e('Responsive', 'voyage'); ?></label>	
				
				<input id="voyage_theme_options[mobile_style]" name="voyage_theme_options[mobile_style]" type="radio" value="2" <?php checked( '2', $options['mobile_style'] ); ?> />
				<label class="description"><?php _e('Static', 'voyage'); ?></label></p>	
			</div>	
									
			<hr>
			<h3>Blog Layout</h3>
			
			<div class="grid_3 alpha">
				<p><b><?php _e('Sidebar Position', 'voyage'); ?></b></p>
			</div>
			<div class="grid_2">
				<p><input id="voyage_theme_options[blog_layout]" name="voyage_theme_options[blog_layout]" type="radio" value="1" <?php checked( '1', $options['blog_layout'] ); ?> />
				<label class="description"><?php _e('Right', 'voyage'); ?></label></p>
				<img src="<?php echo get_template_directory_uri() . '/images/admin/right-sidebar.png' ?>" width="100px" alt="" />
			</div>	
			<div class="grid_2">
				<p><input id="voyage_theme_options[blog_layout]" name="voyage_theme_options[blog_layout]" type="radio" value="2" <?php checked( '2', $options['blog_layout'] ); ?> />
				<label class="description"><?php _e('Left', 'voyage'); ?></label></p>
				<img src="<?php echo get_template_directory_uri() . '/images/admin/left-sidebar.png' ?>" width="100px" alt="" />
			</div>		
			<div class="grid_2">
				<p><input id="voyage_theme_options[blog_layout]" name="voyage_theme_options[blog_layout]" type="radio" value="3" <?php checked( '3', $options['blog_layout'] ); ?> />
				<label class="description"><?php _e('Left & Right', 'voyage'); ?></label></p>
				<img src="<?php echo get_template_directory_uri() . '/images/admin/two-sidebars.png' ?>" width="100px" alt="" />
			</div>	
			<div class="clear"></div>	

			<div class="grid_3 alpha">
				<p><b><?php _e('Width in Column(s)', 'voyage'); ?></b></p>
			</div>
			<div class="grid_9">
				<p>Content: <input id="voyage_theme_options[column_content]" name="voyage_theme_options[column_content]" type="text" size="4" value="<?php echo esc_attr($options['column_content']) ?>" />
				Widget Area 1 : <input id="voyage_theme_options[column_sidebar1]" name="voyage_theme_options[column_sidebar1]" type="text" size="4" value="<?php echo esc_attr($options['column_sidebar1']); ?>" />
				Widget Area 2 : <input id="voyage_theme_options[column_sidebar2]" name="voyage_theme_options[column_sidebar2]" type="text" size="4" value="<?php echo esc_attr($options['column_sidebar2']); ?>" />
				<label class="description"><?php _e('Columns', 'voyage'); ?></label></p>
			</div>
			
			<hr>
			<h3><?php _e('Home Widget Area','voyage'); ?></h3>	
			<div class="grid_3 alpha">
				<p><b><?php _e('Widths of Home Widget Areas', 'voyage'); ?></b></p>
			</div>
			<div class="grid_9">
				<p><input id="voyage_theme_options[column_home1]" name="voyage_theme_options[column_home1]" type="text" size="4" value="<?php echo esc_attr($options['column_home1']); ?>" />
				<input id="voyage_theme_options[column_home2]" name="voyage_theme_options[column_home2]" type="text" size="4" value="<?php echo esc_attr($options['column_home2']); ?>" />
				<input id="voyage_theme_options[column_home3]" name="voyage_theme_options[column_home3]" type="text" size="4" value="<?php echo esc_attr($options['column_home3']); ?>" />
				<input id="voyage_theme_options[column_home4]" name="voyage_theme_options[column_home4]" type="text" size="4" value="<?php echo esc_attr($options['column_home4']); ?>" />
				<label class="description"><?php _e('Columns', 'voyage'); ?></label></p>
			</div><div class="clear"></div>

			<hr>
			<h3><?php _e('Footer Widget Area','voyage'); ?></h3>	
			<div class="grid_3 alpha">
				<p><b><?php _e('Widths of Footer Widget Areas', 'voyage'); ?></b></p>
			</div>
			<div class="grid_9">
				<p><input id="voyage_theme_options[column_footer1]" name="voyage_theme_options[column_footer1]" type="text" size="4" value="<?php echo esc_attr($options['column_footer1']); ?>" />
				<input id="voyage_theme_options[column_footer2]" name="voyage_theme_options[column_footer2]" type="text" size="4" value="<?php echo esc_attr($options['column_footer2']); ?>" />
				<input id="voyage_theme_options[column_footer3]" name="voyage_theme_options[column_footer3]" type="text" size="4" value="<?php echo esc_attr($options['column_footer3']); ?>" />
				<input id="voyage_theme_options[column_footer4]" name="voyage_theme_options[column_footer4]" type="text" size="4" value="<?php echo esc_attr($options['column_footer4']); ?>" />
				<label class="description"><?php _e('Columns', 'voyage'); ?></label></p>
			</div>
		
<?php			do_action('voyage_options_tab_layout'); ?>
			</div></div>
<?php
/*********************************************************************************
*  Theme Options related to home page
**********************************************************************************/
?>
			<div class="voyage-pane clearfix"><div class="grid_12">
<?php
				voyage_option_display($theme_options['homepage'], $options);
				voyage_option_display($theme_options['fp_interval'], $options);
				voyage_option_display($theme_options['fp_effect'], $options);
?>
			<h3><?php _e('Featured Home Page','voyage'); ?></h3>
			<?php
				voyage_option_display($theme_options['fp_height'], $options);
				voyage_option_display($theme_options['fp_image'], $options);
				voyage_option_display($theme_options['fp_postnum'], $options);
				voyage_option_display($theme_options['fp_category'], $options);
				voyage_option_display($theme_options['fp_sticky'], $options);
				voyage_option_display($theme_options['fp_action'], $options);
				voyage_option_display($theme_options['fp_headline'], $options);
			?>
			<hr>
			<h3><?php _e('Landing Page','voyage'); ?></h3>
			<?php
				voyage_option_display($theme_options['headline'], $options); 
				voyage_option_display($theme_options['tagline'], $options); 
				voyage_option_display($theme_options['actionlabel'], $options);
				voyage_option_display($theme_options['actionurl'], $options); 
				voyage_option_display($theme_options['mediacontent'], $options); 
			?>	
			<hr>
			<h3><?php _e('Featured Blog','voyage'); ?></h3>
			<?php
				voyage_option_display($theme_options['fb_height'], $options);

				do_action('voyage_options_tab_home');
			?>			
			</div></div>
<?php
/*********************************************************************************
*  Header Options
**********************************************************************************/
?>
			<div class="voyage-pane clearfix"><div class="grid_12">
<?php
				voyage_option_display($theme_options['fixed_menu'], $options);
				voyage_option_display($theme_options['searchform'], $options);
				voyage_option_display($theme_options['nonavbar'], $options);			
				voyage_option_display($theme_options['navbarcolor'], $options);
?>
			<h3><?php _e('Current Logo/Header Image','voyage'); ?></h3>
			<img src="<?php header_image(); ?> "/>
			<p><?php printf(__('Replace or remove the logo?','voyage')); ?> <?php printf(__('<a href="%s">Click here</a>.', 'voyage'), admin_url('themes.php?page=custom-header')); ?></p>
<?php
				voyage_option_display($theme_options['logopos'], $options);
				do_action('voyage_options_tab_header');
?>
			<img src="<?php echo get_template_directory_uri() . '/images/admin/header-layout.png' ?>" alt="" />
			</div></div>			
<?php
/*********************************************************************************
*  Theme Options Posts
**********************************************************************************/
?>
			<div class="voyage-pane clearfix"><div class="grid_12">
			<h3>Post Meta</h3>			
			<div class="grid_3 alpha">
				<p><b><?php _e('Show Author', 'voyage'); ?></b></p>
			</div>
			<div class="grid_9">
				<p><input id="voyage_theme_options[showauthor]" name="voyage_theme_options[showauthor]" type="checkbox" value="1" <?php checked( '1', $options['showauthor'] ); ?> />
				<label class="description"><?php _e('Check to display Author Name or Biographical Info', 'voyage'); ?></label></p>
			</div>

<?php			voyage_option_display($theme_options['pp_commoff'], $options);
				do_action('voyage_options_tab_post');
?>
			</div></div>
<?php
/*********************************************************************************
*  Theme Options: Skinning
**********************************************************************************/
?>
			<div class="voyage-pane clearfix"><div class="grid_12">
<?php			voyage_option_display($theme_options['colorscheme'], $options);
				do_action('voyage_options_tab_skinning');
?>
			</div></div>			
<?php
/*********************************************************************************
*  Theme Options related to social network
**********************************************************************************/
?>
			<div class="voyage-pane clearfix"><div class="grid_12"><!-- Social -->
			<h3>Social Links</h3>
			
			<div class="grid_3 alpha"><p><b><?php _e('Display Social Links	', 'voyage'); ?></b></p></div>
			<div class="grid_9">
				<p><input name="voyage_theme_options[sociallink_top]" type="checkbox" value="1" <?php checked( '1', $options['sociallink_top'] ); ?> />
				<label class="description"><?php _e('On Top', 'voyage'); ?></label>
				<input name="voyage_theme_options[sociallink_bottom]" type="checkbox" value="1" <?php checked( '1', $options['sociallink_bottom'] ); ?> />
				<label class="description"><?php _e('On Bottom', 'voyage'); ?></label>
				</p>
			</div>

			<div class="grid_3 alpha"><p><b><?php _e('Catch Words', 'voyage'); ?></b></p></div>
			<div class="grid_9">
				<p><input name="voyage_theme_options[sociallink_text]" type="text" size="20" value="<?php echo esc_attr($options['sociallink_text']); ?>" /></p>
			</div>
			
			<div class="grid_3 alpha"><p><b><?php _e('URLs', 'voyage'); ?></b></p></div>
			<div class="grid_9">
			<?php $social_links = voyage_social_links();
			foreach ($social_links as $link ) { ?>
				<div class="grid_2 alpha">
				<p><img src="<?php echo $link['image']; ?>" class ="voyage-icon" /><b><?php echo esc_attr($link['label']); ?></b></p></div>
				<div class="grid_9">
				<p><input type="text" size="50" name="voyage_theme_options[<?php echo $link['name']; ?>]" value="<?php echo esc_url( $options[$link['name']] ); ?>" /></p></div>
			<?php } ?>
			</div>			
			<hr>

			<h3><?php _e('Social Sharing','voyage') ?></h3>

			<div class="grid_3 alpha">
				<p><b><?php _e('Jetpack Sharing', 'voyage'); ?></b></p>
			</div>
			<div class="grid_9">
				<p><input id="voyage_theme_options[sharesocial]" name="voyage_theme_options[sharesocial]" type="checkbox" value="1" <?php checked( '1', $options['sharesocial'] ); ?> />
				<label class="description"><?php _e('Check to integrate Jetpack Sharing', 'voyage'); ?></label>
				</p>
			</div>

			<div class="grid_3 alpha">
				<p><b><?php _e('Location on Single Post/Page', 'voyage'); ?></b></p>
			</div>
			<div class="grid_9">
				<p><input id="voyage_theme_options[share_top]" name="voyage_theme_options[share_top]" type="checkbox" value="1" <?php checked( '1', $options['share_top'] ); ?> />
				<label class="description"><?php _e('Top', 'voyage'); ?></label>
				<input id="voyage_theme_options[share_bottom]" name="voyage_theme_options[share_bottom]" type="checkbox" value="1" <?php checked( '1', $options['share_bottom'] ); ?> />
				<label class="description"><?php _e('Bottom', 'voyage'); ?></label>
				</p>
			</div>

			<div class="grid_3 alpha">
				<p><b><?php _e('Location on Post Summary/Archive', 'voyage'); ?></b></p>
			</div>
			<div class="grid_9">
				<p><input id="voyage_theme_options[share_sum_top]" name="voyage_theme_options[share_sum_top]" type="checkbox" value="1" <?php checked( '1', $options['share_sum_top'] ); ?> />
				<label class="description"><?php _e('Top', 'voyage'); ?></label>
				<input id="voyage_theme_options[share_sum_bottom]" name="voyage_theme_options[share_sum_bottom]" type="checkbox" value="1" <?php checked( '1', $options['share_sum_bottom'] ); ?> />
				<label class="description"><?php _e('Bottom', 'voyage'); ?></label>
				</p>
			</div>
			
			<div class="clear"></div>
									
<?php			do_action('voyage_options_tab_social'); ?>
			</div></div><!-- Sharing -->
<?php
/*********************************************************************************
*  Addon Options
**********************************************************************************/
?>
			<div class="voyage-pane clearfix"><div class="grid_12"><!-- Addons -->
<?php			voyage_option_display($theme_options['ao_pprint'], $options);
				voyage_option_display($theme_options['ao_colorbox'], $options);
//Allow child them to add options.
				do_action('voyage_options_tab_addon'); 
?>
			<h3><a href="http://www.wordpress.org/extend/plugins/voyage-plus">Voyage+</a> (Plugin) Features:</h3>
			<ul>
				<li>[ad] shortcode</li>
				<li>[column] shortcode</li>
			</ul>
			</div></div><!-- Addons -->
<?php
/*********************************************************************************
*  Custom CSS
**********************************************************************************/
?>
			<div class="voyage-pane clearfix"><div class="grid_12"><!-- Custom CSS -->
		
			<div class="grid_3 alpha">
				<p><b><?php _e('Custom CSS Style', 'voyage'); ?></b></p>
			</div>
			<div class="grid_9">
				<p><textarea id="voyage_theme_options[voyage_inline_css]" class="inline-css large-text" cols="80" rows="30" name="voyage_theme_options[voyage_inline_css]"><?php echo esc_textarea($options['voyage_inline_css']); ?></textarea>
				</p>
			</div>

			</div></div><!-- Custom CSS -->
<?php
/*********************************************************************************
*  Child Theme Options
**********************************************************************************/
?>
			<div class="voyage-pane clearfix"><div class="grid_12">

<?php		do_action('voyage_options_tab_page'); ?>
			</div></div>
<?php voyage_option_display($theme_options['currenttab'], $options); ?>
			<p><input id="save-button-bottom" type="submit" class="button-primary" value="<?php _e('Save Options','voyage'); ?>" /></p>
			</div><!-- voyage-wrapper -->
        </form>
    </div><!-- wrap -->
    <?php
}
/**
 * Returns the default theme options.
 * @since Voyage
 */
function voyage_default_theme_options() {
	$default_theme_options = array(
		'grid_pixel' => 960,
		'grid_column' => 12,
		'blog_layout' => 1, //Right Sidebar
		'grid_style' => 1, //Fluid
		'mobile_style' => 1, //Responsive
		'column_content'  => 8,
		'column_sidebar1' => 4,
		'column_sidebar2' => 4,
		'column_home1' => 4,
		'column_home2' => 4,
		'column_home3' => 4,
		'column_home4' => 0,
		'column_footer1' => 3,
		'column_footer2' => 3,
		'column_footer3' => 3,
		'column_footer4' => 3,
		'showauthor' => 1, //Show author
		'voyage_inline_css' => '',
		'sharesocial' => 0,	
		'share_sum_top' => 0,
		'share_sum_bottom' => 0,
		'share_top' => 0,
		'share_bottom' => 1,
		'sociallink_top' => 1,
		'sociallink_bottom' => 0,
		'sociallink_text' => __('Follow Us','voyage'),		
		'url_vimeo' => '',
		'url_youtube' => '',
		'url_facebook' => '',
		'url_linkedin' => '',
		'url_twitter' => '',
		'url_gplus' => '',
		'url_rss' => get_bloginfo('rss2_url'),		
	);
	$theme_options = voyage_theme_options_array();
	foreach ($theme_options as $theme_option) {
		$default_theme_options[$theme_option['name']] = $theme_option['default'];
	}
	return apply_filters( 'voyage_default_theme_options', $default_theme_options );
}

/**
 * Returns the theme options array.
 */
function voyage_get_options() {
	return wp_parse_args( get_option( 'voyage_theme_options' ), voyage_default_theme_options());
}

/**
 * Sanitize and validate input. Accepts an array, return a sanitized array.
 */
function voyage_theme_options_validate($input) {
	$theme_options = voyage_theme_options_array();
	foreach ($theme_options as $theme_option) {
		switch ($theme_option['type']) {
			case 'checkbox':
				if (!isset($input[$theme_option['name']]))
					$input[$theme_option['name']] = null;
		    		$input[$theme_option['name']] = ( $input[$theme_option['name']] == 1 ? 1 : 0 );			
				break;
			case 'text':
			case 'textarea':
				$input[$theme_option['name']] = wp_kses_stripslashes($input[$theme_option['name']]);
				break;
			case 'number':	
				$input[$theme_option['name']] = intval($input[$theme_option['name']]);	
				break;				
			case 'url':	
				$input[$theme_option['name']] = esc_url_raw($input[$theme_option['name']]);	
				break;
		}
	}
	// checkbox value is either 0 or 1
	foreach (array(
		'showauthor',
		'sharesocial',
		'share_sum_top',
		'share_sum_bottom',
		'share_top',
		'share_bottom',
		'sociallink_top'	,	
		'sociallink_bottom'
		) as $checkbox) {
		if (!isset($input[$checkbox]))
			$input[$checkbox] = null;
		    $input[$checkbox] = ( $input[$checkbox] == 1 ? 1 : 0 );
	}
	// No need to validate radio buttons

	//Remove unwanted characters
	$input['voyage_inline_css'] = wp_kses_stripslashes($input['voyage_inline_css']);
	$input['sociallink_text'] = wp_kses_stripslashes($input['sociallink_text']);
	
	// Widths - convert to integer
	$input['grid_pixel'] = intval($input['grid_pixel']);	
	$input['column_content'] = intval($input['column_content']);
	$input['column_sidebar1'] = intval($input['column_sidebar1']);
	$input['column_sidebar2'] = intval($input['column_sidebar2']);
	$input['column_home1'] = intval($input['column_home1']);		
	$input['column_home2'] = intval($input['column_home2']);	
	$input['column_home3'] = intval($input['column_home3']);
	$input['column_home4'] = intval($input['column_home4']);
	$input['column_footer1'] = intval($input['column_footer1']);		
	$input['column_footer2'] = intval($input['column_footer2']);	
	$input['column_footer3'] = intval($input['column_footer3']);
	$input['column_footer4'] = intval($input['column_footer4']);

	//URL
	$input[ 'url_facebook' ] = esc_url_raw( $input[ 'url_facebook' ] );
	$input[ 'url_linkedin' ] = esc_url_raw( $input[ 'url_linkedin' ] );
	$input[ 'url_twitter' ] = esc_url_raw( $input[ 'url_twitter' ] );
	$input[ 'url_gplus' ] = esc_url_raw( $input[ 'url_gplus' ] );
	$input[ 'url_rss' ] = esc_url_raw( $input[ 'url_rss' ] );
	//Update Scheme Options
	$options = voyage_get_options();
	if ($input['colorscheme'] != $options['colorscheme']) {
		foreach ($theme_options['colorscheme']['values'] as $scheme) {
			if ($input['colorscheme'] == $scheme['key']) {
				$input['schemecss'] = $scheme['css']; 
				foreach ($scheme['options'] as $scheme_options) {
					$input[$scheme_options['name']] = $scheme_options['value'];
				}
			}
		}		
	}
	return $input;
}