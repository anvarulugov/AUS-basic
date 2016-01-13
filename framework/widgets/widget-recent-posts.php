<?php 

class AUS_Recent_Posts extends WP_Widget {

	private $defaults;

	function __construct() {
		$widget_ops = array(
			'classname' => 'recent-posts', 
			'description' => __( 'Your site\'s most recent Posts. Integrated to Bootstrap', 'aus-basic' ) );
		
		parent::__construct(
			'aus-recent-posts', 
			__( 'Recent Posts', 'aus-basic' ), 
			$widget_ops
		);
		$this->defaults = array(
			'title' => '',
			'number' => 5,
			'category' => '',
			'show_date' => '',
		);
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->defaults );
		$categories = get_categories();
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">
				<?php echo __( 'Title', 'aus-basic' ); ?>: 
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
			</label>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'category' ); ?>">
				<?php echo __( 'Category', 'aus-basic' ); ?>: 
				<select class="widefat" id="<?php echo $this->get_field_id( 'category' ); ?>" name="<?php echo $this->get_field_name( 'category' ); ?>">
					<option><?php _e( 'Any Category', 'aus-basic' ); ?></option>
					<?php foreach ( $categories as $cat ) : ?>
						<option <?php selected( $instance['category'], $cat->term_id ); ?> value="<?php echo $cat->term_id; ?>"><?php echo $cat->name; ?></option>
					<?php endforeach; ?>
				</select>
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>">
				<?php echo __( 'Number of posts to show', 'aus-basic' ); ?>
			</label>
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo esc_attr( $instance['number'] ); ?>" size="3">
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( esc_attr( $instance['show_date'] ), 'on' ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>">
			<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?', 'aus-basic' ); ?></label>
		</p>
		<?php 
	}

	function update( $new_instance, $old_instance ) {
		$old_instance = wp_parse_args( (array) $old_instance, $this->defaults );
		foreach ($old_instance as $key => $val) {
			$old_instance[ $key ] = esc_attr( $new_instance[ $key ] );
		}
		$instance = $old_instance;
		return $instance;
	}

	function widget( $args, $instance ) {

		extract( $args, EXTR_SKIP );
		$title = empty( $instance['title'] ) ? '' : apply_filters( 'widget_title', $instance['title'] );
		$html  = $before_widget;
		if ( $title ) {
			$html .= $before_title . $title . $after_title;
		}
		$posts = query_posts( array( 'posts_per_page' => $instance['number'], 'cat' => $instance['category'] ) );
		$html .= '<div class="aus-recent-posts list-group">';
		foreach ( $posts as $post ) {
			$html .= '<a href="' . get_permalink( $post->ID ) . '" class="list-group-item recentcomments">' . get_the_title( $post->ID );
			if ( $instance['show_date'] == 'on' ) {
				$html .= '<span class="post-date label label-primary pull-right"><i class="fa fa-calendar"></i> ' . get_the_date( get_option( 'date_format' ), $post->ID ) . '</span>';
			}
			$html .= '<div class="clearfix"></div>';
			$html .= '</a>';
		}
		$html .= '</div>';

		$html .= $after_widget;
		echo $html;
		wp_reset_query();
	}

}