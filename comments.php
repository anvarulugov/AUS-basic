<?php 
if ( post_password_required() ) {
	return;
}

global $elements;
?>
<div id="comments">
<?php comment_form(); ?>
<?php if ( have_comments() ) : ?>

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<ul class="pager">
			<li class="previous"><?php previous_comments_link( __( '&larr; Older Comments' ) ); ?></li>
			<li class="next"><?php next_comments_link( __( 'Newer Comments &rarr;' ) ); ?></li>
		</ul>
	<?php endif; // Check for comment navigation. ?>

	<section class="comment-list">
		<?php wp_list_comments( array( 
			'style'=>'ul', 
			'type'=>'comment',
			'short_ping' => true,
			'avatar_size'=> 34,
			'callback'=>array( $elements, 'comment_template' ) 
		) ); ?>
	</section><!-- .comment-list -->

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<ul class="pager">
			<li class="previous"><?php previous_comments_link( __( '&larr; Older Comments', 'theme_slug' ) ); ?></li>
			<li class="next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'theme_slug' ) ); ?></li>
		</ul>
	<?php endif; // Check for comment navigation. ?>

	<?php if ( ! comments_open() ) : ?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'theme_slug' ); ?></p>
	<?php endif; ?>

<?php endif; // have_comments() ?>
</div>