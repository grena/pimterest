<?php

namespace AppBundle\Twitter;

use TwitterAPIExchange;

class TwitterReader
{
    protected $settings;

    protected $tag;

    public function __construct(
        $tag,
        $oauth_access_token,
        $oauth_access_token_secret,
        $consumer_key,
        $consumer_secret
    ) {
        $this->tag = trim($tag);

        $this->settings = [
            'oauth_access_token'        => $oauth_access_token,
            'oauth_access_token_secret' => $oauth_access_token_secret,
            'consumer_key'              => $consumer_key,
            'consumer_secret'           => $consumer_secret,
        ];
    }

    public function retrieve()
    {
        $url           = 'https://api.twitter.com/1.1/search/tweets.json';
        $getfield      = sprintf('?q=#%s', $this->tag);
        $requestMethod = 'GET';

        $twitter = new TwitterAPIExchange($this->settings);

        $response = $twitter->setGetfield($getfield)
            ->buildOauth($url, $requestMethod)
            ->performRequest();

        $data = json_decode($response);

        $formatted = [];

        foreach ($data->statuses as $postData) {
            $formatted[] = $this->extractPost($postData);
        }

        return $formatted;
    }

    protected function extractPost($data)
    {
        $formatted = [];
        if ($data->coordinates) {
            dump($data);
            $formatted = [
                'app_id'    => $data->id,
                'source'    => 'twitter',
                'username'  => $data->user->name,
                'usertype'  => 'community',
                'active'    => true,
                'content'   => $data->text,
                'latitude'  => $data->location ? $data->location->latitude : '',
                'longitude' => $data->location ? $data->location->longitude : ''
            ];

            if (count((array) $data->media)) {
                $formatted['mediaurl'] = $data->media[0]->media_url;
            }
        }

        return $formatted;
    }
}
