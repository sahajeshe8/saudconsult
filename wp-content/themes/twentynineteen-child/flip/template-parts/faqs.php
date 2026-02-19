	<?php if( have_rows('faqs') ): ?>
		<section class="single-faqs-sec">
			<div class="container">
				<div class="single-faqs-inner">
					<?php if( !empty( get_field('faq_title') ) ){ ?><h3><?php the_field('faq_title'); ?></h3><?php } ?>
					<?php while( have_rows('faqs') ): the_row();  ?>
						<div class="accordion-panel">
							<div class="accordion__header">
								<h6><?php the_sub_field('faq_question'); ?></h6>
								<i class="fa-solid fa-caret-down arrow-view"></i>
							</div>
							<div class="accordion__body animated">
								<?php the_sub_field('faq_answer'); ?>
							</div>
						</div>
					<?php endwhile; ?>

				</div>
			</div>
		</section>
	<?php endif; ?>

