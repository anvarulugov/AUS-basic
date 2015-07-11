<?php 
/**
 * AUS Basic Options
 *
 * Theme Options page generator class
 * Uses Wordpress default form html markup
 *
 * @link http://codex.wordpress.org/Creating_Options_Pages
 *
 * @package WordPress
 * @subpackage AUS Bsic Options
 * @since AUS Bsic 0.1.1
 * @author Anvar Ulugov
 * @license GPL2
 */

class AUS_theme_options {

	private $theme_name;
	private $theme_slug;
	private $menutype;
	private $options;
	private $tabs;
	private $metaboxes;

	function __construct( $config ) {

		$this->theme_name = $config['theme_name'];
		$this->theme_slug = $config['theme_slug'];
		$this->menutype = $config['menutype'];
		$this->tabs = $config['tabs'];
		$this->metaboxes = $config['metaboxes'];

		$this->init();
		add_action( 'admin_menu', array( $this, 'create_menu_page' ) );
		add_action( 'admin_init', array( $this, 'initialize_theme_options' ) );
		//add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
		add_action( 'add_meta_boxes', array( $this, 'reg_metabox' ) );
		add_action( 'save_post', array( $this, 'save_metabox' ) );
	}

	function init() {
		$this->options = get_option( $this->theme_slug . '_theme_options' );
		$this->developer_mode = false;
	}

	/**
	 * Register Menu items
	 */

	public function create_menu_page() {
		switch ( $this->menutype ) {
			case 'toplevel':
				/*
				add_menu_page(
					sprintf(__('%s theme options', 'aus-basic'),$this->theme_name), // The Title to be displayed on corresponding page for this menu
					sprintf(__('%s Theme', 'aus-basic'),$this->theme_name), // The Text to be displayed for this actual menu item
					'administrator', // Which type of users can see this menu
					$this->theme_slug . '_theme', // The unique ID - that is, the slug - for this menu item
					array( $this, 'menu_page_display' ),
					''
				);

				add_submenu_page(
					$this->theme_slug . '_theme', // Register this submenu with the menu defined above
					$this->theme_name . ' Theme Options', // The text to the display in the browser when this menu item is active
					sprintf(__('%s theme options', 'aus-basic'),$this->theme_name), // The text for this menu item
					'administrator', // Which type of users can see this menu
					$this->theme_slug . '_theme_options', // The unique ID - the slug - for this menu item
					array( $this, 'theme_options_display' ) // The function used to render the menu for this page to the screen
				);
				*/
				break;
				
			default:
				add_theme_page(
					$this->theme_name . ' Theme Options', // The text to the display in the browser when this menu item is active
					sprintf(__('%s theme options', 'aus-basic'),$this->theme_name), // The text for this menu item
					'administrator', // Which type of users can see this menu
					$this->theme_slug . '_theme_options', // The unique ID - the slug - for this menu item
					array( $this, 'theme_options_display' ) // The function used to render the menu for this page to the screen
				);
				break;
		}

	}

	/**
	 * Main menu page display
	 */

	public function menu_page_display() {

		$html  = '<div class="wrap">';
		$html .= '<h2>' . sprintf(__('%s Theme', 'aus-basic'),$this->theme_name) . '</h2>';
		$html .= '';
		$html .= '';
		$html .= '</div>';
		echo $html;

	}

	public function scripts() {
		//isset( $_GET['page'] ) && $_GET['page'] == $this->theme_slug . '_theme_options'
		if ( is_admin() ) {
			wp_enqueue_media();
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_style( 'aus-admin', get_template_directory_uri() . '/media/css/admin.css' );
			wp_register_script( 'aus-admin', get_template_directory_uri() . '/media/js/admin.js', array( 'jquery', 'wp-color-picker' ) );
			wp_enqueue_script( 'aus-admin' );
		}
	}

	/**
	 * #1 submenu page display
	 */

	public function theme_options_display() {
		//add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
		$this->scripts();
		?>
		<div class="wrap">
			<h2><?php echo sprintf(__('%s Theme', 'aus-basic'), $this->theme_name ); ?></h2>
			<h2 class="aus-tabs nav-tab-wrapper">
				<?php $i = 0; foreach ( $this->tabs as $tab ) : $i++; ?>
					<a href="#<?php echo $tab['id']; ?>" class="nav-tab <?php echo ( $i == 1 ? 'nav-tab-active' : '' ); ?>"><?php echo $tab['title']; ?></a>
				<?php endforeach; ?>
			</h2>
			<form method="post" action="options.php">
				<?php settings_fields( $this->theme_slug . '_theme_options_group' ); ?>
				<?php $c = 0; foreach ( $this->tabs as $tab ) : $c++; ?>
					<div class="tab-content <?php echo ( $c == 1 ? 'active' : '' ); ?>" id="<?php echo $tab['id']; ?>">
						<?php do_settings_sections( $this->theme_slug . '_theme_options_' . $tab['id'] ); ?>
					</div>
				<?php endforeach; ?>
			<?php submit_button(); ?>
			</form>
		</div>
		<?php 
	}

	/**
	 * Initialize theme options
	 */

	public function initialize_theme_options() {

		foreach ( $this->tabs as $tab ) {
			add_settings_section(
				$this->theme_slug . '_theme_settings_section_' . $tab['id'],
				sprintf( __( '%s settings', 'aus-basic' ), $tab['title'] ),
				'',
				$this->theme_slug . '_theme_options_' . $tab['id']
			);

			foreach ( $tab['fields'] as $tab_field ) {
				$default = array(
					'id'			=> '',
					'type'			=> '',
					'description'	=> '',
					'options'		=> '',
					'atts'			=> '',
				);
				$field = array_merge( $default, $tab_field );
				add_settings_field(
					$field['id'],
					'<label for="' . $field['id'] . '">' . $field['title'] . '</label>',
					array( $this, 'input'),
					$this->theme_slug . '_theme_options_' . $tab['id'],
					$this->theme_slug . '_theme_settings_section_' . $tab['id'],
					array(
						'id' => $field['id'],
						'type' => $field['type'],
						'description' => $field['description'],
						'options' => $field['options'],
						'atts' => $field['atts'],
					)
				);
			}
		}

		register_setting(
			$this->theme_slug . '_theme_options_group',
			$this->theme_slug . '_theme_options',
			array( $this, 'senitize')
		);

	}

	public function senitize( $input ) {
		$output = array();

		foreach ($input as $key => $value) {
			if ( isset( $input[ $key ] ) ) {
				$output[ $key ] = strip_tags( stripslashes( $input[ $key ] ) );
			}
		}

		return apply_filters( array( $this, 'senitize' ), $output, $input);

	}

	public function _esc_attr( $option ) {
		if( isset( $this->options[ $option ] ) )
			return $this->options[ $option ];
		else
			return false;
	}

	/**
	 * Initialize theme options callbacks
	 */
	public function theme_general_options_ballback() {

		$html = '<h4>' . __( 'General Options', 'aus-basic' ) . '</h4>';
		//echo $html;

	}

	/**
	 * Adds the meta box container.
	 */
	public function reg_metabox() {
		global $post;
		if ( isset( $post ) && ! empty( $post ) && isset( $this->metaboxes[$post->post_type] ) && ! empty( $this->metaboxes[$post->post_type] ) ) {
			add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
			foreach ($this->metaboxes as $type => $metabox) {
				add_meta_box( $metabox['id'], $metabox['title'], array( $this, 'render_metaboxes' ), $type, $metabox['context'], $metabox['priority']);
			}
		}
	}

	/**
	 * Render Meta Box content.
	 *
	 */
	public function render_metaboxes( $post ) {

		wp_nonce_field( 'aus_metabox_nonce', 'aus_metabox' );

		echo '<table class="form-table">';
		echo '<tbody>';
		if ( isset( $this->metaboxes[$post->post_type]['fields'] ) && ! empty( $this->metaboxes[$post->post_type]['fields'] ) ) {
			foreach ($this->metaboxes[$post->post_type]['fields'] as $field) {
				echo '<tr>';
				echo '<th scope="row">';
				echo '<label for="' . $field['id'] . '">' . $field['title'] . '</label>';
				echo '</th>';
				echo '<td>';
				$this->input( $field, 'metabox', $post->ID );
				echo '</td>';
				echo '</tr>';
			}
		}
		echo '</tboxy>';
		echo '</table>';
	}

	/**
	 * Save the meta when the post is saved.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
	public function save_metabox( $post_id ) {
		global $post;
		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['aus_metabox'] ) )
			return $post_id;

		$nonce = $_POST['aus_metabox'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'aus_metabox_nonce' ) )
			return $post_id;

		// If this is an autosave, our form has not been submitted,
				//     so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;

		// Check the user's permissions.
		if ( 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
	
		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}

		/* OK, its safe for us to save the data now. */
		foreach ( $this->metaboxes[$post->post_type]['fields'] as $field ) {
			$old_data = get_post_meta( $post_id, $field['id'], true );
			$new_data = sanitize_text_field( $_POST[ $field['id'] ] );

			if ( $new_data && $new_data != $old_data ) {
				update_post_meta( $post_id, $field['id'], $new_data );
			} elseif ( '' == $new_data && $old_data ) {
				delete_post_meta( $post_id, $field['id'], $old_data );
			}
		}
	}

	public function input( $args, $name_type = 'option', $post_id = false ) {

		$defaults = array(
			'id' => '',
			'type' => '',
			'title' => '',
			'description' => '',
			'options' => array(),
			'editor' => array(
				'teeny'=>true,
				'textarea_rows'=>4,
			),
			'atts' => array(),
		);
		extract( $defaults, EXTR_OVERWRITE );
		extract( $args, EXTR_OVERWRITE );

		if ( $name_type == 'option' ) {
			$file_name = $this->theme_slug . '_theme_options' . '[' . $id . ']';
			$value = $this->_esc_attr( $id, $type );
		} elseif ( $name_type == 'metabox' && $post_id ) {
			$file_name = $id;
			$value = get_post_meta( $post_id, $id, true );
		}
		

		$editor['textarea_name'] = $file_name;

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
					$input .= '<input type="radio" name="' . $file_name . '" value="' . $key . '" ' . ( $value == $key ? 'checked="checked"' : '' ) . ' />';
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
					$input .= '<input style="display:none" type="radio" name="' . $file_name . '" value="' . $key . '" ' . ( $value == $key ? 'checked="checked"' : '' ) . ' />';
					$input .= '<img' . ( $value == $key ? ' class="checked"' : '' ) . '  src="' . $option . '"';
					//$input .= '<span>' . $option . '</span>';
					$input .= '</label>';
					$input .= "</li>";
				}
				$input .= '</ul>';
				$input .= '</fieldset>';
				break;
			case 'textarea':
				ob_start();
				wp_editor($value, $id, $editor);
				$input = ob_get_contents();
				ob_end_clean();
						break;
			case 'select':
				$input  = '<select name="' . $file_name . '" id="' .$id . '" ' . $attributes . '>';
				$input .= '<option value="0">&ndash; ' . __( 'Select', 'aus-basic' ) . ' &ndash;</option>';
				foreach ( $options as $key => $option ) {
					$input .= '<option ' . ( $value == $key ? 'selected="selected"' : '' ) . ' value="'. $key .'">' . $option . '</option>';
				}
				$input .= '</select>';
				break;

			case 'categories':
			case 'cats':
				$input = '<select name="' . $file_name . '" id="' .$id . '" ' . $attributes . '>';
				$input .= '<option value="0">&ndash; ' . __( 'Select', 'aus-basic' ) . ' &ndash;</option>';
				foreach ( get_categories( array( 'hide_empty' => false ) ) as $cat ) {
					$input .= '<option ' . ( $value == $cat->cat_ID ? 'selected="selected"' : '' ) . ' value="'. $cat->cat_ID .'">' . $cat->cat_name . '</option>';
				}
				$input .= '</select>';
				break;

			case 'thumbnails':
				$input = '<select name="' . $file_name . '" id="' .$id . '" ' . $attributes . '>';
				$input .= '<option value="0">&ndash; ' . __( 'Select', 'aus-basic' ) . ' &ndash;</option>';
				foreach ( $this->get_image_sizes() as $thumbnail => $size ) {
					$input .= '<option ' . ( $value == $thumbnail ? 'selected="selected"' : '' ) . ' value="'. $thumbnail . '">' . $thumbnail . ' - ' . $size['width'] . 'x' . $size['height'] . 'px</option>';
				}
				$input .= '</select>';
				break;

			case 'image':
				$input = '<input id="' .$id . '" type="text" size="36" name="' . $file_name . '" placeholder="http://..." value="' . $value . '" />';
				$input .= '<input class="button image-upload" data-field="#' . $id . '" type="button" value="' . __( 'Upload Image', 'aus-basic' ) . '" />';
				break;

			case 'checkbox':
				$input = '<fieldset>';
				$input .= '<label title="' . $id . '">';
				$input .= '<input name="' . $file_name . '" id="' .$id . '" type="' .$type . '" value="1"' . $attributes  . ( $value ? 'checked="checked"' : '' ) . ' />';
				$input .= $title;
				$input .= '</label>';
				$input .= '</fieldset>';
				break;

			default:
			case 'email':
			case 'text':
				$input = '<input name="' . $file_name . '" id="' .$id . '" type="' .$type . '" value="' . $value . '"' . $attributes . ' />';
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