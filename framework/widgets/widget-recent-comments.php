<?php 

class AUS_Recent_Comments extends WP_Widget {

	private $defaults;

	function __construct() {
		$widget_ops = array(
			'classname' => 'recent-comments', 
			'description' => __( 'Your site\'s most recent comments. Integrated to Bootstrap', 'aus-basic' ) );
		
		parent::__construct(
			'aus-recent-comments', 
			__( 'Recent Comments', 'aus-basic' ), 
			$widget_ops
		);
		$this->defaults = array(
			'title' => '',
			'number' => 5,
		);
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->defaults );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">
				<?php echo __( 'Title', 'aus-basic' ); ?>: 
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>">
				<?php echo __( 'Number of comments to show', 'aus-basic' ); ?>
			</label>
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo esc_attr( $instance['number'] ); ?>" size="3">
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
		$comments = get_comments( $instance );
		$html .= '<div class="aus-recent-comments list-group">';
		foreach ( $comments as $comment ) {
			$title = get_the_title( $comment->comment_post_ID );
			$html .= '<a href="' . get_comment_link( $comment ) . '" class="list-group-item recentcomments">' . $title;
			$html .= '<span class="comment-author-link label label-primary pull-right"><i class="fa fa-user"></i> ' . $comment->comment_author . '</span>';
			$html .= '<div class="clearfix"></div>';
			$html .= '</a>';
		}
		$html .= '</div>';

		$html .= $after_widget;
		echo $html;
	}

}