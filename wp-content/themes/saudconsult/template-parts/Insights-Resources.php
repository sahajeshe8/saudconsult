<?php
/**
 * Insights & Resources Section Component Template
 *
 * @package tasheel
 */

// Extract data from args array passed from get_template_part()
$args = isset($args) ? $args : array();

// Set default values or use passed values
$label = isset($args['label']) ? $args['label'] : 'Insights & Resources';
$title = isset($args['title']) ? $args['title'] : 'Elevate Your';
$title_span = isset($args['title_span']) ? $args['title_span'] : 'Understanding';
$title_break = isset($args['title_break']) ? $args['title_break'] : true; // Whether to add <br> before span
$section_class = isset($args['section_class']) ? $args['section_class'] : '';
$show_view_all_button = isset($args['show_view_all_button']) ? $args['show_view_all_button'] : false;
$view_all_url = isset($args['view_all_url']) ? $args['view_all_url'] : home_url('/news');

// Get news detail page URL
$news_detail_page = get_page_by_path('news-detail');
$news_detail_url = $news_detail_page ? get_permalink($news_detail_page->ID) : home_url('/news-detail');

?>

<section class="insights_resources_section pt_100 pb_100 <?php echo esc_attr($section_class); ?>">
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
                <div class="view-all-button-wrapper">
                    <a href="<?php echo esc_url($view_all_url); ?>" class="btn_style but_black">
                        View All
                    </a>
                </div>
            <?php endif; ?>



        </div>


        <div class="insights_section_content" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
            <div class="swiper mySwiper-insights">
                <div class="swiper-wrapper">
                    <div class="swiper-slide" data-aos="fade-up" data-aos-duration="800" data-aos-delay="300">
                        <a href="<?php echo esc_url($news_detail_url); ?>" class="insights_item">
                            <div class="insights_item_image">
                                <span class="latest_news_lable">
                                    05 August 2025
                                </span>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/news-01.jpg"
                                    alt="Insight">
                            </div>
                            <div class="insights_item_content">
                                <h4>Saud Consult Secures Design Contract for Jeddah's New Central Utility Plant. </h4>
                                <span class="latest_news_text_lable">Latest News</span>
                            </div>
                        </a>
                    </div>



                    <div class="swiper-slide" data-aos="fade-up" data-aos-duration="800" data-aos-delay="400">
                        <a href="<?php echo esc_url($news_detail_url); ?>" class="insights_item">
                            <div class="insights_item_image">
                                <span class="latest_news_lable">
                                    05 August 2025
                                </span>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/news-02.jpg"
                                    alt="Insight">
                            </div>
                            <div class="insights_item_content">
                                <h4>Saud Consult Secures Design Contract for Jeddah's New Central Utility Plant. </h4>
                                <span class="latest_news_text_lable">Latest News</span>
                            </div>
                        </a>
                    </div>

                    <div class="swiper-slide" data-aos="fade-up" data-aos-duration="800" data-aos-delay="500">
                        <a href="<?php echo esc_url($news_detail_url); ?>" class="insights_item">
                            <div class="insights_item_image">
                                <span class="latest_news_lable">
                                    05 August 2025
                                </span>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/news-03.jpg"
                                    alt="Insight">
                            </div>
                            <div class="insights_item_content">
                                <h4>Saud Consult Secures Design Contract for Jeddah's New Central Utility Plant. </h4>
                                <span class="latest_news_text_lable">Latest News</span>
                            </div>
                        </a>
                    </div>

                    <div class="swiper-slide" data-aos="fade-up" data-aos-duration="800" data-aos-delay="600">
                        <a href="<?php echo esc_url($news_detail_url); ?>" class="insights_item">
                            <div class="insights_item_image">
                                <span class="latest_news_lable">
                                    05 August 2025
                                </span>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/news-04.jpg"
                                    alt="Insight">
                            </div>
                            <div class="insights_item_content">
                                <h4>Saud Consult Secures Design Contract for Jeddah's New Central Utility Plant. </h4>
                                <span class="latest_news_text_lable">Latest News</span>
                            </div>
                        </a>
                    </div>
                    <div class="swiper-slide" data-aos="fade-up" data-aos-duration="800" data-aos-delay="700">
                        <a href="<?php echo esc_url($news_detail_url); ?>" class="insights_item">
                            <div class="insights_item_image">
                                <span class="latest_news_lable">
                                    05 August 2025
                                </span>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/news-02.jpg"
                                    alt="Insight">
                            </div>
                            <div class="insights_item_content">
                                <h4>Saud Consult Secures Design Contract for Jeddah's New Central Utility Plant. </h4>
                                <span class="latest_news_text_lable">Latest News</span>
                            </div>
                        </a>
                    </div>

                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>

</section>