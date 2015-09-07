<?php

namespace AppBundle\Command;

use AppBundle\Twitter\TwitterReader;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RetrieveTweetsCommand extends ContainerAwareCommand
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
        $result = json_decode($reader->retrieve());

        dump($result->statuses);

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
}
