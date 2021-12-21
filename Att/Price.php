<?php
namespace TFC\GoogleShopping\Att;
# 2021-12-20, 2021-12-21
# 1) «Required.
# Example: 15.00 USD.
# Syntax:
# 		- Numeric
# 		- ISO 4217
# » https://support.google.com/merchants/answer/7052112#price
# 2.1) «Use the price [price] attribute to tell users how much you’re charging for your product.
# This information is shown to users.
# 2.2) Minimum requirements:
# These are the requirements you'll need to meet to show your product.
# If you don't follow these requirements, we'll disapprove your product
# and let you know in the Diagnostics page in your Merchant Center account.
#	-	Make sure that the price in your product data meets both the landing page and checkout requirements.
#		Learn more about landing page requirements: https://support.google.com/merchants/answer/4752265
#		-	Submit an amount and currency that match the price on your landing page and the checkout pages.
#			Learn more currency requirements for your country of sale: https://support.google.com/merchants/answer/160637
#		-	If you charge any additional fees at checkout and they’re not included in the product price,
#			make sure to include these charges in Merchant Center
#			by combining them with the applicable shipping costs either via the shipping [shipping] attribute
#		 	(https://support.google.com/merchants/answer/6324484) or using the Merchant Center shipping services.
#		-	Include the price in the currency of your country of sale prominently on your landing page and checkout pages.
#		-	Don’t change the price of your product on your landing page based on a user’s location.
#			Ensure that users can purchase the product online for the price that you submit, regardless of their location.
#		-	Display variants and prices in a straightforward way on your landing page.
#		-	Display the submitted product and price prominently on your landing page.
#			If you have multiple variants on your landing page,
#			make sure the submitted product and corresponding price are the most prominent.
#		-	Charge the submitted price to all users in the country of sale
#			unless regional pricing is available in your country of sale.
#			Learn more about regional availability and pricing: https://support.google.com/merchants/answer/9698880
#		-	Include any minimum order value in your shipping settings.
#			Learn more about how to add a minimum order value: https://support.google.com/merchants/answer/7378591
#	-	Don’t include shipping costs in your price.
#		Instead, use Merchant Center shipping services or the shipping [shipping] attribute in the feed:
#		https://support.google.com/merchants/answer/6324484
# 2.3) Best practices
#	-	Highlight sales that promote your products.
#		Use the sale price [sale_price] attribute (https://support.google.com/merchants/answer/6324471)
#		to tell users how much you’re charging for your product during a sale.
#		During the period that you specify, your sale price will show as the current price for your product.
#		If your original and sale prices meet certain requirements, your original price may show along with the sale price,
#		allowing people to see the difference between the two.
#» https://support.google.com/merchants/answer/6324371
/** @used-by \TFC\GoogleShopping\Products::_p() */
final class Price extends \TFC\GoogleShopping\Att {
	/**
	 * 2021-12-20
	 * @override
	 * @see \TFC\GoogleShopping\Att::v()
	 * @used-by \TFC\GoogleShopping\Products::atts()
	 * @return string
	 */
	function v() {return df_cc_s(dff_2($this->p()->getFinalPrice()), $this->p()->getStore()->getDefaultCurrencyCode());}
}