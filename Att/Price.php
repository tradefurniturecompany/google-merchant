<?php
namespace TFC\GoogleShopping\Att;
# 2021-12-20
final class Price extends \TFC\GoogleShopping\Att {
	/**
	 * 2021-12-20
	 * @override
	 * @see \TFC\GoogleShopping\Att::v()
	 * @used-by \TFC\GoogleShopping\Products::atts()
	 * @return string
	 */
	function v() {return df_cc_s($this->p()->getFinalPrice(), $this->p()->getStore()->getDefaultCurrencyCode());}
}