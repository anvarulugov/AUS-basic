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
				
				add_menu_page(
					sprintf(__('%s theme options', 'aus-basic'),$this->theme_name), // The Title to be displayed on corresponding page for this menu
					sprintf(__('%s', 'aus-basic'),$this->theme_name), // The Text to be displayed for this actual menu item
					'administrator', // Which type of users can see this menu
					$this->theme_slug . '_theme', // The unique ID - that is, the slug - for this menu item
					array( $this, 'theme_options_display' ),
					''
				);

				add_submenu_page(
					$this->theme_slug . '_theme', // Register this submenu with the menu defined above
					sprintf( __( '%s documentaion', 'aus-basic' ), $this->theme_name ), // The text to the display in the browser when this menu item is active
					__( 'Documentation', 'aus-basic' ), // The text for this menu item
					'administrator', // Which type of users can see this menu
					$this->theme_slug . '_theme_options', // The unique ID - the slug - for this menu item
					array( $this, 'menu_page_display' ) // The function used to render the menu for this page to the screen
				);
				
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
		$html .= '<h2>' . sprintf( __( '%s theme documentation', 'aus-basic' ), $this->theme_name ) . '</h2>';
		$html .= '';
		$html .= '';
		$html .= '</div>';
		echo $html;

	}

	public function scripts() {
		if ( is_admin() ) {
			wp_enqueue_media();
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'jquery-ui-datepicker' );
			wp_enqueue_style( 'jquery-style', get_aus_uri() . '/media/css/jquery-ui.css' );
			wp_enqueue_style( 'fontawesome', get_aus_uri() . '/media/css/font-awesome.min.css' );
			wp_enqueue_style( 'aus-admin', get_aus_uri() . '/media/css/admin.css' );
			wp_enqueue_script( 'aus-admin', get_aus_uri() . '/media/js/admin.js', array( 'jquery', 'wp-color-picker', 'jquery-ui-datepicker' ) );
		}
	}

	/**
	 * #1 submenu page display
	 */

	public function theme_options_display() {
		$this->scripts();
		?>
		<div class="wrap">
		<pre>
			<?php //print_r($this->options); ?>
		</pre>
		<div class="aus-panel">
			<div class="aus-panel-sidebar">
				<div class="aus-panel-logo">
					<img src="<?php echo get_aus_uri(); ?>/media/img/logo.png">
				</div>
				<ul class="aus-panel-nav">
					<?php $i = 0; foreach ( $this->tabs as $tab ) : $i++; ?>
						<?php 
						if ( !isset(  $tab['icon'] ) || empty(  $tab['icon'] ) )
							 $tab['icon'] = 'fa-cog';
						?>
						<li><a class="<?php echo ( $i == 1 ? 'active' : '' ); ?>" href="#<?php echo $tab['id']; ?>"><i class="fa <?php echo $tab['icon']; ?>"></i> <?php echo $tab['title']; ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="aus-panel-content">
				<form method="post" action="options.php">
				<ul class="aus-panel-tabs">
					<?php submit_button(); ?>
					<?php settings_fields( $this->theme_slug . '_theme_options_group' ); ?>
					<?php $c = 0; foreach ( $this->tabs as $tab ) : $c++; ?>
						<li id="<?php echo $tab['id']; ?>" class="<?php echo ( $c == 1 ? 'active' : '' ); ?>">
							<h1><?php echo $tab['title']; ?></h1>
							<?php foreach ( $tab['sections'] as $section ) : ?>
								<div class="aus-panel-section">
								<?php do_settings_sections( $this->theme_slug . '_theme_options_' . $section['id'] ); ?>
								</div>
							<?php endforeach; ?>
						</li>
					<?php endforeach; ?>
				</ul>

				</form>
			</div>
		</div>
		</div>

		<?php 
	}

	/**
	 * Initialize theme options
	 */

	public function initialize_theme_options() {

		foreach ( $this->tabs as $tab ) {
			foreach ( $tab['sections'] as $section ) {
				add_settings_section(
					$this->theme_slug . '_theme_settings_section_' . $section['id'],
					sprintf( __( '%s settings', 'aus-basic' ), $section['title'] ),
					'', // there's no need for a callback function
					$this->theme_slug . '_theme_options_' . $section['id']
				);
				foreach ($section['fields'] as $tab_field) {
					$default = array(
						'id'			=> '',
						'type'			=> '',
						'editor'		=> '',
						'description'	=> '',
						'options'		=> '',
						'atts'			=> '',
					);
					$field = array_merge( $default, $tab_field );
					$input = new AUS_input( $this->theme_slug, $this->options );
					add_settings_field(
						$field['id'],
						'<label for="' . $field['id'] . '">' . $field['title'] . '</label>',
						array( $input, 'input'),
						$this->theme_slug . '_theme_options_' . $section['id'],
						$this->theme_slug . '_theme_settings_section_' . $section['id'],
						array(
							'id' => $field['id'],
							'type' => $field['type'],
							'editor' => $field['editor'],
							'description' => $field['description'],
							'options' => $field['options'],
							'atts' => $field['atts'],
						)
					);
				}
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
				if ( is_array( $input[ $key ] ) ) {
					foreach ( $input[ $key ] as $sub_key => $sub_value ) {
						$output[ $key ][ $sub_key ] = strip_tags( stripslashes( $sub_value ) );
					}
				} else {
					$output[ $key ] = strip_tags( stripslashes( $input[ $key ] ) );
				}
			}
		}

		return apply_filters( array( $this, 'senitize' ), $output, $input);

	}

	/**
	 * Initialize theme options callbacks
	 */
	public function theme_general_options_ballback() {

		$html = '<h4>' . __( 'General Options', 'aus-basic' ) . '</h4>';
		//echo $html;

	}

}