<?php 

class loginBrokenLinkCheckerCest
{
    // tests
    public function UserCanUseLinks(FunctionalTester $I)

    {
        $I->amOnPage('/');
        $links = $I->grabMultiple('footer .footer-info-holder a', 'href');
        foreach ($links as $link) {
            $I->sendGET($link);
            $I->seeResponseCodeIsSuccessful();
        }
    }
}
