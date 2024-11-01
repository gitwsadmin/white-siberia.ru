 <?global $APPLICATION, $arRegion, $arSite, $arTheme, $bIndexBot, $is404, $isForm, $isIndex;?>
<?if(!$is404 && !$isForm && !$isIndex):?>
<?$APPLICATION->ShowViewContent('section_bnr_content');?>
	<?if($APPLICATION->GetProperty("HIDETITLE") !== 'Y'):?>
		<!--title_content-->
<? if ($APPLICATION->GetCurPage(false) == '/blog/') : ?>
		<div class="maxwidth-theme only-on-front mwnew">
			<?$APPLICATION->IncludeComponent(
			"bitrix:breadcrumb","",Array(
				"START_FROM" => "0", 
				"PATH" => "", 
				"SITE_ID" => "s1" 
			)
			);?>

			<div class="top-block title">											
						<h1 id="pagetitle"><i class="svg inline  svg-inline-forh1" aria-hidden="true">
					<svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path opacity="0.5" d="M15.9622 0H11.7494C10.8047 0 9.96248 0.596021 9.64888 1.48727L2.78015 21H6.99296C7.93768 21 8.77991 20.404 9.09352 19.5127L15.9622 0Z" fill="#F5333F"></path>
						<path opacity="0.25" d="M15.54 0H8.96873C8.02401 0 7.18178 0.596021 6.86817 1.48727L0 21H8.14822L15.54 0Z" fill="#F5333F"></path>
						<path d="M19.003 0H14.7902C13.8455 0 13.0033 0.596021 12.6896 1.48727L5.82092 21H10.0337C10.9785 21 11.8207 20.404 12.1343 19.5127L19.003 0Z" fill="#F5333F"></path>
					</svg>
							</i><? if ($APPLICATION->GetCurPage(false) == '/blog/') : ?><?$APPLICATION->ShowTitle(false);?> - <span id="h1subtitle" class="h1subtitle">.</span><?else:?> Блог - <span id="h1subtitle" class="h1subtitle"></span><? endif; ?></h1>
			</div>


		</div>
<?else:?>
<div class="maxwidth-theme only-on-front mwnew">
				<?$APPLICATION->IncludeComponent(
				"bitrix:breadcrumb","",Array(
					"START_FROM" => "0", 
					"PATH" => "", 
					"SITE_ID" => "s1" 
				)
				);?>
			<div class="top-block title">											
						<h1 id="pagetitle"><i class="svg inline  svg-inline-forh1" aria-hidden="true">
					<svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path opacity="0.5" d="M15.9622 0H11.7494C10.8047 0 9.96248 0.596021 9.64888 1.48727L2.78015 21H6.99296C7.93768 21 8.77991 20.404 9.09352 19.5127L15.9622 0Z" fill="#F5333F"></path>
						<path opacity="0.25" d="M15.54 0H8.96873C8.02401 0 7.18178 0.596021 6.86817 1.48727L0 21H8.14822L15.54 0Z" fill="#F5333F"></path>
						<path d="M19.003 0H14.7902C13.8455 0 13.0033 0.596021 12.6896 1.48727L5.82092 21H10.0337C10.9785 21 11.8207 20.404 12.1343 19.5127L19.003 0Z" fill="#F5333F"></path>
					</svg>
							</i><?$APPLICATION->ShowTitle(false);?> </h1>
					
			</div>
		</div>
<?endif;?>
		<!--end-title_content-->
	<?endif;?>
	<?$APPLICATION->ShowViewContent('top_section_filter_content');?>
<?endif;?>
<?include_once('top_wraps_custom.php');?>