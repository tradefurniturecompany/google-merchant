<?php
namespace TFC\GoogleShopping\Att;
# 2021-11-24, 2021-12-19
# 1) https://github.com/googleads/googleads-shopping-samples/blob/053bc550/php/ProductsSample.php#L218-L219
# 2) https://developers.google.com/shopping-content/reference/rest/v2.1/products#Product.FIELDS.image_link
# 3) «Required. The URL of your product’s main image. Don't submit a placeholder or a generic image.»
# https://support.google.com/merchants/answer/7052112#image_link
# 4) «If you have multiple, different images of the product,
# submit the main image using the image link [image_link] attribute,
# and include all other images in the additional image link [additional_image_link] attribute.»
# https://support.google.com/merchants/answer/6324350
# 5) «Once you submit your product data, the image will typically be crawled within 3 days.»
# https://support.google.com/merchants/answer/6324350#urlguidelines
# 6) «If you need to change an image of an existing product, submit a new URL for the new image.
# When you submit a new URL, the image will be crawled within 3 days.
# Keep in mind that if you change the image, but keep the same URL,
# it may take a while to detect the change and recrawl the new image.»
# https://support.google.com/merchants/answer/6324350#urlguidelines
final class ImageLink extends \TFC\GoogleShopping\Att {
	/**
	 * 2021-12-19
	 * @override
	 * @see \TFC\GoogleShopping\Att::v()
	 * @used-by \TFC\GoogleShopping\Products::atts()
	 * @return string
	 */
	function v() {return df_product_image_url($this->p());}
}