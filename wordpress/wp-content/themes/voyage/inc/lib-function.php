<?php 
if ( !defined('ABSPATH')) exit;
/**
 * Voyage Theme functions: Functions that extends WordPress Functions
 *
 * @package voyage
 * @subpackage voyage
 * @since Voyage 1.1
 */

function voyage_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	$title .= get_bloginfo( 'name' );
	
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'voyage' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'voyage_wp_title', 10, 2 );

/* Content Filter: Remove image from post*/
function remove_images( $content ) {
   $postOutput = preg_replace('/<img[^>]+./','', $content);
   return $postOutput;
}

/* The following function extends wp_nav_menu class for the dropdown menu */
function voyage_hasSub($menu_item_id, &$items) {
	foreach ($items as $item) {
		if ($item->menu_item_parent && $item->menu_item_parent==$menu_item_id) {
			return true;
		}
    }
	return false;
};

function voyage_parant_menu_class($items) {
    foreach ($items as $item) {
        if (voyage_hasSub($item->ID, $items)) {
            $item->classes = array_merge( array('parent','dropdown'), $item->classes); 
        }
    }
    return $items;    
}
add_filter('wp_nav_menu_objects', 'voyage_parant_menu_class');

class voyage_walker_nav_menu extends Walker_Nav_Menu {
 
// add classes to ul sub-menus
function start_lvl( &$output, $depth ) {
    // depth dependent classes
    $indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
    $display_depth = ( $depth + 1); // because it counts the first submenu as 0
    $classes = array(
        'dropdown-menu',
        'menu-depth-' . $display_depth
        );
    $class_names = implode( ' ', $classes );
  
    // build html
    $output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
}
  
// add main/sub classes to li's and links
 function start_el( &$output, $item, $depth, $args ) {
    global $wp_query;
    $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent
  
    // depth dependent classes
    $depth_classes = array(
        ( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
        ( ($depth >=1 && $item->classes[0] == "parent") ? 'dropdown-submenu' : '' ),
        'menu-item-depth-' . $depth
    );
    $depth_class_names = esc_attr( implode( ' ', $depth_classes ) );
  
    // passed classes
    $classes = empty( $item->classes ) ? array() : (array) $item->classes;
    $class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );
  
    // build html
	if ($item->title == "-" ) {
		$attributes = '';
		if ($depth == 0)
		    $output .= $indent . '<li class="divider-vertical">';
		else
		    $output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' divider">';
		$item_output = "";
	}
	else {
    $output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';
  
    // link attributes
    $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
    $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
    $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
    $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
	
	$link_after =  $args->link_after;
	if ( $depth ==0 && $item->classes[0] == "parent") {
		$link_after = '</a><a class="dropdown-toggle" data-toggle="dropdown" href="#"><b class="caret"></b>';
	}
		  
    $attributes .= ' class="menu-link"';
    $item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
        $args->before,
        $attributes,
        $args->link_before,
        apply_filters( 'the_title', $item->title, $item->ID ),
        $link_after ,
        $args->after
    );		
	}  
    // build html
    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
}

} // Class voyage_walker_nav_menu

/* Category Array */
function voyage_categories() {
	$category = get_categories();
	return apply_filters( 'voyage_categories', $category );
}	

function voyage_thumbnail_size($option, $x = 96, $y = 96) {
	switch ($option) {
		case 2:
			return 'medium';
		case 3:
			return 'large';
		case 4:
			return 'full';
		case 5:
			if (($x > 0) && ($y > 0) ) {
				return array( $x, $y);
			}
			else
				return 'thumbnail';
		case 6:
			return 'none';
		default:
			return 'thumbnail';
	}	
}

//Add meta boxes to page/post
function voyage_meta_box() {
	global $voyage_meta_box;
	
	$voyage_meta_box['page'] = array( 
		'id' => 'voyage-page-meta',
		'title' => __('Template Options (Voyage)', 'voyage'),  
		'context' => 'side',  //normal, advaned, side  
		'priority' => 'low', //high, core, default, low
		'fields' => array(
        	array(
            	'name' => __('Post Category :','voyage'),
            	'desc' => '',
            	'id' => '_voyage_category',
            	'type' => 'category',
            	'default' => ''
        	),
        	array(
            	'name' => __('Posts per page :', 'voyage'),
            	'desc' => '',
            	'id' => '_voyage_postperpage',
            	'type' => 'number',
            	'default' => '',
        	),
        	array(
            	'name' => __('Sidebar :', 'voyage'),
            	'desc' => __('check to show sidebar<hr>Note: Some options may not be relevant for this page template.','voyage'),
            	'id' => '_voyage_sidebar',
            	'type' => 'checkbox',
            	'default' => '',
        	),
        	array(
            	'name' => __('Layout :', 'voyage'),
            	'desc' => __('Columns','voyage'),
            	'id' => '_voyage_column',
            	'type' => 'select',
            	'default' => '',
				'options' => array( 
								array( 'value' => '1',
									   'name' => '1' ),
								array( 'value' => '2', 
									   'name' => '2' ),
								array( 'value' => '', //Dedault
									   'name' => '3' ),
								array( 'value' => '4', 
									   'name' => '4' ),
							 ),
        	),
        	array(
            	'name' => __('Display Thumbnail : <br />', 'voyage'),
            	'desc' => '',
            	'id' => '_voyage_thumbnail',
            	'type' => 'radio',
            	'default' => '',
				'options' => array( 
								array( 'value' => '',
									   'name' => __('Thumbnail<br />','voyage') ),
								array( 'value' => '2', 
									   'name' => __('Mediumn<br />','voyage') ),
								array( 'value' => '3', 
									   'name' => __('Large<br />','voyage') ),
								array( 'value' => '5', //4 is Full
									   'name' => __('Custom<br />','voyage') ),
								array( 'value' => '6', 
									   'name' => __('None','voyage') ),
							 ),
        	),
        	array(
            	'name' => __('Custom Size (Width) :', 'voyage'),
            	'desc' => '',
            	'id' => '_voyage_size_x',
            	'type' => 'number',
            	'default' => '',
        	),
        	array(
            	'name' => __('Custom Size (Height) :', 'voyage'),
            	'desc' => '',
            	'id' => '_voyage_size_y',
            	'type' => 'number',
            	'default' => '',
        	),
        	array(
            	'name' => __('Intro Text : <br />', 'voyage'),
            	'desc' => '',
            	'id' => '_voyage_intro',
            	'type' => 'radio',
            	'default' => '',
				'options' => array( 
								array( 'value' => '',
									   'name' => __('Excerpt<br />','voyage') ),
								array( 'value' => '2', 
									   'name' => __('Content<br />','voyage') ),
								array( 'value' => '3', 
									   'name' => __('None<br />','voyage') ),
							 ),
        	),
        	array(
            	'name' => __('Post Meta :', 'voyage'),
            	'desc' => __('check to display post meta','voyage'),
            	'id' => '_voyage_disp_meta',
            	'type' => 'checkbox',
            	'default' => '',
        	),
    	)
	);
	$voyage_meta_box['post'] = array( 
		'id' => 'voyage-post-meta',
		'title' => __('Voyage Post Options', 'voyage'),  
		'context' => 'side',  //normal, advaned, side  
		'priority' => 'high', //high, core, default, low
		'fields' => array(
        	array(
            	'name' => __('Layout :', 'voyage'),
            	'desc' => '',
            	'id' => '_voyage_layout',
            	'type' => 'select',
            	'default' => '',
				'options' => array( 
								array( 'value' => '', //Dedault
									   'name' => 'Default' ),
								array( 'value' => '1', 
									   'name' => 'Fullwidth' ),
							 ),
        	),
    	)
	);

    foreach($voyage_meta_box as $post_type => $value) {
        add_meta_box($value['id'], $value['title'], 'voyage_meta_display', $post_type, $value['context'], $value['priority']);
    }
}
add_action('admin_menu', 'voyage_meta_box');

//Display Meta Box
function voyage_meta_display() {
  global $voyage_meta_box, $post;
 
  // Use nonce for verification
  echo '<input type="hidden" name="voyage_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
 
  foreach ($voyage_meta_box[$post->post_type]['fields'] as $field) {
      // get current post meta data
      $meta = get_post_meta($post->ID, $field['id'], true);
 
      echo '<p><strong>' . $field['name'] . ' </strong>';
      switch ($field['type']) {
          case 'text':
              echo '<input type="text" name="'. $field['id']. '" id="'. $field['id'] .'" value="'. ($meta ? $meta : $field['default']) . '" size="30" />';
              break;
          case 'textarea':
              echo '<textarea name="'. $field['id']. '" id="'. $field['id']. '" cols="60" rows="4" >'. ($meta ? $meta : $field['default']) . '</textarea>'. '<br />'. $field['desc'];
              break;
          case 'number':
              echo '<input type="text" name="'. $field['id']. '" id="'. $field['id'] .'" value="'. ($meta ? $meta : $field['default']) . '" size="4" />';
              break;
          case 'select':
              echo '<select name="'. $field['id'] . '" id="'. $field['id'] . '">';
              foreach ($field['options'] as $option) {
                  echo '<option value="' . $option['value']. '" ' . ( $meta == $option['value'] ? ' selected="selected"' : '' ) . '>'. $option['name'] . '</option>';
              }
              echo '</select> ' . $field['desc'];
              break;
          case 'category':
              echo '<select name="'. $field['id'] . '" id="'. $field['id'] . '">';		  
              echo '<option value="" ' . ( $meta ? '' : 'selected="selected"' ) . '>'
					. __('All Categories','voyage') . '</option>';
						  
              foreach (voyage_categories()  as $category) {
                  echo '<option value="' . $category->term_id . '" '. ( $meta == $category->term_id ? ' selected="selected"' : '' ) . '>'. $category->name . '</option>';
              }
              echo '</select>';
              break;
          case 'radio':
              foreach ($field['options'] as $option) {
                  echo '<input type="radio" name="' . $field['id'] . '" value="' . $option['value'] . '"' . ( $meta == $option['value'] ? ' checked="checked"' : '' ) . ' /> ' . $option['name'] . ' ';
              }
              break;
          case 'checkbox':
              echo '<input type="checkbox" name="' . $field['id'] . '" id="' . $field['id'] . '" value="1"' . ( $meta ? ' checked="checked"' : '' ) . ' /> ' . $field['desc'];;
              break;
      }
	  echo '</p>';
  }
 
}
// Save data from meta box
function voyage_meta_save($post_id) {
    global $voyage_meta_box,  $post;
    
    //Verify nonce
    if ( !isset($_POST['voyage_meta_box_nonce']) )
		return $post_id;
	
	if (!wp_verify_nonce($_POST['voyage_meta_box_nonce'], basename(__FILE__)))
        return $post_id;
 
    //Check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
 
    //Check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }
    
    foreach ($voyage_meta_box[$post->post_type]['fields'] as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
		if (isset($_POST[$field['id']]) ) {
			$new = $_POST[$field['id']];
			if ($field['type'] == 'number') {
				$new = (int)$new;
			}			
		}
		else {
        	$new = '';			
		}

        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }
}
add_action('save_post', 'voyage_meta_save');

function voyage_category_count_span($links) {
  $links = str_replace('</a> (', '</a> <span>(', $links);
  $links = str_replace(')', ')</span>', $links);
  return $links;
}
add_filter('wp_list_categories', 'voyage_category_count_span');

function voyage_archive_count_span($links) {
  $links = str_replace('</a>&nbsp;(', '</a> <span>(', $links);
  $links = str_replace(')', ')</span>', $links);
  return $links;
}
add_filter('get_archives_link', 'voyage_archive_count_span');
?>