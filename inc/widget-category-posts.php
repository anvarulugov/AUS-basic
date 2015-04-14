<?php 
/*
Plugin Name: AUS Category Posts
Plugin URI: http://wp.ulugov.uz/
Description: Displays posts from single selected category
Author: Anvar Ulugov
Version: 0.0.1
Author URI: http://ulugov.uz/
*/


class UbCategoryPostsWidget extends WP_Widget {

	function UbCategoryPostsWidget() {

		$widget_ops = array('classname' => 'UbCategoryPostsWidget', 'description' => 'Displays posts from single selected category' );
		$this->WP_Widget('UbCategoryPostsWidget', 'UB Category Posts', $widget_ops);

	}
	function form($instance) {

		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category'=>'','limit'=>5 ) );
		$title = $instance['title'];
		$category = $instance['category'];
		$limit = $instance['limit'];
		$categories = get_categories();

	?>
	<p>
		<label for="<?php echo $this->get_field_id('title'); ?>">
			Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</label>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('text'); ?>">
			Category:
			<select id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>">
				<?php foreach ($categories as $cat) : ?>
					<option <?php echo ($cat->term_id == esc_attr($category)) ? 'selected="selected"' : ''; ?> value="<?php echo $cat->term_id; ?>"><?php echo $cat->name; ?></option>
				<?php endforeach; ?>
			</select>
		</label>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('limit'); ?>">
			Posts limit: <input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo esc_attr($limit); ?>" />
		</label>
	</p>
	<?php
	}
	 
	function update($new_instance, $old_instance) {
		
		$old_instance['title'] = $new_instance['title'];
		$old_instance['category'] = $new_instance['category'];
		$old_instance['limit'] = $new_instance['limit'];
		$instance = $old_instance;
		return $instance;

	}
	 
	function widget($args, $instance) {
		
		extract($args, EXTR_SKIP);

		echo $before_widget;
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$cat_id = empty($instance['category']) ? '' : $instance['category'];
		$limit = empty($instance['limit']) ? '' : $instance['limit'];

		echo '<div class="news-widget">';
		if (!empty($title))
			echo $before_title . $title . $after_title;;
	 
		$posts = query_posts(array('posts_per_page'=>$limit,'cat'=>$cat_id));

		foreach ($posts as $post) {
			echo '<p><a href="'.$post->guid.'">'.date('d-m-Y H:i',strtotime($post->post_date)).' '.$post->post_title.'</a></p>';
		}
	 	echo '</div>';
	 	wp_reset_query();
		echo $after_widget;
	}
	
}
add_action( 'widgets_init', create_function('', 'return register_widget("UbCategoryPostsWidget");') );?>