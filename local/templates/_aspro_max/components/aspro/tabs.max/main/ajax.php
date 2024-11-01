<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
/** @global CDatabase $DB */

$this->setFrameMode(true);

$class_block="s_".$this->randString();

$arTab=array();
$arParams["DISPLAY_BOTTOM_PAGER"] = "Y";
$arParams['SET_TITLE'] = 'N';
$arTmp = reset($arResult["TABS"]);
$arParams["FILTER_HIT_PROP"] = $arTmp["CODE"];
$arParamsTmp = urlencode(serialize($arParams));

if($arResult["SHOW_SLIDER_PROP"]):?>
	<div class="content_wrapper_block <?=$templateName;?>">
		<div class="maxwidth-theme">
			<div class="tab_slider_wrapp specials <?=$class_block;?> best_block clearfix" itemscope itemtype="http://schema.org/WebPage">
				<span class='request-data' data-value='<?=$arParamsTmp?>'></span>
				<div class="top_block">
					<?if($arParams['TITLE_BLOCK']):?>
						<h3 class="pull-left"><i class="svg inline  svg-inline-forh1" aria-hidden="true"><svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg"><path opacity="0.5" d="M15.9622 0H11.7494C10.8047 0 9.96248 0.596021 9.64888 1.48727L2.78015 21H6.99296C7.93768 21 8.77991 20.404 9.09352 19.5127L15.9622 0Z" fill="#F5333F"></path><path opacity="0.25" d="M15.54 0H8.96873C8.02401 0 7.18178 0.596021 6.86817 1.48727L0 21H8.14822L15.54 0Z" fill="#F5333F"></path><path d="M19.003 0H14.7902C13.8455 0 13.0033 0.596021 12.6896 1.48727L5.82092 21H10.0337C10.9785 21 11.8207 20.404 12.1343 19.5127L19.003 0Z" fill="#F5333F"></path></svg>
				</i><?=$arParams['TITLE_BLOCK'];?></h3>
					<?endif;?>
					<div class="right_block_wrapper">
						<div class="tabs_wrapper <?=$arParams['TITLE_BLOCK_ALL'] && $arParams['ALL_URL'] ? 'with_link' : ''?>">
							<ul class="tabs ajax">
								<?$i=1;
								foreach($arResult["TABS"] as $code => $arTab):?>
									<li data-code="<?=$code?>" class="font_xs <?=($i==1 ? "cur clicked" : "")?>"><span class="muted777"><?=$arTab["TITLE"];?></span></li>
									<?$i++;?>
								<?endforeach;?>
							</ul>
						</div>
						<?if($arParams['TITLE_BLOCK_ALL'] && $arParams['ALL_URL']):?>
							<a href="<?=$arParams['ALL_URL'];?>" class="font_upper muted"><?=$arParams['TITLE_BLOCK_ALL'];?></a>
						<?endif;?>
					</div>
				</div>
				<ul class="tabs_content">
					<?$j=1;?>
					<?foreach($arResult["TABS"] as $code => $arTab):?>
						<li class="tab <?=$code?>_wrapp <?=($j == 1 ? "cur opacity1" : "");?>" data-code="<?=$code?>" data-filter="<?=($arTab["FILTER"] ? urlencode(serialize($arTab["FILTER"])) : '');?>">
							<div class="tabs_slider <?=$code?>_slides wr">
								<?if(strtolower($_REQUEST['ajax']) == 'y')
									$APPLICATION->RestartBuffer();?>
								<?if($j++ == 1)
								{
									if($arTab["FILTER"])
										$GLOBALS[$arParams["FILTER_NAME"]] = $arTab["FILTER"];

									include(str_replace("//", "/", $_SERVER["DOCUMENT_ROOT"].SITE_DIR."include/mainpage/comp_catalog_ajax.php"));
								}?>
								<?if(strtolower($_REQUEST['ajax']) == 'y')
									CMax::checkRestartBuffer(true, 'catalog_tab');?>
							</div>
						</li>
					<?endforeach;?>
				</ul>
			</div>
		</div>
	</div>
	<script>try{window.tabsInitOnReady();}catch{}</script>
<?endif;?>