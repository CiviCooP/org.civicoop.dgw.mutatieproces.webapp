<?php

namespace CiviCoop\VragenboomBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SyncCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('civicrm:sync')
            ->setDescription('Synchronisation with Civi')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $civicase = $this->getApplication()->getKernel()->getContainer()->get('civicoop.dgw.mutatieproces.civicase');
		$civicase->sync();

        $output->writeln('Syncing complete');
    }
}