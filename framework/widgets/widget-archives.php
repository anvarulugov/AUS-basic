<?php 

class AUS_Widget_Archives extends WP_Widget {

	private $defaults;

	function __construct() {
		$widget_ops = array(
			'classname' => 'archives', 
			'description' => __( 'A monthly archive of your site\'s Posts. Integrated to Bootstrap', 'aus-basic' ) );
		
		parent::__construct(
			'aus-archives', 
			__( 'Archives', 'aus-basic' ), 
			$widget_ops
		);
		$this->defaults = array(
			'title' => '',
			'dropdown' => false,
			'count' => false,
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
		$archives = $this->archives( $instance );

		if ( $instance['dropdown'] ) {
			$html .= '<select id="' . $args['widget_id'] . '" name="archive" class="form-control aus-archives">';
				$html .= '<option value="-1">' . __( 'Select Month', 'aus-basic' ) . '</option>';
				foreach ( $archives as $archive ) {
					$html .= '<option value="' . $archive['link'] . '">' . esc_attr( $archive['text'] ) . ( $instance['count'] ? '&nbsp;(' . esc_attr( $archive['count'] ) . ')' : '' ) . '</option>';
				}
			$html .= '</select>';
		} else {
			$html .= '<nav class="aus-archives" role="navigation">';
			foreach ( $archives as $archive ) {
				$html .= '<a class="list-group-item archive-item" href="' . esc_url( $archive['link'] ) . '">' . esc_attr( $archive['text'] );
				if ( $instance['count'] ) {
					$html .= '<span class="badge pull-right">' . esc_attr( $archive['count'] ) . '</span>';
				}
				$html .= '</a>';
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
				  jQuery('.aus-archives').on('change', function () {
					  var url = jQuery(this).val(); // get selected value
					  if (url) { // require a URL
						  window.location = url; // redirect
					  }
					  return false;
				  });
				});
			</script>
			";
		});
	}

	function archives( $instance ) {
		$args = array( 'echo' => 0 );
		if ( $instance['count'] ) {
			$args['show_post_count'] = 1;
		}
		$archi = wp_get_archives( $args );
		$archi = explode( '</li>' , $archi );
		$links = array();
		$i = 0;
		foreach( $archi as $link ) {
			$link = str_replace( array( '<li>' , "\n" , "\t" , "\s" ), '' , $link );
			if ( $instance['count'] ) {
				$count = preg_replace('/(<a.*?>.*<\/a>)/', '', $link);
				$count = str_replace('&nbsp;', '', $count);
			}
			if( '' != $link ) {
				preg_match('~<a .*?href=[\'"]+(.*?)[\'"]+.*?>(.*?)</a>~ims', $link, $result);
				$links[ $i ]['link'] = $result[1];
				$links[ $i ]['text'] = $result[2];
				if ( $instance['count'] && $count ) {
					$links[ $i ]['count'] = str_replace( array( '(', ')' ), '', $count );; 
				}
				$i++;
			} else {
				continue;
			}
		}
		return $links;
	}

}