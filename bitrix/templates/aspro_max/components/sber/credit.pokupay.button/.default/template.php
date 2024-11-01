<?php
	if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
	IncludeModuleLangFile(__FILE__);

	$this->setFrameMode(true);
	// CJSCore::Init(['masked_input']);
	// CJSCore::RegisterExt('test', array()); 
?>
<?php if($arResult['TEMPLATE_MODE'] === 'BASE') { ?>
	<div class="com-sber-pokupay__wrapper">
		<div class="com-sber-pokupay--buy-button__wrapper">
			<button class="com-sber-pokupay--buy-button__button one_click <?/*js-sberbank-open-modal*/?> sber-button-custom _type<?= $arResult['MODULE_SETTINGS']['CREDIT_QUICK_BUTTON_TYPE'];?> <?= $arResult['SBER_CREDIT_AVAILABLE'] == 'CREDIT' ? '_credit' : '_rass';?>" href="#" data-item="<?=$arParams['CONFIG']['PRODUCT']['ID'];?>" data-iblockid="55" data-quantity="1" onclick="oneClickBuySber('<?=$arParams['CONFIG']['PRODUCT']['ID'];?>', '55', this)">
				<?= GetMessage('SBER_POKUPAY_BUTTON_TEXT_BUY_TO');?> <?= $arResult['SBER_CREDIT_AVAILABLE'] == 'CREDIT' ? GetMessage('SBER_POKUPAY_BUTTON_TEXT_CREDIT') : GetMessage('SBER_POKUPAY_BUTTON_TEXT_INSTALLMENT'); ?>
				<img src="<?= $arParams['BUTTON_IMAGE_URL'];?>" alt="">	
			</button>
		</div>
	</div>
	<div class="com-sber-pokupay--modal__wrapper js-sberbank-modal">
		<div class="com-sber-pokupay--modal__inner">
			<div class="com-sber-pokupay--modal__window">
				<div class="com-sber-pokupay--modal__close">
					<button class="com-sber-pokupay--modal__close-button js-sberbank-modal-close">З</button>
				</div>
				<div class="com-sber-pokupay--modal-preloader__wrapper js-sberbank-popup-preloader">
					<div class="com-sber-pokupay--modal-preloader__inner">
						<div class="lds-ring"><div></div><div></div><div></div><div></div></div>
					</div>
				</div>
				<div class="com-sber-pokupay--product__wrapper">
					<img class="com-sber-pokupay--header-logo" src="/bitrix/images/sberbank.pokupay/bank_logo_2.svg" alt="">
				</div> 
				<div class="com-sber-pokupay--form__wrapper">
					<div class="com-sber-pokupay--product__info">
						<span class="com-sber-pokupay--product__title"><?=$arParams['PRODUCT_NAME']?></span>
					</div>
					<form class="com-sber-pokupay--form__form" action="/bitrix/components/sberbank/sberbank.pokupay2/ajax.php" id="sberbank-credit-form">
						

						<p class="com-sber-pokupay--form__title"><?= GetMessage('SBER_POKUPAY_BUTTON_TITLE_ORDER_INFO'); ?></p>

						<div class="com-sber-pokupay--form__summ-wrapper">
							<label class="com-sber-pokupay--form__label" for=""><?= GetMessage('SBER_POKUPAY_BUTTON_POSITION_COUNT'); ?></label>
							<span class="com-sber-pokupay--product__counter">
								<button class="com-sber-pokupay--product__counter-button minus js-button-count">-</button>
								<input class="com-sber-pokupay--product__counter-input js-count-field" value="1" type="number">
								<span class="com-sber-pokupay--product__count-measure"><em class="js-count-measure"></em></span>
								<em class="com-sber-pokupay--product__count-max js-count-max"></em>
								<button class="com-sber-pokupay--product__counter-button plus js-button-count">+</button>
							</span>
						</div>

						<div class="com-sber-pokupay--form__input">
							<label class="com-sber-pokupay--form__label"><?= GetMessage('SBER_POKUPAY_BUTTON_LABEL_TO_PAYMENT');?></label>
							<span class="com-sber-pokupay--form__summ-value">
								0 <?= GetMessage('SBER_POKUPAY_BUTTON_MEASURE_NAME'); ?>
							</span>
						</div>
						
						<p class="com-sber-pokupay--form__title"><?= GetMessage('SBER_POKUPAY_BUTTON_FORM_TITLE');?></p>
						
						<div class="com-sber-pokupay--form__input">
							<label class="com-sber-pokupay--form__label _required" for=""><?= GetMessage('SBER_POKUPAY_BUTTON_LABEL_FIO');?><i class="">*</i></label>
							<input type="text" class="com-sber-pokupay--form__field js-sberbank-form-field _fio" name="USER_FIO" value="">
						</div>
						<span class="com-sber-pokupay--form__field-error-message _fio"><?= GetMessage('SBER_POKUPAY_BUTTON_ERROR_FIO');?></span>
						
						<div class="com-sber-pokupay--form__input">
							<label class="com-sber-pokupay--form__label _required" for=""><?= GetMessage('SBER_POKUPAY_BUTTON_LABEL_EMAIL');?><i class="">*</i></label>
							<input type="text" class="com-sber-pokupay--form__field js-sberbank-form-field _email" name="USER_EMAIL" value="">
						</div>
						<span class="com-sber-pokupay--form__field-error-message _email"><?= GetMessage('SBER_POKUPAY_BUTTON_ERROR_EMAIL');?></span>
						
						<div class="com-sber-pokupay--form__input">
							<label class="com-sber-pokupay--form__label _required" for=""><?= GetMessage('SBER_POKUPAY_BUTTON_LABEL_PHONE');?><i class="">*</i></label>
							<input type="text" class="com-sber-pokupay--form__field js-sberbank-form-field _phone" name="USER_PHONE" id="sberpokupay_phone" value="">
						</div>
						<span class="com-sber-pokupay--form__field-error-message _phone"><?= GetMessage('SBER_POKUPAY_BUTTON_ERROR_PHONE');?></span>
						
						<div class="com-sber-pokupay--form__input">
							<label class="com-sber-pokupay--form__label _required" for=""><?= GetMessage('SBER_POKUPAY_BUTTON_LABEL_ADDRESS');?><i class="">*</i></label>
							<input type="text" class="com-sber-pokupay--form__field js-sberbank-form-field _address" name="USER_ADDRESS" value="">
						</div>
						<span class="com-sber-pokupay--form__field-error-message _address"><?= GetMessage('SBER_POKUPAY_BUTTON_ERROR_ADDRESS');?></span>
						
						<div class="com-sber-pokupay--form__input">
							<label class="com-sber-pokupay--form__label _required" for=""><?= GetMessage('SBER_POKUPAY_BUTTON_LABEL_COMMENT');?></label>
							<textarea type="text" class="com-sber-pokupay--form__field js-sberbank-form-field _comment _textarea" name="USER_COMMENT"></textarea>
						</div>
						
						<hr class="com-sber-pokupay--form__separator">

						<div class="com-sber-pokupay--form__footer">
							<button type="submit" class="com-sber-pokupay--form__submit <?= $arResult['SBER_CREDIT_AVAILABLE'] == 'CREDIT' ? '_credit' : '_installment';?>">
								<?= GetMessage('SBER_POKUPAY_BUTTON_TEXT_BUY_TO');?> <?= $arResult['SBER_CREDIT_AVAILABLE'] == 'CREDIT' ? GetMessage('SBER_POKUPAY_BUTTON_TEXT_CREDIT') : GetMessage('SBER_POKUPAY_BUTTON_TEXT_INSTALLMENT'); ?>
								<img src="<?= $arParams['BUTTON_IMAGE_URL'];?>" alt="">	
							</button>
						</div>
					</form>
				</div>
				<div class="com-sber-pokupay--payment-gate-errors__wrapper">
					<span class="com-sber-pokupay--payment-gate-errors__title"><?= Getmessage('SBER_POKUPAY_BUTTON_PAYMENT_GATE_ERROR');?></span>
					<span class="com-sber-pokupay--payment-gate-errors__code"></span>
					<span class="com-sber-pokupay--payment-gate-errors__message"></span>
					<button class="com-sber-pokupay--payment-gate-errors__btn-return"><?= Getmessage('SBER_POKUPAY_BUTTON_PAYMENT_RETURN_TO_FORM');?></button>
				</div>
			</div>
		</div>
	</div>
	<script>
		var SberCreaditPokupayButton = new JSberCreditPokupayButton(<?=CUtil::PhpToJSObject($arParams, false, true)?>);
	</script>
<?php } else if($arResult['TEMPLATE_MODE'] === 'BUTTON') { ?>
	<div class="com-sber-pokupay__wrapper">
		<div class="com-sber-pokupay--buy-button__wrapper">
			<button class="com-sber-pokupay--buy-button__button js-sberbank-open-modal _type<?= $arResult['MODULE_SETTINGS']['CREDIT_QUICK_BUTTON_TYPE'];?> <?= $arResult['SBER_CREDIT_AVAILABLE'] == 'CREDIT' ? '_credit' : '_rass';?>" href="#">
				<?= GetMessage('SBER_POKUPAY_BUTTON_TEXT_BUY_TO');?> <?= $arResult['SBER_CREDIT_AVAILABLE'] == 'CREDIT' ? GetMessage('SBER_POKUPAY_BUTTON_TEXT_CREDIT') : GetMessage('SBER_POKUPAY_BUTTON_TEXT_INSTALLMENT'); ?>
				<img src="<?= $arParams['BUTTON_IMAGE_URL'];?>" alt="">	
			</button>
		</div>
	</div>
<?php } ?>


