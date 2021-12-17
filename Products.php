<?php
namespace TFC\GoogleShopping;
use Magento\Catalog\Model\Product as P;
use Magento\Catalog\Model\Product\Visibility as V;
use Magento\Catalog\Model\ResourceModel\Product\Collection as PC;
# 2021-12-06
# "Setup an automatic integration between Magento and Google Merchant Center":
# https://github.com/tradefurniturecompany/google-shopping/issues/1
final class Products {
	/**
	 * 2021-21-06
	 * @used-by \TFC\GoogleShopping\Products::p()
	 * @return array(array(string => mixed))
	 */
	private function _p() {
		$pc = df_pc(); /** @var PC $pc */
		#$pc->getSelect()->limit(1);
		$pc->addAttributeToSelect('*');
		#$pc->addAttributeToFilter('entity_id', 119);
		$pc->setVisibility([V::VISIBILITY_BOTH, V::VISIBILITY_IN_CATALOG, V::VISIBILITY_IN_SEARCH]);
		$pc->addMediaGalleryData(); # 2019-11-20 https://magento.stackexchange.com/a/228181
		return array_values(df_map($pc, function(P $p) {return dfak_prefix([
			'additional_image_link' => []
			# 2021-11-24
			# 1) https://github.com/googleads/googleads-shopping-samples/blob/053bc550/php/ProductsSample.php#L216
			# 2) https://developers.google.com/shopping-content/reference/rest/v2.1/products#Product.FIELDS.description
			# 3) «Required. Max 5000 characters.
			# Use formatting (for example, line breaks, lists, or italics) to format your description»
			# https://support.google.com/merchants/answer/7052112#description
			# 4) «If your description does not fit within the character limit, Google will truncate it to fit.
			# You will receive a warning indicating that the description has been truncated.»
			# https://support.google.com/merchants/answer/6324468#Guidelines
			,'description' => $p->getDescription()
			# 2021-11-24
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
			,'id' => $p->getSku()
			# 2021-11-24
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
			,'image_link' => df_product_image_url($p)
			# 2021-11-24
			# 1) https://github.com/googleads/googleads-shopping-samples/blob/053bc550/php/ProductsSample.php#L217
			# 2) «String. URL directly linking to your item's page on your website.»
			# https://developers.google.com/shopping-content/reference/rest/v2.1/products#Product.FIELDS.link
			# 3) «Required. Your product’s landing page.» https://support.google.com/merchants/answer/7052112#link
			# 4) https://support.google.com/merchants/answer/6324416
			,'link' => $p->getProductUrl()
			# 2021-11-24
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
			,'title' => $p->getName()
		], 'g:', true);}));
	}

	/**
	 * 2021-12-06
	 * @used-by \TFC\GoogleShopping\Controller\Index\Index::execute()
	 * @return array(array(string => mixed))
	 */
	static function p() {$i = new self; return $i->_p();}
}