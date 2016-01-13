
<?php 
get_header();

$archi = wp_get_archives( 'echo=0&show_post_count=1' );
print_r($archi);
$archi = explode( '</li>' , $archi );
$links = array();
$i = 0;
foreach( $archi as $link ) {
	$link = str_replace( array( '<li>' , "\n" , "\t" , "\s" ), '' , $link );
	$count = preg_replace('/(<a.*?>.*<\/a>)/', '', $link);
	$count = str_replace('&nbsp;', '', $count);
	if( '' != $link ) {
		preg_match('~<a .*?href=[\'"]+(.*?)[\'"]+.*?>(.*?)</a>~ims', $link, $result);
		$links[$i]['link'] = $result[1];
		$links[$i]['text'] = $result[2];
		$links[$i]['count'] = $count;
		$i++;
	} else {
		continue;
	}
}
print '<pre>';
print_r( $links );
print '</pre>';


$comments = get_comments();

print '<pre>';
print_r( $comments );
print '</pre>';

get_footer();