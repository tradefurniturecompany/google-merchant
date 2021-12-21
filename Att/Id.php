<?php
namespace TFC\GoogleShopping\Att;
# 2021-11-24, 2021-12-19
# 1) https://github.com/googleads/googleads-shopping-samples/blob/053bc550/php/ProductsSample.php#L214
# 2) String, required.
# «A unique identifier for the item.
# Leading and trailing whitespaces are stripped
# and multiple whitespaces are replaced by a single whitespace upon submission.
# Only valid unicode characters are accepted.
# See the products feed specification for details: https://support.google.com/merchants/answer/7052112#id
# Note: Content API methods that operate on products take the REST ID of the product, not this identifier.»
# https://developers.google.com/shopping-content/reference/rest/v2.1/products#Product.FIELDS.offer_id
# 3) «Required. Max 50 characters.
# Your product’s unique identifier.
# Example: A2B4.
# Use a unique value for each product.
# - Use the product's SKU where possible.
# - Keep the ID the same when updating your data.
# - Use only valid unicode characters.
# - Avoid invalid characters like control, function, or private area characters.
# - Use the same ID for the same product - across countries or languages»
# https://support.google.com/merchants/answer/7052112#id
# 4) «Use the ID [id] attribute to uniquely identify each product.
# The ID won’t be shown to customers who view your products online.
# However, you can use the ID to look up your product, place bids, and check a product's performance.
# We recommend that you use your product SKU for this value.»
# https://support.google.com/merchants/answer/6324405
/** @used-by \TFC\GoogleShopping\Products::_p() */
final class Id extends \TFC\GoogleShopping\Att {
	/**
	 * 2021-12-19
	 * @override
	 * @see \TFC\GoogleShopping\Att::v()
	 * @used-by \TFC\GoogleShopping\Products::atts()
	 * @return string
	 */
	function v() {return $this->p()->getSku();}
}