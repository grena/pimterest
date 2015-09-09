<?php

namespace AppBundle\Controller\Rest;

use AppBundle\Entity\Contribution;
use AppBundle\Repository\ContributionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class LocationsController extends Controller
{
    public function listAction()
    {
        $contributations = $this->getContribRepo()->findAll();
        $locations = [];

        /** @var Contribution $contrib */
        foreach($contributations as $contrib) {
            if ($contrib->getLatitude()) {
                $locations[] = [
                    'lat' => (float) $contrib->getLatitude(),
                    'lng' => (float) $contrib->getLongitude()
                ];
            }
        }

        return new JsonResponse($locations);
    }

    /**
     * @return ContributionRepository
     */
    public function getContribRepo()
    {
        return $this->container->get('pimterest.repository.contribution');
    }
}
