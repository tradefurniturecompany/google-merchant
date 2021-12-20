<?php
namespace TFC\GoogleShopping;
use Magento\Catalog\Model\Product as P;
use Magento\Catalog\Model\Product\Visibility as V;
use Magento\Catalog\Model\ResourceModel\Product\Collection as PC;
use TFC\GoogleShopping\Att;
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
		return array_values(df_map($pc, function(P $p) {return dfak_prefix(df_ksort($this->atts($p, [
			\TFC\GoogleShopping\Att\Availability::class
			,\TFC\GoogleShopping\Att\Id::class
			,\TFC\GoogleShopping\Att\ImageLink::class
			,\TFC\GoogleShopping\Att\Title::class
		]) + [
			# 2021-11-24
			# 1) https://developers.google.com/shopping-content/reference/rest/v2.1/products#Product.FIELDS.additional_image_links
			# 2) Optional. «Submit up to 10 additional product images»:
			# https://support.google.com/merchants/answer/7052112#additional_image_link
			# 3) https://support.google.com/merchants/answer/6324370
			'additional_image_link' => df_product_images_additional($p, 10)
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
			# 1) https://github.com/googleads/googleads-shopping-samples/blob/053bc550/php/ProductsSample.php#L217
			# 2) «String. URL directly linking to your item's page on your website.»
			# https://developers.google.com/shopping-content/reference/rest/v2.1/products#Product.FIELDS.link
			# 3) «Required. Your product’s landing page.» https://support.google.com/merchants/answer/7052112#link
			# 4) https://support.google.com/merchants/answer/6324416
			,'link' => $p->getProductUrl()
		]), 'g:', true);}));
	}

	/**
	 * 2021-12-19
	 * @used-by _p()
	 * @param P $p
	 * @param string[] $a
	 * @return array(string => string)
	 */
	private function atts(P $p, array $a) {return df_map_r($a, function($c) use($p) {
		$i = new $c($p); /** @var Att $i */
		return [df_camel_to_underscore(df_class_l($c)), $i->v()];
	});}

	/**
	 * 2021-12-06
	 * @used-by \TFC\GoogleShopping\Controller\Index\Index::execute()
	 * @return array(array(string => mixed))
	 */
	static function p() {$i = new self; return $i->_p();}
}