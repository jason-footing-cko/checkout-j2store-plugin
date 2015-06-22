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

		<p>Please Select your Credit Card Type</p>

		<input type="hidden" name="cko_cc_token" id="cko_cc_token" value="" >
		<input type="hidden" name="cko_cc_email" id="cko_cc_email" value="" >

		<script src="https://www.checkout.com/cdn/js/Checkout.js"></script>
		<div style="" class="widget-container">
		    <script type="text/javascript">
		        window.CKOConfig = {
		            namespace: 'CKOJS',
		            publicKey: <?php echo '\''. $vars->publishable_key .'\'' ?>,
		            customerEmail: <?php echo '\''. $vars->customerEmail .'\''?>,
		            customerName: <?php echo  '\''.$vars->customerName .'\''?>,
		            value: <?php echo  '\''.$vars->value .'\''?>,
		            currency: <?php echo '\''. $vars->currency .'\''?>,
		            billingDetails: {
		                addressLine1: <?php echo '\''. $vars->billing_addressLine1 .'\'' ?>,
		                addressLine2: <?php echo '\''.  $vars->billing_addressLine2 .'\'' ?>,
		                postcode: <?php echo '\''.  $vars->billing_postcode .'\'' ?>,
		                country: <?php echo '\''.  $vars->billing_country .'\''?>,
		                city: <?php echo '\''. $vars->billing_city .'\''?>,
		                state: <?php echo '\''.  $vars->billing_state .'\'' ?>,
		                phone: <?php echo '\''. $vars->billing_phone .'\''?>
		            },
		            widgetContainerSelector: '.widget-container',
		            widgetRendered: function (event) {
		                jQuery(".cko-pay-now").hide();
		            },
		            cardTokenReceived: function (event) {
		                document.getElementById('cko_cc_token').value = event.data.cardToken;
		                document.getElementById('cko_cc_email').value = event.data.email;
		            }
		        };

		    </script>
		</div>

        <div class="plugin_error_div">
			<span class="plugin_error"></span>
			<span class="plugin_error_instruction"></span>
		</div>

		<br />


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
