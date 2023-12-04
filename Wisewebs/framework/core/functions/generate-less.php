<?php
/**
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @created    21/12/2015
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2015, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
 */

function yolo_generate_less()
{
    try {
        $yolo_options = yolo_get_options();
        
	    $yolo_options = get_option('yolo_motor_options');
	    if ( ! defined( 'FS_METHOD' ) ) {
		    define('FS_METHOD', 'direct');
	    }
        $home_preloader =  $yolo_options['home_preloader'];
        $css_variable   = yolo_custom_css_variable();
        $custom_css     = yolo_custom_css();

        if (!class_exists('Less_Parser')) {
            require_once get_template_directory() . '/framework/core/less/Autoloader.php';
            Less_Autoloader::register();
        }

        // Create file .min.css
        $parser = new Less_Parser(array( 'compress'=>true ));

        $parser->parse($css_variable);
        $parser->parseFile( get_template_directory() . '/assets/less/style.less' );

        if ($home_preloader != 'none' && !empty($home_preloader)) {
            $parser->parseFile( get_template_directory() . '/assets/less/loading/'.$home_preloader.'.less' );
        }

        if ( isset($yolo_options['switch_selector']) && ($yolo_options['switch_selector'] == 1)) {
            $parser->parseFile( get_template_directory() . '/assets/less/switch-style-selector.less' );
        }

        $parser->parse($custom_css);
        $css = $parser->getCss();

        require_once ABSPATH . 'wp-admin/includes/file.php';
        WP_Filesystem();
        global $wp_filesystem;

        if (!$wp_filesystem->put_contents( get_template_directory().   "/style.min.css", $css, FS_CHMOD_FILE)) {
            return array(
                'status' => 'error',
                'message' => esc_html__( 'Could not save file', 'yolo-motor' )
            );
        }

        $theme_info = $wp_filesystem->get_contents( get_template_directory() . "/theme-info.txt" );

        // Create file .css
        $parser = new Less_Parser();
        $parser->parse($css_variable);
        $parser->parseFile(get_template_directory() . '/assets/less/style.less');
        if ($home_preloader != 'none' && !empty($home_preloader)) {
            $parser->parseFile( get_template_directory() . '/assets/less/loading/'.$home_preloader.'.less' );
        }

        if ( isset($yolo_options['switch_selector']) && ($yolo_options['switch_selector'] == 1)) {
            $parser->parseFile( get_template_directory() . '/assets/less/switch-style-selector.less' );
        }


        $parser->parse($custom_css);
        $css = $parser->getCss();

        $css = $theme_info . "\n" . $css;
	    $css = str_replace("\r\n","\n", $css);

        if (!$wp_filesystem->put_contents( get_template_directory().   "/style.css", $css, FS_CHMOD_FILE)) {
            return array(
                'status'  => 'error',
                'message' => esc_html__('Could not save file','yolo-motor')
            );
        }

        return array(
            'status'  => 'success',
            'message' => ''
        );

    }catch(Exception $e){
        $error_message = $e->getMessage();
        return array(
            'status'  => 'error',
            'message' => $error_message
        );
    }
}