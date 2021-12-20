<?php
namespace TFC\GoogleShopping\Att;
# 2021-11-24, 2021-12-20
# 1) https://github.com/googleads/googleads-shopping-samples/blob/053bc550/php/ProductsSample.php#L215
# 2) String. «Title of the item»
# https://developers.google.com/shopping-content/reference/rest/v2.1/products#Product.FIELDS.title
# 3) «Required. Max 150 characters.
# Your product’s name.
# Example: Mens Pique Polo Shirt.
# - Accurately describe your product and match the title from your landing page
# - Don’t include promotional text like "free shipping," all capital letters, or gimmicky foreign characters
# For variants: include a distinguishing feature such as color or size.»
# https://support.google.com/merchants/answer/7052112#title
# 4) Use the title attribute to clearly identify the product you’re selling.
# The title is one of the most prominent parts of your ad or free listing.
# A specific and accurate title will help us show your product to the right users.
# https://support.google.com/merchants/answer/6324415
# 5) «If your title does not fit within the maximum character limit, Google will truncate it to fit.
# You will receive a warning indicating that the title has been truncated.»
# https://support.google.com/merchants/answer/6324415#Guidelines
final class Title extends \TFC\GoogleShopping\Att {
	/**
	 * 2021-12-20
	 * @override
	 * @see \TFC\GoogleShopping\Att::v()
	 * @used-by \TFC\GoogleShopping\Products::atts()
	 * @return string
	 */
	function v() {return $this->p()->getName();}
}