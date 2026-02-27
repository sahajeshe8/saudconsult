<?php
/**
 * Insights & Resources Section Component Template
 *
 * @package tasheel
 */

// Extract data from args array passed from get_template_part()
$args = isset($args) ? $args : array();

// Set default values or use passed values
$label = isset($args['label']) ? $args['label'] : esc_html__('Insights & Resources', 'tasheel');
$title = isset($args['title']) ? $args['title'] : esc_html__('Elevate Your', 'tasheel');
$title_span = isset($args['title_span']) ? $args['title_span'] : esc_html__('Understanding', 'tasheel');
$title_break = isset($args['title_break']) ? $args['title_break'] : true;
$section_class = isset($args['section_class']) ? $args['section_class'] : '';
$show_view_all_button = isset($args['show_view_all_button']) ? $args['show_view_all_button'] : false;
$view_all_url = isset($args['view_all_url']) ? $args['view_all_url'] : home_url('/news');
$insights = isset($args['insights']) && is_array($args['insights']) ? $args['insights'] : array();

$news_detail_page = get_page_by_path('news-detail');
$news_detail_url = $news_detail_page ? get_permalink($news_detail_page->ID) : home_url('/news-detail');

if ( empty( $insights ) ) {
	$insights = array(
		array( 'image' => get_template_directory_uri() . '/assets/images/news-01.jpg', 'date_label' => '05 August 2025', 'title' => "Saud Consult Secures Design Contract for Jeddah's New Central Utility Plant.", 'category_label' => esc_html__( 'Latest News', 'tasheel' ), 'link' => $news_detail_url ),
		array( 'image' => get_template_directory_uri() . '/assets/images/news-02.jpg', 'date_label' => '05 August 2025', 'title' => "Saud Consult Secures Design Contract for Jeddah's New Central Utility Plant.", 'category_label' => esc_html__( 'Latest News', 'tasheel' ), 'link' => $news_detail_url ),
		array( 'image' => get_template_directory_uri() . '/assets/images/news-03.jpg', 'date_label' => '05 August 2025', 'title' => "Saud Consult Secures Design Contract for Jeddah's New Central Utility Plant.", 'category_label' => esc_html__( 'Latest News', 'tasheel' ), 'link' => $news_detail_url ),
		array( 'image' => get_template_directory_uri() . '/assets/images/news-04.jpg', 'date_label' => '05 August 2025', 'title' => "Saud Consult Secures Design Contract for Jeddah's New Central Utility Plant.", 'category_label' => esc_html__( 'Latest News', 'tasheel' ), 'link' => $news_detail_url ),
		array( 'image' => get_template_directory_uri() . '/assets/images/news-02.jpg', 'date_label' => '05 August 2025', 'title' => "Saud Consult Secures Design Contract for Jeddah's New Central Utility Plant.", 'category_label' => esc_html__( 'Latest News', 'tasheel' ), 'link' => $news_detail_url ),
	);
}

?>

<section class="insights_resources_section pt_100 pb_100 mobile_padding <?php echo esc_attr($section_class); ?>">
    <div class="wrap">
        <?php if (!empty($label)): ?>
            <span class="lable_text green_text">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/dot-02.svg"
                    alt="<?php echo esc_attr($label); ?>">
                <?php echo esc_html($label); ?>
            </span>
        <?php endif; ?>

        <div class="insights_section_header ">
            <div class="insights_section_header_left">
                <h3 class="h3_title_50">

                    <?php echo esc_html($title); ?><?php if ($title_break): ?><br><?php endif; ?><?php if ($title_span): ?><span><?php echo esc_html($title_span); ?></span><?php endif; ?>
                </h3>
            </div>




            <div class="slider_arrow_block pb_0 <?php echo $show_view_all_button ? 'hidden-navigation' : ''; ?>">
                <span class="slider_buttion but_next news_but_next">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/slider-arrow.svg"
                        alt="Next Project">
                </span>
                <span class="slider_buttion but_prev news_but_prev">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/slider-arrow.svg"
                        alt="Previous Project">
                </span>
            </div>
            <?php if ($show_view_all_button): ?>
                <div class="view-all-button-wrapper view-all-button-wrapper--top mobile_hide">
                    <a href="<?php echo esc_url($view_all_url); ?>" class="btn_style but_black">
                        <?php echo esc_html__( 'View All', 'tasheel' ); ?>
                    </a>
                </div>
            <?php endif; ?>



        </div>


        <div class="insights_section_content" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
            <div class="swiper mySwiper-insights">
                <div class="swiper-wrapper">
                    <?php
                    $delay = 300;
                    foreach ( $insights as $item ) :
                        $item_img = isset( $item['image'] ) ? $item['image'] : get_template_directory_uri() . '/assets/images/news-01.jpg';
                        $item_date = isset( $item['date_label'] ) ? $item['date_label'] : '';
                        $item_title = isset( $item['title'] ) ? $item['title'] : '';
                        $item_cat = isset( $item['category_label'] ) ? $item['category_label'] : esc_html__( 'Latest News', 'tasheel' );
                        $item_link = isset( $item['link'] ) ? esc_url( $item['link'] ) : $news_detail_url;
                    ?>
                    <div class="swiper-slide" data-aos="fade-up" data-aos-duration="800" data-aos-delay="<?php echo esc_attr( $delay ); ?>">
                        <a href="<?php echo $item_link; ?>" class="insights_item">
                            <div class="insights_item_image">
                                <?php if ( $item_date ) : ?><span class="latest_news_lable"><?php echo esc_html( $item_date ); ?></span><?php endif; ?>
                                <img src="<?php echo esc_url( $item_img ); ?>" alt="<?php echo esc_attr( $item_title ?: 'Insight' ); ?>">
                            </div>
                            <div class="insights_item_content">
                                <?php if ( $item_title ) : ?><h4><?php echo esc_html( $item_title ); ?></h4><?php endif; ?>
                                <span class="latest_news_text_lable"><?php echo esc_html( $item_cat ); ?></span>
                            </div>
                        </a>
                    </div>
                    <?php $delay += 100; endforeach; ?>
                </div>
                <div class="swiper-pagination"></div>
            </div>
            <?php if ($show_view_all_button): ?>
                <div class="view-all-button-wrapper view-all-button-wrapper--bottom mobile_show mt_30">
                    <a href="<?php echo esc_url($view_all_url); ?>" class="btn_style but_black w_100">
                        <?php echo esc_html__( 'View All', 'tasheel' ); ?>
                        <span>
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/buttion-arrow.svg" alt="View All">
                        </span>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

</section>