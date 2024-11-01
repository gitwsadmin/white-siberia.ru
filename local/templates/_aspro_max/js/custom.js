/* You can use this file with your scripts. It will not be overwritten when you upgrade solution. */
$( document ).ready(function(){

$('.hidden-link').click(function(){window.open($(this).data('link'));return false;});

if(location.href.includes('/landings/') && location.href.length>36){
$('.buttons_block').html('<span class="btn btn-danger has-ripple" data-event="jqm" data-param-form_id="CALLBACK" data-name="callback">Связаться с менеджером</span>');

try{$('.reviews-block').append('<br><div style="text-align: center;"><span class="btn btn-danger has-ripple btn_leed" data-event="jqm" data-param-form_id="CALLBACK" data-name="callback">Связаться со мной</span></div>');}catch{}

$.get( "https://white-siberia.ru/ajax/form.php?form_id=CALLBACK_2AoK7&data-trigger=%7B%22class%22%3A%22btn%20btn-danger%20has-ripple%20clicked%22%2C%22data-event%22%3A%22jqm%22%2C%22data-param-form_id%22%3A%22CALLBACK_2AoK7%22%2C%22data-name%22%3A%22callback_2AoK7%22%7D", function( data ) {
	$( ".goods_catalog" ).append( '<div id="CALLBACK_2AoK7_div" style="text-align: center; max-width:480px;margin: 20px auto;">' + data.replaceAll('licenses_popup', 'licenses_popup_2AoK7') + '</div>' );
	$( "#CALLBACK_2AoK7_div .close, button[name='web_form_reset']" ).hide();
});


$('.goods_catalog2').append(`<div style="text-align: center;"><div class="callback_frame jqmWindow jqm-init scrollblock show" data-popup="0" data-trigger="%7B%22class%22%3A%22btn%20btn-danger%20has-ripple%20btn_leed%20clicked%22%2C%22data-event%22%3A%22jqm%22%2C%22data-param-form_id%22%3A%22CALLBACK%22%2C%22data-name%22%3A%22callback%22%7D" style="z-index: 3000;opacity: 1;max-width: 500px;margin-top: 4.33rem;">	<div id="comp_026763f0f1a767b51622bc43654c9907">
<div class="form CALLBACK  ">
	<!--noindex-->
	<div class="form_head">
					<h2>Оставь заявку и получи консультацию</h2>
					</div>
					
<form name="CALLBACK" action="/ajax/form.php?form_id=CALLBACK&data-trigger=%7B%22class%22%3A%22btn+btn-danger+has-ripple+btn_leed+clicked%22%2C%22data-event%22%3A%22jqm%22%2C%22data-param-form_id%22%3A%22CALLBACK%22%2C%22data-name%22%3A%22callback%22%7D" method="POST" enctype="multipart/form-data" novalidate="novalidate"><input type="hidden" name="bxajaxid" id="bxajaxid_026763f0f1a767b51622bc43654c9907_8BACKi" value="026763f0f1a767b51622bc43654c9907"><input type="hidden" name="AJAX_CALL" value="Y"><script>
function _processform_8BACKi(){
	if (BX('bxajaxid_026763f0f1a767b51622bc43654c9907_8BACKi'))
	{
		var obForm = BX('bxajaxid_026763f0f1a767b51622bc43654c9907_8BACKi').form;
		BX.bind(obForm, 'submit', function() {BX.ajax.submitComponentForm(this, 'comp_026763f0f1a767b51622bc43654c9907', true)});
	}
	BX.removeCustomEvent('onAjaxSuccess', _processform_8BACKi);
}
if (BX('bxajaxid_026763f0f1a767b51622bc43654c9907_8BACKi'))
	_processform_8BACKi();
else
	BX.addCustomEvent('onAjaxSuccess', _processform_8BACKi);
</script>
<input type="hidden" name="sessid" id="sessid" value="5241b9a96043f1ab528d6c7b53bcc354"><input type="hidden" name="WEB_FORM_ID" value="3">		<input type="hidden" name="sessid" id="sessid_1" value="5241b9a96043f1ab528d6c7b53bcc354">		<div class="form_body">
																							<div class="form-control">
				<label><span>Ваше имя&nbsp;<span class="star">*</span></span></label>
													<input type="text" class="inputtext" data-sid="CLIENT_NAME" required="" name="form_text_11" value="" aria-required="true">							</div>
																								<div class="form-control">
				<label><span>Телефон&nbsp;<span class="star">*</span></span></label>
													<input type="tel" class="phone" data-sid="PHONE" required="" name="form_text_12" value="" aria-required="true">							</div>
														<div class="clearboth"></div>
										<textarea name="nspm" style="display:none;"></textarea>
						<div class="clearboth"></div>
		</div>
		<div class="form_footer">
										<input type="hidden" name="aspro_max_form_validate">
				<div class="licence_block filter onoff label_block">
					<input type="checkbox" id="licenses_popup2" name="licenses_popup" required="" value="Y" aria-required="true">
					<label for="licenses_popup2">
						Я согласен на <a href="/include/licenses_detail.php" target="_blank">обработку персональных данных</a>					</label>
				</div>
						<button type="submit" class="btn btn-lg btn-default has-ripple">Отправить</button>
			<input type="hidden" class="btn btn-default" value="Отправить" name="web_form_submit">
		</div>
		</form>		<!--/noindex-->
	<script>
	$(document).ready(function(){

		$('form[name="CALLBACK"]').validate({
			highlight: function( element ){
				$(element).parent().addClass('error');
			},
			unhighlight: function( element ){
				$(element).parent().removeClass('error');
			},
			submitHandler: function( form ){
				if( $('form[name="CALLBACK"]').valid() ){
					setTimeout(function() {
						$(form).find('button[type="submit"]').attr("disabled", "disabled");
					}, 500);
					var eventdata = {type: 'form_submit', form: form, form_name: 'CALLBACK'};
					BX.onCustomEvent('onSubmitForm', [eventdata]);
				}
			},
			errorPlacement: function( error, element ){
				error.insertBefore(element);
			},
			messages:{
		      licenses_popup: {
		        required : BX.message('JS_REQUIRED_LICENSES')
		      }
			}
		});

		if(arMaxOptions['THEME']['PHONE_MASK'].length){
			var base_mask = arMaxOptions['THEME']['PHONE_MASK'].replace( /(d)/g, '_' );
			$('form[name=CALLBACK] input.phone').inputmask('mask', {'mask': arMaxOptions['THEME']['PHONE_MASK'] });
			$('form[name=CALLBACK] input.phone').blur(function(){
				if( $(this).val() == base_mask || $(this).val() == '' ){
					if( $(this).hasClass('required') ){
						$(this).parent().find('label.error').html(BX.message('JS_REQUIRED'));
					}
				}
			});
		}

		$('input[type=file]').uniform({fileButtonHtml: BX.message('JS_FILE_BUTTON_NAME'), fileDefaultHtml: BX.message('JS_FILE_DEFAULT')});
		$(document).on('change', 'input[type=file]', function(){
			if($(this).val())
			{
				$(this).closest('.uploader').addClass('files_add');
			}
			else
			{
				$(this).closest('.uploader').removeClass('files_add');
			}
		})
		$('.form .add_file').on('click', function(){
			var index = $(this).closest('.input').find('input[type=file]').length+1;

			$(this).closest('.form-group').find('.input').append('<input type="file" id="POPUP_FILE" name="FILE_n'+index+'"   class="inputfile" value="" />');
			//$('<input type="file" id="POPUP_FILE" name="FILE_n'+index+'"   class="inputfile" value="" />').closest()($(this));
			$('input[type=file]').uniform({fileButtonHtml: BX.message('JS_FILE_BUTTON_NAME'), fileDefaultHtml: BX.message('JS_FILE_DEFAULT')});
		});

		$('.form .add_file').on('click', function(){
			var index = $(this).closest('.input').find('input[type=file]').length+1;

			$(this).closest('.form-group').find('.input').append('<input type="file" id="POPUP_FILE" name="FILE_n'+index+'"   class="inputfile" value="" />');
			//$('<input type="file" id="POPUP_FILE" name="FILE_n'+index+'"   class="inputfile" value="" />').closest()($(this));
			$('input[type=file]').uniform({fileButtonHtml: BX.message('JS_FILE_BUTTON_NAME'), fileDefaultHtml: BX.message('JS_FILE_DEFAULT')});
		});

		$('.form .add_text').on('click', function(){
			var input = $(this).closest('.form-group').find('input[type=text]').first(),
				index = $(this).closest('.form-group').find('input[type=text]').length,
				name = input.attr('id').split('POPUP_')[1];

			$(this).closest('.form-group').find('.input').append('<input type="text" id="POPUP_'+name+'" name="'+name+'['+index+']"  class="form-control " value="" />');
		});
			
		// $('.popup').jqmAddClose('a.jqmClose');
		$('.jqmClose').on('click', function(e){
			e.preventDefault();
			$(this).closest('.jqmWindow').jqmHide();
		})
		$('.popup').jqmAddClose('button[name="web_form_reset"]');
	});
	</script>
</div><!--'start_frame_cache_form-block3'--><script>
$(document).ready(function() {
	$('.form.CALLBACK input[data-sid="PRODUCT_NAME"]').attr('value', $('h1').text());
});
</script>
<!--'end_frame_cache_form-block3'--></div></div></div>`);}

if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|BB|PlayBook|IEMobile|Windows Phone|Kindle|Silk|Opera Mini/i.test(navigator.userAgent)) {if(location.href.includes('/landings/') && location.href.length>36){document.querySelector('.items .flexbox').setAttribute('class','flexbox justify-center');$('.tizers .item-wrapper').attr('class','item-wrapper col-md-3 col-sm-4 clearfix');$('.maxwidth-banner').attr('data-bg',$('#mob_img').html());$('.maxwidth-banner').attr('data-src',$('#mob_img').html());$('.banner-wrapper .maxwidth-theme').attr('style','height:625px;justify-content: center;');$('.fadeInUp').attr('style','padding-bottom:0px;position: absolute;bottom: 0;');$('.maxwidth-banner').attr('style',"background-image: url("+$('#mob_img').html()+");background-size: cover;background-position: inherit;");document.querySelector('h1').style.display='none';}}});$( document ).ready(function() { $('.colored_theme_svg').removeClass('colored_theme_svg'); }); // $('.js-video-slider').owlCarousel() $(document).on('click', ".js-play", function() { let element = $(this) let video = element.data('video') let preview = element.children('.video__preview') let title = element.children('.video__title') let frame = element.children('.video__frame') preview.remove() title.remove() // frame.fadeIn(150) onYouTubeIframeAPIReady(video) }); var tag = document.createElement('script'); tag.src = "<a href="https://www.youtube.com/iframe_api&quot;">https://www.youtube.com/iframe_api&quot;</a>; var firstScriptTag = document.getElementsByTagName('script')[0]; firstScriptTag.parentNode.insertBefore(tag, firstScriptTag); var player; function onYouTubeIframeAPIReady(code) { let video_code = code; player = new YT.Player(video_code, { height: '360', width: '640', videoId: code, events: { 'onReady': onPlayerReady } }); console.log(code); } function onPlayerReady(event) { event.target.playVideo(); }

