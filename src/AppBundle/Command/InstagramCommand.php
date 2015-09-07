<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author    Adrien Pétremann <adrien.petremann@akeneo.com>
 * @copyright 2015 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class InstagramCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('pimterest:instagram:read')
            ->setDescription('Read instagram API')
            ->addArgument(
                'hashtag',
                InputArgument::REQUIRED,
                'Instagram hashtag to fetch'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var \AppBundle\Service\InstagramReader $reader */
        $reader = $this->getContainer()->get('pimterest.reader.instagram');
        $hashtag = $input->getArgument('hashtag');

        if (!$hashtag) {
            throw new Exception('Need an hashtag to fetch');
        }

        print_r($reader->retrieveByTag($hashtag));
    }
}
