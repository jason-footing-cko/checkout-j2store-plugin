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
<form id="j2store_checkoutapipaymentdirect_form" action="<?php echo JRoute::_("index.php?option=com_j2store&view=checkout"); ?>" method="post" name="adminForm" enctype="multipart/form-data">

    <p>Click on Place order to enter your card details.</p>
    <input type="hidden" name="cko-cc-paymenToken" id="cko-cc-paymenToken" value="<?php echo $vars->paymentToken ?>" >
    <?php
    if ($vars->endpoint == 'live') {
      $js_src = 'https://www.checkout.com/cdn/js/checkout.js';
    }
    else {
      $js_src = '//sandbox.checkout.com/js/v1/checkout.js';
    }
    ?>
    <script async src="<?php echo $js_src ?>"></script>
    <div style="" class="widget-container">
        <script type="text/javascript">
          if (typeof (j2store) == 'undefined') {
              var j2store = {};
          }
          if (typeof (j2store.jQuery) == 'undefined') {
              j2store.jQuery = jQuery.noConflict();
          }

          if (typeof (j2storeURL) == 'undefined') {
              var j2storeURL = '';
          }

          var reload = false;
          window.CKOConfig = {
              debugMode: false,
              renderMode: 0,
              namespace: 'CheckoutIntegration',
              publicKey: '<?php echo $vars->publishable_key ?>',
              customerEmail: '<?php echo $vars->customerEmail ?>',
              customerName: '<?php echo $vars->customerName ?>',
              value: <?php echo $vars->value ?>,
              currency: '<?php echo $vars->currency ?>',
              paymentMode: 'mixed',
              paymentToken: '<?php echo $vars->paymentToken ?>',
              widgetContainerSelector: '.widget-container',
              cardCharged: function (event) {
                  function j2storecheckoutapipaymentdirectSubmit() {

                      (function ($) {

                          var form = $('#j2store_checkoutapipaymentdirect_form');
                          var values = form.serializeArray();

                          var jqXHR = $.ajax({
                              url: 'index.php',
                              type: 'post',
                              data: values,
                              dataType: 'json',
                              beforeSend: function () {

                              }
                          });

                          jqXHR.done(function (json) {
                              form.find('.j2success, .j2warning, .j2attention, .j2information, .j2error').remove();

                              if (json['error']) {
                                  form.find('.plugin_error').after('<span class="j2error">' + json['error'] + '</span>');
                                  form.find('.plugin_error_instruction').after('<br /><span class="j2error"><?php echo JText::_('J2STORE_CHECKOUTAPI_ON_ERROR_INSTRUCTIONS'); ?></span>');
                              }

                              if (json['redirect']) {
                                  window.location.href = json['redirect'];
                              }
                          });

                          jqXHR.always(function () {
                              $('.wait').remove();
                          });

                      })(j2store.jQuery);
                  }
                  j2storecheckoutapipaymentdirectSubmit();
              },
              lightboxDeactivated: function () {
                  if (reload) {
                      window.location.reload();
                  }
              },
              paymentTokenExpired: function (event) {
                  reload = true;
              },
              invalidLightboxConfig: function (event) {
                  reload = true;
              },
          };

        </script>
    </div>
    <div class="plugin_error_div">
        <span class="plugin_error"></span>
        <span class="plugin_error_instruction"></span>
    </div>
    <br />
    <input type='hidden' name='order_id' value='<?php echo @$vars->order_id; ?>' />
    <input type='hidden' name='orderpayment_id' value='<?php echo @$vars->orderpayment_id; ?>' />
    <input type='hidden' name='orderpayment_type' value='<?php echo @$vars->orderpayment_type; ?>' />
    <input type='hidden' name='option' value='com_j2store' />
    <input type='hidden' name='view' value='checkout' />
    <input type='hidden' name='task' value='confirmPayment' />
    <input type='hidden' name='paction' value='process' />
    <?php echo JHTML::_('form.token'); ?>
</form>

