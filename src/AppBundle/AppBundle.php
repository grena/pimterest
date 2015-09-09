<?php

namespace AppBundle;

use AppBundle\Command\InstagramCommand;
use AppBundle\Command\TwitterCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AppBundle extends Bundle
{
    public function registerCommands(Application $application)
    {
        $application->add(new InstagramCommand());
        $application->add(new TwitterCommand());
    }
}
