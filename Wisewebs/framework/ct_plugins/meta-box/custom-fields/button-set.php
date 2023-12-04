<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'RWMB_Button_Set_Field' ) )
{
	class RWMB_Button_Set_Field extends RWMB_Field
	{
		static function admin_enqueue_scripts()
		{
			wp_enqueue_style( 'rwmb-button-set', get_template_directory_uri(). '/framework/ct_plugins/meta-box/custom-fields/assets/css/button-set.css', array() );
			wp_enqueue_script( 'rwmb-button-set', get_template_directory_uri(). '/framework/ct_plugins/meta-box/custom-fields/assets/js/button-set.js', array() );
		}
		/**
		 * Get field HTML
		 *
		 * @param mixed $meta
		 * @param array $field
		 *
		 * @return string
		 */
		static function html( $meta, $field )
		{
			$html = '<div class="rwmb-button-set">';

			if (isset($field['options']) && is_array($field['options']) && !array_key_exists($meta, $field['options']) && isset($field['std'])) {
				$meta = $field['std'];
			}

			$html .= sprintf(
				'<input type="hidden" class="rwmb-hidden" name="%s" id="%s" value="%s" />',
				$field['field_name'],
				$field['id'],
				$meta
			);

			$html .= sprintf('<div class="rwmb-button-set-inner%s"%s>',
				isset($field['allowClear']) && $field['allowClear'] == true ? ' allow-clear' : '',
				(isset($field['allowClear']) && $field['allowClear'] == true) && isset($field['clearValue']) ? ' data-clear-value="' . $field['clearValue'] . '"' : '');

			foreach ( $field['options'] as $value => $label )
			{
				$html .= sprintf(
					'<label%s data-value="%s"><span>%s</span></label>',
					$meta == $value ? ' class="selected"' : '',
					$value,
					$label
				);
			}
			$html .= '</div>';

			$html .= '</div>';
			return $html;
		}

	}
}
