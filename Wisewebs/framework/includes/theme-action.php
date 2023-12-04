<?php
/**
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2016, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/
 
/*---------------------------------------------------
/* THEME ADD ACTION
/*---------------------------------------------------*/


/* COMMENT FORM BEFORE */
if (!function_exists('yolo_comment_form_before_fields')) {
    function yolo_comment_form_before_fields() {
        ?>
        <div class="comment-fields-wrap">
            <div class="comment-fields-inner clearfix">
                <div class="row">
        <?php
    }
    add_action('comment_form_before_fields','yolo_comment_form_before_fields');
    add_action('comment_form_logged_in_after','yolo_comment_form_before_fields');
}


/* COMMENT BOTTOM FORM */
if (!function_exists('yolo_bottom_comment_form')) {
    function yolo_bottom_comment_form() {
        echo '</div></div></div>';
    }
    add_action('comment_form','yolo_bottom_comment_form');
}


/* CUSTOM HEADER CSS */
if (!function_exists('yolo_custom_header_css')) {
	function yolo_custom_header_css() {
		$page_id = '0';
		if (isset($_REQUEST['current_page_id'])) {
			$page_id = $_REQUEST['current_page_id'];
		}

		$css_variable = yolo_custom_css_variable($page_id);

		if (!class_exists('Less_Parser')) {
			require_once get_template_directory() . '/framework/core/less/Autoloader.php';
			Less_Autoloader::register();
		}
		$parser = new Less_Parser(array( 'compress'=>true ));

		$parser->parse($css_variable, get_template_directory_uri());
		$parser->parseFile( get_template_directory() . '/assets/less/variable.less', get_template_directory_uri() );
		$parser->parseFile( get_template_directory() . '/assets/less/mixins.less', get_template_directory_uri() );
		$parser->parseFile( get_template_directory() . '/assets/less/header-customize.less', get_template_directory_uri() );

		$prefix = 'yolo_';
		$enable_page_color = get_post_meta($page_id,$prefix . 'enable_page_color',true);
		if ($enable_page_color == '1') {
			$parser->parseFile( get_template_directory() . '/assets/less/color.less' );
		}

		$css = $parser->getCss();

		header("Content-type: text/css; charset: UTF-8");
		echo sprintf('%s', $css);
	}
	add_action('yolo-custom-page/header-custom-css', 'yolo_custom_header_css');
}