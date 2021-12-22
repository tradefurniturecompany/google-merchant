<?php
namespace TFC\GoogleShopping\Att;
# 2021-12-21
# 1) "Implement the `sale_price` attribute": https://github.com/tradefurniturecompany/google-shopping/issues/4
/** @used-by \TFC\GoogleShopping\Products::_p() */
final class SalePrice extends \TFC\GoogleShopping\Att {
	/**
	 * 2021-12-21
	 * @override
	 * @see \TFC\GoogleShopping\Att::v()
	 * @used-by \TFC\GoogleShopping\Products::atts()
	 * @return string|null
	 */
	function v() {$p = $this->p(); return !($a = df_price_special($p)) ? null : Price::format($p, $a);}
}