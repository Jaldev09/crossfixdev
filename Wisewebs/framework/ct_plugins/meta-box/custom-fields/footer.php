<?php
/**
 * This class defines new "Footer" field type for Meta Box class
 * 
 * @author GDragon <longdt@vietbrain.com>
 * @package Meta Box
 * @see http://metabox.io/?post_type=docs&p=390
 */

if ( class_exists( 'RWMB_Field' ) && !class_exists( 'RWMB_Footer_Field' ) ) {
	class RWMB_Footer_Field extends RWMB_Field {

		/**
		 * Enqueue scripts and styles
		 *
		 * @return void
		 */
		static function admin_enqueue_scripts() {
			wp_register_style( 'rwmb-footer', get_template_directory_uri(). '/framework/ct_plugins/meta-box/custom-fields/assets/css/footer.css', array(), '3.2', true );
			wp_enqueue_style('rwmb-footer');

			wp_register_script( 'rwmb-footer', get_template_directory_uri(). '/framework/ct_plugins/meta-box/custom-fields/assets/js/footer.js', array(), '3.2', true );
			wp_enqueue_script('rwmb-footer');
		}

		/**
		 * Get field HTML
		 *
		 * @param mixed  $meta
		 * @param array  $field
		 *
		 * @return string
		 */
		static function html( $meta, $field ) {		
			$html = sprintf('<select class="rwmb-footer" name="%s" id="%s">',
				$field['field_name'],
				$field['id']
				);

			$html .= self::options_html( $field, $meta );
			$html .= '</select>';

			return $html;
		}

		/**
		 * Creates html for options
		 *
		 * @param array $field
		 * @param mixed $meta
		 *
		 * @return array
		 */
		static function options_html( $field, $meta )
		{	
			$field['options'] = self::get_footer_posts();

			$html = '';
			$html .= '<option value="">'. esc_html__( 'Default', 'yolo-motor' ) .'</option>';
			$option = '<option value="%s"%s>%s</option>';

			foreach ( $field['options'] as $value => $label ) {
				$html .= sprintf(
					$option,
					$value,
					selected( in_array( $value, (array) $meta ), true, false ),
					$label
				);
			}

			return $html;
		}

		// Get Footer Block to render
		static function get_footer_posts() {
            $args = array(
                'posts_per_page'   => -1,
                'post_type'        => 'yolo_footer',
                'post_status'      => 'publish',
            );
            $posts_array = get_posts( $args );
            foreach ( $posts_array as $k => $v ) {
                $footer[$v->ID] = $v->post_title;
            }

            return $footer;
		}
	}
}