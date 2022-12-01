<?php
namespace TFC\GoogleShopping\Att;
use Magento\Catalog\Model\Product as P;
# 2021-12-21
# 1) "Implement the `sale_price` attribute": https://github.com/tradefurniturecompany/google-shopping/issues/4
/** @used-by \TFC\GoogleShopping\Products::_p() */
final class SalePrice extends \TFC\GoogleShopping\Att {
	/**
	 * 2021-12-21
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
	function v():string {
		$p = $this->p(); /** @var P $p */
		list($reg, $fin) = Price::regFin($p); /** @var float|int $reg */  /** @var float|int $fin */
		return dff_eq($fin, $reg) ? '' : Price::format($p, $fin);
	}
}