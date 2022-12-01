<?php
namespace TFC\GoogleShopping\Att;
use Magento\Catalog\Model\Product as P;
use Magento\Framework\Pricing\PriceInfo\Base as I;
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
# 2021-12-22 "Implement the `price` attribute": https://github.com/tradefurniturecompany/google-shopping/issues/6
/** @used-by \TFC\GoogleShopping\Products::_p() */
final class Price extends \TFC\GoogleShopping\Att {
	/**
	 * 2021-12-20
	 * 2022-12-01
	 * 1) If a configrable product does not have the `special_price` set in the database (it can not be set via UI),
	 * and its child has a `special_price`:
	 * 	{
	 *		"base_price": 0,
	 *		"catalog_rule_price": false,
	 *		"configured_price": 0,
	 *		"configured_regular_price": 0,
	 *		"custom_option_price": [],
	 *		"final_price": 333,
	 *		"msrp_price": 0,
	 *		"regular_price": 939.95,
	 *		"special_price": false,
	 *		"tier_price": false
	 *	}
	 * 2) If the same configrable product has the `special_price` set in the database (it can not be set via UI),
	 * and its child has a `special_price`:
	 *	{
	 *		"base_price": 0,
	 *		"final_price": 333,
	 *		"regular_price": 939.95,
	 *		"special_price": 479.95,
	 *		"tier_price": false
	 *	}
	 * Please note that other keys are absent in the hash.
	 * 3) If the same configrable product does not have the `special_price` set in the database (it can not be set via UI),
	 * and its children do not have a `special_price`:
	 *	{
	 *		"base_price": 0,
	 *		"final_price": 939.95,
	 *		"regular_price": 939.95,
	 *		"special_price": false,
	 *		"tier_price": false
	 *	}
	 * Please note that other keys are absent in the hash.
	 * https://github.com/tradefurniturecompany/google-shopping/issues/11#issuecomment-1333273606
	 * @override
	 * @see \TFC\GoogleShopping\Att::v()
	 * @used-by \TFC\GoogleShopping\Products::atts()
	 */
	function v():string {return self::format($p = $this->p(), max(...self::regFin($p)));}

	/**
	 * 2022-12-01
	 * @used-by v()
	 * @used-by \TFC\GoogleShopping\Att\SalePrice::v()
	 * @return array(int|float)
	 */
	static function regFin(P $p):array {
		$i = $p->getPriceInfo(); /** @var I $i */
		return [$i->getPrice('regular_price')->getValue(), $i->getPrice('final_price')->getValue()];
	}

	/**
	 * 2021-12-21
	 * @used-by v()
	 * @used-by \TFC\GoogleShopping\Att\SalePrice::v()
	 */
	static function format(P $p, float $a):string {return df_cc_s(dff_2($a), $p->getStore()->getDefaultCurrencyCode());}
}