<?php 

/**
 * AUS Basic Inputs
 *
 * Theme Options page metabox generator class
 * Uses Wordpress default form html markup
 *
 * @package WordPress
 * @subpackage AUS Bsic Options
 * @since AUS Bsic 0.1.1
 * @author Anvar Ulugov
 * @license GPL2
 */

class AUS_metabox {

	private $metaboxes;

	public function __construct($metaboxes) {
		$this->metaboxes = $metaboxes;
		add_action( 'add_meta_boxes', array( $this, 'reg_metabox' ) );
		add_action( 'save_post', array( $this, 'save_metabox' ) );
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
	 */
	public function render_metaboxes( $post ) {

		wp_nonce_field( 'aus_metabox_nonce', 'aus_metabox' );
		$input = new AUS_input();
		echo '<table class="form-table">';
		echo '<tbody>';
		if ( isset( $this->metaboxes[$post->post_type]['fields'] ) && ! empty( $this->metaboxes[$post->post_type]['fields'] ) ) {
			foreach ($this->metaboxes[$post->post_type]['fields'] as $field) {
				echo '<tr>';
				echo '<th scope="row">';
				echo '<label for="' . $field['id'] . '">' . $field['title'] . '</label>';
				echo '</th>';
				echo '<td>';
				$input->input( $field, 'metabox', $post->ID );
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

}