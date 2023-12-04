<?php
/**
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2016, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
 *
 */

/*---------------------------------------------------
/* SEARCH AJAX
/*---------------------------------------------------*/

if (!function_exists('yolo_result_search_callback')) {
    function yolo_result_search_callback() {
        ob_start();

        $yolo_options = yolo_get_options();
        $posts_per_page = 8;

        if (isset($yolo_options['search_box_result_amount']) && !empty($yolo_options['search_box_result_amount'])) {
            $posts_per_page = $yolo_options['search_box_result_amount'];
        }

        $post_type = array();
        if (isset($yolo_options['search_box_post_type']) && is_array($yolo_options['search_box_post_type'])) {
            foreach($yolo_options['search_box_post_type'] as $key => $value) {
                if ($value == 1) {
                    $post_type[] = $key;
                }
            }
        }

        $keyword = $_REQUEST['keyword'];

        if ( $keyword ) {
            $search_query = array(
                's'              => $keyword,
                'order'          => 'DESC',
                'orderby'        => 'date',
                'post_status'    => 'publish',
                'post_type'      => $post_type,
                'posts_per_page' => $posts_per_page + 1,
            );
            $search = new WP_Query( $search_query );

            $newdata = array();
            if ($search && count($search->post) > 0) {
                $count = 0;
                foreach ( $search->posts as $post ) {
                    if ($count == $posts_per_page) {
                        $newdata[] = array(
                            'id'        => -2,
                            'title'     => '<a href="' . site_url() .'?s=' . $keyword . '"><i class="wicon icon-outline-vector-icons-pack-94"></i> ' . esc_html__('View More','yolo-motor') . '</a>',
                            'guid'      => '',
                            'date'      => null,
                        );

                        break;
                    }
                    $newdata[] = array(
                        'id'        => $post->ID,
                        'title'     => $post->post_title,
                        'guid'      => get_permalink( $post->ID ),
                        'date'      => mysql2date( 'M d Y', $post->post_date ),
                    );
                    $count++;

                }
            }
            else {
                $newdata[] = array(
                    'id'        => -1,
                    'title'     => esc_html__( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'yolo-motor' ),
                    'guid'      => '',
                    'date'      => null,
                );
            }

            ob_end_clean();
            echo json_encode( $newdata );
        }
        die(); // this is required to return a proper result
    }
    add_action( 'wp_ajax_nopriv_result_search', 'yolo_result_search_callback' );
    add_action( 'wp_ajax_result_search', 'yolo_result_search_callback' );

}

if (!function_exists('yolo_result_search_product_callback')) {
	function yolo_result_search_product_callback() {
		ob_start();

		$yolo_options = yolo_get_options();
		$posts_per_page = 8;

		if (isset($yolo_options['search_box_result_amount']) && !empty($yolo_options['search_box_result_amount'])) {
			$posts_per_page = $yolo_options['search_box_result_amount'];
		}

		$keyword = $_REQUEST['keyword'];
		$cate_id = isset($_REQUEST['cate_id']) ? $_REQUEST['cate_id'] : '-1';

		if ( $keyword ) {
			$search_query = array(
				's' => $keyword,
				'order'     	=> 'DESC',
				'orderby'   	=> 'date',
				'post_status'	=> 'publish',
				'post_type' 	=> array('product'),
				'posts_per_page'         => $posts_per_page + 1,
			);
			if (isset($cate_id) && ($cate_id != -1)) {
				$search_query ['tax_query'] = array(array(
                    'taxonomy'         => 'product_cat',
                    'terms'            => array($cate_id),
                    'include_children' => true,
				));
			}

			$search = new WP_Query( $search_query );

			$newdata = array();
			if ($search && count($search->post) > 0) {
				$count = 0;
				foreach ( $search->posts as $post ) {
					if ($count >= $posts_per_page) {

						$category = get_term_by('id', $cate_id, 'product_cat', 'ARRAY_A');
						$cate_slug = isset($category['slug']) ? '&amp;product_cate=' . $category['slug'] : '';
						$newdata[] = array(
							'id'        => -2,
							'title'     => '<a href="' . site_url() .'?s=' . $keyword . '&amp;post_type=product' . $cate_slug . '"><i class="wicon icon-outline-vector-icons-pack-94"></i> ' . esc_html__('View More','yolo-motor') . '</a>',
						);
						break;
					}
					$product = new WC_Product( $post->ID );
					$price = $product->get_price_html();

					$newdata[] = array(
						'id'        => $post->ID,
						'title'     => $post->post_title,
						'guid'      => get_permalink( $post->ID ),
						'thumb'		=> get_the_post_thumbnail( $post->ID, 'thumbnail' ),
						'price'		=> $price
					);
					$count++;

				}
			}
			else {
				$newdata[] = array(
					'id'        => -1,
					'title'     => esc_html__( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'yolo-motor'),
				);
			}

			ob_end_clean();
			echo json_encode( $newdata );
		}
		die(); // this is required to return a proper result
	}
	add_action( 'wp_ajax_nopriv_result_search_product', 'yolo_result_search_product_callback' );
	add_action( 'wp_ajax_result_search_product', 'yolo_result_search_product_callback' );
}

/*---------------------------------------------------
/* CUSTOM PAGE - LESS JS
/*---------------------------------------------------*/
if (!function_exists('yolo_custom_page_less_js')) {
    function yolo_custom_page_less_js() {
        echo yolo_custom_css_variable();
        echo '@import "' . get_template_directory_uri() .'/assets/less/style.less";', PHP_EOL;
        $yolo_options = yolo_get_options();

        $home_preloader =  $yolo_options['home_preloader'];
        if ($home_preloader != 'none' && !empty($home_preloader)) {
            echo '@import "' . get_template_directory_uri() .'/assets/less/loading/'.$home_preloader.'.less";', PHP_EOL;
        }

        if ( isset($yolo_options['switch_selector']) && ($yolo_options['switch_selector'] == 1)) {
            echo '@import "' . get_template_directory_uri() .'/assets/less/switch-style-selector.less";', PHP_EOL;
        }

	    $enable_rtl_mode = '0';
	    if (isset($yolo_options['enable_rtl_mode'])) {
		    $enable_rtl_mode =  $yolo_options['enable_rtl_mode'];
	    }

		if (is_rtl() || $enable_rtl_mode == '1' || isset($_GET['RTL'])) {
			echo '@import "' . get_template_directory_uri() .'/assets/less/rtl.less";', PHP_EOL;
		}
    }
    add_action('yolo-custom-page/less-js', 'yolo_custom_page_less_js');
}


/*---------------------------------------------------
/* Add less script for developer
/*---------------------------------------------------*/
if (!function_exists('yolo_add_less_for_dev')) {
    function yolo_add_less_for_dev () {
        if (defined( 'YOLO_SCRIPT_DEBUG' ) && YOLO_SCRIPT_DEBUG) {
	        echo sprintf('<link rel="stylesheet/less" type="text/css" href="%s%s"/>',
    		        get_site_url() . '?yolo-custom-page=less-js',
    		        isset($_GET['RTL']) ? '&RTL=1' : ''
		        );

            echo '<script src="'. get_template_directory_uri(). '/assets/js/less.min.js"></script>';

            $css = yolo_custom_css();
            echo '<style>' . $css . '</style>';
        }
    }
    add_action('wp_head','yolo_add_less_for_dev', 100);
}

/*---------------------------------------------------
/* Switch Selector
/*---------------------------------------------------*/
if (!function_exists('yolo_switch_selector_callback')) {
    function yolo_switch_selector_callback() {
        yolo_get_template('switch-selector');
        die();
    }
    add_action( 'wp_ajax_nopriv_switch_selector', 'yolo_switch_selector_callback' );
    add_action( 'wp_ajax_switch_selector', 'yolo_switch_selector_callback' );
}

if (!function_exists('yolo_switch_selector_change_color_callback')) {
    function yolo_switch_selector_change_color_callback() {
        if (!class_exists('Less_Parser')) {
            require_once get_template_directory() . '/framework/core/less/Autoloader.php';
            Less_Autoloader::register();
        }
        $content_file  = yolo_custom_css_variable(get_the_ID());
        $primary_color = $_REQUEST['primary_color'];
        $content_file  .= '@primary_color:' . $primary_color . ';';

        $file_full_variable = get_template_directory() . '/assets/less/variable.less';
        $file_mixins        = get_template_directory() . '/assets/less/mixins.less';
        $file_color         = get_template_directory() . '/assets/less/color.less';

        $parser = new Less_Parser(array( 'compress'=>true ));
        $parser->parse($content_file);
        $parser->parseFile($file_full_variable);
        $parser->parseFile($file_mixins);
        $parser->parseFile($file_color);
        $css    = $parser->getCss();
        echo  $css;
        die();

    }
    add_action( 'wp_ajax_nopriv_custom_css_selector', 'yolo_switch_selector_change_color_callback' );
    add_action( 'wp_ajax_custom_css_selector', 'yolo_switch_selector_change_color_callback' );
}

/*---------------------------------------------------
/* Product Quick View
/*---------------------------------------------------*/
if (!function_exists('yolo_product_quick_view_callback')) {
	function yolo_product_quick_view_callback() {
        $product_id = $_REQUEST['id'];
        global $post, $product, $woocommerce;
        $post       = get_post($product_id);
        setup_postdata($post);
        $product    = wc_get_product( $product_id );
        wc_get_template_part('content-product-quick-view');
        wp_reset_postdata();
		die();
	}
	add_action( 'wp_ajax_nopriv_product_quick_view', 'yolo_product_quick_view_callback' );
	add_action( 'wp_ajax_product_quick_view', 'yolo_product_quick_view_callback' );
}

/*
* Get products by category slug
*/
if ( !function_exists('yolo_get_data_by_category')) {
    function yolo_get_data_by_category(){
        $output = '';
        if ( isset($_POST) ) {
            $args = array(
                    'post_type'      => 'product',
                    'posts_per_page' => -1,
                    'post_status'    => 'publish',
                    'tax_query'      => array(
                    'relation'       => 'AND',
                    array(
                        'taxonomy'  => 'product_cat',
                        'field'     => 'slug',
                        'terms'     => $_POST['cat']
                    )
                ),
            );
            $the_query = new WP_Query( $args );
            while ( $the_query->have_posts() ) {
                $the_query->the_post();
                $output .= wc_get_template_part( 'content', 'product' );
            }
        }
        return $output;
    }
    add_action( 'wp_ajax_nopriv_yolo_get_data_by_category', 'yolo_get_data_by_category' );
    add_action( 'wp_ajax_yolo_get_data_by_category', 'yolo_get_data_by_category' );
}