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
	final protected function attributes() {return ['version' => '2.0', 'xmlns:g' => 'http://base.google.com/ns/1.0'];}

	/**
	 * 2021-12-03
	 * @override
	 * @see \Df\Framework\W\Result\Xml::contents()
	 * @used-by \Df\Framework\W\Result\Xml::__toString()
	 * @return array(string => mixed)
	 */
	protected function contents() {return ['channel' => []];}

	/**
	 * 2021-12-03
	 * @override
	 * @see \Df\Framework\W\Result\Xml::tag()
	 * @used-by \Df\Framework\W\Result\Xml::__toString()
	 * @return string
	 */
	final protected function tag() {return 'rss';}
}