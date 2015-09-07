<?php

namespace AppBundle\Service;

use MetzWeb\Instagram\Instagram;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * @author    Adrien Pétremann <adrien.petremann@akeneo.com>
 * @copyright 2015 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class InstagramReader implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    protected $settings;

    public function __construct()
    {
        $this->settings = [
            'apiKey'      => '192da7558c59416fb12a7311718c01cc',
            'apiSecret'   => 'c1bf10a55f6144429b703b9b9adff505',
            'apiCallback' => 'http://pimterest.local/'
        ];
    }

    public function retrieveByTag($tag)
    {
        $formatted = [];

        $response = $this->getInstagram()->getTagMedia($tag);
        $data = $response->data;

        if (!empty($data)) {
            foreach ($data as $postData) {
                $formatted[] = $this->extractPost($postData);
            }
        }

        return $formatted;
    }

    protected function extractPost($data)
    {
        return [
            'id' => $data->id,
            'username' => $data->user->username,
            'usertype' => 'community',
            'mediaurl' => $data->images->standard_resolution->url,
            'active' => true,
            'content' => $data->caption->text
        ];
    }

    protected function getInstagram()
    {
        return new Instagram($this->settings['apiKey']);
    }
}
