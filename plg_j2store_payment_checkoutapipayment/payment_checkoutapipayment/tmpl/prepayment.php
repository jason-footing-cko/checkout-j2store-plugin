<?php
/*
* @package		plg_j2store_payment_checkoutapipayment
* @subpackage	J2Store
* --------------------------------------------------------------------------------
*/

//no direct access
defined('_JEXEC') or die('Restricted access');

?>
  <div class="note">
       <strong><?php echo JText::_($vars->display_name); ?></strong>
		<br />
		<?php echo JText::_($vars->onbeforepayment_text); ?>
    </div>
<form id="j2store_checkoutapipaymentdirect_form" action="<?php echo JRoute::_( "index.php?option=com_j2store&view=checkout" ); ?>" method="post" name="adminForm" enctype="multipart/form-data">

        <table class="table">
            <tr>
                <td class="field_name"><?php echo JText::_( 'J2STORE_CHECKOUTAPIPAYMENT_CREDITCARD_TYPE' ) ?></td>
                <td><?php echo $vars->cardtype;
			//echo $vars->cardtype; ?></td>
            </tr>
            <tr>
                <td class="field_name"><?php echo JText::_( 'J2STORE_CHECKOUTAPIPAYMENT_CARD_NUMBER' ) ?></td>
                <td>************<?php echo $vars->cardnum_last4; ?></td>
            </tr>
            <tr>
                <td class="field_name"><?php echo JText::_( 'J2STORE_CHECKOUTAPIPAYMENT_EXPIRATION_DATE' ) ?></td>
                <td><?php echo $vars->cardexp; ?></td>
            </tr>
            <tr>
                <td class="field_name"><?php echo JText::_( 'J2STORE_CHECKOUTAPIPAYMENT_CARD_CVV' ) ?></td>
                <td>****</td>
            </tr>
        </table>

        <div class="plugin_error_div">
			<span class="plugin_error"></span>
			<span class="plugin_error_instruction"></span>
		</div>

		<br />

<input type='hidden' name='cardname' value='<?php echo @$vars->cardname; ?>' />
    <input type='hidden' name='cardtype' value='<?php echo @$vars->cardtype; ?>' />
    <input type='hidden' name='cardnum' value='<?php echo @$vars->cardnum; ?>' />
    <input type='hidden' name='cardexp' value='<?php echo @$vars->cardexp; ?>' />
    <input type='hidden' name='cardcvv' value='<?php echo @$vars->cardcvv; ?>' />
        <input type='hidden' name='cardmonth' value='<?php echo @$vars->cardmonth; ?>' />
        <input type='hidden' name='cardyear' value='<?php echo @$vars->cardyear; ?>' />

<input type="button" onclick="j2storecheckoutapipaymentdirectSubmit(this)" class="button btn btn-primary" value="<?php echo JText::_($vars->button_text); ?>" />

    <input type='hidden' name='order_id' value='<?php echo @$vars->order_id; ?>' />
    <input type='hidden' name='orderpayment_id' value='<?php echo @$vars->orderpayment_id; ?>' />
    <input type='hidden' name='orderpayment_type' value='<?php echo @$vars->orderpayment_type; ?>' />
     <input type='hidden' name='option' value='com_j2store' />
    <input type='hidden' name='view' value='checkout' />
    <input type='hidden' name='task' value='confirmPayment' />
    <input type='hidden' name='paction' value='process' />

    <?php echo JHTML::_( 'form.token' ); ?>
</form>
<script type="text/javascript">
if(typeof(j2store) == 'undefined') {
	var j2store = {};
}
if(typeof(j2store.jQuery) == 'undefined') {
	j2store.jQuery = jQuery.noConflict();
}

if(typeof(j2storeURL) == 'undefined') {
	var j2storeURL = '';
}

function j2storecheckoutapipaymentdirectSubmit(button) {

	(function($) {
		$(button).attr('disabled', 'disabled');
		$(button).val('<?php echo JText::_('J2STORE_CHECKOUTAPIPAYMENT_PROCESSING_PLEASE_WAIT')?>');
		var form = $('#j2store_checkoutapipaymentdirect_form');
	    var values = form.serializeArray();

	var jqXHR =	$.ajax({
			url: 'index.php',
			type: 'post',
			data: values,
			dataType: 'json',
			beforeSend: function() {
				$(button).after('<span class="wait">&nbsp;<img src="media/j2store/images/loader.gif" alt="" /></span>');
			}
	});

		jqXHR.done(function(json) {
			form.find('.j2success, .j2warning, .j2attention, .j2information, .j2error').remove();
			console.log(json);
			if (json['error']) {
				form.find('.plugin_error').after('<span class="j2error">' + json['error']+ '</span>');
				form.find('.plugin_error_instruction').after('<br /><span class="j2error"><?php echo JText::_('J2STORE_CHECKOUTAPI_ON_ERROR_INSTRUCTIONS'); ?></span>');
				$(button).val('<?php echo JText::_('J2STORE_CHECKOUTAPIPAYMENT_ERROR_PROCESSING')?>');
			}

			if (json['redirect']) {
				$(button).val('<?php echo JText::_('J2STORE_CHECKOUTAPIPAYMENT_COMPLETED_PROCESSING')?>');
				window.location.href = json['redirect'];
			}

		});

		jqXHR.fail(function() {
			$(button).val('<?php echo JText::_('J2STORE_CHECKOUTAPIPAYMENT_ERROR_PROCESSING')?>');
		})

		jqXHR.always(function() {
			$('.wait').remove();
		 });

	})(j2store.jQuery);
}

</script>
