<?php

class loginPageCest
{
    private $magicWord;
    private $loginURL;
    private $appStoreID;
    private $playStoreID;
    private $email;
    private $password;
    private $nonExistentUser;
    private $phone;

    const LANGUAGE = "/en";
    const LOGIN_PATH = "/login";
    const HOME_BODY = "body.layout-front-page";

    public function _before(\AcceptanceTester $I)
    {
        $this->magicWord = getenv("MAGIC_WORD");
        $this->loginURL = self::LANGUAGE . self::LOGIN_PATH;
        $this->appStoreID = getenv("APP_STORE_ID");
        $this->playStoreID = 'lt.lemonlabs.android.' . $this->magicWord;
        $this->email = getenv("EMAIL");
        $this->password = getenv("PASSWORD");
        $this->nonExistentUser = getenv("NON_EXISTENT_USER");
        $this->phone = getenv("PHONE");
    }
// tests
    public function UserCanReturnHome(AcceptanceTester $I)
    {
        $I->amOnPage($this->loginURL);
        $I->waitForElementVisible(["css" => ".{$this->magicWord}-logo > a"]);
        $I->click(["css" => ".{$this->magicWord}-logo > a"]);
        $I->seeElement(self::HOME_BODY);
    }

    public function UserCanDownloadIOSApp(AcceptanceTester $I)
    {
        $I->amOnPage($this->loginURL);
        $I->click("App Store");
        $I->switchToNextTab();
        $I->seeInCurrentUrl($this->appStoreID);
        $I->closeTab();
    }

    public function UserCanDownloadAndroidApp(AcceptanceTester $I)
    {
        $I->amOnPage($this->loginURL);
        $I->click("Google Play");
        $I->switchToNextTab();
        $I->seeInCurrentUrl($this->playStoreID);
        $I->closeTab();
    }

    public function UserCanChooseLanguage(AcceptanceTester $I)
    {
        $I->amOnPage($this->loginURL);
        $I->seeElement(["id" => "react-language-list-container"]);
        $I->click(["css" => "#react-language-list-container li > span[role='button']"]);
        $I->waitForElementVisible(["class"=>"modal-content"]);
        $I->seeElement(["class"=>"modal-content"]);
        $I->click(["css" => ".modal-header .close"]);
        $I->waitForElementNotVisible(["class"=>"modal-content"]);
        $I->dontSeeElement(["class"=>"modal-content"]);
    }

    public function UserCanLogInWithEmail(AcceptanceTester $I)
    {
        $I->amOnPage($this->loginURL);
        $I->waitForElementVisible(["id" => "userIdentifier"]);
        $I->fillField(["id" => "userIdentifier"], $this->email);
        $I->click(["css" => ".authentication-login-form-container button[type=\"submit\"]"]);
        $I->waitForElementVisible(["class" => "user-identifier-container"], 5);
        $I->seeElement(["class" => "user-identifier-container"]);
        $I->see($this->email, ["css" => ".identifier-block > strong"]);
        $I->waitForElementVisible(["css" => "a[aria-controls=\"login-methods-body-user_credentials\"]"]);
        $I->wait(3);
        $I->click(["css" => "a[aria-controls=\"login-methods-body-user_credentials\"]"]);
        $I->waitForElementVisible(["id" => "password"]);
        $I->fillField(["id" => "password"], $this->password);
        $I->click(["css" => "#login-methods-body-user_credentials button[type=\"submit\"]"]);
        $I->waitForElementVisible(["id" => "navbar-logout-button"]);
        $I->seeElement(["id" => "navbar-logout-button"]);

    }

    public function UserCanLogInWithPhone(AcceptanceTester $I)
    {
        $I->amOnPage($this->loginURL);
        $I->waitForElementVisible(["id" => "userIdentifier"]);
        $I->fillField(["id" => "userIdentifier"], $this->phone);
        $I->click(["css" => ".authentication-login-form-container button[type=\"submit\"]"]);
        $I->waitForElementVisible(["class" => "user-identifier-container"], 5);
        $I->seeElement(["class" => "user-identifier-container"]);
        $I->see($this->phone, ["css" => ".identifier-block > strong"]);
        $I->waitForElementVisible(["css" => "a[aria-controls=\"login-methods-body-user_credentials\"]"]);
        $I->wait(3);
        $I->click(["css" => "a[aria-controls=\"login-methods-body-user_credentials\"]"]);
        $I->waitForElementVisible(["id" => "password"]);
        $I->fillField(["id" => "password"], $this->password);
        $I->click(["css" => "#login-methods-body-user_credentials button[type=\"submit\"]"]);
        $I->waitForElementVisible(["id" => "navbar-logout-button"]);
        $I->seeElement(["id" => "navbar-logout-button"]);
    }

    public function UserNonExistentErrorDisplayed(AcceptanceTester $I)
    {
        $I->amOnPage($this->loginURL);
        $I->waitForElementVisible(["id" => "userIdentifier"]);
        $I->dontSeeElement(["css" => ".authentication-login-form-container .alert"]);
        $I->fillField(["id" => "userIdentifier"], $this->nonExistentUser);
        $I->click(["css" => ".authentication-login-form-container button[type=\"submit\"]"]);
        $I->waitForElementVisible(["css" => ".authentication-login-form-container .alert"]);
        $I->SeeElement(["css" => ".authentication-login-form-container .alert"]);
    }

    public function UserCanRegister(AcceptanceTester $I)
    {
        $I->amOnPage($this->loginURL);
        $I->waitForElementVisible(["css" => ".text-center a"]);
        $I->click(["css" => ".text-center a"]);
        $I->waitForElementVisible(["id" => "registration-h1"]);
        $I->seeInCurrentUrl("registration");

    }

    public function UserCanChangePasswordWithEmail(AcceptanceTester $I)
    {
        $I->amOnPage($this->loginURL);
        $I->waitForElementVisible(["id" => "userIdentifier"]);
        $I->fillField(["id" => "userIdentifier"], $this->email);
        $I->click(["css" => ".authentication-login-form-container button[type=\"submit\"]"]);
        $I->waitForElementVisible(["css" => "a[aria-controls=\"login-methods-body-user_credentials\"]"]);
        $I->wait(3);
        $I->click(["css" => "a[aria-controls=\"login-methods-body-user_credentials\"]"]);
        $I->waitForElementVisible(["css" => "#login-methods-body-user_credentials .panel-body .text-center a"]);
        $I->click(["css" => "#login-methods-body-user_credentials .panel-body .text-center a"]);
        $I->waitForElementVisible(["css" => ".ng-scope .panel-body"]);
        $I->seeInCurrentUrl("reset-password");
    }

    public function UserCanChangePasswordWithPhone(AcceptanceTester $I)
    {
        $I->amOnPage($this->loginURL);
        $I->waitForElementVisible(["id" => "userIdentifier"]);
        $I->fillField(["id" => "userIdentifier"], $this->phone);
        $I->click(["css" => ".authentication-login-form-container button[type=\"submit\"]"]);
        $I->waitForElementVisible(["css" => "a[aria-controls=\"login-methods-body-user_credentials\"]"]);
        $I->wait(3);
        $I->click(["css" => "a[aria-controls=\"login-methods-body-user_credentials\"]"]);
        $I->waitForElementVisible(["css" => "#login-methods-body-user_credentials .panel-body .text-center a"]);
        $I->click(["css" => "#login-methods-body-user_credentials .panel-body .text-center a"]);
        $I->waitForElementVisible(["css" => ".ng-scope .panel-body"]);
        $I->seeInCurrentUrl("reset-password");
    }

    public function UserCanUseLiveChat(AcceptanceTester $I)
    {
        $I->amOnPage($this->loginURL);
        $I->waitForElementVisible(["class" => "kayako-wrapper"]);
        $I->seeElement(["class" => "kayako-wrapper"]);
        $I->click(["class" => "kayako-wrapper"]);
        $I->switchToNewWindow();
        $I->seeInCurrentUrl("LiveChat");
        $I->switchToWindow();
    }

}
