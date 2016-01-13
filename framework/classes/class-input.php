<?php 

/**
 * AUS Basic Inputs
 *
 * Theme Options page inputs generator class
 * Uses Wordpress default form html markup
 *
 * @package WordPress
 * @subpackage AUS Bsic Options
 * @since AUS Bsic 0.1.1
 * @author Anvar Ulugov
 * @license GPL2
 */

class AUS_input {

	private $theme_slug;
	private $options;

	public function __construct( $theme_slug = null, $options = null ) {
		$this->theme_slug = $theme_slug;
		$this->options = $options;
	}

	public function _esc_attr( $option ) {
		if( isset( $this->options[ $option ] ) )
			return $this->options[ $option ];
		else
			return false;
	}

	public function input( $args, $name_type = 'option', $post_id = false ) {
		$defaults = array(
			'id' => '',
			'type' => '',
			'title' => '',
			'description' => '',
			'options' => array(),
			'editor' => array(
				'visual' => true,
				'teeny'=>true,
				'textarea_rows'=>4,
			),
			'atts' => array(),
		);

		$configs = array_replace_recursive( $defaults, $args );
		extract( $configs, EXTR_OVERWRITE );

		if ( ( $type == 'select' || $type == 'cats' || $type == 'categories' ) && ! empty( $atts ) && array_key_exists( 'multiple', $atts ) ) {
			$multiple = true;
		} else {
			$multiple = false;
		}

		if ( $name_type == 'option' ) {
			$field_name = $this->theme_slug . '_theme_options' . '[' . $id . ']';
			$value = $this->_esc_attr( $id, $type );
		} elseif ( $name_type == 'metabox' && $post_id ) {
			$field_name = $id;
			if ( get_post_meta( $post_id, $id, true ) )
				$value = get_post_meta( $post_id, $id, true );
		}
		

		$editor['textarea_name'] = $field_name;

		$attributes = '';
		if( isset( $atts ) and ! empty( $atts ) ) {
			foreach ($atts as $attribute => $attr_value) {
				$attributes .= $attribute . '="' . $attr_value . '"';
			}
		}

		switch ( $type ) {

			case 'radio':
				$input = '<fieldset>';
				foreach ($options as $key => $option) {
					$input .= '<label title="' . $option . '">';
					$input .= '<input type="radio" name="' . $field_name . '" value="' . $key . '" ' . ( $value == $key ? 'checked="checked"' : '' ) . ' />';
					$input .= '<span>' . $option . '</span>';
					$input .= '</label><br />';
				}
				$input .= '</fieldset>';
				break;
			case 'radioimage':
				$input = '<fieldset>';
				$input .= '<ul class="radioimage">';
				foreach ($options as $key => $option) {
					$input .= "<li>";
					$input .= '<label title="' . $option . '">';
					$input .= '<input style="display:none" type="radio" name="' . $field_name . '" value="' . $key . '" ' . ( $value == $key ? 'checked="checked"' : '' ) . ' />';
					$input .= '<img' . ( $value == $key ? ' class="checked"' : '' ) . '  src="' . get_aus_uri() . '/media/img/' . $option . '" />';
					//$input .= '<span>' . $option . '</span>';
					$input .= '</label>';
					$input .= "</li>";
				}
				$input .= '</ul>';
				$input .= '</fieldset>';
				break;
			case 'textarea':
				if ( $editor['visual'] === true ) {
					ob_start();
					wp_editor($value, $id, $editor);
					$input = ob_get_contents();
					ob_end_clean();
				} else {
					$input = '<textarea name="' . $field_name . '" id="' .$id . '"' . $attributes . '>' . $value . '</textarea>';
				}
				break;
			case 'select':
				$input  = '<select name="' . $field_name . ( $multiple ? '[]' : '' ) . '" id="' .$id . '" ' . $attributes . '>';
				$input .= '<option value="0">&ndash; ' . __( 'Select', 'aus-basic' ) . ' &ndash;</option>';
				foreach ( $options as $key => $option ) {
					if ( $multiple ) {
						$selected = ( in_array( $key, $value ) ? 'selected="selected"' : '' );
					} else {
						$selected = ( $value == $key ? 'selected="selected"' : '' );
					}
					$input .= '<option ' . $selected . ' value="'. $key .'">' . $option . '</option>';
				}
				$input .= '</select>';
				break;

			case 'categories':
			case 'cats':
				$input = '<select name="' . $field_name . ( $multiple ? '[]' : '' ) . '" id="' .$id . '" ' . $attributes . '>';
				$input .= '<option value="0">&ndash; ' . __( 'Select', 'aus-basic' ) . ' &ndash;</option>';
				foreach ( get_categories( array( 'hide_empty' => false ) ) as $cat ) {
					if ( $multiple ) {
						$selected = ( in_array( $cat->cat_ID, $value ) ? 'selected="selected"' : '' );
					} else {
						$selected = ( $value == $cat->cat_ID ? 'selected="selected"' : '' );
					}
					$input .= '<option ' . $selected . ' value="'. $cat->cat_ID .'">' . $cat->cat_name . '</option>';
				}
				$input .= '</select>';
				break;

			case 'thumbnails':
				$input = '<select name="' . $field_name . '" id="' .$id . '" ' . $attributes . '>';
				$input .= '<option value="0">&ndash; ' . __( 'Select', 'aus-basic' ) . ' &ndash;</option>';
				foreach ( $this->get_image_sizes() as $thumbnail => $size ) {
					$input .= '<option ' . ( $value == $thumbnail ? 'selected="selected"' : '' ) . ' value="'. $thumbnail . '">' . $thumbnail . ' - ' . $size['width'] . 'x' . $size['height'] . 'px</option>';
				}
				$input .= '</select>';
				break;

			case 'image':
				$input = '<input id="' .$id . '" type="text" size="36" name="' . $field_name . '" placeholder="http://..." value="' . $value . '" />';
				$input .= '<input class="button image-upload" data-field="#' . $id . '" type="button" value="' . __( 'Upload Image', 'aus-basic' ) . '" />';
				break;

			case 'checkbox':
				$input = '<fieldset class="checkbox-label">';
				$input .= '<label title="' . $id . '">';
				$input .= '<input name="' . $field_name . '" id="' .$id . '" type="' .$type . '" value="1"' . $attributes  . ( $value ? 'checked="checked"' : '' ) . ' />';
				$input .= $title;
				$input .= '</label>';
				$input .= '<span class="checkbox' . ( $value ? ' checked' : '' ) . '"></span>';
				$input .= '</fieldset>';
				break;
			case 'date':
				$input = '<input name="' . $field_name . '" id="' .$id . '" type="text" value="' . $value . '"' . $attributes . ' />';
				break;
			default:
			case 'email':
			case 'text':
				$input = '<input name="' . $field_name . '" id="' .$id . '" type="' .$type . '" value="' . $value . '"' . $attributes . ' />';
				break;

		}

		$html  = '';
		$html .= $input;
		if( ! empty( $description ) )
			$html .= '<p class="description">' . $description . '</p>';
		echo $html;
	}

	public function get_image_sizes( $size = '' ) {

		global $_wp_additional_image_sizes;

		$sizes = array();
		$get_intermediate_image_sizes = get_intermediate_image_sizes();

		// Create the full array with sizes and crop info
		foreach( $get_intermediate_image_sizes as $_size ) {

			if ( in_array( $_size, array( 'thumbnail', 'medium', 'large' ) ) ) {

				$sizes[ $_size ]['width'] = get_option( $_size . '_size_w' );
				$sizes[ $_size ]['height'] = get_option( $_size . '_size_h' );
				$sizes[ $_size ]['crop'] = (bool) get_option( $_size . '_crop' );

			} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {

				$sizes[ $_size ] = array( 
					'width' => $_wp_additional_image_sizes[ $_size ]['width'],
					'height' => $_wp_additional_image_sizes[ $_size ]['height'],
					'crop' =>  $_wp_additional_image_sizes[ $_size ]['crop']
				);

			}

		}

		// Get only 1 size if found
		if ( $size ) {

			if( isset( $sizes[ $size ] ) ) {
				return $sizes[ $size ];
			} else {
				return false;
			}

		}

		return $sizes;
	}

}