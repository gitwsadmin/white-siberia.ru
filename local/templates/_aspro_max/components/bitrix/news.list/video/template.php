<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if($arResult["ITEMS"]):?>
    <div class="drag-block container VIDEO_SECTIONS js-load-block loader_circle" data-class="video_sections_drag" data-order="4">
		<div class="content_wrapper_block front_sections_only">
			<div class="maxwidth-theme">
				<div class="sections_wrapper type1 normal">
					<div class="top_block">
						<h3>Видеоролики</h3>
						<a target="_blank" href="https://www.youtube.com/channel/UCLMxls9urKSgQdE7setOt9w" class="pull-right font_upper muted">Наш YouTube</a>
					</div>
					<div class="owl-carousel owl-theme owl-bg-nav video-slider loading_state short-nav hidden-dots visible-nav swipeignore" 
						data-plugin-options='{"nav": true, "dots": false, "loop": false, "marginMove": true, "autoplay": false, "smartSpeed": 600, "useCSS": true, "responsive": {"0":{"items": 1, "lightDrag": true, "margin":30}, "768":{"items": 2, "autoWidth": false, "lightDrag": false, "margin":30}, "1200":{"items": 3, "margin":30}}}'
					>
					<?foreach($arResult["ITEMS"] as $arItem):?>
						<div class="video__item js-play" data-video="<?=$arItem["VIDEO"]?>" data-lazyload>
							<div 
								class="video__preview darken-bg-animate lazy"
								style="background-image: url('<?=SITE_TEMPLATE_PATH?>/images/loaders/double_ring.svg')"
								data-src="//img.youtube.com/vi/<?=$arItem["VIDEO"]?>/hqdefault.jpg"
								data-bg="//img.youtube.com/vi/<?=$arItem["VIDEO"]?>/hqdefault.jpg"
							>
								<div class="video__button">
									<i class="fa fa-play-circle video__button-icon"></i>
								</div>
								<div class="video__title"><?=$arItem["NAME"]?></div>
							</div>
							<div class="video__frame" id="<?=$arItem["VIDEO"]?>"></div>
						</div>
					<?endforeach?>
					</div>

				</div>
			</div>
		</div>
	</div>	
<?endif?>