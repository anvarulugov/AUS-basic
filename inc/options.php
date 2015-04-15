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
					sprintf(__('%s theme options', 'themeslug'),$this->theme_name), // The Title to be displayed on corresponding page for this menu
					sprintf(__('%s Theme', 'themeslug'),$this->theme_name), // The Text to be displayed for this actual menu item
					'administrator', // Which type of users can see this menu
					$this->theme_slug . '_theme', // The unique ID - that is, the slug - for this menu item
					array( $this, 'menu_page_display' ),
					''
				);

				add_submenu_page(
					$this->theme_slug . '_theme', // Register this submenu with the menu defined above
					$this->theme_name . ' Theme Options', // The text to the display in the browser when this menu item is active
					sprintf(__('%s theme options', 'themeslug'),$this->theme_name), // The text for this menu item
					'administrator', // Which type of users can see this menu
					$this->theme_slug . '_theme_options', // The unique ID - the slug - for this menu item
					array( $this, 'theme_options_display' ) // The function used to render the menu for this page to the screen
				);
				*/
				break;
				
			default:
				add_theme_page(
					$this->theme_name . ' Theme Options', // The text to the display in the browser when this menu item is active
					sprintf(__('%s theme options', 'themeslug'),$this->theme_name), // The text for this menu item
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
		$html .= '<h2>' . sprintf(__('%s Theme', 'themeslug'),$this->theme_name) . '</h2>';
		$html .= '';
		$html .= '';
		$html .= '</div>';
		echo $html;

	}

	/**
	 * #1 submenu page display
	 */

	public function theme_options_display() {
		?>
		<div class="wrap">
			<h2><?php echo sprintf(__('%s Theme', 'themeslug'),$this->theme_name); ?></h2>
			<?php if ( $this->developer_mode ) : ?>
			<pre>
			<?php print_r($this->options); ?>
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
			sprintf(__('%s theme options', 'themeslug'),$this->theme_name), // Title to be displayed on the administration page
			array( $this, 'theme_general_options_ballback'), // Call back used to render the description of the section
			$this->theme_slug . '_theme_options' // Page on which to add this section of options
		);

		// Next, we'll introduce the fields11
		add_settings_field(
			'show_header', // ID to identify the field throughout the theme 
			__( 'Show header', 'themeslug' ), // The label to the left of the option interface
			array( $this, 'input'), // The name of the function responsible for rendering the option interface
			$this->theme_slug . '_theme_options', // The page on which this option will be displayed
			$this->theme_slug . '_theme_settings_section', // The name of the section to which this field belongs
			array(
				'id' => 'show_header',
				'type' => 'text',
				'description' => __( 'Show header description', 'themeslug' ),
				'atts' => array( 'style' => 'width:auto;')
			) // The array of arguments to pass to the callback function.
		);

		add_settings_field(
			'show_footer', // ID to identify the field throughout the theme 
			__( 'Show footer', 'themeslug' ), // The label to the left of the option interface
			array( $this, 'input'), // The name of the function responsible for rendering the option interface
			$this->theme_slug . '_theme_options', // The page on which this option will be displayed
			$this->theme_slug . '_theme_settings_section', // The name of the section to which this field belongs
			array(
				'id' => 'show_footer',
				'type' => 'checkbox',
				'title' => 'Show footer',
				'description' => __( 'Show footer description', 'themeslug' ),
			) // The array of arguments to pass to the callback function.
		);

		add_settings_field(
			'show_sidebar',
			__( 'Show sidebar', 'themeslug' ),
			array( $this, 'input'),
			$this->theme_slug . '_theme_options',
			$this->theme_slug . '_theme_settings_section',
			array(
				'id' => 'show_sidebar',
				'type' => 'select',
				'description' => __( 'Show sidebar description', 'themeslug' ),
				'options' => array( false => '&ndash; Select &ndash;', 'on' => 'Yes', 'off' => 'No'),
			)
		);

		add_settings_field(
			'show_logo',
			__( 'Show logo', 'themeslug' ),
			array( $this, 'input'),
			$this->theme_slug . '_theme_options',
			$this->theme_slug . '_theme_settings_section',
			array(
				'id' => 'show_logo',
				'type' => 'radio',
				'description' => __( 'Show logo description', 'themeslug' ),
				'options' => array( 'on' => 'Yes', 'off' => 'No'),
			)
		);

		add_settings_field(
			'featured_cat',
			__( 'Show featured category', 'themeslug' ),
			array( $this, 'input'),
			$this->theme_slug . '_theme_options',
			$this->theme_slug . '_theme_settings_section',
			array(
				'id' => 'featured_cat',
				'type' => 'categories',
				'description' => __( 'Show featured_cat description', 'themeslug' ),
			)
		);

		add_settings_field(
			'rich_text',
			__( 'Rich text editor', 'themeslug' ),
			array( $this, 'input'),
			$this->theme_slug . '_theme_options',
			$this->theme_slug . '_theme_settings_section',
			array(
				'id' => 'rich_text',
				'type' => 'textarea',
				'description' => __( 'Rich text editor description', 'themeslug' ),
			)
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

		$html = '<h4>' . __( 'General Options', 'themeslug' ) . '</h4>';
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

		if( isset($atts) and !empty($atts)) {
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
				foreach ( $options as $key => $option ) {
					$input .= '<option ' . ( $value == $key ? 'selected="selected"' : '' ) . ' value="'. $key .'">' . $option . '</option>';
				}
				$input .= '</select>';
				break;

			case 'categories':
			case 'cats':
				$input = '<select name="' . $this->theme_slug . '_theme_options'. '[' .$id . ']" id="' .$id . '" ' . $attributes . '>';
				foreach ( get_categories( array( 'hide_empty' => false ) ) as $cat ) {
					$input .= '<option ' . ( $value == $cat->cat_ID ? 'selected="selected"' : '' ) . ' value="'. $cat->cat_ID .'">' . $cat->cat_name . '</option>';
				}
				$input .= '</select>';
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

}