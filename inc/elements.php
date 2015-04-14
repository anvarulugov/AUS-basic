<?php
/**
 * Table of contents
 * Init
 * Settings
 * Site
 * - logo
 * - site_name
 * Navigation
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
 * Comments
 * - comment_form_fields
 * - comment_form_textarea
 * - comment_button
 * - comment_template
 * Reserveds
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
	function __construct( $theme_name = 'API', $theme_slug = 'api', $menutype = 'sublevel' ) {

		$this->theme_name = $theme_name;
		$this->theme_slug = $theme_slug;

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
		add_action( 'comment_form', array( $this, 'comment_button' ) );

	}

	/**
	 * @param $key
	 * @return mixed
	 */
	private function settings( $key ) {
		if ( isset( $this->options[ $key ] ) ) {
			return $this->options[ $key ];
		} else {
			return false;
		}
		
	}

	/**
	 * Displays site logo
	 * @return html;
	 */
	public function logo() {
		if ( $this->settings( 'logo_img' ) ) {
			echo '<a href="' . home_url() . '"><img class="logo_img" src="' . $this->settings( 'logo_img' ) . '" /></a>';
		} else {
			echo '<a class="logo_text" href="' . home_url() . '">' . get_bloginfo( 'name' ) . '</a>';
		}
	}

	/**
	 * Displays Website Name
	 * @return string
	 */
	public function site_name() {
		echo get_bloginfo( 'site_name' );
	}

	public function site_description() {
		echo get_bloginfo( 'description' );
	}

	/**
	 * @param $nav_location
	 * @param array $args
	 */
	public function navigation( $nav_location = 'primary', $args = array() ) {

		$container = 'nav';
		$container_class = 'container';
		$menu_class = 'navbar-default';

		extract( $args, EXTR_OVERWRITE );

		if ( $container != 'div' ) {
			$container = 'nav';
		}

		$pages = $this->get_pages( $nav_location );

		if ( $pages ):

			$html = '<' . $container . ' class="' . $container_class . '">';
			$html .= '<ul class="' . $menu_class . '">';
			foreach ( $pages as $page ) {
				$html .= '<li><a title="' . $page['attr_title'] . '" class="' . $page['classes'] . '" target="' . $page['target'] . '" href="' . $page['url'] . '">' . $page['title'] . '</a></li>';
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

		$container_class = 'container';
		$navbar_class = 'navbar-default';

		extract( $args, EXTR_OVERWRITE );
		$pages = $this->get_pages( $nav_location );
		if ( $pages ):
			$html  = '<nav class="navbar ' . $navbar_class . '" role="navigation">';
			$html .= '<div class="' . $container_class . '">';
			$html .= '<!-- Brand and toggle get grouped for better mobile display -->';
			$html .= '<div class="navbar-header">';
			if ( $nav_location == 'primary' && $this->settings( 'show_home_menu' ) ) {
				if ( $this->settings( 'home_menu_text' ) ) {
					$html .= '<a class="navbar-brand" href="' . home_url() . '">' . $this->settings( 'home_menu_text' ) . '</a>';
				} else {
					$html .= '<a class="navbar-brand" href="' . home_url() . '"><i class="fa fa-home"></i></a>';
				}
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
			$html .= '<ul class="nav navbar-nav">';
			foreach ( $pages as $page ) {

				if ( empty( $page['childs'] ) ):
					$html .= '<li><a title="' . $page['attr_title'] . '" class="' . $page['classes'] . '" target="' . $page['target'] . '" href="' . $page['url'] . '">' . $page['title'] . '</a></li>';
				elseif ( !empty( $page['childs'] ) ):
					$html .= '<li class="dropdown"><a href="' . $page['url'] . '" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">' . $page['title'] . '<span class="caret"></span></a>';
					$html .= '<ul class="dropdown-menu" role="menu">';
					foreach ( $page['childs'] as $child ) {
						$html .= '<li><a href="' . $child['url'] . '">' . $child['title'] . '</a></li>';
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
	private function get_pages( $nav_location = 'primary' ) {
		$theme_locations = get_nav_menu_locations();
		if ( isset( $theme_locations[ $nav_location ] ) ) {
			$menu_obj = get_term( $theme_locations[ $nav_location ], 'nav_menu' );
			$menu_name = $menu_obj->name;
			$items = wp_get_nav_menu_items( $menu_name );
		} else {
			$items = false;
		}
		

		if ( $items ):
			foreach ( $items as $item ) {
				if ( $item->menu_item_parent == 0 ) {
					$pages[] = array( 
						'id' => $item->ID,
						'title' => $item->title,
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
					'url' => $child->url, 
					'classes' => implode( ' ', $item->classes ),
					'target' => $item->target,
					'attr_title' => $item->attr_title,
					'description' => $item->description,
					'childs' => $this->get_page_childs( $child->ID, $childs )
				 );
			}

		}
		return $children;
	}

	/**
	 * @param $query
	 */
	public function pager( $query = null ) {

		global $wp_query;
		if ( $query == null ) {
			$query = $wp_query;
		}

		$big = 999999999; // need an unlikely integer
		$pages = paginate_links( array( 
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?paged=%#%',
			'prev_text' => __( '&laquo;' ),
			'next_text' => __( '&raquo;' ),
			'mid_size' => 5,
			'type' => 'array',
			'current' => max( 1, get_query_var( 'paged' ) ),
			'total' => $query->max_num_pages,
		 ) );
		$pager = '<ul class="pagination">';
		if ( isset( $pages ) and !empty( $pages ) ) {
			foreach ( $pages as $page ) {
				$pager .= '<li>' . $page . '</li>';
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
			$title = mb_substr( $title, 0, $limit, 'UTF-8' ) . '...';

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
		$date = get_the_date( get_option( 'date_format' ) );
		echo $date;
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
		$link = true;
		$target = '_self';
		$class = '';
		$title = '';
		$taxonomy = 'category';
		extract( $args, EXTR_OVERWRITE );

		$post_categories = get_the_terms( $post_id, $taxonomy );
		$cats = array();
		$last_cat = end( $post_categories );
		foreach ( $post_categories as $c ) {
			$cat = get_category( $c );
			if ( $cat->term_id != $this->settings( 'featured_cat' ) ) {
				if ( $link )
					$html  = '<a class="' . $class . '" target="' . $target . '" title="' . $title . '" href="' . get_category_link( $cat->term_id ) . '">';
				$html .= $cat->name;
				if ( $link )
					$html .= '</a>';
			}
			if ( count( $post_categories ) > 1 and $cat->term_id != $last_cat and $cat->term_id != $this->settings( 'featured_cat' ) ) {
				$html .= ', ';
			}
			echo $html;
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

			the_tags( '<div class="' . $class . '">' . $icon . '&nbsp;&nbsp;' . __( 'Tags:' ) . ': ', ' • ', '</div>' );

		} else {

			$tags = get_the_tags( $post->ID );

			if ( $tags ) {

				$html = '<ul class="list-inline ' . $class . '" >';
				$html .= '<li>' . $icon . '&nbsp;&nbsp;' . __( 'Tags:', 'themeslug' ) . '</li>';
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
				$html = '<a href="' . get_comments_link() .'">' . __('No Comments') .'</a>';
			} elseif ( $num_comments > 1 ) {
				$html = '<a href="' . get_comments_link() .'">' . $num_comments . __(' Comments') .'</a>';
			} else {
				$html = '<a href="' . get_comments_link() .'">' . __('1 Comment') .'</a>';
			}
		} else {
			$html =  __('Comments are off for this post.');
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

		$first_img = '';
		ob_start();
		ob_end_clean();

		$output = preg_match_all( '/<img.+src=[\'"]( [^\'"]+ )[\'"].*>/i', $post->post_content, $matches );

		if ( isset( $matches[1][0] ) ) {
			$first_img = $matches[1][0];
			$search = array( '.jpeg', '.jpg', '.png', '.gif', '.bmp' );
			$replace = array( '-280x180.jpeg', '-280x180.jpg', '-280x180.png', '-280x180.gif', '-280x180.bmp' );
			$first_img = str_replace( $search, $replace, $first_img );
		}

		if ( ! empty( $thumbnail ) ) {
			echo '<a href="' . $post->guid . '">' . $thumbnail . '</a>';
		} elseif ( ! empty( $first_img ) ) {
			echo '<a href="' . $post->guid . '"><img src="' . $first_img . '" ' . $args . '/></a>';
		} elseif ( $this->settings( 'thumbnail_img' ) ) {
			echo '<a href="' . $post->guid . '"><img src="' . $this->settings( 'thumbnail_img' ) . '" ' . $args . '/></a>';
		}
	}

	/**
	 * @param $limit
	 * @param $post_id
	 */
	public function excerpt( $limit = 250, $post_id = '' ) {
		if ( empty( $post_id ) ) {
			global $post;
		} else {
			$post = get_post( $post_id );
		}

		$excerpt = $post->post_content;
		$excerpt = preg_replace( " ( \[.*?\] )", '', $excerpt );
		$excerpt = strip_shortcodes( $excerpt );
		$excerpt = strip_tags( $excerpt );
		$excerpt = mb_substr( $excerpt, 0, $limit, 'UTF-8' );
		$excerpt = mb_substr( $excerpt, 0, strripos( $excerpt, " " ), 'UTF-8' );
		$excerpt = trim( preg_replace( '/\s+/', ' ', $excerpt ) );
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

		$html = '<a class="' . $class . '" href="' . get_permalink( $post->ID ) . '">' . __( 'Read more <i class="fa fa-angle-double-right"></i>', 'themeslug' ) . '</a>';
		echo $html;

	}

	public function edit_button( $args = array() ) {

		global $post;
		$class = 'btn btn-sm btn-default';
		$text = __( 'Edith this', 'themeslug' );
		extract( $args, EXTR_OVERWRITE );

		$html = '<a class="' . $class . '" href="' . get_edit_post_link() . '"><i class="fa fa-pencil"></i> ' . $text . '</a>';

		echo $html;

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
			'author' => '<div class="form-group comment-form-author">' . '<label for="author">' . __( 'Name', 'themeslug' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
						'<input class="form-control" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></div>',
			'email'  => '<div class="form-group comment-form-email"><label for="email">' . __( 'Email', 'themeslug' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
						'<input class="form-control" id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></div>',
			'url'	=> '<div class="form-group comment-form-url"><label for="url">' . __( 'Website', 'themeslug' ) . '</label> ' .
						'<input class="form-control" id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></div>',
		 );
		
		return $fields;
	}

	/**
	 * Changes the default comment form textarea to bootstrap markup
	 * @param  [type] $args [description]
	 * @return [type]       [description]
	 */
	function comment_form_textarea( $args ) {

		$args['comment_field'] = '<div class="form-group comment-form-comment">
				<label for="comment">' . _x( 'Comment', 'noun' ) . '</label> 
				<textarea class="form-control" id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>
			</div>';
		return $args;

	}

	/**
	 * Changes the default comment form submit button to bootstrap markup
	 * @return [type] [description]
	 */
	function comment_button() {
	    echo '<button class="btn btn-default" type="submit">' . __( 'Submit', 'themeslug' ) . '</button>';
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
			$html  .= '<article id="comment-' . $comment->comment_ID . '">';
			$html .= '<div class="comment-user col-md-2 col-sm-2 hidden-xs text-right">';
			$html .= '<figure class="comment-avatar">';
			$html .= get_avatar( $comment, $size='75' );
			$html .= '</figure>';
			$html .= '</div>';
			$html .= '<div class="col-md-10 col-sm-10">';
			$html .= '<div class="panel panel-default arrow left">';
			$html .= '<div class="panel-body">';
			$html .= '<header class="text-left">';
			$html .= '<div class="comment-user">';
			$html .= '<i class="fa fa-user"></i> ' . get_comment_author_link( $comment->comment_ID ) . ' | <i class="fa fa-calendar"></i> <time datetime="' . get_comment_date() . '"> <a href="' . htmlspecialchars( get_comment_link( $comment->comment_ID ) ) . '">' . get_comment_date() . '</a></time>';
			$html .= '</div>';
			$html .= '</header>';
			
			if ( $comment->comment_approved == '0' ) {
			$html .= '<div class="alert alert-success" role="alert">' . __( 'Your comment is awaiting moderation.' ) . '</div>';
			}
			
			$html .= '<div class="comment-post"><p>' . apply_filters( 'comment_text', get_comment_text() ) . '</p></div>';
			$html .= '<p class="text-right">';
			
			if ( get_option( 'comment_registration' ) && ! is_user_logged_in() ) {
			$html .= '<a rel="nofollow" class="comment-reply-login btn btn-default btn-sm" href="' . esc_url( wp_login_url( get_permalink() ) ) . '"><i class="fa fa-reply"></i> ' . __( 'Log in to Reply', 'themeslug' ) . '</a>';
			} else {
			$html .= '<a href="' . get_permalink() . '&replytocom=' . $comment->comment_ID . '#respond" class="comment-reply-link btn btn-default btn-sm" onclick="return addComment.moveForm( \'comment-' . $comment->comment_ID . '\', \'' . $comment->comment_ID . '\', \'respond\', \'' . $comment->comment_post_ID . '\' )">';
			$html .= '<i class="fa fa-reply"></i> ' . __( 'Reply', 'themeslug' );
			$html .= '</a>';
			}
			
			$html .= '</p>';
			$html .= '</div>';
			$html .= '</div>';
			$html .= '</div>';
			$html .= '</article>';
		echo $html;
	}

	/**
	 * Lists the entry comments
	 * Custom list function, it is not a Wordpress default function or callback
	 * @param  boolean $post_id [description]
	 * @return [type]           [description]
	 */
	public function comments_list( $post_id = false ) {
		if ( ! $post_id ) {
			global $post;
			$post_id = $post->ID;
		}
		$comments = $this->comments_array( $post_id );
		if( $comments ) {
			$html = '<section class="comment-list">';
			$count = 0;
			foreach ( $comments as $comment ) {
				$count++;
				$html .= $this->comment_format( $comment );
			}
			$html .= '</section>';
			echo $html;
		}
	}







	/**
	 * Formats the comment data
	 * @param  array $comment
	 * @return html
	 */
	private function comment_format( $comment, $offset = 0 ) {

		$html  = '<article ' . comment_class( 'row', $comment['comment_ID'], $comment['post_id'], false ) . ' id="comment-' . $comment['comment_ID'] . '">';

		if ( $offset > 3 )
			$offset = 3;

		$col = 10 - $offset;

		$comment_thumb  = '<div class="col-md-2 col-sm-2 hidden-xs col-md-offset-' . $offset . '">';
		$comment_thumb .= '<figure class="comment-avatar">';
		$comment_thumb .= get_avatar( $comment['comment_author_email'], 70 );
		$comment_thumb .= '</div>';		

		$comment_content  = '<div class="col-md-' . $col . ' col-sm-' . $col . '">';
		$comment_content .= '<div class="panel panel-default arrow left">';
		$comment_content .= '<div class="panel-heading right">' . $comment['comment_depth'] . '</div>';
		$comment_content .= '<div class="panel-body">';
		$comment_content .= '<header class="text-left">';
		$comment_content .= '<div class="comment-user"><i class="fa fa-user"></i> ' . $comment['comment_author'] . ' | <time class="comment-date" datetime="' . date( 'Y-m-d' , strtotime( $comment['comment_date'] ) ) . '"><i class="fa fa-clock-o"></i> ' . date( get_option( 'date_format' ), strtotime( $comment['comment_date'] ) ) . '</time> - Parent: ' . $comment['comment_parent'] . ' ID: ' . $comment['comment_ID'] . '</div>';
		$comment_content .= '</header>';
		$comment_content .= '<div class="comment-post">';
		$comment_content .= '<p>Offset: ' . $offset . ' ' . $comment['comment_content'] . '</p>';
		$comment_content .= '</div>';
		$comment_content .= '<p class="text-right">';
		if ( get_option( 'comment_registration' ) && ! is_user_logged_in() ) {
			$comment_content .= '<a rel="nofollow" class="comment-reply-login btn btn-default btn-sm" href="' . esc_url( wp_login_url( get_permalink() ) ) . '"><i class="fa fa-reply"></i> ' . __( 'Log in to Reply', 'themeslug' ) . '</a>';
		} else {
			$comment_content .= '<a href="' . get_permalink() . '&replytocom=' . $comment['comment_ID'] . '#respond" class="comment-reply-link btn btn-default btn-sm" onclick="return addComment.moveForm( \'comment-' . $comment['comment_ID'] . '\', \'' . $comment['comment_ID'] . '\', \'respond\', \'' . $comment['post_id'] . '\' )">';
			$comment_content .= '<i class="fa fa-reply"></i> ' . __( 'Reply', 'themeslug' );
			$comment_content .= '</a>';
		}
		$comment_content .= '</p>';
		$comment_content .= '</div>';
		$comment_content .= '</div>';
		$comment_content .= '</div>';

		if ( $comment_right ) {
			$html .= $comment_content;
			$html .= $comment_thumb;
		} else  {
			$html .= $comment_thumb;
			$html .= $comment_content;
		}
		

		$html .= '</article>';
		
		if ( $comment['childs'] ) {
			$offset++;
			foreach ( $comment['childs'] as $comment ) {
				$html .= $this->comment_format( $comment, $offset );
			}
		}
		return $html;
	}

	/**
	 * Return the array of comments for given post/page
	 * @param  integer $post_id [description]
	 * @return array          [description]
	 */
	private function comments_array( $post_id = null ) {
		$comments = get_comments( array( 'post_id' => $post_id, 'order'=>'ASC' ) );
		$i = 0;
		foreach ( $comments as $comment ) {
			if ( $comment->comment_parent == 0 and $comment->comment_approved == 1 ) {
				$i++;
				$comments_list[] = array( 
					'post_id' => $comment->comment_post_ID ,
					'comment_ID' => $comment->comment_ID,
					'comment_parent' => $comment->comment_parent,
					'comment_depth' => $i,
					'comment_author' => $comment->comment_author,
					'comment_author_email' => $comment->comment_author_email,
					'comment_author_url' => $comment->comment_author_url,
					'comment_date' => $comment->comment_date,
					'comment_content' => $comment->comment_content,
					'childs' => $this->get_comment_childs( $comment->comment_ID, $comments, $i ),
				 );
			}
		}
		return $comments_list;
	}

	/**
	 * Returns the array of child comments for given comment
	 * @param  integer $parent ID of parent comment
	 * @param  array $childs array of all child comments
	 * @param  integer $depth  depth of the comment
	 * @return array        [description]
	 */
	private function get_comment_childs( $parent, $childs, $depth ) {
		$children = array();
		$i = 0;
		foreach ( $childs as $child ) {
			if ( $child->comment_parent == $parent and $child->comment_approved == 1 ) {
				$i++;
				$children[] = array( 
					'post_id' => $child->comment_post_ID ,
					'comment_ID' => $child->comment_ID,
					'comment_parent' => $child->comment_parent,
					'comment_depth' => $depth . '.' . $i,
					'comment_author' => $child->comment_author,
					'comment_author_email' => $child->comment_author_email,
					'comment_author_url' => $child->comment_author_url,
					'comment_date' => $child->comment_date,
					'comment_content' => $child->comment_content,
					'childs' => $this->get_comment_childs( $child->comment_ID, $childs, $depth . '.' . $i ),
				 );
			}

		}
		return $children;
	}

}

?>