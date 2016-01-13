<?php 

class AUS_Widget_Categories extends WP_Widget {

	private $defaults;

	function __construct() {
		$widget_ops = array(
			'classname' => 'categories', 
			'description' => __( 'A list or dropdown of categories. Integrated to Bootstrap', 'aus-basic' ) );
		
		parent::__construct(
			'aus-categories', 
			__( 'Categories', 'aus-basic' ), 
			$widget_ops
		);
		$this->defaults = array(
			'title' => '',
			'dropdown' => false,
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
			<input class="checkbox" id="<?php echo $this->get_field_id( 'dropdown' ); ?>" name="<?php echo $this->get_field_name( 'dropdown' ); ?>" type="checkbox" <?php checked( esc_attr( $instance['dropdown'] ), 'on' ); ?> />
			<label for="<?php echo $this->get_field_id( 'dropdown' ); ?>">
				<?php echo __( 'Display as dropdown', 'aus-basic' ); ?>
			</label>
		<br />
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
		if ( $title ) {
			$html .= $before_title.$title.$after_title;
		}
		$categories_obj = get_categories();
		if ( $instance['hierarchical'] ) {
			$cats = $this->buildTree($categories_obj);
		} else {
			$cats = $categories_obj;
		}
		if ( $instance['dropdown'] ) {
			$html .= '<select name="' . $args['widget_id'] . '" id="cat" class="form-control aus-categories">';
				$html .= '<option value="-1">' . __( 'Select Category', 'aus-basic' ) . '</option>';
				foreach ($cats as $cat) {
					$html .= '<option ' . ( is_category( $cat->term_id ) ? 'selected="selected"' : '' ) . ' class="level-0" value="' . esc_url( get_category_link( $cat->term_id ) ) . '">' . esc_attr( $cat->name ) . ( $instance['count'] ? ' (' . esc_attr( $cat->count ) . ')' : '' ) . '</option>';
					if ( $cat->children ) {
						$html .= $this->show_childs_indent( $cat->children, $instance );
					}
				}
			$html .= '</select>';
		} else {
			$html .= '<nav class="aus-categories" role="navigation">';
			foreach ( $cats as $cat ) {
				$html .= '<a class="list-group-item cat-item cat-item-' . $cat->term_id . ' ' . ( is_category( $cat->term_id ) ? 'active' : '' ) . '" href="' . esc_url( get_category_link( $cat->term_id ) ) . '">' . esc_attr( $cat->name );
				if ( $instance['count'] ) {
					$html .= '<span class="badge pull-right">' . esc_attr( $cat->count ) . '</span>';
				}
				$html .= '</a>';
				if ( $cat->children ) {
					$html .= $this->show_childs( $cat->children, $instance );
				}
			}
			$html .= '</nav>';
		}
		$html .= $after_widget;
		echo $html;
		add_action( 'wp_footer', function() {
			echo "
			<script>
				jQuery(function(){
				  // bind change event to select
				  jQuery( '.aus-categories' ).on( 'change', function () {
					  var cat = jQuery(this).val(); // get selected value
					  if ( cat ) { // require a URL
						  window.location = cat; // redirect
					  }
					  return false;
				  });
				});
			</script>
			";
		});
	}

	function show_childs( $cats, $instance ) {
		$html  = '<ul class="children">';
		foreach ( $cats as $cat ) {
			$html .= '<a class="list-group-item cat-item cat-item-' . $cat->term_id . ' ' . ( is_category( $cat->term_id ) ? 'active' : '' ) . '" href="' . esc_url( get_category_link( $cat->term_id ) ) . '">' . esc_attr( $cat->name );
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

	function show_childs_indent( $cats, $instance, $level = 1 ) {
		$indent = '';
		for ($i=0; $i < $level; $i++) { 
			$indent .= '&nbsp;&nbsp;';
		}
		$html = '';
		foreach ($cats as $cat) {
			$html .= '<option ' . ( is_category( $cat->term_id ) ? 'selected="selected"' : '' ) . ' class="level-' . $level . '" value="' . esc_url( get_category_link( $cat->term_id ) ) . '">' . $indent . esc_attr( $cat->name ) . ( $instance['count'] ? ' (' . esc_attr( $cat->count ) . ')' : '' ) . '</option>';
			if ( $cat->children ) {
				$html .= $this->show_childs_indent( $cat->children, $instance, $level+1 );
			}
		}
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