<?php 

class loginBrokenLinkCheckerCest
{
    const LANGUAGE = "/en";
    const LOGIN_PATH = "/login";

    public function __construct()
    {
        $this->loginURL = self::LANGUAGE . self::LOGIN_PATH;
    }

    public function UserCanUseLinks(FunctionalTester $I)
    {
        $I->amOnPage($this->loginURL);
        $links = $I->grabMultiple(["css" => "footer a"], 'href');
        foreach ($links as $link) {
            $I->sendGET($link);
            $I->seeResponseCodeIsSuccessful();
        }
    }
}
