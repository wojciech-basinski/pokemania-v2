<?php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CronCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('cron')
            ->addArgument(
                'mode',
                InputArgument::REQUIRED
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $mode = $input->getArgument('mode');

        switch ($mode) {
            case 'AddPa':
                $this->addPa($output);
                break;
            default:
                return;
        }
    }

    private function addPa(OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $em->getRepository('AppBundle:User')->addPa();
    }
}
