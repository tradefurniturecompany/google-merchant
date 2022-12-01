<?php
namespace TFC\GoogleShopping\Att;
# 2021-11-24, 2021-12-20
# 1) https://github.com/googleads/googleads-shopping-samples/blob/053bc550/php/ProductsSample.php#L217
# 2) «String. URL directly linking to your item's page on your website.»
# https://developers.google.com/shopping-content/reference/rest/v2.1/products#Product.FIELDS.link
# 3) «Required. Your product’s landing page.» https://support.google.com/merchants/answer/7052112#link
# 4) https://support.google.com/merchants/answer/6324416
/** @used-by \TFC\GoogleShopping\Products::_p() */
final class Link extends \TFC\GoogleShopping\Att {
	/**
	 * 2021-12-20
	 * @override
	 * @see \TFC\GoogleShopping\Att::v()
	 * @used-by \TFC\GoogleShopping\Products::atts()
	 */
	function v():string {return $this->p()->getProductUrl();}
}