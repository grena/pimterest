<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Contribution;
use Doctrine\ORM\EntityRepository;

/**
 * @author    Adrien Pétremann <adrien.petremann@akeneo.com>
 * @copyright 2015 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class ContributionRepository extends EntityRepository
{
    /**
     * @param Contribution $contribution
     */
    public function save(Contribution $contribution)
    {
        $this->getEntityManager()->persist($contribution);
        $this->getEntityManager()->flush($contribution);
    }
}
