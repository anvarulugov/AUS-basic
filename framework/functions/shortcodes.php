<?php 

class AUS_Shortcodes {

	public function __construct() {

		$this->load_shortcodes();

	}

	public function load_shortcodes() {

		/* Load the news box. */
		require_once( trailingslashit( AUS_SHORTCODES ) . 'class-news-box.php' );

	}

}
new AUS_Shortcodes();