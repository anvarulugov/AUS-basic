<?php 

class AUS_Widget_Nav_Menu extends WP_Widget {

	private $defaults;

	function __construct() {
		$widget_ops = array(
			'classname' => 'nav_menu', 
			'description' => __( 'Add a custom menu to your sidebar. Integrated to Bootstrap', 'aus-basic' ) );
		
		parent::__construct(
			'aus-menu', 
			__( 'Custom Menu', 'aus-basic' ), 
			$widget_ops
		);
		$this->defaults = array(
			'title' => '',
			'menu' => false,
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
			<label for="<?php echo $this->get_field_id( 'menu' ); ?>"><?php echo __( 'Select Menu', 'aus-basic' ); ?>:</label>
			<select id="<?php echo $this->get_field_id( 'menu' ); ?>" name="<?php echo $this->get_field_name( 'menu' ); ?>">
				<option value="0"><?php echo __( '&ndash; Select &ndash;', 'aus-basic' ); ?></option>
				<?php foreach ( wp_get_nav_menus() as $menu ) { ?>
					<option value="<?php echo esc_attr( $menu->term_id ); ?>" <?php selected( $instance['menu'], $menu->term_id ); ?>><?php echo esc_html( $menu->name ); ?></option>
				<?php } ?>
			</select>
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
		$pages = wp_get_nav_menu_items( $instance['menu'] );
		$pages = $this->buildTree( $pages );
		$html .= '<nav class="aus-nav-menu" role="navigation">';
		foreach ( $pages as $page ) {
			$is_child_active = $this->is_child_active( $page );
			if ( in_array( true, $is_child_active ) ) {
				$expanded = 'true';
			} else {
				$expanded = 'false';
			}
			$html .= '<a ' . ( $page->children ? 'data-toggle="collapse" aria-expanded="' . $expanded . '" aria-controls="collapse-' . $page->ID . '" href="#collapse-' . $page->ID . '"' : 'href="' . esc_url( $page->url ) . '"' ) . ' title="' . esc_attr( $page->attr_title ) . '" id="menu-item-' . esc_attr( $page->ID ) . '" class="' . ( $page->children ? 'has-collapse ' : '' ) . 'list-group-item menu-item menu-item-type-' . esc_attr( $page->type ) . ' menu-item-object-' . $page->object . ' menu-item-' . esc_attr( $page->ID ) . ' ' . implode( ' ', $page->classes ) . ( aus_is_active_menu( $page->object, $page->object_id ) ? ' active' : '' ) . '" target="' . esc_attr( $page->target ) . '" rel="' . esc_attr( $page->xfn ) . '">' . esc_attr( $page->title );
			$html .= '</a>';
			if ( $page->children ) {
				$html .= $this->show_children( $page->children, $page->ID, 1, $expanded );
			}
		}
		$html .= '</nav>';
		$html .= $after_widget;
		echo $html;
	}

	function show_children( $pages, $parent_id = '', $level = 1, $parent_expanded ) {
		$indent = '';
		for ( $i=0; $i < $level; $i++ ) {
			$indent .= '&nbsp;&nbsp;';
		}
		$html  = '<div class="sub-menu collapse' . ( $parent_expanded == 'true' ? ' in' : '' ) . '" id="collapse-' . $parent_id . '">';
		foreach ( $pages as $page ) {
			$is_child_active = $this->is_child_active( $page );
			if ( in_array( true, $is_child_active ) ) {
				$expanded = 'true';
			} else {
				$expanded = 'false';
			}
			$html .= '<a ' . ( $page->children ? 'data-toggle="collapse" aria-expanded="' . $expanded . '" aria-controls="collapse-' . $page->ID . '" href="#collapse-' . $page->ID . '"' : 'href="' . esc_url( $page->url ) . '"' ) . ' title="' . esc_attr( $page->attr_title ) . '" id="menu-item-' . esc_attr( $page->ID ) . '" class="' . ( $page->children ? 'has-collapse ' : '' ) . 'list-group-item menu-item menu-item-type-' . esc_attr( $page->type ) . ' menu-item-object-' . $page->object . ' menu-item-' . esc_attr( $page->ID ) . ' ' . implode( ' ', $page->classes ) . ( aus_is_active_menu( $page->object, $page->object_id ) ? ' active' : '' ) . '" target="' . esc_attr( $page->target ) . '" rel="' . esc_attr( $page->xfn ) . '">' . $indent . esc_attr( $page->title );
			$html .= '</a>';
			if ( $page->children ) {
				$html .= $this->show_children( $page->children, $page->ID, $level+1, $expanded );
			}
		}
		$html .= '</div>';
		return $html;
	}

	function is_child_active( $page, $actives = array() ) {
		if ( $page->children ) {
			foreach ( $page->children as $child ) {
				if ( aus_is_active_menu( $child->object, $child->object_id ) ) {
					$actives[]  = true;
				} else {
					$actives = $this->is_child_active( $child, $actives );
				}
			}
		} else {
			$actives[] = false;
		}
		return $actives;
	}

	function buildTree( array $elements, $parent = 0 ) {
		$branch = array();

		foreach ( $elements as $key => $element ) {
			if ( $element->menu_item_parent == $parent ) {
				$children = $this->buildTree( $elements, $element->ID );
				if ( $children ) {
					$element->children = $children;
				}
				array_push( $branch, $element );
			}
		}

		return $branch;
	}

}