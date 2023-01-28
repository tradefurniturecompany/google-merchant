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
	private function _p():array {
		$pc = df_pc(); /** @var PC $pc */
		$pc->addAttributeToSelect('*');
		# 2021-12-20
		# A configurable product:
		# https://www.tradefurniturecompany.co.uk/admin/catalog/product/edit/id/119
		# https://www.tradefurniturecompany.co.uk/catalog/product/view/id/119
		#$pc->addAttributeToFilter('entity_id', 119);
		#$pc->addAttributeToFilter('entity_id', 1790);
		# 2021-12-21
		# A product with a special price:
		# https://www.tradefurniturecompany.co.uk/admin/catalog/product/edit/id/6063
		# https://www.tradefurniturecompany.co.uk/cream-barcelona-leather-dining-chair-t10
		#$pc->addAttributeToFilter('entity_id', [119, 6063]);
		# 2021-12-22
		# https://www.tradefurniturecompany.co.uk/admin/catalog/product/edit/id/6219
		#$pc->addAttributeToFilter('sku', 'T57');
		#$pc->getSelect()->limit(1);
		/**
		 * 2021-12-20
		 * @uses \Magento\Catalog\Model\ResourceModel\Product\Collection::setVisibility() filters out disabled products:
		 * https://github.com/JustunoCom/m2/blob/1.7.3/Controller/Response/Catalog.php#L46-L48
		 */
		$pc->setVisibility([V::VISIBILITY_BOTH, V::VISIBILITY_IN_CATALOG, V::VISIBILITY_IN_SEARCH]);
		$pc->addMediaGalleryData(); # 2019-11-20 https://magento.stackexchange.com/a/228181
		return array_values(df_map($pc, function(P $p) {return dfak_prefix($this->atts($p, [
			\TFC\GoogleShopping\Att\AdditionalImageLink::class
			,\TFC\GoogleShopping\Att\Availability::class
			,\TFC\GoogleShopping\Att\Brand::class
			,\TFC\GoogleShopping\Att\Description::class
			,\TFC\GoogleShopping\Att\Id::class
			,\TFC\GoogleShopping\Att\ImageLink::class
			,\TFC\GoogleShopping\Att\Link::class
			,\TFC\GoogleShopping\Att\Mpn::class
			,\TFC\GoogleShopping\Att\Price::class
			,\TFC\GoogleShopping\Att\SalePrice::class
			,\TFC\GoogleShopping\Att\Title::class
		]), 'g:', true);}));
	}

	/**
	 * 2021-12-19
	 * @used-by self::_p()
	 * @param string[] $a
	 */
	private function atts(P $p, array $a):array {return df_map_r($a, function($c) use($p):array {
		$i = new $c($p); /** @var Att $i */
		return [df_camel_to_underscore(df_class_l($c)), $i->v()];
	});}

	/**
	 * 2021-12-06
	 * @used-by \TFC\GoogleShopping\Controller\Index\Index::execute()
	 * @return array(array(string => mixed))
	 */
	static function p():array {$i = new self; return $i->_p();}
}