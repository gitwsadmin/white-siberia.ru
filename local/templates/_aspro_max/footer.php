

					<? if(CSite::InDir('/blog/')) : ?>
						<div class="banner_wrapp">
							<div class="right_sotial">
								<div class="title_sotial">
									<p>
										Смотрите обзоры и новости первыми на нашем</br> Youtube-канале
									</p>
									<a href="https://www.youtube.com/channel/UCLMxls9urKSgQdE7setOt9w" target="_blank">Смотреть</a>
								</div>
							</div>
							<div class="left_sotial">
								<div class="title_sotial">
									<p>
								  		 Подписывайтесь на наши соцсети
									</p>
								</div>
<div class="social_icons_blog">
	<ul class="icons_list">
		<li><a href="https://vk.com/ws_electro" target="_blank"><img src="/bitrix/templates/aspro_max/images/icon_blog/vk.png" alt="vk"></a></li>
		<li><a href="https://www.youtube.com/channel/UCLMxls9urKSgQdE7setOt9w" target="_blank"><img src="/bitrix/templates/aspro_max/images/icon_blog/yt.png" alt="youtoobe"</a></li>
		<li><a href="https://api.whatsapp.com/send/?phone=%2B79256555509&text&app_absent=0" target="_blank"><img src="/bitrix/templates/aspro_max/images/icon_blog/ws.png" alt="wathapp"></a></li>
		<li class="zen"><a href="https://zen.yandex.ru/white_siberia" target="_blank"><img src="/bitrix/templates/aspro_max/images/icon_blog/zen.png" alt="Yndexdzen"></a></li>
	</ul>
</div>
							</div>
						</div>
				<? endif; ?> 


						<?CMax::checkRestartBuffer();?>
						<?IncludeTemplateLangFile(__FILE__);?>
							<?if(!$isIndex):?>
									<?if($isHideLeftBlock && !$isWidePage):?>
									</div> <?// .maxwidth-theme?>
								<?endif;?>
								</div> <?// .container?>
							<?else:?>
								<?CMax::ShowPageType('indexblocks');?>
							<?endif;?>


							<?CMax::get_banners_position('CONTENT_BOTTOM');?>
						</div> <?// .middle?>
					<?//if(($isIndex && $isShowIndexLeftBlock) || (!$isIndex && !$isHideLeftBlock) && !$isBlog):?>
					<?if(($isIndex && ($isShowIndexLeftBlock || $bActiveTheme)) || (!$isIndex && !$isHideLeftBlock)):?>
						</div> <?// .right_block?>
						<?if($APPLICATION->GetProperty("HIDE_LEFT_BLOCK") != "Y" && !defined("ERROR_404")):?>
							<?CMax::ShowPageType('left_block');?>
						<?endif;?>
					<?endif;?>
					</div> <?// .container_inner?>
				<?if($isIndex):?>
					</div>
				<?elseif(!$isWidePage):?>
					</div> <?// .wrapper_inner?>
				<?endif;?>



			</div> <?// #content?>
			<?CMax::get_banners_position('FOOTER');?>
		</div><?// .wrapper?>

		<footer id="footer">
			<?include_once(str_replace('//', '/', $_SERVER['DOCUMENT_ROOT'].'/'.SITE_DIR.'include/footer_include/under_footer.php'));?>
			<?include_once(str_replace('//', '/', $_SERVER['DOCUMENT_ROOT'].'/'.SITE_DIR.'include/footer_include/top_footer.php'));?>
		</footer>
		<?include_once(str_replace('//', '/', $_SERVER['DOCUMENT_ROOT'].'/'.SITE_DIR.'include/footer_include/bottom_footer.php'));?>
		<script>
			window.addEventListener('onBitrixLiveChat', function(event){
				var widget = event.detail.widget;
				widget.setOption('checkSameDomain', false);
			});
		</script>
	</body>
</html>