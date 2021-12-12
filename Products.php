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
	 * @used-by p()
	 * @return array(array(string => mixed))
	 */
	private function _p() {
		$pc = df_pc(); /** @var PC $pc */
		$pc->addAttributeToSelect('*');
		$pc->setVisibility([V::VISIBILITY_BOTH, V::VISIBILITY_IN_CATALOG, V::VISIBILITY_IN_SEARCH]);
		$pc->addMediaGalleryData(); # 2019-11-20 https://magento.stackexchange.com/a/228181
		return array_values(df_map($pc, function(P $p) {return [
			'name' => $p->getName()
		];}));
	}

	/**
	 * 2021-21-06
	 * @return array(array(string => mixed))
	 */
	static function p() {$i = new self; return $i->_p();}
}