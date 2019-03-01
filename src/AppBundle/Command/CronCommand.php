<?php
namespace AppBundle\Command;

use AppBundle\Utils\Cron;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CronCommand extends ContainerAwareCommand
{
    /**
     * @var Cron
     */
    private $cron;

    public function __construct(Cron $cron)
    {
        parent::__construct();
        $this->cron = $cron;
    }

    protected function configure(): void
    {
        $this
            ->setName('cron')
            ->addArgument(
                'mode',
                InputArgument::REQUIRED
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $mode = $input->getArgument('mode');

        switch ($mode) {
            case 'AddPa':
                $this->cron->addPa();
                return;
            case 'RemoveInactive':
                $this->cron->removeInactive();
                return;
            case 'DailyReset':
                $this->cron->dailyReset();
                return;
            case 'Shiny':
                $this->cron->shiny();
                return;
        }
        return;
    }
}
