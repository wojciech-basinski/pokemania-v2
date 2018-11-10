<?php
namespace AppBundle\Utils;

use AppBundle\Entity\Achievement;
use AppBundle\Entity\Performance;
use AppBundle\Entity\Report;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class GameAchievements
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var Session
     */
    private $session;
    /**
     * @var AchievementsHelper
     */
    private $helper;
    /**
     * @var User
     */
    private $user;
    /**
     * @var array
     */
    private $main;
    /**
     * @var array
     */
    private $secondary;
    /**
     * @var array
     */
    private $kanto;
    /**
     * @var array
     */
    private $kantoMaster;
    /**
     * @var Achievement
     */
    private $achievements;
    /**
     * @var Performance
     */
    private $performance;

    public function __construct(EntityManagerInterface $em, Session $session, AchievementsHelper $helper)
    {
        $this->em = $em;
        $this->session = $session;
        $this->helper = $helper;
    }

    public function execute(User $user)
    {
        $this->user = $user;
        $this->prepareFromDb();
        $this->checkIfAchievementsCanHaveNextLevel($user->getId());
        $this->checkAchievements('main');
        $this->checkAchievements('secondary');
        $this->checkAchievements('kanto');
        $this->checkKantoMaster();
        $this->em->flush();
    }

    public function getMain(): array
    {
        return $this->main;
    }

    public function getSecondary(): array
    {
        return $this->secondary;
    }

    public function getKanto(): array
    {
        return $this->kanto;
    }

    public function getKantoMaster(): array
    {
        return $this->kantoMaster;
    }

    private function checkIfAchievementsCanHaveNextLevel(int $userId)
    {
        $items = $this->em->getRepository('AppBundle:Items')->find($userId);
        $requirements = $this->performance->getZnawcaKanto() + 1;
        if ($requirements <= 5) {
            $quantity = 0;
            for ($i = 1; $i <= 7; $i++) {
                if ($this->performance->{'getZnawcaKanto'.$i}() >= $requirements) {
                    $quantity++;
                }
            }
            if ($quantity == 7) {
                //update bazy i dodanie poziomu achievementa
                $this->performance->setZnawcaKanto($requirements);
                if ($requirements < 5) {
                    $coins = 1;
                } else {
                    $coins = 2;
                }
                $items->setCoins($items->getCoins() + $coins);
                $performance = 'Znawca regionu Kanto</span>, poziom: ' . $requirements;
                $this->addReport(
                    $performance,
                    $userId
                );
                $this->addFlash('Znawca regionu Kanto', $requirements, $coins);
            }
        }
        for ($j = 0; $j < 3; $j++) {
            switch ($j) {
                case 0:
                    $main = $this->helper->getMain();
                    break;
                case 1:
                    $main = $this->helper->getSecondary();
                    break;
                case 2:
                    $main = $this->helper->getKanto();
                    break;
            }
            for ($i = 0; $i < count($main); $i++) {
                if ($main[$i]['table'] == '') {
                    continue;
                }
                $nameInEntity = $main[$i]['inDb'];
                $requirements = $this->performance->{'get'.$nameInEntity}() + 1;
                if ($requirements <= (count($main[$i]) - 4)) {
                    $table = explode(';', $main[$i]['table']);
                    if ($table[0] == 'users') {
                        $table1 = $this->user->{'get'.$table[1]}();
                    } else {
                        $table1 = $this->{$table[0]}->{'get'.$table[1]}();
                    }
                    $req = $main[$i][$requirements]; //wymagania na nowy poziom osiągnięcia
                    if ($table1 >= $req) {//nowy poziom achievementa
                        //update bazy i dodanie poziomu achievementa
                        $this->performance->{'set'.$nameInEntity}($requirements);
                        if (($requirements) < ((count($main[$i]) - 4))) {
                            $coins = 1;
                        } else {
                            $coins = 2;
                        }
                        $this->addReport($main[$i]['name'], $userId);
                        $this->addFlash($main[$i]['name'], $requirements, $coins);
                        $items->setCoins($items->getCoins() + $coins);
                    }
                }
            }
        }
        $this->em->persist($items);
        $this->em->persist($this->performance);
    }

    private function prepareFromDb()
    {
        $this->achievements = $this->em->getRepository('AppBundle:Achievement')->findOneBy(['id' => $this->user->getId()]);
        $this->performance = $this->em->getRepository('AppBundle:Performance')->findOneBy(['id' => $this->user->getId()]);
    }

    private function checkAchievements(string $what)
    {
        $main = $this->helper->{'get'.$what}();
        $mainToView = [];
        for ($i = 0; $i < count($main); $i++) {
            $nameInEntity = $main[$i]['inDb'];
            $tempNewMain['name'] = $main[$i]['name'];
            $tempNewMain['level'] = $this->performance->{'get'.$nameInEntity}();

            if ($this->performance->{'get'.$nameInEntity}() < (count($main[$i]) - 4)) {
                $tempNewMain['background'] = 'jeden_ttlo';
            } else {
                $tempNewMain['background'] = 'zielone_tlo_osiagniecie';
            }

            $requirements = $this->performance->{'get'.$nameInEntity}() + 1; //Następny poziom :)

            $table = explode(';', $main[$i]['table']);
            if ($table[0] == 'users') {
                $table1 = $this->user->{'get'.$table[1]}();
            } else {
                $table1 = $this->{$table[0]}->{'get'.$table[1]}();
            }

            $tempNewMain['max'] = 1;
            $tempNewMain['echo'] = $main[$i]['echo'];
            $tempNewMain['table1'] = $table1;

            if (($this->performance->{'get'.$nameInEntity}() + 1) <= (count($main[$i]) - 4)) {
                $tempNewMain['max'] = 0;
                $tempNewMain['requirements'] = $main[$i][$requirements];
            }

            $mainToView[$i] = $tempNewMain;
        }
        $this->$what = $mainToView;
    }

    private function checkKantoMaster()
    {
        $masterKanto = $this->helper->getKantoMaster();
        $master = $this->performance->getZnawcaKanto();
        if ($master < 5) {
            $this->kantoMaster['background'] = 'jeden_ttlo';
        } else {
            $this->kantoMaster['background'] = 'zielone_tlo_osiagniecie';
        }
        $requirements = $master + 1; //Następny poziom :)

        $this->kantoMaster['name'] = $masterKanto['name'];
        $this->kantoMaster['level'] = $master;

        if (($requirements) <= 5) {
            $requirementsLevel = $requirements;
            $quantity = 0;
            for ($i = 1; $i <= 7; $i++) {
                if ($this->performance->{'getZnawcaKanto'.$i}() >= $requirementsLevel) {
                    $quantity++;
                }
            }
            $this->kantoMaster['echo'] = $requirementsLevel . ' ' . $masterKanto['echo'] . ' (' . $quantity . '/7)';
        } else {
            $this->kantoMaster['echo'] = '';
        }
    }

    private function addReport(string $performance, int $userId)
    {
        $report = new Report();
        $report->setTitle('Nowe osiągnięcie');
        $report->setUserId($userId);
        $report->setIsRead(0);
        $report->setTime(new \DateTime());
        $report->setContent("<div class=\"row nomargin text-center\"><div class=\"col-xs-12\">Zdobyłeś nowe osiągnięcie: <span class=\"pogrubienie\">
        {$performance}</div></div>");
        $this->em->persist($report);
    }

    private function addFlash(string $performance, int $level, int $coins)
    {
         $this->session->getFlashBag()->add(
             'success',
             "Nowy, {$level} poziom: <span class=\"pogrubienie\">{$performance}</span>
                    <br />Otrzymujesz {$coins}x <img src=\"img/przedmioty/dukat.png\"
                        class=\"pokeball_min\" data-toggle=\"tooltip\" data-title=\"Dukat\" />"
         );
    }
}
