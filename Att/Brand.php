<?php
namespace TFC\GoogleShopping\Att;
# 2021-12-22 "Implement the `brand` attribute": https://github.com/tradefurniturecompany/google-shopping/issues/8
/** @used-by \TFC\GoogleShopping\Products::_p() */
final class Brand extends \TFC\GoogleShopping\Att {
	/**
	 * 2021-12-19
	 * @override
	 * @see \TFC\GoogleShopping\Att::v()
	 * @used-by \TFC\GoogleShopping\Products::atts()
	 * @return string
	 */
	function v() {
		static $c; $c = $c ?: df_category_children_map(1540); /** @var array(int => string) $c */
		$p = $this->p();
		$k = df_first(array_intersect(df_int($p->getCategoryIds()), array_keys($c)));
		return !$k ? $p->getStore()->getFrontendName() : dfa($c, $k);
	}
}