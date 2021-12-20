<?php
namespace TFC\GoogleShopping;
use Magento\Catalog\Model\Product as P;
/**
 * 2021-12-19
 * "Setup an automatic integration between Magento and Google Merchant Center":
 * https://github.com/tradefurniturecompany/google-shopping/issues/1
 * @see \TFC\GoogleShopping\Att\Availability
 * @see \TFC\GoogleShopping\Att\Id
 * @see \TFC\GoogleShopping\Att\ImageLink
 * @see \TFC\GoogleShopping\Att\Title
 */
abstract class Att {
	/**
	 * 2021-12-19
	 * @used-by \TFC\GoogleShopping\Products::atts()
	 * @see \TFC\GoogleShopping\Att\Availability::v()
	 * @see \TFC\GoogleShopping\Att\Id::v()
	 * @see \TFC\GoogleShopping\Att\ImageLink::v()
	 * @see \TFC\GoogleShopping\Att\Title::v()
	 * @return string
	 */
	abstract function v();

	/**
	 * 2021-12-19
	 * @used-by \TFC\GoogleShopping\Products::atts()
	 * @param P $p
	 */
	final function __construct(P $p) {$this->_p = $p;}

	/**
	 * 2021-12-19
	 * @used-by \TFC\GoogleShopping\Att\Id::v()
	 * @used-by \TFC\GoogleShopping\Att\ImageLink::v()
	 * @used-by \TFC\GoogleShopping\Att\Title::v()
	 * @return P
	 */
	final protected function p() {return $this->_p;}

	/**
	 * 2021-12-19
	 * @used-by __construct()
	 * @used-by p()
	 * @var P
	 */
	private $_p;
}