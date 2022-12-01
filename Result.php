<?php
namespace TFC\GoogleShopping;
# 2021-12-03 https://support.google.com/merchants/answer/160567
/** @final Unable to use the PHP «final» keyword here because of the M2 code generation. */
class Result extends \Df\Framework\W\Result\Xml {
	/**
	 * 2021-12-03
	 * @override
	 * @see \Df\Framework\W\Result\Xml::attributes()
	 * @used-by \Df\Framework\W\Result\Xml::__toString()
	 * @return array(string => mixed)
	 */
	final protected function attributes():array {return ['version' => '2.0', 'xmlns:g' => 'http://base.google.com/ns/1.0'];}

	/**
	 * 2021-12-03
	 * @override
	 * @see \Df\Framework\W\Result\Xml::contents()
	 * @used-by \Df\Framework\W\Result\Xml::__toString()
	 * @return array(string => mixed)
	 */
	protected function contents():array {return ['channel' => [
		'created_at' => df_dts(null, 'y-MM-dd HH:mm'), 'item' => $this->_products
	]];}

	/**
	 * 2021-12-03
	 * @override
	 * @see \Df\Framework\W\Result\Xml::tag()
	 * @used-by \Df\Framework\W\Result\Xml::__toString()
	 */
	final protected function tag():string {return 'rss';}

	/**
	 * 2021-12-03
	 * @used-by self::contents()
	 * @used-by self::i()
	 * @var array(array(string => mixed))
	 */
	private $_products;

	/**
	 * 2021-12-03
	 * @used-by \TFC\GoogleShopping\Controller\Index\Index::p()
	 * @param array(array(string => mixed)) $p
	 */
	final static function i(array $p):self {/** @var self $i */ $i = new self; $i->_products = $p; return $i;}
}