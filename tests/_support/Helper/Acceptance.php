<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Acceptance extends \Codeception\Module
{
    public function switchToNewWindow()
    {
        $webdriver = $this->getModule('WebDriver')->webDriver;
        $handles = $webdriver->getWindowHandles();
        $lastWindow = end($handles);
        $webdriver->switchTo()->window($lastWindow);
    }
}
