<?php

namespace AppBundle\Command;

use AppBundle\Instagram\InstagramReader;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
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
        $this->setName('pimterest:instagram:read')->setDescription('Read instagram API');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $reader = $this->getInstagramReader();

        print_r($reader->retrieve());
    }

    /**
     * @return InstagramReader
     */
    protected function getInstagramReader()
    {
        return $this->getContainer()->get('pimterest.reader.instagram');
    }
}
