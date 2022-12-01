<?php
namespace TFC\GoogleShopping\Att;
# 2021-12-22 "Implement the `mpn` attribute": https://github.com/tradefurniturecompany/google-shopping/issues/9
/** @used-by \TFC\GoogleShopping\Products::_p() */
final class Mpn extends \TFC\GoogleShopping\Att {
	/**
	 * 2021-12-22
	 * @override
	 * @see \TFC\GoogleShopping\Att::v()
	 * @used-by \TFC\GoogleShopping\Products::atts()
	 */
	function v():string {return $this->p()->getSku();}
}