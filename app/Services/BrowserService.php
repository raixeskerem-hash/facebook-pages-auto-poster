<?php

namespace App\Services;

use Facebook\WebDriver\Chrome\ChromeDriver;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\WebDriver;

class BrowserService
{
    protected $browser;

    public function openBrowserWithProfile($profilePath)
    {
        try {
            $chromeOptions = new ChromeOptions();
            $chromeOptions->addArguments([
                'user-data-dir=' . $profilePath,
                '--no-sandbox',
                '--disable-dev-shm-usage',
            ]);

            $this->browser = ChromeDriver::start($chromeOptions);
            $this->navigateToFacebook();

            return $this->browser;
        } catch (\Exception $e) {
            \Log::error('Browser opening error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function closeBrowser($browser = null)
    {
        if ($browser) {
            $browser->quit();
        } elseif ($this->browser) {
            $this->browser->quit();
        }
    }

    public function navigateToFacebook($browser = null)
    {
        $targetBrowser = $browser ?? $this->browser;
        if ($targetBrowser) {
            $targetBrowser->get('https://www.facebook.com');
        }
    }

    protected function createWebDriver($profilePath)
    {
        $chromeOptions = new ChromeOptions();
        $chromeOptions->addArguments([
            'user-data-dir=' . $profilePath,
        ]);

        return ChromeDriver::start($chromeOptions);
    }
}