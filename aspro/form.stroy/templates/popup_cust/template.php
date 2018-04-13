<?if( !defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true ) die();?>
<?
$num = 0;
?>
<?$this->setFrameMode(false);?>
<div class="form popup<?=($arResult['isFormNote'] == 'Y' ? ' success' : '')?>">
	<?if($arResult["isFormNote"] == "Y"){?>
		<div class="form-header">
			<i class="fa fa-check"></i>
			<div class="text">
				<div class="title"><?=GetMessage("SUCCESS_TITLE")?></div>
				<?=$arResult["FORM_NOTE"]?>
			</div>
		</div>
		<?if( $arParams["DISPLAY_CLOSE_BUTTON"] == "Y" ){?>
			<div class="form-footer" style="text-align: center;">
				<?=str_replace('class="', 'class="btn-lg ', $arResult["CLOSE_BUTTON"])?>
			</div>
		<?}
	}else{?>
		<?=$arResult["FORM_HEADER"]?>
			<div class="form-header">
				<i class="fa fa-phone"></i>
				<div class="text">
					<?if( $arResult["isIblockTitle"] ){?>
						<div class="title"><?=$arResult["IBLOCK_TITLE"]?></div>
					<?}?>
					<?if( $arResult["isIblockDescription"] ){
						if( $arResult["IBLOCK_DESCRIPTION_TYPE"] == "text" ){?>
							<p><?=$arResult["IBLOCK_DESCRIPTION"]?></p>
						<?}else{?>
							<?=$arResult["IBLOCK_DESCRIPTION"]?>
						<?}
					}?>
				</div>
			</div>
			<div class="form-body">
				<div class="row">
					<?if(is_array($arResult["QUESTIONS"])):?>
						<?foreach( $arResult["QUESTIONS"] as $FIELD_SID => $arQuestion ){
							if( $arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'hidden' ){
								echo $arQuestion["HTML_CODE"];
							}else{
							$num = $num + 1;
							?>
								<div class="col-md-6 <?=$FIELD_SID?>">
									<div class="form-group">
										<div class="cols-md-12" data-sidy="<?=$FIELD_SID?>">
											<b><?=$arQuestion["CAPTION"]?></b>
											<div class="input">
												<?=$arQuestion["HTML_CODE"]?>
											</div>
											<?if( !empty( $arQuestion["HINT"] ) ){?>
												<div class="hint"><?=$arQuestion["HINT"]?></div>
											<?}?>
										</div>
									</div>
								</div>
								<?/*if($FIELD_SID == 'GABARIT'):?>
								</div>
								<div class="col-md-6">
								<?endif*/?>
							<?if($num%2 == 0):?>
								</div>
								<div class="row">
							<?endif?>
							<?}
						}?>
					<?endif;?>
				</div>
				<?if( $arResult["isUseCaptcha"] == "Y" ){?>
					<div class="row captcha-row">
						<div class="col-md-12">
							<div class="form-group">
								<?=$arResult["CAPTCHA_CAPTION"]?>
								<div class="row">
									<div class="col-md-6 col-sm-6 col-xs-6">
										<?=$arResult["CAPTCHA_IMAGE"]?>
										<span class="refresh"><a href="javascript:;" rel="nofollow"><?=GetMessage("REFRESH")?></a></span>
									</div>
									<div class="col-md-6 col-sm-6 col-xs-6">
										<div class="input <?=$arResult["CAPTCHA_ERROR"] == "Y" ? "error" : ""?>">
											<?=$arResult["CAPTCHA_FIELD"]?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?}?>
			</div>
			<div class="form-footer clearfix" style="padding-bottom:30px;padding-top:0">
				<div class="pull-left required-fileds">
					<i class="star">*</i><?=GetMessage("FORM_REQUIRED_FILEDS")?>
				</div>
				<div class="pull-right">
					<?=str_replace('class="', 'class="btn-lg ', $arResult["SUBMIT_BUTTON"])?>
				</div>
			</div>
		<?=$arResult["FORM_FOOTER"]?>
	<?}?>
</div>

<script>
	$(document).ready(function(){
		$('form[name="<?=$arResult["IBLOCK_CODE"]?>"]').validate({
			highlight: function( element ){
				$(element).parent().addClass('error');
			},
			unhighlight: function( element ){
				$(element).parent().removeClass('error');
			},
			submitHandler: function( form ){
				if( $('form[name="<?=$arResult["IBLOCK_CODE"]?>"]').valid() ){
					$(form).closest('.jqmWindow').addClass('success');
					$(form).find('button[type="submit"]').attr('disabled', 'disabled');
					form.submit();
				}
			},
			errorPlacement: function( error, element ){
				error.insertBefore(element);
			}
		});
		
		if(arStroyOptions['THEME']['PHONE_MASK'].length){
			var base_mask = arStroyOptions['THEME']['PHONE_MASK'].replace( /(\d)/g, '_' );
			$('form[name="<?=$arResult["IBLOCK_CODE"]?>"] input.phone').inputmask('mask', {'mask': arStroyOptions['THEME']['PHONE_MASK'] });
			$('form[name="<?=$arResult["IBLOCK_CODE"]?>"] input.phone').blur(function(){
				if( $(this).val() == base_mask || $(this).val() == '' ){
					if( $(this).hasClass('required') ){
						$(this).parent().find('div.error').html(BX.message('JS_REQUIRED'));
					}
				}
			});
		}
		
		$('form[name="<?=$arResult["IBLOCK_CODE"]?>"] input.date').inputmask(arStroyOptions['THEME']['DATE_MASK'], { 'placeholder': arStroyOptions['THEME']['DATE_PLACEHOLDER'] });
		
		$('.jqmClose').closest('.jqmWindow').jqmAddClose('.jqmClose');
		
		$('.jqmWindow').scrollTop();
		
		$('input[type=file]').uniform({fileButtonHtml: BX.message('JS_FILE_BUTTON_NAME'), fileDefaultHtml: BX.message('JS_FILE_DEFAULT')});
	});
</script>