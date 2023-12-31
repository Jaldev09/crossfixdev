<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $el_class
 * @var $full_width
 * @var $full_height
 * @var $equal_height
 * @var $columns_placement
 * @var $content_placement
 * @var $parallax
 * @var $parallax_image
 * @var $css
 * @var $el_id
 * @var $video_bg
 * @var $video_bg_url
 * @var $video_bg_parallax
 * @var $parallax_speed_bg
 * @var $parallax_speed_video
 * @var $content - shortcode content
 * Shortcode class
 * Yolo Options
 * @var $layout
 * @var $overlay_set
 * @var $overlay_image
 * @var $overlay_color
 * @var $overlay_opacity
 * @var $css_animation
 * @var $duration
 * @var $delay
 * @var $this WPBakeryShortCode_VC_Row
 */
$el_class = $full_height = $parallax_speed_bg = $parallax_speed_video = $full_width = $equal_height = $flex_row = $columns_placement = $content_placement = $parallax = $parallax_image = $css = $el_id = $video_bg = $video_bg_url = $video_bg_parallax = '';
// Custom yolo variables
$str_el_id = $layout = $overlay_set = $overlay_image = $overlay_color = $overlay_opacity = $css_animation = $duration = $delay = '';

$output = $after_output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

wp_enqueue_script( 'wpb_composer_front_js' );

$el_class = $this->getExtraClass( $el_class );

$css_classes = array(
    'vc_row',
    'wpb_row', //deprecated
    'vc_row-fluid',
    $el_class,
    vc_shortcode_custom_css_class( $css ),
);

if (vc_shortcode_custom_css_has_property( $css, array('border', 'background') ) || $video_bg || $parallax) {
    $css_classes[]='vc_row-has-fill';
}

if (!empty($atts['gap'])) {
    $css_classes[] = 'vc_column-gap-'.$atts['gap'];
}

$wrapper_attributes = array();
// build attributes for wrapper
if ( ! empty( $el_id ) ) {
    $wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}
if ( ! empty( $full_width ) ) {
    $wrapper_attributes[] = 'data-vc-full-width="true"';
    $wrapper_attributes[] = 'data-vc-full-width-init="false"';
    if ( 'stretch_row_content' === $full_width ) {
        $wrapper_attributes[] = 'data-vc-stretch-content="true"';
    } elseif ( 'stretch_row_content_no_spaces' === $full_width ) {
        $wrapper_attributes[] = 'data-vc-stretch-content="true"';
        $css_classes[] = 'vc_row-no-padding';
    }
    $after_output .= '<div class="vc_row-full-width vc_clearfix"></div>';
}

if ( ! empty( $full_height ) ) {
    $css_classes[] = 'vc_row-o-full-height';
    if ( ! empty( $columns_placement ) ) {
        $flex_row = true;
        $css_classes[] = 'vc_row-o-columns-' . $columns_placement;
        if ( 'stretch' === $columns_placement ) {
            $css_classes[] = 'vc_row-o-equal-height';
        }
    }
}

if ( ! empty( $equal_height ) ) {
    $flex_row = true;
    $css_classes[] = 'vc_row-o-equal-height';
}

if ( ! empty( $content_placement ) ) {
    $flex_row = true;
    $css_classes[] = 'vc_row-o-content-' . $content_placement;
}

if ( ! empty( $flex_row ) ) {
    $css_classes[] = 'vc_row-flex';
}

$has_video_bg = ( ! empty( $video_bg ) && ! empty( $video_bg_url ) && vc_extract_youtube_id( $video_bg_url ) );

$parallax_speed = $parallax_speed_bg;
if ( $has_video_bg ) {
    $parallax = $video_bg_parallax;
    $parallax_speed = $parallax_speed_video;
    $parallax_image = $video_bg_url;
    $css_classes[] = 'vc_video-bg-container';
    wp_enqueue_script( 'vc_youtube_iframe_api_js' );
}

if ( ! empty( $parallax ) ) {
    wp_enqueue_script( 'vc_jquery_skrollr_js' );
    $wrapper_attributes[] = 'data-vc-parallax="' . esc_attr( $parallax_speed ) . '"'; // parallax speed
    $css_classes[] = 'vc_general vc_parallax vc_parallax-' . $parallax;
    if ( false !== strpos( $parallax, 'fade' ) ) {
        $css_classes[] = 'js-vc_parallax-o-fade';
        $wrapper_attributes[] = 'data-vc-parallax-o-fade="on"';
    } elseif ( false !== strpos( $parallax, 'fixed' ) ) {
        $css_classes[] = 'js-vc_parallax-o-fixed';
    }
}

if ( ! empty( $parallax_image ) ) {
    if ( $has_video_bg ) {
        $parallax_image_src = $parallax_image;
    } else {
        $parallax_image_id = preg_replace( '/[^\d]/', '', $parallax_image );
        $parallax_image_src = wp_get_attachment_image_src( $parallax_image_id, 'full' );
        if ( ! empty( $parallax_image_src[0] ) ) {
            $parallax_image_src = $parallax_image_src[0];
        }
    }
    $wrapper_attributes[] = 'data-vc-parallax-image="' . esc_attr( $parallax_image_src ) . '"';
}
if ( ! $parallax && $has_video_bg ) {
    $wrapper_attributes[] = 'data-vc-video-bg="' . esc_attr( $video_bg_url ) . '"';
}

// Custom add animation class to row
$css_classes[] = yolo_get_css_animation($css_animation);
$css_classes[] = yolo_get_style_animation($duration, $delay);

$css_class            = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( array_unique( $css_classes ) ) ), $this->settings['base'], $atts ) );

// Custom add yolo params
if ($overlay_set != 'hide_overlay') {
    $css_class .= ' overlay-bg-vc-wapper';
    if ($overlay_set == 'show_overlay_color') {
        $overlay_color        = yolo_convert_hex_to_rgba(esc_attr($overlay_color), (esc_attr($overlay_opacity) / 100));
        $wrapper_attributes[] = 'data-overlay-color="' . esc_attr($overlay_color) . '"';
    } else if ($overlay_set == 'show_overlay_image') {
        $image_attributes     = wp_get_attachment_image_src( $overlay_image, 'full' );
        $wrapper_attributes[] = 'data-overlay-image="' . $image_attributes[0] . '"';
        $wrapper_attributes[] = 'data-overlay-opacity="' . (esc_attr($overlay_opacity) / 100) . '"';
    }
}

$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

if (!empty($el_id)) {
    $str_el_id = ' id="' . esc_attr($el_id) . '" ';
}

// Yolo layout
if ($layout == 'boxed') {
    $style_layout = 'container';
} elseif ($layout == 'container-fluid') {
    $style_layout = 'container-fluid';
} else {
    $style_layout = 'fullwidth';
}

// Fix equal height bug
if ( ! empty( $equal_height ) ) {
    $output .= '<div' . $str_el_id . ' class="yolo-full-width">'; // @TODO: need change fullwidth to page_layout
    $output .=      '<div ' . implode( ' ', $wrapper_attributes ) . '>';
    $output .=          '<div class="' . $style_layout . '">';
    // $output .=              '<div ' . implode( ' ', $wrapper_attributes ) . '>';
    $output .=              '<div class="vc_row wpb_row vc_row-fluid vc_row-has-fill vc_row-o-equal-height vc_row-flex">';
    $output .= wpb_js_remove_wpautop( $content );
    $output .=              '</div>';
    $output .=          '</div>';
    $output .=      '</div>';
    $output .= '</div>';
    $output .= $after_output;
} else {
    $output .= '<div class = "yolo-full-width">';
    $output .=  '<div ' . implode( ' ', $wrapper_attributes ) . '>';
    $output .=      '<div' . $str_el_id . ' class="' . $style_layout . '" ' . '>';
    $output .= wpb_js_remove_wpautop( $content );
    $output .=      '</div>';
    $output .= '</div></div>';
    $output .= $after_output;
}

echo $output;