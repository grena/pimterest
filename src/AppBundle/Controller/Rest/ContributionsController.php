<?php

namespace AppBundle\Controller\Rest;

use AppBundle\Repository\ContributionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author    Adrien Pétremann <adrien.petremann@akeneo.com>
 * @copyright 2015 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class ContributionsController extends Controller
{
    public function listAction(Request $request)
    {
        $contributations = $this->getRepository()->findBy([], ['id' => 'DESC']);

        $contributations = array_map(function($contrib) {
            $data = $contrib->toArray();
            $data['authorlink'] = $this->getAuthorLink($contrib->getUsername(), $contrib->getSource());

            return $data;
        }, $contributations);

        return new JsonResponse($contributations);
    }

    protected function getAuthorLink($username, $source)
    {
        $urls = [
            'twitter' => 'https://twitter.com/%s',
            'instagram' => 'https://instagram.com/%s',
            'community' => 'http://www.akeneo.com/'
        ];

        return sprintf($urls[$source], $username);
    }

    /**
     * @return ContributionRepository
     */
    protected function getRepository()
    {
        return $this->container->get('pimterest.repository.contribution');
    }
}
