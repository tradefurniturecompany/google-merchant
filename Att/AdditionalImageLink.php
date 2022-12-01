<?php
namespace TFC\GoogleShopping\Att;
# 2021-11-24, 2021-12-20
# 1) https://developers.google.com/shopping-content/reference/rest/v2.1/products#Product.FIELDS.additional_image_links
# 2) Optional. «Submit up to 10 additional product images»:
# https://support.google.com/merchants/answer/7052112#additional_image_link
# 3) https://support.google.com/merchants/answer/6324370
/** @used-by \TFC\GoogleShopping\Products::_p() */
final class AdditionalImageLink extends \TFC\GoogleShopping\Att {
	/**
	 * 2021-12-20
	 * @override
	 * @see \TFC\GoogleShopping\Att::v()
	 * @used-by \TFC\GoogleShopping\Products::atts()
	 */
	function v():string {return df_product_images_additional($this->p(), 10);}
}