<?php

namespace AppBundle\Service;

use TwitterAPIExchange;

class TwitterReader
{
    protected $settings;

    public function __construct()
    {
        $this->settings = [
            'oauth_access_token'        => "976729392-fuYxsR0xLVmkDqKRVRMdDpGFU6ilF8biKoOEvolK",
            'oauth_access_token_secret' => "bPPWslRIUGqkBEki9mtQYzMFAUW5GSzEPG5HeQyDALPxO",
            'consumer_key'              => "EY8u0i6USR7JwgMmrEN5RD4V1",
            'consumer_secret'           => "N6JcipiRz6mOV6B4j3YDAU03mey0CHovBKmnqtOAzcyFjGN7fE"
        ];
    }

    public function retrieve()
    {
        $url           = 'https://api.twitter.com/1.1/search/tweets.json';
        $getfield      = '?q=%23akeneoAroundTheWorld&src=typd&lang=fr';
        $requestMethod = 'GET';

        $twitter = new TwitterAPIExchange($this->settings);
        echo $twitter->setGetfield($getfield)
            ->buildOauth($url, $requestMethod)
            ->performRequest();
    }
}
