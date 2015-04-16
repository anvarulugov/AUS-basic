<?php 
/**
 * AU Slim Options
 *
 * Theme Options page generator class
 * Uses Wordpress default form html style
 *
 * @link http://codex.wordpress.org/Creating_Options_Pages
 *
 * @package WordPress
 * @subpackage AU Slim Options
 * @since AU Slim Options 0.1.1
 * @author Anvar Ulugov
 * @license 
 */

class AUS_theme_options {

	private $theme_name;
	private $theme_slug;
	private $menutype;
	private $options;

	function __construct( $theme_name = 'API', $theme_slug = 'api', $menutype = 'sublevel' ) {

		$this->theme_name = $theme_name;
		$this->theme_slug = $theme_slug;
		$this->menutype = $menutype;

		$this->init();
		add_action( 'admin_menu', array( $this, 'create_menu_page' ) );
		add_action( 'admin_init', array( $this, 'initialize_theme_options' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
	
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
		if ( isset( $_GET['page'] ) && $_GET['page'] == $this->theme_slug . '_theme_options' ) {
			wp_enqueue_media();
			wp_register_script( 'aus-admin', get_template_directory_uri() . '/media/js/admin.js', array( 'jquery' ) );
			wp_enqueue_script( 'aus-admin' );
		}
	}

	/**
	 * #1 submenu page display
	 */

	public function theme_options_display() {
		?>
		<div class="wrap">
			<h2><?php echo sprintf(__('%s Theme', 'aus-basic'), $this->theme_name ); ?></h2>
			<?php if ( $this->developer_mode ) : ?>
			<pre>
			<?php print_r( $this->options ); ?>
			</per>
			<?php endif; ?>
			<form method="post" action="options.php">
			<?php settings_fields( $this->theme_slug . '_theme_options_group' ); ?>
			<?php do_settings_sections( $this->theme_slug . '_theme_options' ); ?>
			<?php submit_button(); ?>
			</form>
		</div>
		<?php 
	}

	/**
	 * Initialize theme options
	 */

	public function initialize_theme_options() {

		// First, we register a section. This is necessary since all 
		// future options must belong a section.
		add_settings_section(
			$this->theme_slug . '_theme_settings_section', // ID that used to identify this section and whith wich to register options
			sprintf(__('%s theme options', 'aus-basic'),$this->theme_name), // Title to be displayed on the administration page
			array( $this, 'theme_general_options_ballback'), // Call back used to render the description of the section
			$this->theme_slug . '_theme_options' // Page on which to add this section of options
		);

		add_settings_field(
			'logo_img',
			'<label for="logo_img">' . __( 'Logo Image', 'aus-basic' ) . '</label>',
			array( $this, 'input'),
			$this->theme_slug . '_theme_options',
			$this->theme_slug . '_theme_settings_section',
			array(
				'id' => 'logo_img',
				'type' => 'image',
				'description' => __( 'Insert image url or upload', 'aus-basic' ),
			)
		);

		add_settings_field(
			'featured_cat',
			'<label for="featured_cat">' . __( 'Featured category', 'aus-basic' ) . '</label>',
			array( $this, 'input'),
			$this->theme_slug . '_theme_options',
			$this->theme_slug . '_theme_settings_section',
			array(
				'id' => 'featured_cat',
				'type' => 'categories',
				'description' => __( 'Select featured category', 'aus-basic' ),
			)
		);

		add_settings_field(
			'show_home_menu', // ID to identify the field throughout the theme 
			'<label for="show_home_menu">' . __( 'Show home menu', 'aus-basic' ) . '</label>', // The label to the left of the option interface
			array( $this, 'input'), // The name of the function responsible for rendering the option interface
			$this->theme_slug . '_theme_options', // The page on which this option will be displayed
			$this->theme_slug . '_theme_settings_section', // The name of the section to which this field belongs
			array(
				'id' => 'show_home_menu',
				'type' => 'checkbox',
				'title' => __( 'Show home menu', 'aus-basic' ),
				'description' => __( 'Show home menu on primary navigation', 'aus-basic' ),
			) // The array of arguments to pass to the callback function.
		);

		add_settings_field(
			'home_menu_text', // ID to identify the field throughout the theme 
			'<label for="home_menu_text">' . __( 'Home menu text', 'aus-basic' ) . '</label>', // The label to the left of the option interface
			array( $this, 'input'), // The name of the function responsible for rendering the option interface
			$this->theme_slug . '_theme_options', // The page on which this option will be displayed
			$this->theme_slug . '_theme_settings_section', // The name of the section to which this field belongs
			array(
				'id' => 'home_menu_text',
				'type' => 'text',
				'description' => __( 'Leave it blank to show home menu as home icon', 'aus-basic' ),
				'atts' => array( 'style' => 'width:auto;')
			) // The array of arguments to pass to the callback function.
		);

		add_settings_field(
			'thumbnail_img',
			'<label for="thumbnail_img">' . __( 'Default thumbnail', 'aus-basic' ) . '</label>',
			array( $this, 'input'),
			$this->theme_slug . '_theme_options',
			$this->theme_slug . '_theme_settings_section',
			array(
				'id' => 'thumbnail_img',
				'type' => 'image',
				'description' => __( 'Insert image url or upload', 'aus-basic' ),
			)
		);

		add_settings_field(
			'thumbnail_size', // ID to identify the field throughout the theme 
			'<label for="thumbnail_size">' . __( 'Default thumbnail size', 'aus-basic' ) . '</label>', // The label to the left of the option interface
			array( $this, 'input'), // The name of the function responsible for rendering the option interface
			$this->theme_slug . '_theme_options', // The page on which this option will be displayed
			$this->theme_slug . '_theme_settings_section', // The name of the section to which this field belongs
			array(
				'id' => 'thumbnail_size',
				'type' => 'thumbnails',
				'description' => __( 'Select default thumbnail size', 'aus-basic' ),
			) // The array of arguments to pass to the callback function.
		);

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
				$output[ $key ] = $input[ $key ];
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

	public function input( $args ) {

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
		$editor['textarea_name'] = $this->theme_slug . '_theme_options' . '[' . $id . ']';

		$attributes = '';
		if( isset( $atts ) and ! empty( $atts ) ) {
			foreach ($atts as $attribute => $attr_value) {
				$attributes .= $attribute . '="' . $attr_value . '"';
			}
		}

		$value = $this->_esc_attr( $id, $type );

		switch ( $type ) {

			case 'radio':
				$input = '<fieldset>';
				foreach ($options as $key => $option) {
					$input .= '<label title="' . $option . '">';
					$input .= '<input type="radio" name="' . $this->theme_slug . '_theme_options'. '[' .$id . ']" value="' . $key . '" ' . ( $value == $key ? 'checked="checked"' : '' ) . ' />';
					$input .= '<span>' . $option . '</span>';
					$input .= '</label><br />';
				}
				$input .= '</fieldset>';
				break;
			case 'textarea':
				ob_start();
				wp_editor($value, $id, $editor);
				$input = ob_get_contents();
				ob_end_clean();
						break;
			case 'select':
				$input  = '<select name="' . $this->theme_slug . '_theme_options'. '[' .$id . ']" id="' .$id . '" ' . $attributes . '>';
				$input .= '<option value="0">&ndash; ' . __( 'Select', 'aus-basic' ) . ' &ndash;</option>';
				foreach ( $options as $key => $option ) {
					$input .= '<option ' . ( $value == $key ? 'selected="selected"' : '' ) . ' value="'. $key .'">' . $option . '</option>';
				}
				$input .= '</select>';
				break;

			case 'categories':
			case 'cats':
				$input = '<select name="' . $this->theme_slug . '_theme_options'. '[' .$id . ']" id="' .$id . '" ' . $attributes . '>';
				$input .= '<option value="0">&ndash; ' . __( 'Select', 'aus-basic' ) . ' &ndash;</option>';
				foreach ( get_categories( array( 'hide_empty' => false ) ) as $cat ) {
					$input .= '<option ' . ( $value == $cat->cat_ID ? 'selected="selected"' : '' ) . ' value="'. $cat->cat_ID .'">' . $cat->cat_name . '</option>';
				}
				$input .= '</select>';
				break;

			case 'thumbnails':
				$input = '<select name="' . $this->theme_slug . '_theme_options'. '[' .$id . ']" id="' .$id . '" ' . $attributes . '>';
				$input .= '<option value="0">&ndash; ' . __( 'Select', 'aus-basic' ) . ' &ndash;</option>';
				foreach ( $this->get_image_sizes() as $thumbnail => $size ) {
					$input .= '<option ' . ( $value == $thumbnail ? 'selected="selected"' : '' ) . ' value="'. $thumbnail . '">' . $thumbnail . ' - ' . $size['width'] . 'x' . $size['height'] . 'px</option>';
				}
				$input .= '</select>';
				break;

			case 'image':
				$input = '<input id="' .$id . '" type="text" size="36" name="' . $this->theme_slug . '_theme_options'. '[' .$id . ']" placeholder="http://..." value="' . $value . '" />';
				$input .= '<input class="button image-upload" data-field="#' . $id . '" type="button" value="' . __( 'Upload Image', 'aus-basic' ) . '" />';
				break;

			case 'checkbox':
				$input = '<fieldset>';
				$input .= '<label title="' . $id . '">';
				$input .= '<input name="' . $this->theme_slug . '_theme_options'. '[' .$id . ']" id="' .$id . '" type="' .$type . '" value="1"' . $attributes  . ( $value ? 'checked="checked"' : '' ) . ' />';
				$input .= $title;
				$input .= '</label>';
				$input .= '</fieldset>';
				break;

			case 'email':
			case 'text':
				$input = '<input name="' . $this->theme_slug . '_theme_options'. '[' .$id . ']" id="' .$id . '" type="' .$type . '" value="' . $value . '"' . $attributes . ' />';
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