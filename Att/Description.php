<?php
namespace TFC\GoogleShopping\Att;
# 2021-11-24, 2021-12-20
# 1) https://github.com/googleads/googleads-shopping-samples/blob/053bc550/php/ProductsSample.php#L216
# 2) https://developers.google.com/shopping-content/reference/rest/v2.1/products#Product.FIELDS.description
# 3) «Required. Max 5000 characters.
# Use formatting (for example, line breaks, lists, or italics) to format your description»
# https://support.google.com/merchants/answer/7052112#description
# 4) «If your description does not fit within the character limit, Google will truncate it to fit.
# You will receive a warning indicating that the description has been truncated.»
# https://support.google.com/merchants/answer/6324468#Guidelines
/** @used-by \TFC\GoogleShopping\Products::_p() */
final class Description extends \TFC\GoogleShopping\Att {
	/**
	 * 2021-12-20
	 * @override
	 * @see \TFC\GoogleShopping\Att::v()
	 * @used-by \TFC\GoogleShopping\Products::atts()
	 * @return string
	 */
	function v() {return $this->p()->getDescription();}
}