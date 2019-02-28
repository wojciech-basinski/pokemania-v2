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
                $this->addPa();
                break;
            case 'RemoveInactive':
                $this->removeInactive();
                break;
            case 'DailyReset':
                $this->dailyReset();
                break;
        }
        return;
    }

    private function addPa(): void
    {
        $this->cron->addPa();
    }

    private function removeInactive(): void
    {
        $this->cron->removeInactive();
    }

    private function dailyReset(): void
    {
        $this->cron->dailyReset();
    }
}
