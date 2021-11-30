<?php
namespace TFC\GoogleShopping\Command;
use Google\Client as Cl;
use Google\Service\ShoppingContent as S;
use Google\Service\ShoppingContent\Account as Acc;
use Google\Service\ShoppingContent\AccountIdentifier as AccId;
use Google\Service\ShoppingContent\AccountsAuthInfoResponse as AuthInfo;
use Google\Service\ShoppingContent\Product as gP;
use Magento\Catalog\Model\Category as C;
use Magento\Catalog\Model\Product as P;
# 2021-11-22
# "Setup an automatic integration between Magento and Google Merchant Center":
# https://github.com/tradefurniturecompany/google-shopping/issues/1
final class C1 extends \Df\Framework\Console\Command {
	/**
	 * 2021-11-22
	 * @override
	 * @see \Symfony\Component\Console\Command\Command::configure()
	 * @used-by \Symfony\Component\Console\Command\Command::__construct()
	 */
	protected function configure() {
		$this->setName('tfc:google-shopping:1');
		$this->setDescription("An integration with Google Merchant Center via the Google's Content API for Shopping");
	}

	/**
	 * 2021-11-22
	 * @override
	 * @see \Df\Framework\Console\Command::p()
	 * @used-by \Df\Framework\Console\Command::execute()
	 */
	protected function p() {
		df_google_init_service_account();
		# 2021-11-22
		# https://github.com/googleapis/google-api-php-client/blob/v2.11.0/README.md#authentication-with-service-accounts
		$c = new Cl; /** @var Cl $c */
		# 2021-11-22
		# 1) https://github.com/googleapis/google-api-php-client/blob/v2.11.0/README.md#authentication-with-service-accounts
		# 2) https://github.com/googleads/googleads-shopping-samples/blob/053bc550/php/ContentSession.php#L339
		$c->useApplicationDefaultCredentials();
		# 2021-11-22 https://github.com/googleads/googleads-shopping-samples/blob/053bc550/php/ContentSession.php#L69
		$c->setScopes(S::CONTENT);
		# 2021-11-24 https://github.com/googleads/googleads-shopping-samples/blob/053bc550/php/ContentSession.php#L118
		$s = new S($c); /** @var S $s */
		# 2021-11-24
		# 1) https://github.com/googleads/googleads-shopping-samples/blob/053bc550/php/ContentSession.php#L195
		# 2) https://developers.google.com/shopping-content/reference/rest/v2.1/accounts/authinfo
		$authInfo = $s->accounts->authinfo(); /** @var AuthInfo $authInfo */
		# 2021-11-24
		# 1) https://github.com/googleads/googleads-shopping-samples/blob/053bc550/php/ContentSession.php#L206
		# 2) https://developers.google.com/shopping-content/reference/rest/v2.1/accounts/authinfo#body.AccountsAuthInfoResponse.FIELDS.account_identifiers
		$accId = df_first($authInfo->getAccountIdentifiers()); /** @var AccId $accId */
		# 2021-11-24
		# 1) https://github.com/googleads/googleads-shopping-samples/blob/053bc550/php/ContentSession.php#L208
		# 2) https://developers.google.com/shopping-content/reference/rest/v2.1/accounts/authinfo#AccountIdentifier.FIELDS.merchant_id
		$merchantId = (int)$accId->getMerchantId(); /** @var int $merchantId */
		# 2021-11-24
		# 1) https://github.com/googleads/googleads-shopping-samples/blob/053bc550/php/ContentSession.php#L233
		# 2) https://developers.google.com/shopping-content/reference/rest/v2.1/accounts/get
		$acc = $s->accounts->get($merchantId, $merchantId); /** @var Acc $acc */
		# 2021-11-24
		# 1) https://github.com/googleads/googleads-shopping-samples/blob/053bc550/php/ContentSession.php#L235
		# 2) https://developers.google.com/shopping-content/reference/rest/v2.1/accounts#Account.FIELDS.website_url
		$websiteUrl = $acc->getWebsiteUrl(); /** @var string $websiteUrl */
		$gp = $this->gp(1); /** @var gP $gp */
		$this->output()->writeln(__METHOD__);
	}

	/**
	 * 2021-11-30
	 * @param P $p
	 * @return string|null
	 */
	private function brand(P $p) {return dfa(
		$c = df_category_children_map(1540), df_first(array_intersect(df_int($p->getCategoryIds()), array_keys($c)))
	);}

	/**
	 * 2021-11-24
	 * @used-by p()
	 * @param int $id
	 * @return gP
	 */
	private function gp($id) {
		$p = df_product($id); /** @var P $p */
		# 2021-11-24 https://github.com/googleads/googleads-shopping-samples/blob/053bc550/php/ProductsSample.php#L212
		$r = new gP; /** @var gP $r */
		# 2021-11-24
		# 1) https://github.com/googleads/googleads-shopping-samples/blob/053bc550/php/ProductsSample.php#L214
		# 2) String, required.
		# «A unique identifier for the item.
		# Leading and trailing whitespaces are stripped
		# and multiple whitespaces are replaced by a single whitespace upon submission.
		# Only valid unicode characters are accepted.
		# See the products feed specification for details: https://support.google.com/merchants/answer/7052112#id
		# Note: Content API methods that operate on products take the REST ID of the product, not this identifier.»
		# https://developers.google.com/shopping-content/reference/rest/v2.1/products#Product.FIELDS.offer_id
		# 3) «Required. Max 50 characters.
		# Your product’s unique identifier.
		# Example: A2B4.
		# Use a unique value for each product.
		# - Use the product's SKU where possible.
		# - Keep the ID the same when updating your data.
		# - Use only valid unicode characters.
		# - Avoid invalid characters like control, function, or private area characters.
		# - Use the same ID for the same product - across countries or languages»
		# https://support.google.com/merchants/answer/7052112#id
		# 4) «Use the ID [id] attribute to uniquely identify each product.
		# The ID won’t be shown to customers who view your products online.
		# However, you can use the ID to look up your product, place bids, and check a product's performance.
		# We recommend that you use your product SKU for this value.»
		# https://support.google.com/merchants/answer/6324405
		$r->setOfferId($p->getSku());
		# 2021-11-24
		# 1) https://github.com/googleads/googleads-shopping-samples/blob/053bc550/php/ProductsSample.php#L215
		# 2) String. «Title of the item»
		# https://developers.google.com/shopping-content/reference/rest/v2.1/products#Product.FIELDS.title
		# 3) «Required. Max 150 characters.
		# Your product’s name.
		# Example: Mens Pique Polo Shirt.
		# - Accurately describe your product and match the title from your landing page
		# - Don’t include promotional text like "free shipping," all capital letters, or gimmicky foreign characters
		# For variants: include a distinguishing feature such as color or size.»
		# https://support.google.com/merchants/answer/7052112#title
		# 4) Use the title attribute to clearly identify the product you’re selling.
		# The title is one of the most prominent parts of your ad or free listing.
		# A specific and accurate title will help us show your product to the right users.
		# https://support.google.com/merchants/answer/6324415
		# 5) «If your title does not fit within the maximum character limit, Google will truncate it to fit.
		# You will receive a warning indicating that the title has been truncated.»
		# https://support.google.com/merchants/answer/6324415#Guidelines
		$r->setTitle($p->getName());
		# 2021-11-24
		# 1) https://github.com/googleads/googleads-shopping-samples/blob/053bc550/php/ProductsSample.php#L216
		# 2) https://developers.google.com/shopping-content/reference/rest/v2.1/products#Product.FIELDS.description
		# 3) «Required. Max 5000 characters.
		# Use formatting (for example, line breaks, lists, or italics) to format your description»
		# https://support.google.com/merchants/answer/7052112#description
		# 4) «If your description does not fit within the character limit, Google will truncate it to fit.
		# You will receive a warning indicating that the description has been truncated.»
		# https://support.google.com/merchants/answer/6324468#Guidelines
		$r->setDescription($p->getDescription());
		# 2021-11-24
		# 1) https://github.com/googleads/googleads-shopping-samples/blob/053bc550/php/ProductsSample.php#L217
		# 2) «String. URL directly linking to your item's page on your website.»
		# https://developers.google.com/shopping-content/reference/rest/v2.1/products#Product.FIELDS.link
		# 3) «Required. Your product’s landing page.» https://support.google.com/merchants/answer/7052112#link
		# 4) https://support.google.com/merchants/answer/6324416
		$r->setLink($p->getProductUrl());
		# 2021-11-24
		# 1) https://github.com/googleads/googleads-shopping-samples/blob/053bc550/php/ProductsSample.php#L218-L219
		# 2) https://developers.google.com/shopping-content/reference/rest/v2.1/products#Product.FIELDS.image_link
		# 3) «Required. The URL of your product’s main image. Don't submit a placeholder or a generic image.»
		# https://support.google.com/merchants/answer/7052112#image_link
		# 4) «If you have multiple, different images of the product,
		# submit the main image using the image link [image_link] attribute,
		# and include all other images in the additional image link [additional_image_link] attribute.»
		# https://support.google.com/merchants/answer/6324350
		# 5) «Once you submit your product data, the image will typically be crawled within 3 days.»
		# https://support.google.com/merchants/answer/6324350#urlguidelines
		# 6) «If you need to change an image of an existing product, submit a new URL for the new image.
		# When you submit a new URL, the image will be crawled within 3 days.
		# Keep in mind that if you change the image, but keep the same URL,
		# it may take a while to detect the change and recrawl the new image.»
		# https://support.google.com/merchants/answer/6324350#urlguidelines
		$r->setImageLink(df_product_image_url($p));
		# 2021-11-24
		# 1) https://developers.google.com/shopping-content/reference/rest/v2.1/products#Product.FIELDS.additional_image_links
		# 2) Optional. «Submit up to 10 additional product images»:
		# https://support.google.com/merchants/answer/7052112#additional_image_link
		# 3) https://support.google.com/merchants/answer/6324370
		$r->setAdditionalImageLinks(df_product_images_additional($p, 10));
		# 2021-11-24
		# 1) https://github.com/googleads/googleads-shopping-samples/blob/053bc550/php/ProductsSample.php#L220
		# 2) String, required.
		# «The two-letter ISO 639-1 language code for the item.»
		# https://developers.google.com/shopping-content/reference/rest/v2.1/products#Product.FIELDS.content_language
		$r->setContentLanguage('en');
		# 2021-11-30
		# 1) https://github.com/googleads/googleads-shopping-samples/blob/053bc550/php/ProductsSample.php#L221
		# 2) https://github.com/googleads/googleads-shopping-samples/blob/053bc550/php/ProductsSample.php#L28-L29
		# 3) String, required.
		# «The CLDR territory code for the item.»
		# https://developers.google.com/shopping-content/reference/rest/v2.1/products#Product.FIELDS.target_country
		# 4) https://github.com/unicode-org/cldr/blob/release-40/common/main/en.xml#L996
		# 5) https://github.com/unicode-org/cldr/blob/release-40/common/main/en.xml#L1163-L1164
		$r->setTargetCountry('GB');
		# 2021-11-30
		# 1) https://github.com/googleads/googleads-shopping-samples/blob/053bc550/php/ProductsSample.php#L222
		# 2) https://github.com/googleads/googleads-shopping-samples/blob/053bc550/php/ProductsSample.php#L24-L25
		# 3) String, required.
		# «The item's channel (online or local). Acceptable values are: "local", "online".»
		# https://developers.google.com/shopping-content/reference/rest/v2.1/products#Product.FIELDS.channel
		$r->setChannel('online');
		# 2021-11-30
		# String, optional. «Brand of the item.»
		# https://developers.google.com/shopping-content/reference/rest/v2.1/products#Product.FIELDS.brand
		$r->setBrand($this->brand($p));
		# 2021-12-01
		# 1) String, optional. «Color of the item.»
		# https://developers.google.com/shopping-content/reference/rest/v2.1/products#Product.FIELDS.color
		# 2.1)
		# 	-	Required for all apparel products in feeds
		# 		that are targeted to Brazil, France, Germany, Japan, the UK, and the US
		#		as well as all products available in different colors).
		#	-	Required for enhanced free listings for all Apparel & Accessories (ID: 166) products.
		#	-	Optional for all other products and countries of sale.
		# 2.2) Example: «Black».
		# 2.3) Syntax: Max 100 alphanumeric characters (max 40 characters per color).
		# https://support.google.com/merchants/answer/7052112#color
		# 3.1) «Use the color [color] attribute to describe your product’s color.
		# This information helps create accurate filters, which customers can use to narrow search results.
		# If your product has variants that vary by color, use this attribute to provide that information.»
		# 3.2) «Include up to 3 colors.
		# If your product is made up of several colors, you can specify 1 primary color followed by up to 2 secondary colors
		# that are each separated by a slash ( / ). For example: Red/Green/Black.»
 		# https://support.google.com/merchants/answer/6324487
		$r->setColor('');
		# 2021-12-01
		# 1) String, optional.
		# «Google's category of the item (see Google product taxonomy: https://support.google.com/merchants/answer/6324436).
		# When querying products, this field will contain the user provided value.
		# There is currently no way to get back the auto assigned google product categories through the API.»
		# https://developers.google.com/shopping-content/reference/rest/v2.1/products#Product.FIELDS.google_product_category
		# 2) «You can use these attributes to organize your advertising campaigns in Google Ads
		# and to override Google’s automatic product categorization in specific cases.»
		# https://support.google.com/merchants/answer/7052112#intro-product-category
		# 3.1) «Google-defined product category for your product».
		# 3.2 «Example: Apparel & Accessories > Clothing > Outerwear > Coats & JacketsExample».
		# 3.3) «Syntax: Value from the Google product taxonomy
		# 	- The numerical category ID
		#	- or The full path of the category»
		# https://support.google.com/merchants/answer/7052112#google_product_category
		# 4.1) «All products are automatically assigned a product category from Google’s continuously evolving product taxonomy.
		# Providing high-quality, on-topic titles and descriptions, as well as accurate pricing, brand, and GTIN information
		# will help ensure your products are correctly categorized.»
		# 4.2) «The Google product category [google_product_category] attribute is optional,
		# and can be used to override Google’s automatic categorization in specific cases.»
		# 4.3)
		# «Google will only accept a product category override in the following cases:
		# 4.3.1) Calculation of US taxes.
		# For products sold in the US, you can override Google’s automatic categorization
		# to ensure that the correct US tax rate is applied to your product.
		# 4.3.2) Enforcement of category-specific attribute requirements.
		# Some product categories (such as Apparel & Accessories, Mobile Phones, or Software) impose additional required fields.
		# If Google incorrectly assigns your product to one of these categories,
		# use this attribute to override the categorization and remove the category-specific requirements.
		# 4.3.3) Targeting of Google Ads campaigns.
		# If you’ve defined any of your ad campaigns based upon Google’s product categories,
		# you can use this attribute to reassign products within your campaign structure.
		# Learn more about managing a Shopping campaign with product groups: https://support.google.com/google-ads/answer/6275317
		# 4.3.4) Alcohol. Alcoholic beverages must be correctly categorized.
		# If the category of your product is incorrectly assigned,
		# you can use the Google product category [google_product_category] attribute to override it
		#and ensure that your product remains compliant.
		# Learn more about our alcoholic beverages policy.»
		# 4.4) Download a list of all Google product categories:
		# 4.4.1) http://www.google.com/basepages/producttype/taxonomy-with-ids.en-US.xls
		# 4.4.2) http://www.google.com/basepages/producttype/taxonomy-with-ids.en-US.txt
		# https://support.google.com/merchants/answer/6324436
		$r->setGoogleProductCategory('');
		return $r;
	}
}