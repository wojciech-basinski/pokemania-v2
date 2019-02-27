<?php
namespace AppBundle\Command;

use AppBundle\Entity\Cron;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CronCommand extends ContainerAwareCommand
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
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
        }
        return;
    }

    private function addPa(): void
    {
        $this->em->getRepository('AppBundle:User')->addPa();
        $this->addCronMessage('Executed AddPa');
    }

    private function removeInactive(): void
    {
        $this->em->getRepository('AppBundle:User')->removeInactive();
        $this->addCronMessage('Executed RemoveInactive');
    }

    private function addCronMessage(string $message): void
    {
        $cron = new Cron();
        $cron->setDate(new \DateTime())
            ->setLog($message);
        $this->em->persist($cron);
        $this->em->flush();
    }
}
