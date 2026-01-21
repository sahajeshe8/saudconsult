<?php
/**
 * Events List Component Template
 *
 * Events list section for Media Center page
 *
 * @package tasheel
 */

// Extract data from args array passed from get_template_part()
$args = isset( $args ) ? $args : array();

// Set default values or use passed values
$title = isset( $args['title'] ) ? $args['title'] : '';
$title_span = isset( $args['title_span'] ) ? $args['title_span'] : '';

// Handle section wrapper classes - can be array or string
$section_wrapper_class = isset( $args['section_wrapper_class'] ) ? $args['section_wrapper_class'] : array();
if ( is_array( $section_wrapper_class ) ) {
	$section_wrapper_class = ! empty( $section_wrapper_class ) ? implode( ' ', array_map( 'esc_attr', $section_wrapper_class ) ) : '';
} else {
	$section_wrapper_class = esc_attr( $section_wrapper_class );
}

$section_class = isset( $args['section_class'] ) ? $args['section_class'] : '';
?>

<div style="background:  #272A2A url(<?php echo esc_url( get_template_directory_uri() . '/assets/images/event-bg.svg' ) ; ?>) no-repeat left top;  " class="pt_100 pb_100 events_list_section <?php echo esc_attr( $section_class ); ?> <?php echo $section_wrapper_class; ?>">
	<div class="events_list_wrapper">
		<div class="wrap">
			<?php if ( $title || $title_span ) : ?>
				<div class="title_block">
					<div class="title_block_left">
						<h3 class="h3_title_50 white_txt">
							<?php if ( $title ) : ?>
								<?php echo esc_html( $title ); ?>
							<?php endif; ?>
							<?php if ( $title_span ) : ?>
								<span><?php echo esc_html( $title_span ); ?></span>
							<?php endif; ?>
						</h3>
					</div>
					<div class="title_block_right">
						<a class="btn_style btn_transparent btn_green" href="#">
							View all
							<span><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/buttion-arrow.svg' ); ?>" alt="View All Events"></span>
						</a>
					</div>
				</div>
			<?php endif; ?>

		

			<div class="events_list_pagination">
				<!-- Pagination will be added here -->
			</div>
		</div>
	</div>

			<div class="events_list_content pt_50">
				<div class="events_list_container">
					<ul class="events_list_ul">
						<li>
							<a href="#">
								<div class="events_list_item">
									<span class="events_list_item_date">30 <span>Jun</span></span>
									<div class="events_list_item_image">
										<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/event-img-01.jpg' ); ?>" alt="Events">
									</div>
									<div class="events_list_item_content">
										<h4>Contracts awarded to Saudi consulting services company (Saudconsult)</h4>
										<ul class="events_detail_list">
											<li>
												<span class="events_detail_list_item_icon">
													<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/time-icn.svg' ); ?>" alt="Time">
												</span>
												<span class="events_detail_list_item_text">3:00 PM – 4:00 PM</span>
											</li>
											<li>
												<span class="events_detail_list_item_icon">
													<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/mark-icn.svg' ); ?>" alt="Location">
												</span>
												<span class="events_detail_list_item_text">Riyadh, KSA</span>
											</li>
										</ul>
									</div>
								</div>
							</a>
						</li>

						<li>

                        <a href="#">
							<div class="events_list_item">
								<span class="events_list_item_date">30 <span>Jun</span></span>
								<div class="events_list_item_image">
									<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/event-img-02.jpg' ); ?>" alt="Events">
								</div>
								<div class="events_list_item_content">
									<h4>Tour of the exhibition hall with Eng.Faisal AlShawaf and the SCE board</h4>
									<ul class="events_detail_list">
										<li>
											<span class="events_detail_list_item_icon">
												<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/time-icn.svg' ); ?>" alt="Time">
											</span>
											<span class="events_detail_list_item_text">3:00 PM – 4:00 PM</span>
										</li>
										<li>
											<span class="events_detail_list_item_icon">
												<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/mark-icn.svg' ); ?>" alt="Location">
											</span>
											<span class="events_detail_list_item_text">Riyadh, KSA</span>
										</li>
									</ul>
								</div>
							</div>
                            </a>
						</li>

						<li>
							<a href="#">
								<div class="events_list_item">
									<span class="events_list_item_date">30 <span>Jun</span></span>
									<div class="events_list_item_image">
										<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/event-img-03.jpg' ); ?>" alt="Events">
									</div>
									<div class="events_list_item_content">
										<h4>Eng. Fahad AlTamimi receiving the award for SC's participation and sponsorship</h4>
										<ul class="events_detail_list">
											<li>
												<span class="events_detail_list_item_icon">
													<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/time-icn.svg' ); ?>" alt="Time">
												</span>
												<span class="events_detail_list_item_text">3:00 PM – 4:00 PM</span>
											</li>
											<li>
												<span class="events_detail_list_item_icon">
													<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/mark-icn.svg' ); ?>" alt="Location">
												</span>
												<span class="events_detail_list_item_text">Riyadh, KSA</span>
											</li>
										</ul>
									</div>
								</div>
							</a>
						</li>

						<li>
							<a href="#">
								<div class="events_list_item">
									<span class="events_list_item_date">30 <span>Jun</span></span>
									<div class="events_list_item_image">
										<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/event-img-04.jpg' ); ?>" alt="Events">
									</div>
									<div class="events_list_item_content">
										<h4>SAUDCONSULT is signing a memorandum of understanding with the Ministry</h4>
										<ul class="events_detail_list">
											<li>
												<span class="events_detail_list_item_icon">
													<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/time-icn.svg' ); ?>" alt="Time">
												</span>
												<span class="events_detail_list_item_text">3:00 PM – 4:00 PM</span>
											</li>
											<li>
												<span class="events_detail_list_item_icon">
													<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/mark-icn.svg' ); ?>" alt="Location">
												</span>
												<span class="events_detail_list_item_text">Riyadh, KSA</span>
											</li>
										</ul>
									</div>
								</div>
							</a>
						</li>

						<li>
							<a href="#">
								<div class="events_list_item">
									<span class="events_list_item_date">30 <span>Jun</span></span>
									<div class="events_list_item_image">
										<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/event-img-05.jpg' ); ?>" alt="Events">
									</div>
									<div class="events_list_item_content">
										<h4>SAUDCONSULT at the World Stadiums and Arenas Summit</h4>
										<ul class="events_detail_list">
											<li>
												<span class="events_detail_list_item_icon">
													<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/time-icn.svg' ); ?>" alt="Time">
												</span>
												<span class="events_detail_list_item_text">3:00 PM – 4:00 PM</span>
											</li>
											<li>
												<span class="events_detail_list_item_icon">
													<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/mark-icn.svg' ); ?>" alt="Location">
												</span>
												<span class="events_detail_list_item_text">Riyadh, KSA</span>
											</li>
										</ul>
									</div>
								</div>
							</a>
						</li>

						<li>
							<a href="#">
								<div class="events_list_item">
									<span class="events_list_item_date">30 <span>Jun</span></span>
									<div class="events_list_item_image">
										<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/event-img-06.jpg' ); ?>" alt="Events">
									</div>
									<div class="events_list_item_content">
										<h4>Saudi Consulting Services Engineering Consultancy Company (SaudConsult) was honored</h4>
										<ul class="events_detail_list">
											<li>
												<span class="events_detail_list_item_icon">
													<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/time-icn.svg' ); ?>" alt="Time">
												</span>
												<span class="events_detail_list_item_text">3:00 PM – 4:00 PM</span>
											</li>
											<li>
												<span class="events_detail_list_item_icon">
													<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/mark-icn.svg' ); ?>" alt="Location">
												</span>
												<span class="events_detail_list_item_text">Riyadh, KSA</span>
											</li>
										</ul>
									</div>
								</div>
							</a>
						</li>

						<li>
							<a href="#">
								<div class="events_list_item">
									<span class="events_list_item_date">30 <span>Jun</span></span>
									<div class="events_list_item_image">
										<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/event-img-07.jpg' ); ?>" alt="Events">
									</div>
									<div class="events_list_item_content">
										<h4>#SAUDCONSULT is a proud participant in the World Stadiums and Arenas exhibition</h4>
										<ul class="events_detail_list">
											<li>
												<span class="events_detail_list_item_icon">
													<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/time-icn.svg' ); ?>" alt="Time">
												</span>
												<span class="events_detail_list_item_text">3:00 PM – 4:00 PM</span>
											</li>
											<li>
												<span class="events_detail_list_item_icon">
													<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/mark-icn.svg' ); ?>" alt="Location">
												</span>
												<span class="events_detail_list_item_text">Riyadh, KSA</span>
											</li>
										</ul>
									</div>
								</div>
							</a>
						</li>

						<li>
							<a href="#">
								<div class="events_list_item">
									<span class="events_list_item_date">30 <span>Jun</span></span>
									<div class="events_list_item_image">
										<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/event-img-08.jpg' ); ?>" alt="Events">
									</div>
									<div class="events_list_item_content">
										<h4>SCE board Awards Dr. Eng. Tariq AlShawaf</h4>
										<ul class="events_detail_list">
											<li>
												<span class="events_detail_list_item_icon">
													<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/time-icn.svg' ); ?>" alt="Time">
												</span>
												<span class="events_detail_list_item_text">3:00 PM – 4:00 PM</span>
											</li>
											<li>
												<span class="events_detail_list_item_icon">
													<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/mark-icn.svg' ); ?>" alt="Location">
												</span>
												<span class="events_detail_list_item_text">Riyadh, KSA</span>
											</li>
										</ul>
									</div>
								</div>
							</a>
						</li>
					</ul>
				</div>
			</div>





                            </div>

