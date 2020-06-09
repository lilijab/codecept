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

    public function __construct()
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

    /**
     * This test will be executed only in 'desktop' environment
     *
     * @env desktop
     */
    public function UserCanReturnHomeDesktop(AcceptanceTester $I)
    {
        $I->wantTo('Return to the homepage on desktop device');
        $I->amOnPage($this->loginURL);
        $I->waitForElementVisible(["css" => ".{$this->magicWord}-logo > a"]);
        $I->click(["css" => ".{$this->magicWord}-logo > a"]);
        $I->expect("To be on a homepage");
        $I->seeElement(self::HOME_BODY);
    }

    /**
     * This test will be executed only in 'mobile' environment
     *
     * @env mobile
     */
    public function UserCanReturnHomeMobile(AcceptanceTester $I)
    {
        $I->wantTo('Return to the homepage on mobile device');
        $I->amOnPage($this->loginURL);
        $I->waitForElementVisible(["css" => ".logo-container > a"]);
        $I->click(["css" => ".logo-container > a"]);
        $I->expect("To be on a homepage");
        $I->seeElement(self::HOME_BODY);
    }

    /**
     * @env desktop
     */
    public function UserCanDownloadIOSApp(AcceptanceTester $I)
    {
        $I->wantTo("Download an iOS app from the App Store");
        $I->amOnPage($this->loginURL);
        $I->click("App Store");
        $I->switchToNextTab();
        $I->expect("To be on Apple Store page with my app");
        $I->seeInCurrentUrl($this->appStoreID);
        $I->closeTab();
    }

    /**
     * @env desktop
     */
    public function UserCanDownloadAndroidApp(AcceptanceTester $I)
    {
        $I->wantTo("Download an iOS app from the Play Store");
        $I->amOnPage($this->loginURL);
        $I->click("Google Play");
        $I->switchToNextTab();
        $I->expect("To be on Play Store page with my app");
        $I->seeInCurrentUrl($this->playStoreID);
        $I->closeTab();
    }

    /**
     * @env desktop
     * @env mobile
     */
    public function UserCanChooseLanguage(AcceptanceTester $I)
    {
        $I->wantTo("See a full list of available languages");
        $I->amOnPage($this->loginURL);
        $I->seeElement(["id" => "react-language-list-container"]);
        $I->click(["css" => "#react-language-list-container li > span[role='button']"]);
        $I->waitForElementVisible(["class" => "modal-content"]);
        $I->expect("To see a modal with a full list of languages");
        $I->seeElement(["class"=>"modal-content"]);
        $I->waitForElementVisible(["css" => ".modal-header .close"]);
        $I->click(["css" => ".modal-header .close"]);
        $I->waitForElementNotVisible(["class" => "modal-content"]);
        $I->dontSeeElement(["class" => "modal-content"]);
    }

    /**
     * @env desktop
     * @env mobile
     */
    public function UserCanChangeLanguage(AcceptanceTester $I)
    {
        $I->wantTo("Change a language of the website");
        $I->amOnPage($this->loginURL);
        $I->seeElement(["id" => "react-language-list-container"]);
        $initialLanguage = $I->grabTextFrom(["class" => "panel-title"]);
        $I->click(["css" => ".list-inline li:first-child"]);
        $I->waitForElementVisible(["class" => "panel-title"]);
        $newLanguage = $I->grabTextFrom(["class" => "panel-title"]);
        $I->expect("Page is translated to a different language");
        $I->assertNotEquals($initialLanguage, $newLanguage);
    }

    /**
     * @env desktop
     * @env mobile
     */
    public function UserCanLogInWithEmail(AcceptanceTester $I)
    {
        $I->amOnPage($this->loginURL);
        $I->wantTo("Long in to the website with my email");
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
        $I->expect("To be logged in to my account");
        $I->waitForElementVisible(["id" => "navbar-logout-button"]);
        $I->seeElement(["id" => "navbar-logout-button"]);

    }

    /**
     * @env desktop
     * @env mobile
     */
    public function UserCanLogInWithPhone(AcceptanceTester $I)
    {
        $I->amOnPage($this->loginURL);
        $I->wantTo("Long in to the website with my phone number");
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
        $I->expect("To be logged in to my account");
        $I->waitForElementVisible(["id" => "navbar-logout-button"]);
        $I->seeElement(["id" => "navbar-logout-button"]);
    }

    /**
     * @env desktop
     * @env mobile
     */
    public function UserNonExistentErrorDisplayed(AcceptanceTester $I)
    {
        $I->amOnPage($this->loginURL);
        $I->wantTo("See an error if the user does not exist and not log in");
        $I->waitForElementVisible(["id" => "userIdentifier"]);
        $I->dontSeeElement(["css" => ".authentication-login-form-container .alert"]);
        $I->fillField(["id" => "userIdentifier"], $this->nonExistentUser);
        $I->click(["css" => ".authentication-login-form-container button[type=\"submit\"]"]);
        $I->expect("To see an error message");
        $I->waitForElementVisible(["css" => ".authentication-login-form-container .alert"]);
        $I->SeeElement(["css" => ".authentication-login-form-container .alert"]);
    }

    /**
     * @env desktop
     * @env mobile
     */
    public function UserCanRegister(AcceptanceTester $I)
    {
        $I->amOnPage($this->loginURL);
        $I->wantTo("Register as a new user");
        $I->waitForElementVisible(["css" => ".text-center a"]);
        $I->click(["css" => ".text-center a"]);
        $I->expect("To be redirected to a registration page");
        $I->waitForElementVisible(["id" => "registration-h1"]);
        $I->seeInCurrentUrl("registration");

    }

    /**
     * @env desktop
     * @env mobile
     */
    public function UserCanChangePasswordWithEmail(AcceptanceTester $I)
    {
        $I->amOnPage($this->loginURL);
        $I->wantTo("Change my password using email address");
        $I->waitForElementVisible(["id" => "userIdentifier"]);
        $I->fillField(["id" => "userIdentifier"], $this->email);
        $I->click(["css" => ".authentication-login-form-container button[type=\"submit\"]"]);
        $I->waitForElementVisible(["css" => "a[aria-controls=\"login-methods-body-user_credentials\"]"]);
        $I->wait(3);
        $I->click(["css" => "a[aria-controls=\"login-methods-body-user_credentials\"]"]);
        $I->waitForElementVisible(["css" => "#login-methods-body-user_credentials .panel-body .text-center a"]);
        $I->click(["css" => "#login-methods-body-user_credentials .panel-body .text-center a"]);
        $I->expect("To be redirected to a reset password page");
        $I->waitForElementVisible(["css" => ".ng-scope .panel-body"]);
        $I->seeInCurrentUrl("reset-password");
    }

    /**
     * @env desktop
     * @env mobile
     */
    public function UserCanChangePasswordWithPhone(AcceptanceTester $I)
    {
        $I->amOnPage($this->loginURL);
        $I->wantTo("Change my password using email address");
        $I->waitForElementVisible(["id" => "userIdentifier"]);
        $I->fillField(["id" => "userIdentifier"], $this->phone);
        $I->click(["css" => ".authentication-login-form-container button[type=\"submit\"]"]);
        $I->waitForElementVisible(["css" => "a[aria-controls=\"login-methods-body-user_credentials\"]"]);
        $I->wait(3);
        $I->click(["css" => "a[aria-controls=\"login-methods-body-user_credentials\"]"]);
        $I->waitForElementVisible(["css" => "#login-methods-body-user_credentials .panel-body .text-center a"]);
        $I->click(["css" => "#login-methods-body-user_credentials .panel-body .text-center a"]);
        $I->expect("To be redirected to a reset password page");
        $I->waitForElementVisible(["css" => ".ng-scope .panel-body"]);
        $I->seeInCurrentUrl("reset-password");
    }

    /**
     * @env desktop
     * @env mobile
     */
    public function UserCanUseLiveChat(AcceptanceTester $I)
    {
        $I->amOnPage($this->loginURL);
        $I->wantTo("Use a livechat service");
        $I->waitForElementVisible(["class" => "kayako-wrapper"]);
        $I->seeElement(["class" => "kayako-wrapper"]);
        $I->click(["class" => "kayako-wrapper"]);
        $I->switchToNewWindow();
        $I->expect("LiveChat window is open");
        $I->seeInCurrentUrl("LiveChat");
        $I->switchToWindow();
    }

}
