<?php

namespace AppBundle\Twitter;

use TwitterAPIExchange;

class TwitterReader
{
    protected $settings;

    protected $tag;

    public function __construct($tag)
    {
        $this->tag = trim($tag);

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
        $getfield      = sprintf('?q=#%s', $this->tag);
        $requestMethod = 'GET';

        $twitter = new TwitterAPIExchange($this->settings);
        return $twitter->setGetfield($getfield)
            ->buildOauth($url, $requestMethod)
            ->performRequest();
    }
}
