<?php 

class AUS_Widget_Categories extends WP_Widget {

	private $defaults;

	function __construct() {
		$widget_ops = array(
			'classname' => 'categories', 
			'description' => __( 'Displays categories list', 'aus-basic' ) );
		
		parent::__construct(
			'aus-categories', 
			__( 'Categories', 'aus-basic' ), 
			$widget_ops
		);
		$this->defaults = array(
			'title' => '',
			'count' => false,
			'hierarchical' => false,
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
			<input class="checkbox" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="checkbox" <?php checked( esc_attr( $instance['count'] ), 'on' ); ?> />
			<label for="<?php echo $this->get_field_id( 'count' ); ?>">
				<?php echo __( 'Show post counts', 'aus-basic' ); ?>
			</label>
		<br />
			<input class="checkbox" id="<?php echo $this->get_field_id( 'hierarchical' ); ?>" name="<?php echo $this->get_field_name( 'hierarchical' ); ?>" type="checkbox" <?php checked( esc_attr( $instance['hierarchical'] ), 'on' ); ?> />
			<label for="<?php echo $this->get_field_id( 'hierarchical' ); ?>">
				<?php echo __( 'Show hierarchy', 'aus-basic' ); ?>
			</label>

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
		$html .= $before_title.$title.$after_title;
		$categories_obj = get_categories();
		$cats = $this->buildTree($categories_obj);
		$html .= '<nav>';
		foreach ( $cats as $cat ) {
			$html .= '<a class="list-group-item cat-item cat-item-' . $cat->term_id . '" href="' . esc_url( get_category_link( $cat->term_id ) ) . '">' . esc_attr( $cat->name );
			if ( $instance['count'] ) {
				$html .= '<span class="badge pull-right">' . esc_attr( $cat->count ) . '</span>';
			}
			$html .= '</a>';
			if ( $cat->children ) {
				$html .= $this->show_childs( $cat->children, $instance );
			}
		}
		$html .= '</nav>';
		$html .= $after_widget;
		echo $html;
	}

	function show_childs( $cats, $instance ) {
		$html  = '<ul class="children">';
		foreach ( $cats as $cat ) {
			$html .= '<a class="list-group-item cat-item cat-item-' . $cat->term_id . '" href="' . esc_url( get_category_link( $cat->term_id ) ) . '">' . esc_attr( $cat->name );
			if ( $instance['count'] ) {
				$html .= '<span class="badge pull-right">' . esc_attr( $cat->count ) . '</span>';
			}
			$html .= '</a>';
			if ( $cat->children ) {
				$html .= $this->show_childs( $cat->children, $instance );
			}
		}
		$html .= '</ul>';
		return $html;
	}

	function buildTree(array $elements, $parent = 0) {
		$branch = array();

		foreach ($elements as $key => $element) {
			if ($element->parent == $parent) {
				$children = $this->buildTree($elements, $element->term_id);
				if ($children) {
					$element->children = $children;
				}
				array_push($branch, $element);
			}
		}

		return $branch;
	}

}