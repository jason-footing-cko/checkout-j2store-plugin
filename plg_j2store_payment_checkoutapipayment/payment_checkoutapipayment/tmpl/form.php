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
	<p><?php echo JText::_($vars->onselection_text); ?></p>
</div>

<table id="#checkoutapipaymentdirect_form" class="table">
    <tr>
        <td class="field_name"><?php echo JText::_( 'J2STORE_CHECKOUTAPIPAYMENT_CREDITCARD_TYPE' ) ?></td>
        <td><?php echo $vars->cctype_input ?></td>
    </tr>
      <tr>
        <td class="field_name"><?php echo JText::_( 'J2STORE_CHECKOUTAPIPAYMENT_CARDHOLDER_NAME' ) ?></td>
        <td>
        <input type="text"
        class="required"
        name="cardname" size="19"
        value="<?php echo !empty($vars->prepop['x_card_name']) ? ($vars->prepop['x_card_name']) : '' ?>"
        title="<?php echo JText::_('J2STORE_CHECKOUTAPIPAYMENT_VALIDATION_ENTER_CARDHOLDER_NAME'); ?>"
         />
        <div class="k2error"></div>
        </td>

    </tr>

    <tr>
        <td class="field_name"><?php echo JText::_( 'J2STORE_CHECKOUTAPIPAYMENT_CARD_NUMBER' ) ?></td>
        <td>
        <input type="text"
        class="required number"
        name="cardnum" size="19"
        value="<?php echo !empty($vars->prepop['x_card_num']) ? ($vars->prepop['x_card_num']) : '' ?>"
        title="<?php echo JText::_('J2STORE_CHECKOUTAPIPAYMENT_VALIDATION_ENTER_CREDITCARD'); ?>"
         />
        <div class="k2error"></div>
        </td>

    </tr>
    <tr>
        <td class="field_name"><?php echo JText::_( 'J2STORE_CHECKOUTAPIPAYMENT_EXPIRATION_DATE' ) ?></td>
        <td>
        <select name="month" class="required number"
         title="<?php echo JText::_('J2STORE_CHECKOUTAPIPAYMENT_VALIDATION_ENTER_EXPIRY_MONTH'); ?>"
         >
        	<option value=""><?php echo JText::_('J2STORE_MONTH'); ?></option>
        	<option value="01">01</option>
        	<option value="02">02</option>
        	<option value="03">03</option>
        	<option value="04">04</option>
        	<option value="05">05</option>
        	<option value="06">06</option>
        	<option value="07">07</option>
        	<option value="08">08</option>
        	<option value="09">09</option>
        	<option value="10">10</option>
        	<option value="11">11</option>
        	<option value="12">12</option>
        </select>
         <div class="k2error"></div>
        <select name="year" class="required number"
        title="<?php echo JText::_('J2STORE_CHECKOUTAPIPAYMENT_VALIDATION_ENTER_EXPIRY_YEAR'); ?>"
        >
        	<option value=""><?php echo JText::_('J2STORE_YEAR'); ?></option>
        	<?php
        	$two_digit_year = date('y');
        	$four_digit_year = date('Y');
        	?>
        	<?php for($i=$two_digit_year;$i<$two_digit_year+30;$i++) {?>
        		<option value="<?php echo $i;?>"><?php echo $four_digit_year;?></option>
        	<?php
        	$four_digit_year++;
        	} ?>
        	</select>

        <div class="k2error"></div>
        <input type="hidden" class="" name="cardexp" size="10" value="<?php echo !empty($vars->prepop['x_exp_date']) ? ($vars->prepop['x_exp_date']) : '' ?>" />
        </td>
    </tr>
    <tr>
        <td class="field_name"><?php echo JText::_( 'J2STORE_CHECKOUTAPIPAYMENT_CARD_CVV' ) ?></td>
        <td><input type="text" class="required number" name="cardcvv" size="10" value=""
        title="<?php echo JText::_('J2STORE_CHECKOUTAPIPAYMENT_VALIDATION_ENTER_CARD_CVV'); ?>"
        />
        <div class="k2error"></div>
        </td>
    </tr>
</table>