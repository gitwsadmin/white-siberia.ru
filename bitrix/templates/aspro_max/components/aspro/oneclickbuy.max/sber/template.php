<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
	<?if(!$arParams['INLINE_FORM']):?>
		<a class="jqmClose close"><?=CMax::showIconSvg('', SITE_TEMPLATE_PATH.'/images/svg/Close.svg')?></a>
	<?endif;?>
	<div class="form">
		<div class="popup-intro">
			<div class="pop-up-title"><?=GetMessage('FORM_HEADER_CAPTION')?></div>
		</div>
		<div class="form-wr">
			<div class="one_click_buy_result" id="one_click_buy_result">
				<?=CMax::showIconSvg(' colored', SITE_TEMPLATE_PATH.'/images/svg/success.svg');?>
				<div class="result_text">
					<div class="one_click_buy_result_success"><?=GetMessage('ORDER_SUCCESS')?></div>
					<div class="one_click_buy_result_fail"><?=GetMessage('ORDER_ERROR')?></div>
					<div class="one_click_buy_result_text"></div>
				</div>
			</div>
			<form method="post" id="one_click_buy_form" action="<?=$arResult['SCRIPT_PATH']?>/script_sber.php">
				<?foreach($arParams['PROPERTIES'] as $field):
					$class.="inputtext";?>
					<div class="form-control bg">
						<label class="description">
							<?if($field == "COMMENT"):?>
								<?=GetMessage('CAPTION_'.$field)?>
							<?else:?>
								<?=$arResult["PROPS"][$field]["TITLE"];?>
							<?endif;?>
							<?if (in_array($field, $arParams['REQUIRED'])):?><span class="star">*</span><?endif;?>
						</label>
						<?if($field=="PHONE"){
							$class.=" phone";
						}?>
						<?if($field=="COMMENT"):?>
							<textarea name="ONE_CLICK_BUY[<?=$field?>]" id="one_click_buy_id_<?=$field?>" class="<?=$class;?>"></textarea>
						<?else:?>
							<?if($arResult["PROPS"][$field]["TYPE"] == "FILE"):?>
								<div class="files" data-code="<?=$field?>" data-required="<?=(in_array($field, $arParams['REQUIRED']) ? 'Y' : 'N');?>">
									<div class="inner_file">
										<div class="wrapper_file">
											<span class="remove" title="<?=GetMessage("REMOVE_FILE");?>"><i></i></span>
											<input type="file" <?if (in_array($field, $arParams['REQUIRED'])):?>required<?endif;?> name="ONE_CLICK_BUY[<?=$field?>][]">
										</div>
									</div>
								</div>
								<?if($arResult["PROPS"][$field]["MULTIPLE"] == "Y"):?>
									<div class="btn_block_file"><span class="btn btn-default btn-xs"><?=GetMessage("ADD_BTN");?></span></div>
								<?endif;?>
							<?else:?>
								<input type="<?=($field=="EMAIL" ? "email" : ($field=="PHONE" ? "tel" : "text"));?>" name="ONE_CLICK_BUY[<?=$field?>]" value="<?=$value?>" class="<?=$class;?>" id="one_click_buy_id_<?=$field?>" />
							<?endif;?>
						<?endif;?>
					</div>
				<?endforeach;?>
				<?if(\Bitrix\Main\Config\Option::get('aspro.max', 'ONE_CLICK_BUY_CAPTCHA', 'N') == 'Y'):?>
					<div class="form-control captcha-row clearfix">
						<label><span><?=GetMessage("CAPTCHA_LABEL");?><span class="star">*</span></span></label>
						<div class="captcha_image">
							<?$code = htmlspecialcharsbx($APPLICATION->CaptchaGetCode())?>
							<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$code;?>" border="0" data-src="" />
							<input type="hidden" name="captcha_sid" value="<?=$code;?>">
							<div class="captcha_reload"></div>
						</div>
						<div class="captcha_input">
							<input type="text" class="inputtext captcha" name="captcha_word" size="30" maxlength="50" value="" required="" aria-required="true">
						</div>
					</div>
				<?endif;?>
				<?if($arParams["SHOW_LICENCE"] == "Y"):?>
					<div class="form license_form <?=($arParams['SHOW_OFFER'] == 'Y' ? 'w_offer_pub ' : '' )?>">
						<input type="hidden" name="aspro_max_form_validate" />
						<div class="licence_block filter label_block">
							<input type="checkbox" id="licenses_popup_OCB" <?=(COption::GetOptionString("aspro.max", "LICENCE_CHECKED", "N") == "Y" ? "checked" : "");?> name="licenses_popup_OCB" required value="Y">
							<label for="licenses_popup_OCB" class="license">
								<?$APPLICATION->IncludeFile(SITE_DIR."include/licenses_text.php", Array(), Array("MODE" => "html", "NAME" => "LICENSES")); ?>
							</label>
						</div>
					</div>
				<?endif;?>

				<?if($arParams["SHOW_OFFER"] == "Y"):?>
					<div class="form offer_pub_form">
						<div class="offer_block filter label_block">
							<input type="checkbox" id="offer_popup_OCB" <?=(COption::GetOptionString("aspro.max", "OFFER_CHECKED", "N") == "Y" ? "checked" : "");?> name="offer_popup_OCB" required value="Y">
							<label for="offer_popup_OCB" class="offer_pub">
								<?$APPLICATION->IncludeFile(SITE_DIR."include/offer_text.php", Array(), Array("MODE" => "html", "NAME" => "OFFER")); ?>
							</label>
						</div>
					</div>
				<?endif;?>

				<?if($arParams['SHOW_DELIVERY_NOTE'] === 'Y'):?>
					<div class="delivery_note_wrapper">
						<div class="delivery_note">
							<div class="title"><?=GetMessage('DELIVERY_NOTE_TITLE')?></div>
							<?=CMax::showIconSvg('delivery_triangle', SITE_TEMPLATE_PATH.'/images/svg/arrow_catalogcloser.svg')?>
						</div>
						<div class="text" style="display: none;"><?$APPLICATION->IncludeFile(SITE_DIR."include/oneclick_delivery_text.php", Array(), Array("MODE" => "html"));?></div>
					</div>
				<?endif;?>

				<div class="but-r clearfix">
					<!--noindex-->
						<button class="btn btn-default animate-load" type="submit" id="one_click_buy_form_button" name="one_click_buy_form_button" value="<?=GetMessage('ORDER_BUTTON_CAPTION')?>"><span><?=GetMessage("ORDER_BUTTON_CAPTION")?></span></button>
					<!--/noindex-->
				</div>
				<?if(strlen($arParams['OFFER_PROPERTIES'])):?>
					<input type="hidden" name="OFFER_PROPERTIES" value="<?=$arParams['OFFER_PROPERTIES']?>" />
				<?endif;?>
				<?if(intVal($arParams['IBLOCK_ID'])):?>
					<input type="hidden" name="IBLOCK_ID" value="<?=intVal($arParams['IBLOCK_ID']);?>" />
				<?endif;?>
				<?if(intVal($arParams['ELEMENT_ID'])):?>
					<input type="hidden" name="ELEMENT_ID" value="<?=intVal($arParams['ELEMENT_ID']);?>" />
				<?endif;?>
				<?if((float)($arParams['ELEMENT_QUANTITY'])):?>
					<input type="hidden" name="ELEMENT_QUANTITY" value="<?=(float)($arParams['ELEMENT_QUANTITY']);?>" />
				<?endif;?>
				<?if($arParams['BUY_ALL_BASKET']=="Y"):?>
					<input type="hidden" name="BUY_TYPE" value="ALL" />
				<?endif;?>
				<input type="hidden" name="CURRENCY" value="<?=$arParams['DEFAULT_CURRENCY']?>" />
				<input type="hidden" name="SITE_ID" value="<?=SITE_ID;?>" />
				<input type="hidden" name="PROPERTIES" value='<?=serialize($arParams['PROPERTIES'])?>' />
				<input type="hidden" name="PAY_SYSTEM_ID" value="<?=$arParams['DEFAULT_PAYMENT']?>" />
				<input type="hidden" name="DELIVERY_ID" value="<?=$arParams['DEFAULT_DELIVERY']?>" />
				<input type="hidden" name="PERSON_TYPE_ID" value="<?=$arParams['DEFAULT_PERSON_TYPE']?>" />
				<?=bitrix_sessid_post()?>
			</form>
		</div>
	</div>
<script type="text/javascript">
var ocb_files = [], ocb_files_index = 0, ocbTmpFiles = [];

if(!funcDefined('showOneClickSmsCode')){
	function showOneClickSmsCode(data){
		$form = $('#one_click_buy_form');
		$form.find('.sms_confirm').remove();

		if(data.message.length){
			$('.one_click_buy_result_fail, .one_click_buy_result_success').hide();
			$('.one_click_buy_result').addClass('compact').addClass('alert').addClass('alert-success').removeClass('alert-danger');
			$('.one_click_buy_result_text').html(data.message);
		}
		else{
			$('.one_click_buy_result_success').hide();
			$('.one_click_buy_result_fail').show();
			$('.one_click_buy_result').addClass('compact').addClass('alert').addClass('alert-danger').removeClass('alert-success');
			$('.one_click_buy_result_text').html(data.err);
		}

		$('.one_click_buy_result').show();
		$('#one_click_buy_form_button').removeClass('clicked');

		var rand =  Math.round(1 - 0.5 + Math.random() * 9999);
		var bHideInput = data.ext.WAIT_BEFORE_RESEND > 0;

		$form.append('<div class="sms_confirm"><div class="form-control bg"' + (bHideInput ? ' style="display:none;" ' : '') + '><label class="description"><?=GetMessage('ONE_CLICK_SMS_CODE_LABEL')?><span class="star">*</span></label><input type="text" name="ONE_CLICK_BUY[SMS_CODE]" value="" class="inputtext required" id="one_click_buy_id_SMS_CODE"><input type="hidden" name="ONE_CLICK_BUY[SIGNED_DATA]" value="' + data.ext.SIGNED_DATA + '"></div><div class="but-r clearfix"' + (bHideInput ? ' style="display:none;" ' : '') + '><button class="btn btn-default animate-load" type="submit" id="one_click_buy_form_button_send_sms_code" name="one_click_buy_form_button_send_sms_code" value="<?=GetMessage('ONE_CLICK_SMS_SEND')?>"><span><?=GetMessage('ONE_CLICK_SMS_SEND')?></span></button></div><div id="bx_one_click_register_error' + rand + '"><span class="errortext"></span></div><div id="bx_one_click_register_resend' + rand + '"></div></div>');

		$form.addClass('sms_send');
		$form.closest('.form').removeClass('sending');
		showOneClickBack();
		oneClickReInitCaptcha(data);

		new BX.PhoneAuth({
			containerId: 'bx_one_click_register_resend' + rand + '',
			errorContainerId: 'bx_one_click_register_error' + rand + '',
			interval: data.ext.RESEND_INTERVAL,
			data: {signedData: data.ext.SIGNED_DATA},
			onError:
				function(response){
					$('.one_click_buy_result_success').hide();
					$('.one_click_buy_result').addClass('compact').addClass('alert').addClass('alert-danger').removeClass('alert-success');
					$('.one_click_buy_result, .one_click_buy_result_fail, #one_click_buy_form').show();
					oneClickReInitCaptcha(data);

					var errorDiv = document.getElementsByClassName('one_click_buy_result')[0];
					var errorNode = BX.findChildByClassName(errorDiv, 'one_click_buy_result_fail');
					errorNode.innerHTML = '';
					for(var i = 0; i < response.errors.length; i++){
						errorNode.innerHTML = errorNode.innerHTML + BX.util.htmlspecialchars(response.errors[i].message) + '<br>';
					}
				}
		});

		if(bHideInput){
			setTimeout(function(){
				$('#one_click_buy_form .sms_confirm .form-control.bg,#one_click_buy_form .sms_confirm .but-r').fadeIn();
			}, data.ext.RESEND_INTERVAL * 1000);
		}

		$('#one_click_buy_id_SMS_CODE').focus()
	}
}

if(!funcDefined('oneClickReInitCaptcha')){
	function oneClickReInitCaptcha(data){
		if(typeof data.ext === 'object' && data.ext.captcha_html){
			$('#one_click_buy_form .captcha-row').remove();

			if($('#one_click_buy_form .sms_confirm').length){
				$(data.ext.captcha_html).insertBefore($('#one_click_buy_form .sms_confirm .but-r'));
			}
			else{
				$(data.ext.captcha_html).insertBefore($('#one_click_buy_form .form'));
			}
		}
	}
}

if(!funcDefined('showOneClickBack')){
	function showOneClickBack(bPopup){
		var bPopup =  $('#one_click_buy_form').closest('.popup').length;
		if(!bPopup){
			$('#one_click_inline_back').remove();

			var obUrl = parseUrlQuery();

			// if('path' in obUrl){
			// 	if($('#one_click_buy_form.sms_send').length || $('.one_click_buy_result_fail:visible').length){
			// 		var $lastButton = $('#one_click_buy_form [type=submit]').last();
			// 		$lastButton.css({margin:'0 10px 15px 0'});
			// 		$('<a href="'+decodeURIComponent(obUrl.path)+'" style="vertical-align:top;" class="btn btn-link"><?=GetMessage('ONE_CLICK_BACK')?></a>').insertAfter($lastButton);
			// 	}
			// 	else{
			// 		$('<a href="'+decodeURIComponent(obUrl.path)+'" class="btn btn-default"><?=GetMessage('ONE_CLICK_BACK')?></a>').insertAfter($('#one_click_buy_form'));
			// 		$('.one_click_buy_result').css('margin-bottom', '20px');
			// 	}
			// }

			$('html,body').animate({'scrollTop':0},150);
		}
	}
}

if(!funcDefined('oneClickResultHandler')){
	function oneClickResultHandler(form_url, bPopup, type, data){
		$('.sms_confirm').remove();

		if(data.result == 'Y'){
            if(typeof data.ext === 'object' && data.ext.CODE === 'LINK'){
                location.href = data.ext.VALUE;
            }
			else if(typeof data.ext === 'object' && data.ext.CODE === 'SHOW_SMS_FIELD'){
				showOneClickSmsCode(data);
			}
			else{
				if(arMaxOptions['COUNTERS'][(type == 'basket' ? 'USE_FASTORDER_GOALS' : 'USE_1CLICK_GOALS')] !== 'N'){
					var eventdata = {goal: (type == 'basket' ? 'goal_fastorder_success' : 'goal_1click_success')};
					BX.onCustomEvent('onCounterGoals', [eventdata])
				}

				if(ocb_files.length){
					var obData = new FormData(),
						bHasFiles = false;

					$.each(ocb_files, function(key, value){
						if(value){
							bHasFiles = true;
							obData.append(key+'_'+value.code , value[0]);
						}
					});

					if(bHasFiles){
						$.ajax({
							url: form_url+'?uploadfiles&orderID='+data.message,
							type: 'POST',
							data: obData,
							cache: false,
							dataType: 'json',
							processData: false, // Don't process the files
							contentType: false, // this is string query
							error: function(data, exception){
								$('.one_click_buy_result_success').hide();
								$('.one_click_buy_result').addClass('alert').addClass('alert-danger').removeClass('alert-success').removeClass('compact');
								$('.one_click_buy_result_text').html('Error with files');
								$('.one_click_buy_result, .one_click_buy_result_fail, #one_click_buy_form').show();
								$('#one_click_buy_form_button').removeClass('clicked');
								$('#one_click_buy_form').removeClass('sms_send');
								$('#one_click_buy_form').closest('.form').removeClass('sending');
								showOneClickBack();
								oneClickReInitCaptcha(data);
							},
							success: function(respond, textStatus, jqXHR){
								purchaseCounter(data.message, arMaxOptions["COUNTERS"]["TYPE"][type == 'basket' ? 'QUICK_ORDER' : 'ONE_CLICK']);

								$('.one_click_buy_result_fail, #one_click_buy_form').hide();
								$('.one_click_buy_result').addClass('has_order').addClass('alert').addClass('alert-success').removeClass('alert-danger').removeClass('compact').css('margin-bottom', 0);
								$('.one_click_buy_result_text').html('<?=GetMessage('ONE_CLICK_SUCCESS')?>');
								$('.one_click_buy_result, .one_click_buy_result_success').show();
								$('#one_click_buy_form_button').removeClass('clicked');
								$('#one_click_buy_form').removeClass('sms_send');
								$('#one_click_buy_form').closest('.form').removeClass('sending');
								showOneClickBack();
							}
						});
					}
					else{
						purchaseCounter(data.message, arMaxOptions["COUNTERS"]["TYPE"][type == 'basket' ? 'QUICK_ORDER' : 'ONE_CLICK']);

						$('.one_click_buy_result_fail, #one_click_buy_form').hide();
						$('.one_click_buy_result').addClass('has_order').addClass('alert').addClass('alert-success').removeClass('alert-danger').removeClass('compact').css('margin-bottom', 0);
						$('.one_click_buy_result_text').html('<?=GetMessage('ONE_CLICK_SUCCESS')?>');
						$('.one_click_buy_result, .one_click_buy_result_success').show();
						$('#one_click_buy_form_button').removeClass('clicked');
						$('#one_click_buy_form').removeClass('sms_send');
						$('#one_click_buy_form').closest('.form').removeClass('sending');
						showOneClickBack();
					}
				}
				else{
					purchaseCounter(data.message, arMaxOptions["COUNTERS"]["TYPE"][type == 'basket' ? 'QUICK_ORDER' : 'ONE_CLICK']);

					$('.one_click_buy_result_fail, #one_click_buy_form').hide();
					$('.one_click_buy_result').addClass('has_order').addClass('alert').addClass('alert-success').removeClass('alert-danger').removeClass('compact').css('margin-bottom', 0);
					$('.one_click_buy_result_text').html('<?=GetMessage('ONE_CLICK_SUCCESS')?>');
					$('.one_click_buy_result, .one_click_buy_result_success').show();
					$('#one_click_buy_form_button').removeClass('clicked');
					$('#one_click_buy_form').removeClass('sms_send');
					$('#one_click_buy_form').closest('.form').removeClass('sending');
					showOneClickBack();
				}
			}
		}
		else{
			if(('err' in data) && data.err){
				data.message=data.message+' \n'+data.err;
			}
			$('.one_click_buy_result_success').hide();
			$('.one_click_buy_result').addClass('compact').addClass('alert').addClass('alert-danger').removeClass('alert-success');
			$('.one_click_buy_result_text').html(data.message);
			$('.one_click_buy_result, .one_click_buy_result_fail, #one_click_buy_form').show();
			$('#one_click_buy_form_button').removeClass('clicked');
			$('#one_click_buy_form').removeClass('sms_send');
			$('#one_click_buy_form').closest('.form').removeClass('sending');
			showOneClickBack();
			oneClickReInitCaptcha(data);
		}

		$('.one_click_buy_modules_button', self).removeClass('disabled');
	}
}

if(!funcDefined('oneClickSubmitHandler')){
	function oneClickSubmitHandler(form){
		var bPopup =  $(form).closest('.popup').length;
		var type = $(form).find('input[name=BUY_TYPE]').length && $(form).find('input[name=BUY_TYPE]').val() === 'ALL' ? 'basket' : '1ckick';

		if($(form).valid()){
			if($(form).find('input.error').length || $(form).find('textarea.error').length){
				return false;
			}
			else if(!$('#one_click_buy_form_button').hasClass('clicked') && !$('#one_click_buy_form_button_send_sms_code').hasClass('clicked')){
				$('#one_click_buy_form_button').addClass('clicked');
				$('#one_click_buy_form_button_send_sms_code').addClass('clicked');

				var form_url = $(form).attr('action');
				var bSend = true;
				if(window.renderRecaptchaById && window.asproRecaptcha && window.asproRecaptcha.key){
					if(window.asproRecaptcha.params.recaptchaSize == 'invisible' && typeof grecaptcha != 'undefined' && arMaxOptions.THEME.ONE_CLICK_BUY_CAPTCHA === 'Y'){
						if($(form).find('.g-recaptcha-response').val()){
							// eventdata.form.submit();
							bSend = true;
						}
						else{
							grecaptcha.execute($(form).find('.g-recaptcha').data('widgetid'));
							$('#one_click_buy_form_button').removeClass('clicked');
							$('#one_click_buy_form_button_send_sms_code').removeClass('clicked');
							bSend = false;
						}
					}
				}

				if(bSend){
					$(form).closest('.form').addClass('sending');
					$.ajax({
						url: form_url,
						data: $(form).serialize(),
						type: 'POST',
						dataType: 'json',
						error: function(data) {
							oneClickResultHandler(form_url, bPopup, type, {result: 'N', message: '', err: '<?=GetMessage('ONE_CLICK_REQUEST_ERROR')?>'});
						},
						success: function(data) {
							oneClickResultHandler(form_url, bPopup, type, data);
						}
					});
				}
			}
		}

		return false;
	}
}

// unbind all handlers in custom templates
$('#one_click_buy_form').unbind();

$('#one_click_buy_form').validate({
	rules: {
	"ONE_CLICK_BUY['EMAIL']": {email : true},
		<?
		foreach($arParams['REQUIRED'] as $key => $value){
			echo '"ONE_CLICK_BUY['.$value.']": {required : true}';
			if($arParams['REQUIRED'][$key + 1]){
				echo ',';
			}
		}
		?>
	},
	highlight: function( element ){
		$(element).removeClass('error');
	},
	errorPlacement: function( error, element ){
		if(element.attr('type') == 'file')
		{
			error.insertBefore(element.closest('.inner_file'));
		}
		else
			error.insertBefore(element);
	},
	submitHandler: function(form){
		oneClickSubmitHandler(form);
	},
	messages:{
      licenses_popup_OCB: {
        required : BX.message('JS_REQUIRED_LICENSES')
	  },
	  offer_popup_OCB: {
        required : BX.message('JS_REQUIRED_OFFER')
      },
	}
});

$(document).ready(function(){
	$(document).off('change', '#one_click_buy_form input[type=file]');

	$(document).on('change', '#one_click_buy_form input[type=file]', function(){
		var index = 0;

		if(ocbTmpFiles['i_'+$(this).offset().top] >=0)
			index = ocbTmpFiles['i_'+$(this).offset().top];
		else
		{
			ocbTmpFiles['i_'+$(this).offset().top] = ocb_files_index;
			index = ocbTmpFiles['i_'+$(this).offset().top];
			ocb_files_index++;
		}
		if(this.files.length)
		{
			this.files[0].code = $(this).closest('.files').data('code');
			ocb_files[index] = this.files;
			ocb_files[index].code = $(this).closest('.files').data('code');
			$(this).parent().addClass('file');
		}
		else
		{
			delete ocb_files[index];
			$(this).parent().removeClass('file');
		}
	});

	$('.btn_block_file .btn').click(function(){
		var block = $(this).closest('.form-control').find('.files');
		$('<div class="inner_file"><div class="wrapper_file"><span class="remove" title="<?=GetMessage("REMOVE_FILE");?>"><i></i></span><input type="file" '+(block.data('required') == 'Y' ? 'required' : '')+' name="ONE_CLICK_BUY['+block.data('code')+'][]"></div></div>').appendTo(block)
	});

	$(document).on('click', '#one_click_buy_form .files .wrapper_file .remove', function(){
		$(this).closest('.wrapper_file').find('input').val('').change();
	});

	$('#one_click_buy_form .delivery_note').on('click', function(e){
		e.preventDefault();
		$(this).closest('.delivery_note').toggleClass('opened');
		$(this).closest('.delivery_note_wrapper').find('.text').slideToggle();
	});

	$('#one_click_buy_form .delivery_note .text a').on('click', function(e){
		e.preventDefault();
		var href = $(this).attr('href');
		if(typeof href !== 'undefined' && href.length){
			window.open(href, '_blank');
		}
	});

	$('.captcha_reload').on('click', function(e){
		var captcha = $(this).parents('.captcha-row');
		e.preventDefault();
		$.ajax({
			url: arMaxOptions['SITE_DIR'] + 'ajax/captcha.php'
		}).done(function(text){
			captcha.find('input[name=captcha_sid]').val(text);
			captcha.find('img').attr('src', '/bitrix/tools/captcha.php?captcha_sid=' + text);
			captcha.find('input[name=captcha_word]').val('').removeClass('error');
			captcha.find('.captcha_input').removeClass('error').find('.error').remove();
		});
	});

	<?if($arParams['BUY_ALL_BASKET'] == "Y"):?>
		if(arMaxOptions['COUNTERS']['USE_FASTORDER_GOALS'] !== 'N'){
			var eventdata = {goal: 'goal_fastorder_begin'};
			BX.onCustomEvent('onCounterGoals', [eventdata])
		}
	<?else:?>
		if(arMaxOptions['COUNTERS']['USE_1CLICK_GOALS'] !== 'N'){
			var eventdata = {goal: 'goal_1click_begin'};
			BX.onCustomEvent('onCounterGoals', [eventdata])
		}
	<?endif;?>
});

$('.popup .jqmClose').on('click', function(e){
	e.preventDefault();
	$(this).closest('.popup').jqmHide();
});

<?if(!$arParams['INLINE_FORM']):?>
	if(arMaxOptions['THEME']['PHONE_MASK']){
		$('#one_click_buy_id_PHONE').inputmask( "mask", { "mask": arMaxOptions['THEME']['PHONE_MASK'], "showMaskOnFocus": true } );
	}
<?endif;?>
</script>