<?php

namespace AppBundle\Controller\Rest;

use AppBundle\Entity\Contribution;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class LocationsController extends Controller
{
    public function listAction()
    {
        $contributations = $this->getContribRepo()->findAll();
        $locations = [];

        /**
         * @var Contribution $contrib
         */
        foreach($contributations as $contrib) {
            if ($contrib->getLatitude()) {
                $locations[] = [
                    'lat' => (float) $contrib->getLatitude(),
                    'lng' => (float) $contrib->getLongitude()
                ];
            }
        }
//        $locations = [
//            ['lat' => -8.05, 'lng' => -34.9],
//            ['lat' => -8.05, 'lng' => -20],
//            ['lat' => -5, 'lng' => -34],
//            ['lat' => -6, 'lng' => -34],
//            ['lat' => -7, 'lng' => -34],
//            ['lat' => -8, 'lng' => -34],
//        ];

        return new JsonResponse($locations);
    }

    public function getContribRepo()
    {
        return $this->container->get('pimterest.repository.contribution');
    }
}
