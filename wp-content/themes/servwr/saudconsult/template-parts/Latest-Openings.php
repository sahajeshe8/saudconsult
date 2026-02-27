<?php
/**
 * Latest Openings Section Component Template
 *
 * @package tasheel
 */

// Extract data from args array passed from get_template_part()
$args = isset( $args ) ? $args : array();

// Set default values or use passed values
$title = isset( $args['title'] ) ? $args['title'] : esc_html__( 'Latest', 'tasheel' );
$title_span = isset( $args['title_span'] ) ? $args['title_span'] : esc_html__( 'Openings', 'tasheel' );
$openings = isset( $args['openings'] ) ? $args['openings'] : array(
	array(
		'title' => 'Chief Financial Officer',
		'posted_date' => 'Posted 18 Hours Ago',
		'location' => 'Riyadh, Saudi Arabia',
		'job_id' => 'ID: 54294',
		'details_link' => esc_url( home_url( '/job-details' ) )
	),
	array(
		'title' => 'Senior Civil Engineer',
		'posted_date' => 'Posted 1 Day Ago',
		'location' => 'Jeddah, Saudi Arabia',
		'job_id' => 'ID: 54295',
		'details_link' => '#'
	),
	array(
		'title' => 'Project Manager',
		'posted_date' => 'Posted 2 Days Ago',
		'location' => 'Riyadh, Saudi Arabia',
		'job_id' => 'ID: 54296',
		'details_link' => '#'
	)
);
$show_load_more = isset( $args['show_load_more'] ) ? $args['show_load_more'] : true;
$listing_type   = isset( $args['listing_type'] ) ? $args['listing_type'] : 'career';
$initial_count  = isset( $args['initial_count'] ) ? max( 1, min( 50, (int) $args['initial_count'] ) ) : 12;
$has_more       = isset( $args['has_more'] ) ? (bool) $args['has_more'] : false;
$load_more_nonce = wp_create_nonce( 'tasheel_load_more_jobs' );
?>
<style>
/* Same layout as .latest_openings_section so main.js does not target this block */
.latest_openings_section_ajax{width:100%;position:relative;}
.latest_openings_section_ajax .latest_openings_section_inner{width:100%;}
.latest_openings_section_ajax .latest_openings_section_inner .latest_openings_list{margin:0;padding:0;display:grid;grid-template-columns:repeat(2,1fr);gap:30px;list-style:none;}
@media (max-width:600px){.latest_openings_section_ajax .latest_openings_section_inner .latest_openings_list{grid-template-columns:1fr;}}
.latest_openings_section_ajax .latest_openings_section_inner .latest_openings_list li{list-style:none;width:100%;}
.latest_openings_section_ajax .opening_block{width:100%;display:flex;flex-wrap:wrap;align-items:flex-end;padding:6%;border:solid 1px #D2D2D2;transition:all .3s ease;position:relative;}
@media (max-width:1200px){.latest_openings_section_ajax .opening_block{flex-direction:column;}}
.latest_openings_section_ajax .opening_block .opening_icon{position:absolute;width:24px;right:31px;top:40px;margin-bottom:20px;display:flex;align-items:center;}
.latest_openings_section_ajax .opening_block .opening_icon img{width:auto;object-fit:contain;}
@media (max-width:768px){.latest_openings_section_ajax .opening_block .opening_icon{margin-bottom:15px;}
.latest_openings_section_ajax .opening_block .opening_icon img{height:40px;}}
.latest_openings_section_ajax .opening_block .opening_content{flex:1;display:flex;flex-direction:column;}
@media (max-width:1200px){.latest_openings_section_ajax .opening_block .opening_content{align-items:flex-start;width:100%;}}
.latest_openings_section_ajax .opening_block .opening_content h3{margin:0 0 8px 0;font-size:30px;font-weight:500;color:#000;font-family:'RB',sans-serif;line-height:100%;}
@media (max-width:768px),(max-width:700px){.latest_openings_section_ajax .opening_block .opening_content h3{font-size:20px;}}
.latest_openings_section_ajax .opening_block .opening_content p{margin:0;}
@media (max-width:768px){.latest_openings_section_ajax .opening_block .opening_content p{font-size:14px;}}
.latest_openings_section_ajax .opening_block .opening_content .opening_posted{font-size:16px;color:#353535;font-family:'RB',sans-serif;margin-bottom:18px;font-weight:400;}
@media (max-width:768px),(max-width:700px){.latest_openings_section_ajax .opening_block .opening_content .opening_posted{font-size:14px;}}
.latest_openings_section_ajax .opening_block .opening_content .opening_location,
.latest_openings_section_ajax .opening_block .opening_content .opening_id{display:flex;align-items:center;gap:25px;font-size:16px;color:#353535;font-weight:400;font-family:'RB',sans-serif;}
@media (max-width:768px){.latest_openings_section_ajax .opening_block .opening_content .opening_location,.latest_openings_section_ajax .opening_block .opening_content .opening_id{font-size:14px;gap:15px;}}
@media (max-width:700px){.latest_openings_section_ajax .opening_block .opening_content .opening_location,.latest_openings_section_ajax .opening_block .opening_content .opening_id{font-size:13px;}}
.latest_openings_section_ajax .opening_block .opening_content .opening_location img,
.latest_openings_section_ajax .opening_block .opening_content .opening_id img{width:24px;height:auto;display:block;object-fit:contain;}
@media (max-width:768px){.latest_openings_section_ajax .opening_block .opening_content .opening_location img,.latest_openings_section_ajax .opening_block .opening_content .opening_id img{width:16px;}}
.latest_openings_section_ajax .opening_block .opening_content .opening_location span,
.latest_openings_section_ajax .opening_block .opening_content .opening_id span{display:inline-block;}
.latest_openings_section_ajax .opening_block .opening_content .opening_id{margin-top:8px;}
@media (min-width:768px){.latest_openings_section_ajax .opening_block .opening_action{margin-left:20px;}}
@media (max-width:767px){.latest_openings_section_ajax .opening_block{flex-direction:column;align-items:flex-start;gap:15px;}
.latest_openings_section_ajax .opening_block .opening_action{width:100%;}
.latest_openings_section_ajax .opening_block .opening_action .job_details_btn{width:100%;justify-content:space-between;}}
.latest_openings_section_ajax .load_more_container{width:100%;display:flex;justify-content:center;margin-top:80px;}
@media (max-width:1024px){.latest_openings_section_ajax .load_more_container{margin-top:60px;}}
@media (max-width:600px){.latest_openings_section_ajax .load_more_container{margin-top:30px;}}
.latest_openings_section_ajax .load_more_container .load_more_btn.loading{opacity:.7;cursor:not-allowed;pointer-events:none;}
</style>

<section class="latest_openings_section_ajax  pb_120" data-listing-type="<?php echo esc_attr( $listing_type ); ?>" data-initial-count="<?php echo esc_attr( $initial_count ); ?>" data-page="1" data-nonce="<?php echo esc_attr( $load_more_nonce ); ?>" data-ajaxurl="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>" data-has-more="<?php echo $has_more ? '1' : '0'; ?>">
	<div class="wrap">
		<div class="latest_openings_section_inner">
			<?php if ( $title || $title_span ) : ?>
				<h4 class="h3_title_50 pb_20">
					<?php if ( $title ) : ?>
						<?php echo esc_html( $title ); ?>
					<?php endif; ?>
					<?php if ( $title_span ) : ?>
						<span><?php echo esc_html( $title_span ); ?></span>
					<?php endif; ?>
				</h4>
			<?php endif; ?>

			<?php if ( ! empty( $openings ) ) : ?>
				<ul class="latest_openings_list" data-openings-list>
					<?php get_template_part( 'template-parts/Latest-Openings-items', null, array( 'openings' => $openings ) ); ?>
				</ul>

				<?php if ( $show_load_more && $has_more ) : ?>
					<div class="load_more_container">
						<button type="button" class="btn_style btn_green load_more_btn" data-load-more><?php echo esc_html__( 'Load more', 'tasheel' ); ?></button>
					</div>
				<?php endif; ?>
			<?php else : ?>
				<p class="latest_openings_empty"><?php echo esc_html__( 'There are no openings in this category at the moment. Please check back later.', 'tasheel' ); ?></p>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php if ( $show_load_more && ! empty( $openings ) ) : ?>
<script>
(function() {
	var sections = document.querySelectorAll('.latest_openings_section_ajax[data-listing-type][data-ajaxurl]');
	sections.forEach(function(section) {
		var list = section.querySelector('[data-openings-list]');
		var btn = section.querySelector('[data-load-more]');
		var hasMore = section.getAttribute('data-has-more') === '1';
		if (!list || !btn || !hasMore) return;
		var page = parseInt(section.getAttribute('data-page') || '1', 10);
		function loadMore() {
			btn.disabled = true;
			btn.textContent = '<?php echo esc_js( __( 'Loading…', 'tasheel' ) ); ?>';
			var formData = new FormData();
			formData.append('action', 'tasheel_load_more_jobs');
			formData.append('nonce', section.getAttribute('data-nonce'));
			formData.append('listing_type', section.getAttribute('data-listing-type'));
			formData.append('per_page', section.getAttribute('data-initial-count'));
			formData.append('page', String(page + 1));
			fetch(section.getAttribute('data-ajaxurl'), { method: 'POST', body: formData, credentials: 'same-origin' })
				.then(function(r) { return r.json(); })
				.then(function(res) {
					if (res.success && res.data && res.data.html) {
						list.insertAdjacentHTML('beforeend', res.data.html);
						page = page + 1;
						section.setAttribute('data-page', String(page));
						if (!res.data.has_more) {
							btn.closest('.load_more_container').style.display = 'none';
						}
					}
				})
				.catch(function() {})
				.finally(function() {
					btn.disabled = false;
					btn.textContent = '<?php echo esc_js( __( 'Load more', 'tasheel' ) ); ?>';
				});
		}
		btn.addEventListener('click', loadMore);
	});
})();
</script>
<?php endif; ?>

