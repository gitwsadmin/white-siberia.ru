<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?><?$this->setFrameMode(true);?>
<?
$templateData = array(
	'MAP_ITEMS' => $arResult['MAP_ITEMS']
);
?>
<?if($arResult['ITEMS']):?>
	<div class="content_wrapper_block map_type_3 <?=$templateName;?>">
		<div class="maxwidth-theme mwnew">
			<div class="top_block" <?=($nCountItems == 1 ? "style='display:none;'" : "")?>>
				<h3><?=CMax::showIconSvg("forh1", SITE_TEMPLATE_PATH.'/images/svg/forh1.svg');?>Контакты</h3>
				<a href="<?=SITE_DIR.$arParams['ALL_URL'];?>" class="pull-right font_upper muted"><?=$arParams['TITLE_BLOCK_ALL'] ;?></a>
			</div>
				<div class="wrapper_block with_title title_right">
				<?$nCountItems = count($arResult['ITEMS']);?>
				<div class="block_container <?=($nCountItems == 1 ? 'one' : '');?>">
					<div class="block_container_inner">
						<?if($arParams['TITLE_BLOCK'] || $arParams['TITLE_BLOCK_ALL']):?>
							
						<?endif;?>
						<div class="detail_items scrollblock" <?=($nCountItems == 1 ? "style='display:block;'" : "")?>>
							<?foreach($arResult['ITEMS'] as $arItem):?>
								<div class="item" <?=($nCountItems == 1 ? "style='display:block;'" : "")?> data-coordinates="<?=$arItem['DISPLAY_PROPERTIES']['MAP']['VALUE'];?>" data-id="<?=$arItem['ID']?>">
									<div class="big_info">
										<?=CMax::prepareItemMapHtml($arItem, "N", $arParams, "Y");?>
									</div>
									<div class="buttons_block">
										<div class="animate-load f_btn_mail" data-event="jqm" data-param-form_id="ASK" data-name="question"><?=CMax::showIconSvg("mailto", SITE_TEMPLATE_PATH.'/images/svg/mailto.svg');?>
										</div>
									</div>
								</div>
							<?endforeach;?>
						</div>
					</div>
				</div>
			</div>
<?endif;?>