	<article class="our-works block-wide">
		<div class="block-wrap">
<?php load_view('part_h',array(
	'title' => lang('Portfolio'),
	'descr' => lang('Portfolio descr'),
)); ?>	
<<?php 
if(count($portfolio)):
foreach($portfolio as $work):
?>
			<div class="work-one">
				<div class="icon-wrap">
					<div class="icon" style="background-image:url(<?php echo $work->img; ?>);" data-link="<?php echo $work->url; ?>">
						<div class="portfolio-icon-wave">
							<div class="portfolio-wave-title"><?php echo $work->name; ?></div>
						</div>
					</div>
					<div class="icon-wrap-pop-upper"></div>
				</div>
				<div class="work1">
					<h2><?php echo $work->name; ?></h2>
					<div class="hr"></div>
					<h4><?php echo $work->title; ?></h4>
					<div class="more"><div class="arrow">&gt;</div><?php echo lang('More'); ?></div>
				</div>
			</div>
<?php
endforeach;
else:
?>
			<div class="warning-message"><?php echo lang('msg_no_works'); ?></div>
<?php 
endif;
?>
			<div class="wide-empry"></div>
		</div>
	</article>
	<script src="<?php echo get_config_item('base_url'); ?>js/our-works.js"></script>