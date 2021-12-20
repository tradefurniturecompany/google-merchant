<?php
namespace TFC\GoogleShopping\Att;
# 2021-12-19
# 1) Required. «Accurately submit the product's availability
# and match the availability from your landing page and checkout pages.
# Supported values
# 	- In stock [in_stock]
#	- Out of stock [out_of_stock]
#	- Preorder [preorder]
#	- Backorder [backorder]
# » https://support.google.com/merchants/answer/7052112#availability
# 2.1) «Minimum requirements
# These are the requirements you'll need to meet to show your product.
# If you don't follow these requirements, we'll disapprove your product
# and let you know in the Diagnostics page in your Merchant Center account.
# 	- 	Indicate the product availability on your landing page.
#		Learn more about requirements for landing pages: https://support.google.com/merchants/answer/4752265
#	-	Match your product availability with your account shipping settings.
#		Learn more about shipping settings: https://support.google.com/merchants/answer/6069284
#		-	Ship the product to all of the locations
#			that you support in your product data and account shipping settings.
#			This way the availability that users see will match what you submit.
#		-	Match the availability listed in your product data
#			with the availability listed on your landing page and checkout pages.
#			When users come to your website,
#			they expect to see the same availability on your landing page and during checkout
#			that's provided in your product data.
#			One common availability mismatch
#			is that your shipping settings don’t reflect your delivery locations correctly.
#			For example, make sure that you can physically deliver a product to the state of California
#			through specifying the shipping costs to deliver to California.
#			Learn more about shipping settings: https://support.google.com/merchants/answer/6069284
#		-	Make sure the product can be shipped, not just picked up in store.
#			In-store pickup is not currently supported with the exception of Argentina and Chile.
#	-	Provide the most up-to-date data.
#		Availability and prices of your products can change quite frequently.
#		Learn more about maintaining high-quality product data: https://support.google.com/merchants/answer/188489
#	-	Provide the availability date [availability_date] attribute
#		(https://support.google.com/merchants/answer/6324470)
#		if you’re submitting preorder or backorder as the availability value.
# » https://support.google.com/merchants/answer/6324448
# 2.2) «Best practices
# 	-	When your product is temporarily unavailable in the country of sale and you’re not accepting orders for it,
#		set the availability [availability] attribute to `out_of_stock`.
#		If we find that a product is "out of stock" on your landing page or during checkout,
#		but the availability attribute is set to `in_stock` in your product data, we'll disapprove the product.
#		The reason for the disapproval is to prevent you from paying for clicks to your product
#		(if you are using Shopping ads and listings) when you're not actually able to sell it.
# 		Instead of getting disapproved or confusing potential customers,
#		let us know that a product has gone out of stock so we can stop it from showing your product
#		until you're able to sell it again.
#	-	Don't set the availability attribute to `out_of_stock`
#		when you take your website down for maintenance or a holiday.
#		Use the excluded destination [excluded_destination] attribute instead:
#		https://support.google.com/merchants/answer/6324486.
#		By following this best practice, you'll prevent unnecessary disapprovals in your account
#		and get your products running again more quickly than if they'd been disapproved.
#		Learn more best practices for landing page maintenance or a site outage:
#		https://support.google.com/merchants/answer/6337960
#	-	Don’t use `out_of_stock` when you want to prevent showing your product.
#		If the product is available for sale but you’d like to stop your product showing on certain destinations,
#		use the excluded destination [excluded_destination] attribute:
# 		https://support.google.com/merchants/answer/6324486.
#		This way, you can, for example, disable your product from showing on Shopping ads,
#		but still show your products through other formats,
#		such as dynamic remarketing display ads or free product listings.
#	-	Don't set the availability attribute to `out_of_stock` for products that you're no longer selling.
#		Remove any discontinued products from your product data.
#	-	Consider using automatic item updates to help you avoid availability mismatches.
#		Automatic item updates is a feature that uses your landing page status
#		to automatically update your product data, preventing disapprovals.
#		Learn how to set up automatic item updates: https://support.google.com/merchants/answer/6324486
# » https://support.google.com/merchants/answer/6324448
final class Availability extends \TFC\GoogleShopping\Att {
	/**
	 * 2021-12-19
	 * @override
	 * @see \TFC\GoogleShopping\Att::v()
	 * @used-by \TFC\GoogleShopping\Products::atts()
	 * @return string
	 */
	function v() {return 'in_stock';}
}