<?php

namespace AppBundle\Command;

use AppBundle\Entity\Contribution;
use AppBundle\Repository\ContributionRepository;
use AppBundle\Twitter\TwitterReader;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TwitterCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('pimterest:twitter:read');
        $this->setDescription('Read twiter tweets.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $reader = $this->getTwitterReader();
        $result = $reader->retrieve();

        foreach($result as $contributionData) {
            $contribution = new Contribution($contributionData);
            $search = [
                'appId' => $contribution->getAppId(),
                'source' => $contribution->getSource()
            ];

            if (!$this->getContributionRepository()->findOneBy($search)) {
                $this->getEntityManager()->persist($contribution);
                $this->getEntityManager()->flush();
            }
        }

        $output->writeln('<info>Done!</info>');

        return 0;
    }

    /**
     * @return TwitterReader
     */
    protected function getTwitterReader()
    {
        return $this->getContainer()->get('pimterest.api.reader.twitter');
    }

    /**
     * @return ContributionRepository
     */
    protected function getContributionRepository()
    {
        return $this->getContainer()->get('pimterest.repository.contribution');
    }

    /**
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        return $this->getContainer()->get('doctrine.orm.entity_manager');
    }
}
