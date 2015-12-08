<?php
/**
 * Table of contents
 * Init
 * Settings
 * Site
 * - logo
 * - site_name
 * Navigation
 * Navbar
 * Archive
 * - pager
 * Page
 * - page_title
 * Post:
 * - title
 * - date
 * - author
 * - categories
 * - tags 
 * - comments
 * - thumbnail 
 * - excerpt 
 * - content 
 * - readmore 
 * - link_pages
 * Comments
 * - comment_form_fields
 * - comment_form_textarea
 * - comment_button
 * - comment_template
 * Utilites
 * - limit
 */
class AUS_theme_elements {

	private $theme_name;
	private $theme_slug;
	private $options;

	/**
	 * @param $theme_name
	 * @param $theme_slug
	 * @param $menutype
	 */
	function __construct( $config ) {

		$this->theme_name = $config['theme_name'];
		$this->theme_slug = $config['theme_slug'];

		$this->init();

	}

	/**
	 * Initialize basics
	 */
	private function init() {
		global $themeslug_options;
		$this->options = get_option( $this->theme_slug . '_theme_options', $themeslug_options );

		add_filter( 'comment_form_default_fields', array( $this, 'comment_form_fields' ) );
		add_filter( 'comment_form_defaults', array( $this, 'comment_form_textarea' ) );
		//add_action( 'comment_form', array( $this, 'comment_button' ) );

	}

	/**
	 * @param $key
	 * @return mixed
	 */
	private function settings( $key ) {
		global $aus_options, $aus_config;
		if ( 'customizer' == $aus_config['options_type'] ) {
			return get_theme_mod( $key );
		} else {
			if ( isset( $this->options[ $key ] ) ) {
				return $this->options[ $key ];
			}
		}
		return false;
	}

	/**
	 * Displays site logo
	 * @return html;
	 */
	public function logo( $args = array() ) {

		$image = '';
		$before = '';
		$after = '';
		$link_class = '';
		$img_class = '';
		extract( $args, EXTR_OVERWRITE );

		if ( $this->settings( 'logo_img' ) ) {
			$html = '<a class="logo_link ' . $link_class . '" href="' . home_url() . '"><img class="logo_img ' . $img_class . '" src="' . $this->settings( 'logo_img' ) . '" /></a>';
		} elseif ( ! empty( $image ) ) {
			$html = '<a class="logo_link ' . $link_class . '" href="' . home_url() . '"><img class="logo_img ' . $img_class . '" src="' . $image . '" /></a>';
		} else {
			$html = '<a class="logo_link logo_text' . $link_class . '" href="' . home_url() . '">' . get_bloginfo( 'name' ) . '</a>';
		}

		echo $before.$html.$after;
	}

	/**
	 * Displays Website Name
	 * @return string
	 */
	public function site_name() {
		echo get_bloginfo( 'site_name' );
	}

	public function site_description() {
		if ( $this->settings( 'site_description' ) ) {
			echo get_bloginfo( 'description' );
		}
	}

	/**
	 * @param $nav_location
	 * @param array $args
	 */
	public function navigation( $nav_location = 'primary', $args = array() ) {

		$container = 'nav';
		$container_class = get_container_class();
		$menu_class = 'navbar-default';

		extract( $args, EXTR_OVERWRITE );

		if ( $container != 'div' ) {
			$container = 'nav';
		}

		$pages = $this->get_pages( $nav_location );

		if ( $pages ):

			$html = '<' . $container . ' ' . $container_class . '>';
			$html .= '<ul class="' . $menu_class . '">';
			foreach ( $pages as $page ) {
				if( ( ($page['object'] == 'page') && (is_page($page['object_id'])) ) || ( ($page['object'] == 'category') && (is_category($page['object_id'])) ) ) {
					$active = 'class="active"';
				} else {
					$active = '';
				}
				$html .= '<li ' . $active . '><a title="' . $page['attr_title'] . '" class="' . $page['classes'] . '" target="' . $page['target'] . '" href="' . $page['url'] . '">' . $page['title'] . '</a></li>';
			}
			$html .= '</ul>';
			$html .= '</' . $container . '>';
			echo $html;
		endif;

	}

	/**
	 * @param $nav_location
	 * @param array $args
	 * @return mixed
	 */
	public function navbar( $nav_location = 'primary', $args = array() ) {

		$container_class = get_container_class();
		$navbar_class = 'navbar-default';
		$nav_class = '';
		$brand_class = '';
		$item_class = '';
		$html = '';
		extract( $args, EXTR_OVERWRITE );
		$pages = $this->get_pages( $nav_location );
		if ( $pages ):
			$html .= '<nav class="navbar ' . $navbar_class . ( $nav_location != 'primary' ? ' not-primary' : ' primary' ) . '" role="navigation">';
			$html .= '<div ' . $container_class . '>';
			$html .= '<!-- Brand and toggle get grouped for better mobile display -->';
			$html .= '<div class="navbar-header">';
			if ( $nav_location == 'primary' && $this->settings( 'show_home_menu' ) == 'on' ) {
				if ( ! $this->settings( 'home_menu_text' ) ) {
					$html .= '<a data-target="#page-top" class="navbar-brand ' . $brand_class . '" href="' . home_url() . '"><i class="fa fa-home"></i></a>';
				}
			}
			if ( ( $nav_location == 'primary' && $this->settings( 'show_home_menu' ) == 'off' ) ||  $nav_location != 'primary' ) {
				$html .= '<li class="visible-xs navbar-brand">' . __( 'Navigation', 'aus-basic' ) . '</li>';
			}
			
			$html .= '<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-' . $nav_location . '">';
			$html .= '<span class="sr-only">Toggle navigation</span>';
			$html .= '<span class="icon-bar"></span>';
			$html .= '<span class="icon-bar"></span>';
			$html .= '<span class="icon-bar"></span>';
			$html .= '</button>';
			$html .= '</div>';
			$html .= '<!-- Collect the nav links, forms, and other content for toggling -->';
			$html .= '<div class="collapse navbar-collapse" id="navbar-collapse-' . $nav_location . '">';
			$html .= '<ul class="nav navbar-nav ' . $nav_class . '">';
			if ( $nav_location == 'primary' && $this->settings( 'show_home_menu' ) == 'on' ) {
				if ( $this->settings( 'home_menu_text' ) ) {
					$html .= '<li><a data-target="#page-top" class="page home-menu" href="' . home_url() . '">' . $this->settings( 'home_menu_text' ) . '</a></li>';
				}
			}
			foreach ( $pages as $page ) {
				if( ( ($page['object'] == 'page') && (is_page($page['object_id'])) ) || ( ($page['object'] == 'category') && (is_category($page['object_id'])) ) ) {
					$active = 'class="active"';
				} else {
					$active = '';
				}
				$page['classes'] .= ' '.$page['object'];
				$page['classes'] .= ' '.$item_class;
				if ( empty( $page['childs'] ) ):
					$html .= '<li ' . $active . '><a data-target="#page-' . $page['id'] . '" title="' . $page['attr_title'] . '" class="' . $page['classes'] . '" target="' . $page['target'] . '" href="' . $page['url'] . '">' . $page['title'] . '</a></li>';
				elseif ( !empty( $page['childs'] ) ):
					$html .= '<li class="dropdown"><a href="' . $page['url'] . '" class="' . $page['classes'] . ' dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">' . $page['title'] . '&nbsp;<span class="caret"></span></a>';
					$html .= '<ul class="dropdown-menu" role="menu">';
					foreach ( $page['childs'] as $child ) {
						$child['classes'] .= ' '.$child['object'];
						$child['classes'] .= ' '.$item_class;
						$html .= '<li><a data-target="#page-' . $page['id'] . '" class="' . $child['classes'] . '" href="' . $child['url'] . '">' . $child['title'] . '</a></li>';
					}
					$html .= '</ul></li>';
				endif;
			}
			$html .= '</ul>';
			$html .= '</div><!-- /.navbar-collapse -->';
			$html .= '</div><!-- /.container -->';
			$html .= '</nav>';

			echo $html;
		endif;
	}

	/**
	 * @param $nav_location
	 * @return mixed
	 */
	public function get_pages( $nav_location = 'primary' ) {
		$theme_locations = get_nav_menu_locations();
		if ( isset( $theme_locations[ $nav_location ] ) ) {
			$menu_obj = get_term( $theme_locations[ $nav_location ], 'nav_menu' );
			if ( isset( $menu_obj->name ) && ! empty( $menu_obj->name ) ) {
				$items = wp_get_nav_menu_items( $menu_obj->name );
			} else {
				$items = false;
			}
		} else {
			$items = false;
		}
		

		if ( $items ):
			foreach ( $items as $item ) {
				if ( $item->menu_item_parent == 0 ) {
					$pages[] = array( 
						'id' => $item->ID,
						'title' => $item->title,
						'object' => $item->object,
						'object_id' => $item->object_id,
						'url' => $item->url,
						'childs' => $this->get_page_childs( $item->ID, $items ),
						'classes' => implode( ' ', $item->classes ),
						'target' => $item->target,
						'attr_title' => $item->attr_title,
						'description' => $item->description,
					 );
				}
			}
			return $pages;
		else:
			return false;
		endif;
	}

	/**
	 * @param $parent
	 * @param $childs
	 * @return mixed
	 */
	private function get_page_childs( $parent, $childs ) {
		$children = array();
		foreach ( $childs as $child ) {
			if ( $child->menu_item_parent == $parent ) {
				$children[] = array( 
					'id' => $child->ID, 
					'title' => $child->title, 
					'object' => $child->object,
					'object_id' => $child->object_id,
					'url' => $child->url, 
					'classes' => implode( ' ', $child->classes ),
					'target' => $child->target,
					'attr_title' => $child->attr_title,
					'description' => $child->description,
					'childs' => $this->get_page_childs( $child->ID, $childs )
				 );
			}

		}
		return $children;
	}

	/**
	 * @param $query
	 */
	public function pager() {
		global $wp_query, $wp_rewrite;
		$wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
		$pagination = array(
			'base' => @add_query_arg('paged','%#%'),
			'format' => '',
			'prev_text' => __( '&laquo;', 'aus-basic' ),
			'next_text' => __( '&raquo;', 'aus-basic' ),
			'mid_size' => 3,
			'total' => $wp_query->max_num_pages,
			'current' => $current,
			//'show_all' => true,
			'type' => 'array'
		);
	   // if ( $wp_rewrite->using_permalinks() ) $pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );
		//if ( !empty($wp_query->query_vars['s']) ) $pagination['add_args'] = array( 's' => get_query_var( 's' ) );
		$pages = paginate_links( $pagination );
		$pager  = '<ul class="pagination">';
		if(isset($pages) and !empty($pages)) {
			foreach ($pages as $page) {
				$current = strpos( $page, 'current' );
				$pager .= '<li' . ( $current ? ' class="active"' : '' ) . '>'.$page.'</li>';
			}
		}
		$pager .= '</ul>';
		echo $pager;
	}

	public function pager_old( $query = null ) {

		global $wp_query;
		if ( $query == null ) {
			$query = $wp_query;
		}

		$big = 999999999; // need an unlikely integer
		$pages = paginate_links( array( 
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?paged=%#%',
			'prev_text' => __( '&laquo;', 'aus-basic' ),
			'next_text' => __( '&raquo;', 'aus-basic' ),
			'mid_size' => 5,
			'type' => 'array',
			'current' => max( 1, get_query_var( 'paged' ) ),
			'total' => $query->max_num_pages,
		) );
		$pager = '<ul class="pagination">';
		if ( isset( $pages ) and !empty( $pages ) ) {
			foreach ( $pages as $page ) {
				$current = strpos( $page, 'current' );
				$pager .= '<li ' . ( $current ? 'class="active"' : '' ) . '>' . $page . '</li>';
			}
		}
		$pager .= '</ul>';
		echo $pager;
	}

	public function page_title() {

		$title = '';
		
		if ( is_home() ) {
			$title = $this->site_name();
		} elseif ( is_category() || is_tax() || is_tag() ) {
			$title = single_cat_title( '', false );
		} elseif ( is_single() ) {
			$title = $this->title();
		}

		echo $title;

	}

	/**
	 * Displays the post/page title
	 * @param  array
	 * @return html
	 */
	public function title( $args = array() ) {

		global $post;
		extract( $args, EXTR_OVERWRITE );

		$title = get_the_title();
		if ( isset( $limit ) && is_numeric( $limit ) )
			$title = $this->limit( $title, $limit, true );

		echo $title;
	}

	/**
	 * Displays post/page date
	 * @param  array  $args [description]
	 * @return [type]       [description]
	 */
	public function date( $args = array() ) {

		global $post;
		extract( $args, EXTR_OVERWRITE );
		$date = date_i18n( get_option( 'date_format' ), strtotime( get_the_date( 'Y-m-d' ) ) );
		return $date;
	}

	public function author() {

	}

	public function views() {
		global $post;
		$views = get_post_meta( $post->ID, 'aus_hits', true );
		if( ! empty( $views )) {
			echo $views;
		} else {
			echo 0;
		}
	}

	/**
	 * Displays post categories
	 * @param  [type] $post_id [description]
	 * @param  array  $args    [description]
	 * @return [type]          [description]
	 */
	public function categories( $post_id=null, $args = array() ) {
		global $post;
		if ( $post_id === null ) {
			$post_id = $post->ID;
		}
		$before = '';
		$after = '';
		$link = true;
		$target = '_self';
		$class = '';
		$title = '';
		$taxonomy = 'category';
		extract( $args, EXTR_OVERWRITE );

		$post_categories = get_the_terms( $post_id, $taxonomy );
		$cats = array();

		if ( ! empty( $post_categories ) && ! is_page() ) {
			$i = 1;
			$cats_count = count( $post_categories );
			foreach ( $post_categories as $cat ) {

				if ( $cat->term_id != $this->settings( 'featured_cat' ) ) {
					if ( $link ) {
						$html = '<a class="' . $class . '" target="' . $target . '" title="' . $title . '" href="' . get_category_link( $cat->term_id ) . '">';
					}
					$html .= $cat->name;
					if ( $link ) {
						$html .= '</a>';
					}
				}
				if ( $cats_count > 1 && $i < $cats_count ) {
					$html .= ', ';
				}
				echo $before . $html . $after;
				$i++;

			}
		} else {
			return false;
		}
	}

	/**
	 * @param array $args
	 * @param $default
	 */
	public function tags( $args = array(), $default = true ) {

		global $post;
		$class = 'entry-tags';
		$icon = '<i class="fa fa-tags"></i>';
		extract( $args, EXTR_OVERWRITE );
		
		if ( $default ) {

			the_tags( '<div class="' . $class . '">' . $icon . '&nbsp;&nbsp;' . __( 'Tags:', 'aus-basic' ) . ': ', ' &#9679; ', '</div>' );

		} else {

			$tags = get_the_tags( $post->ID );

			if ( $tags ) {

				$html = '<ul class="list-inline ' . $class . '" >';
				$html .= '<li>' . $icon . '&nbsp;&nbsp;' . __( 'Tags:', 'aus-basic' ) . '</li>';
				foreach ( $tags as $tag ) {
					$html .= '<li><a href="' . get_tag_link( $tag->term_id ) . '"><span class="label label-default">' . $tag->name . '</span></a></li>';
				}
				$html .= '</ul>';
				echo $html;

			}

		}

	}

	public function comments() {
		global $post;
		$num_comments = get_comments_number(); // get_comments_number returns only a numeric value

		if ( comments_open() ) {
			if ( $num_comments == 0 ) {
				$html = '<a href="' . get_comments_link() .'">' . __( 'No Comments', 'aus-basic' ) .'</a>';
			} elseif ( $num_comments > 1 ) {
				$html = '<a href="' . get_comments_link() .'">' . $num_comments . __( ' Comments', 'aus-basic' ) .'</a>';
			} else {
				$html = '<a href="' . get_comments_link() .'">' . __( '1 Comment', 'aus-basic' ) .'</a>';
			}
		} else {
			$html =  __('Comments are off for this post.', 'aus-basic' );
		}

		echo $html;
	}

	/**
	 * Function to display post thumbnail
	 * @param $size thumbnail, medium, large, full
	 * @param array $attr array( 'src'=> $src,'class'=> 'attachment-$size','alt'	=> 
	 * trim( strip_tags( $wp_postmeta->_wp_attachment_image_alt ) ) )
	 * @param $post_id integer
	 */
	public function thumbnail( $size = null, $attr = array(), $post_id = '' ) {
		if ( empty( $post_id ) ) {
			global $post;
		} else {
			$post = get_post( $post_id );
		}
		if ( $size == NULL ) {
			$size = $this->settings( 'thumbnail_size' );
		}

		if ( !is_array( $attr ) or empty( $attr ) ) {
			$attr = array();
		}

		$thumbnail = get_the_post_thumbnail( $post->ID, $size, $attr );

		$args = '';
		foreach ( $attr as $key => $value ) {
			$args .= $key . '="' . $value . '" ';
		}

		$doc = new DOMDocument();
		@$doc->loadHTML( $post->post_content );
		$images = $doc->getElementsByTagName('img');
		$first_img = false;
		foreach ($images as $img) {
			$first_img = $img->getAttribute('src');
			break;
		}

		if ( $first_img ) {
			global $wpdb;
			$attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE guid='%s';", $first_img ) );
			if ( isset( $attachment[0] ) ) {
				$first_img = wp_get_attachment_image_src( $attachment[0], $size );
			}
			if ( isset( $first_img[0] ) ) {
				$first_img = $first_img[0];
			}
		}

		if ( ! empty( $thumbnail ) ) {
			echo '<a href="' . get_permalink( $post->ID, $post->name ) . '">' . $thumbnail . '</a>';
		} elseif ( ! empty( $first_img ) ) {
			echo '<a href="' . get_permalink( $post->ID, $post->name ) . '"><img src="' . $first_img . '" ' . $args . '/></a>';
		} elseif ( $this->settings( 'thumbnail_img' ) ) {

			$default_thumbnail_sized = $this->get_thumbnail( $this->settings( 'thumbnail_img' ), $this->settings( 'thumbnail_size' ) );
			
			if ( $default_thumbnail_sized ) {
				$default_thumbnail = $default_thumbnail_sized;
			} else {
				$default_thumbnail = $this->settings( 'thumbnail_img' );
			}
			echo '<a href="' . get_permalink( $post->ID, $post->name ) . '"><img src="' . $default_thumbnail . '" ' . $args . '/></a>';
		
		}
	}

	private function get_thumbnail( $image, $size ) {
		global $wpdb;
		$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image )); 
	  $id = $attachment[0];
	  $thumbnail = wp_get_attachment_image_src( $id, $size );
	  if ( isset( $thumbnail[0] ) && ! empty( $thumbnail[0] ) )
		return $thumbnail[0];
	  else
		return false;
	}

	/**
	 * @param $limit
	 * @param $post_id
	 */
	public function excerpt( $limit = 250, $post_id = '', $bywords = false ) {
		if ( empty( $post_id ) ) {
			global $post;
		} else {
			$post = get_post( $post_id );
		}

		$excerpt = get_the_content();
		if ( ! $excerpt ) {
			$excerpt = $post->post_content;
		}
		$excerpt = preg_replace( " ( \[.*?\] )", '', $excerpt );
		$excerpt = strip_shortcodes( $excerpt );
		$excerpt = strip_tags( $excerpt );
		//$excerpt = mb_substr( $excerpt, 0, $limit, 'UTF-8' );
		$excerpt = $this->limit( $excerpt, $limit, $bywords );
		$excerpt = mb_substr( $excerpt, 0, strripos( $excerpt, " " ), 'UTF-8' );
		$excerpt = trim( $excerpt );
		//$excerpt = trim( preg_replace( '/\s+/', ' ', $excerpt ) );
		$excerpt = $excerpt . '';
		echo $excerpt;
	}

	public function content() {
		global $post;
		the_content();
	}

	/**
	 * @param array $args
	 */
	public function readmore( $args = array() ) {

		global $post;
		$class = '';

		extract( $args, EXTR_OVERWRITE );

		$html = '<a class="' . $class . '" href="' . get_permalink( $post->ID ) . '">' . __( 'Read more <i class="fa fa-angle-double-right"></i>', 'aus-basic' ) . '</a>';
		echo $html;

	}

	public function edit_button( $args = array() ) {

		global $post;
		$class = 'btn btn-sm btn-default';
		$text = __( 'Edith this', 'aus-basic' );
		extract( $args, EXTR_OVERWRITE );

		if ( isset( $post->ID ) && current_user_can( 'edit_posts' ) ) {
			$html = '<a class="' . $class . '" href="' . get_edit_post_link() . '"><i class="fa fa-pencil"></i> ' . $text . '</a>';
			echo $html;
		}

	}

	public function post_meta( $key, $post_id = '', $single = true ) {
		if ( empty( $post_id ) || ! is_numeric( $post_id ) ) {
			global $post;
			$post_id = $post->ID;
		}
		echo get_post_meta( $post_id, $key , true );
	}


	/**
	 * Changes the default comment form fields to bootstrap markup
	 * @param  [type] $fields [description]
	 * @return [type]         [description]
	 */
	function comment_form_fields( $fields ) {

		$commenter = wp_get_current_commenter();
	
		$req	  = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );
		$html5	= current_theme_supports( 'html5', 'comment-form' ) ? 1 : 0;
		
		$fields   =  array( 
			'author' => '<div class="form-group col-md-6 col-sm-6 col-xs-12 comment-form-author">' . '<label for="author">' . __( 'Name', 'aus-basic' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
						'<input class="form-control col-xs-12" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></div>',
			'email'  => '<div class="form-group col-md-6 col-sm-6 col-xs-12 comment-form-email"><label for="email">' . __( 'Email', 'aus-basic' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
						'<input class="form-control col-xs-12" id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></div>',
			'url'	=> '<div class="form-group col-md-6 col-sm-6 col-xs-12 comment-form-url"><label for="url">' . __( 'Website', 'aus-basic' ) . '</label> ' .
						'<input class="form-control col-xs-12" id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></div>',
		 );
		
		return $fields;
	}

	/**
	 * Changes the default comment form textarea to bootstrap markup
	 * @param  [type] $args [description]
	 * @return [type]       [description]
	 */
	function comment_form_textarea( $args ) {

		$args['comment_field'] = '<div class="form-group col-md-7 col-sm-7 col-xs-12 comment-form-comment">
				<label for="comment">' . __( 'Comment', 'aus-basic' ) . '</label> 
				<textarea class="form-control" id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>
			</div>';
		return $args;

	}

	/**
	 * Changes the default comment form submit button to bootstrap markup
	 * @return [type] [description]
	 */
	function comment_button() {
		 echo '<button class="btn btn-primary" type="submit">' . __( 'Submit', 'aus-basic' ) . '</button>';
	}
	
	/**
	 * comment_template callback function 
	 * Changes the default comments list template to bootstrap markup
	 * @param  obj array $comment [description]
	 * @param  array $args    [description]
	 * @param  [type] $depth   [description]
	 * @return [type]          [description]
	 */
	function comment_template( $comment, $args, $depth ) {

		$GLOBALS['comment'] = $comment;
		$html = '<li ' . comment_class( 'row', $comment->comment_ID, $comment->comment_post_ID, false ) . '>';
			$html .= '<div id="comment-' . $comment->comment_ID . '">';
			$html .= '<div class="comment-user col-md-2 col-sm-2 hidden-xs text-right">';
			$html .= '<figure class="comment-avatar">';
			$html .= get_avatar( $comment, $size='75' );
			$html .= '</figure>';
			$html .= '</div>';
			$html .= '<div class="col-md-10 col-sm-10 col-xs-12">';
			$html .= '<div class="panel panel-default arrow left">';
			$html .= '<div class="panel-body">';
			$html .= '<div class="text-left">';
			$html .= '<div class="comment-user">';
			$html .= '<i class="fa fa-user"></i> ' . get_comment_author_link( $comment->comment_ID ) . ' | <i class="fa fa-calendar"></i> <time datetime="' . get_comment_date() . '"> <a href="' . htmlspecialchars( get_comment_link( $comment->comment_ID ) ) . '">' . get_comment_date() . '</a></time>';
			$html .= '</div>';
			$html .= '</div>';
			
			if ( $comment->comment_approved == '0' ) {
			$html .= '<div class="alert alert-success" role="alert">' . __( 'Your comment is awaiting moderation.', 'aus-basic' ) . '</div>';
			}
			
			$html .= '<div class="comment-post text-left"><p>' . apply_filters( 'comment_text', get_comment_text() ) . '</p></div>';
			$html .= '<p class="text-right">';
			
			if ( get_option( 'comment_registration' ) && ! is_user_logged_in() ) {
			$html .= '<a rel="nofollow" class="comment-reply-login btn btn-default btn-sm" href="' . esc_url( wp_login_url( get_permalink() ) ) . '"><i class="fa fa-reply"></i> ' . __( 'Log in to Reply', 'aus-basic' ) . '</a>';
			} else {
			$html .= '<a href="' . get_permalink() . '&replytocom=' . $comment->comment_ID . '#respond" class="comment-reply-link btn btn-default btn-sm" onclick="return addComment.moveForm( \'comment-' . $comment->comment_ID . '\', \'' . $comment->comment_ID . '\', \'respond\', \'' . $comment->comment_post_ID . '\' )">';
			$html .= '<i class="fa fa-reply"></i> ' . __( 'Reply', 'aus-basic' );
			$html .= '</a>';
			}
			
			$html .= '</p>';
			$html .= '</div>';
			$html .= '</div>';
			$html .= '</div>';
			$html .= '</div>';
		echo $html;
	}

	public function limit( $text, $limit = 300, $bywords = false ) {

		$cyr_chars = 'АаБбВвГгДдЕеЁёЖжЗзИиЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЪъЫыЬьЭэЮюЯя';

		if ( $bywords ) {
			if ( str_word_count( $text, 0, $cyr_chars ) >= $limit ) {
				$words = str_word_count( $text, 2, $cyr_chars );
				$pos = array_keys( $words );
				$text = substr( $text, 0, $pos[ $limit ] );
			}
		} else {
			mb_internal_encoding("UTF-8");
			$text = mb_substr( $text, 0, $limit, 'UTF-8' );
		}

		return $text;

	}

}
?>