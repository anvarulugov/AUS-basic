<?php 

class AUS_NewsBox {
	
	public function __construct() {
		add_shortcode( 'aus_newsbox', array( $this, 'newbox' ) );
	}

	public function newbox() {
	?>
	<div class="panel panel-primary aus-news-box aus-nb-style1">
		<div class="panel-heading aus-news-box-heading">
			<h3 class="panel-title">Panel title</h3>
		</div>
		<div class="panel-body aus-news-box-body">
			<div class="row">
				<div class="col-md-6 aus-nb-big-post">
					<img class="img-responsive" src="http://termiz.click/wp-content/uploads/2013/03/featured-image-horizontal.jpg">
					<h3><a href="#">Speed Up Your WordPress Themes</a></h3>
					<div class="">
						<span datetime="2014-05-17T21:15:22+00:00" class="entry-date">May 17, 2014</span>
						<a href="#" class="">7 Comments</a>
					</div>
					<p>
					WordPress Themes can be more faster than you think let’s see how !!? A few months ago, I ran a...<a class="btn btn-primary btn-xs" href="#">Read more <i class="fa fa-angle-double-right"></i></a>
				</p>
				</div>
				<div class="col-md-6 aus-nb-posts-list">
					<ul>
						<li class="panel-default">
							<a href="#">
								<img src="http://termiz.click/wp-content/uploads/2013/03/real_madrid_2-wallpaper-1152x720-90x60.jpg" data-hidpi="#" alt="Create A Twitter Widget" width="90" height="60" class="img-responsive disappear appear">
							</a>
							<div class="">
								<h4><a href="#">Create A Twitter Widget</a></h4>
								<div class="">
									<span datetime="2014-05-17T10:38:14+00:00" class="entry-date">May 17, 2014</span>
										<a href="#" class="">18 Comments</a>
								</div> <!--meta-->
							</div>
						</li>
						<li class="panel-default">
							<a href="#"><img src="http://termiz.click/wp-content/uploads/2013/03/real_madrid_2-wallpaper-1152x720-90x60.jpg" data-hidpi="#" alt="Google Two-Factor Authentication" width="90" height="60" class="img-responsive disappear appear"></a>
							<div class="">
								<h4><a href="#">Google Two-Factor Authentication Google Two-Factor Authentication</a></h4>
								<div class="">
									<span datetime="2014-05-17T09:35:14+00:00" class="entry-date">May 17, 2014</span>
									<a href="#" class="">No comments</a>
								</div> <!--meta-->   
							</div>
						</li>
						<li class="panel-default">
							<a href="#"><img src="http://termiz.click/wp-content/uploads/2013/03/real_madrid_2-wallpaper-1152x720-90x60.jpg" data-hidpi="#" alt="WordPress:Categories VS Tags" width="90" height="60" class="img-responsive disappear appear"></a>
							<div class="">
								<h4><a href="#">WordPress:Categories VS Tags</a></h4>
								<div class="">
									<span datetime="2014-05-17T07:31:40+00:00" class="entry-date">May 17, 2014</span>
									<a href="#" class="">No comments</a>
								</div> <!--meta-->
							</div>
						</li>
						<li class="panel-default">
							<a href="#"><img src="http://termiz.click/wp-content/uploads/2013/03/real_madrid_2-wallpaper-1152x720-90x60.jpg" data-hidpi="#" alt="Best Permalink Structure" width="90" height="60" class="img-responsive disappear appear"></a>
							<div class="">
								<h4><a href="#">Best Permalink Structure</a></h4>
								<div class="">
									<span datetime="2014-05-17T07:20:06+00:00" class="entry-date">May 17, 2014</span>
										<a href="#" class="">No comments</a>
								</div> <!--meta-->
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="panel-footer aus-news-box-footer text-center"><a class="btn btn-default btn-xs" href="#">Show more news <i class="fa fa-refresh"></i></a></div>
	</div>


	<div class="panel panel-primary aus-news-box aus-nb-style2">
		<div class="panel-heading aus-news-box-heading">
			<h3 class="panel-title">Panel title</h3>
		</div>
		<div class="panel-body aus-news-box-body">
			<div class="row">
				<div class="col-md-12 aus-nb-big-post-title">
					<h3><a href="#">Speed Up Your WordPress Themes</a></h3>
					<div class="">
						<span datetime="2014-05-17T21:15:22+00:00" class="entry-date">May 17, 2014</span>
						<a href="#" class="">7 Comments</a>
					</div>
				</div>
				<div class="col-md-6 aus-nb-big-post">
					<img class="img-responsive" src="http://termiz.click/wp-content/uploads/2013/03/featured-image-horizontal.jpg">
				</div>
				<div class="col-md-6 aus-nb-big-post-content">
					<p>
					Most WordPress Themes users are familiar with tags and categories and with how to use them to organize their blog posts. If you use custom post types in WordPress Themes, you might need to organize them like categories and tags. Most WordPress Themes users are familiar with tags and categories and with how to use them to organize their blog posts. If you use custom post types in WordPress Themes, you might need to organize them like categories and tags. Categories...<a class="btn btn-primary btn-xs" href="#">Read more <i class="fa fa-angle-double-right"></i></a>
					</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 aus-nb-post">
					<a href="#">
						<img src="http://termiz.click/wp-content/uploads/2013/03/real_madrid_2-wallpaper-1152x720-90x60.jpg" data-hidpi="#" alt="Create A Twitter Widget" width="90" height="60" class="img-responsive disappear appear">
					</a>
					<div class="">
						<h4><a href="#">Create A Twitter Widget</a></h4>
						<div class="">
							<span datetime="2014-05-17T10:38:14+00:00" class="entry-date">May 17, 2014</span>
								<a href="#" class="">18 Comments</a>
						</div> <!--meta-->
					</div>
				</div>
				<div class="col-md-6 aus-nb-post">
					<a href="#"><img src="http://termiz.click/wp-content/uploads/2013/03/real_madrid_2-wallpaper-1152x720-90x60.jpg" data-hidpi="#" alt="Google Two-Factor Authentication" width="90" height="60" class="img-responsive disappear appear"></a>
					<div class="">
						<h4><a href="#">Google Two-Factor Authentication Google Two-Factor Authentication</a></h4>
						<div class="">
							<span datetime="2014-05-17T09:35:14+00:00" class="entry-date">May 17, 2014</span>
							<a href="#" class="">No comments</a>
						</div> <!--meta-->   
					</div>
				</div>
				<div class="col-md-6 aus-nb-post">
					<a href="#"><img src="http://termiz.click/wp-content/uploads/2013/03/real_madrid_2-wallpaper-1152x720-90x60.jpg" data-hidpi="#" alt="WordPress:Categories VS Tags" width="90" height="60" class="img-responsive disappear appear"></a>
					<div class="">
						<h4><a href="#">WordPress:Categories VS Tags</a></h4>
						<div class="">
							<span datetime="2014-05-17T07:31:40+00:00" class="entry-date">May 17, 2014</span>
							<a href="#" class="">No comments</a>
						</div> <!--meta-->
					</div>
				</div>
				<div class="col-md-6 aus-nb-post">
					<a href="#"><img src="http://termiz.click/wp-content/uploads/2013/03/real_madrid_2-wallpaper-1152x720-90x60.jpg" data-hidpi="#" alt="Best Permalink Structure" width="90" height="60" class="img-responsive disappear appear"></a>
					<div class="">
						<h4><a href="#">Best Permalink Structure</a></h4>
						<div class="">
							<span datetime="2014-05-17T07:20:06+00:00" class="entry-date">May 17, 2014</span>
								<a href="#" class="">No comments</a>
						</div> <!--meta-->
					</div>
				</div>
			</div>
		</div>
		<div class="panel-footer aus-news-box-footer text-center"><a class="btn btn-default btn-xs" href="#">Show more news <i class="fa fa-refresh"></i></a></div>
	</div>

	<div class="panel panel-primary aus-news-box aus-nb-style3">
		<div class="panel-heading aus-news-box-heading">
			<h3 class="panel-title">Panel title</h3>
		</div>
		<div class="panel-body aus-news-box-body">
			<div class="row">
				<div class="col-md-12 aus-nb-big-post-title">
					<h3><a href="#">Speed Up Your WordPress Themes</a></h3>
					<div class="">
						<span datetime="2014-05-17T21:15:22+00:00" class="entry-date">May 17, 2014</span>
						<a href="#" class="">7 Comments</a>
					</div>
				</div>
				<div class="col-md-6 aus-nb-big-post">
					<img class="img-responsive" src="http://termiz.click/wp-content/uploads/2013/03/featured-image-horizontal.jpg">
				</div>
				<div class="col-md-6 aus-nb-big-post-content">
					<p>
					Most WordPress Themes users are familiar with tags and categories and with how to use them to organize their blog posts. If you use custom post types in WordPress Themes, you might need to organize them like categories and tags. Most WordPress Themes users are familiar with tags and categories and with how to use them to organize their blog posts. If you use custom post types in WordPress Themes, you might need to organize them like categories and tags. Categories...<a class="btn btn-primary btn-xs" href="#">Read more <i class="fa fa-angle-double-right"></i></a>
					</p>
				</div>
			</div>
			<div class="aus-nb-post row">
				<ul class="two-col">
					<li>
						<i class="fa fa-angle-double-right"></i> 
						<a href="#">Create A Twitter Widget1</a>
					</li>
					<li>
						<i class="fa fa-angle-double-right"></i> 
						<a href="#">Create A Twitter Widget2</a>
					</li>
					<li>
						<i class="fa fa-angle-double-right"></i> 
						<a href="#">Create A Twitter Widget3</a>
					</li>
					<li>
						<i class="fa fa-angle-double-right"></i> 
						<a href="#">Create A Twitter Widget4</a>
					</li>
					<li>
						<i class="fa fa-angle-double-right"></i> 
						<a href="#">Create A Twitter Widget5</a>
					</li>
					<li>
						<i class="fa fa-angle-double-right"></i> 
						<a href="#">Create A Twitter Widget6</a>
					</li>
					<li>
						<i class="fa fa-angle-double-right"></i> 
						<a href="#">Create A Twitter Widget7</a>
					</li>
					<li>
						<i class="fa fa-angle-double-right"></i> 
						<a href="#">Create A Twitter Widget8</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="panel-footer aus-news-box-footer text-center"><a class="btn btn-default btn-xs" href="#">Show more news <i class="fa fa-refresh"></i></a></div>
	</div>
	<?php 
	}

}
new AUS_NewsBox();