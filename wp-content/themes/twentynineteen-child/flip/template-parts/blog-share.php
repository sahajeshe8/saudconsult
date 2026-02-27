<?php
$wplogoutURL = urlencode(get_the_permalink());
$wplogoutTitle = urlencode(get_the_title());
$wplogoutImage= urlencode(get_the_post_thumbnail_url(get_the_ID(), 'full'));
?>
<div class="single-share-area">
	<span>Share:</span>
	<ul>
		<li><a href="https://www.linkedin.com/shareArticle?url=<?php echo $wplogoutURL; ?>&amp;title=<?php echo $wplogoutTitle; ?>&amp;mini=true" target="_blank" rel="nofollow"><i class="fa-brands fa-linkedin-in"></i></a></li>
		<li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $wplogoutURL; ?>" target="_blank" rel="nofollow"><i class="fa-brands fa-facebook-f"></i></a></li>
		<li><a href="https://twitter.com/intent/tweet?text=<?php echo $wplogoutTitle;?>&amp;url=<?php echo $wplogoutURL;?>&amp;via=wplogout" target="_blank" rel="nofollow"><i class="fa-brands fa-twitter"></i></a></li>
		<li><a href="mailto:?subject=<?php echo wp_title(''); ?>&amp;body=<?php echo $wplogoutURL; ?>" target="_blank" rel="nofollow"><i class="fa-solid fa-envelope"></i></a></li>
		<li><a href="https://api.whatsapp.com/send?text=<?php echo $wplogoutTitle; echo " "; echo $wplogoutURL;?>" target="_blank" rel="nofollow"><i class="fa-brands fa-whatsapp"></i></a></li>
	</ul>
</div>