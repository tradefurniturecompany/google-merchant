<?php
namespace TFC\GoogleShopping\Command;
use Google\Client as C;
use Google\Service\ShoppingContent as S;
use Google\Service\ShoppingContent\Account as Acc;
use Google\Service\ShoppingContent\AccountIdentifier as AccId;
use Google\Service\ShoppingContent\AccountsAuthInfoResponse as AuthInfo;
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
		$c = new C; /** @var C $c */
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
		$this->output()->writeln(__METHOD__);
	}
}