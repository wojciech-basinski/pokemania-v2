<?php
namespace AppBundle\Utils;

use AppBundle\Entity\User;
use AppBundle\Utils\User\UserSettings;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class GameSettings
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
     * @var UserPasswordEncoderInterface
     */
    private $encoder;
    /**
     * @var Request
     */
    private $request;

    public function __construct(
        EntityManagerInterface $em,
        SessionInterface $session,
        UserPasswordEncoderInterface $encoder,
        RequestStack $request
    ) {
        $this->em = $em;
        $this->session = $session;
        $this->encoder = $encoder;
        $this->request = $request->getCurrentRequest();
    }

    /**
     * @param string     $change
     * @param int|string $value
     * @param User       $user
     *
     * @return bool
     */
    public function changeSettings(string $change, $value, User $user): bool
    {
        if (method_exists($this, $change.'Change')) {
            return $this->{$change.'Change'}($value, $user);
        } else {
            $this->session->getFlashBag()->add('error', 'Błedna nazwa ustawienia');
            return false;
        }
    }

    /**
     * @param int|string $value
     * @param User       $user
     *
     * @return bool
     */
    private function descriptionChange($value, User $user): bool
    {
        $value = preg_replace(
            '/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i',
            '',
            $value
        );
        $value = htmlspecialchars(filter_var($value, FILTER_SANITIZE_URL));
        if (empty($value)) {
            $this->session->getFlashBag()->add(
                'error',
                'Błędny opis'
            );
            return false;
        }
        $user->setDescription($value);
        $this->em->persist($user);
        $this->em->flush();
        $this->session->getFlashBag()->add(
            'success',
            'Zapisano opis'
        );
        return true;
    }

    /**
     * @param int|string $value
     * @param User       $user
     *
     * @return bool
     */
    private function backgroundChange($value, User $user): bool
    {
        if (!$value) {
            $this->setSettingInSession(0, $user, 'background');
            $this->session->getFlashBag()->add('success', 'Ustawiono domyślne tło');
        } else {
            $this->setBackgroundInSession($value, $user);
            $this->session->getFlashBag()->add('success', 'Ustawiono tło');
        }
        $this->createCss($user);
        return true;
    }

    private function panelsChange(int $value, User $user): bool
    {
        switch ($this->setPanelsInSession($value, $user)) {
            case 0://zielony
                $message = 'Panele będą miały zielony kolor';
                break;
            case 1://niebieski
                $message = 'Panele będą miały niebieski kolor';
                break;
            case 2://pomarańczowy
                $message = 'Panele będą miały pomarańczowy kolor';
                break;
            case 3://czerwony
                $message = 'Panele będą miały czerwony kolor';
                break;
            case 4://błękitny
                $message = 'Panele będą miały błękitny kolor';
                break;
            case 5://ZÓŁTY
                $message = 'Panele będą miały żółty kolor';
                break;
            case 6://FIOLETOWY
                $message = 'Panele będą miały fioletowy kolor';
                break;
        }
        $this->addSuccessMessage($message);
        $this->createCss($user);
        return true;
    }

    private function styleChange(int $value, User $user): bool
    {
        $this->setSettingInSession($value, $user, 'style') ?
            $message = 'Ustawiono ciemny styl' :
            $message = 'Ustawiono jasny styl';
        $this->addSuccessMessage($message);
        return true;
    }

    private function passwordChange($value, User $user): bool
    {
        $old = $this->request->request->get('old');
        if (!$this->encoder->isPasswordValid($user, $old)) {
            $this->session->getFlashBag()->add('error', 'Podano nie poprawne stare hasło');
            return false;
        }
        $new = $this->request->request->get('new');
        $new2 = $this->request->request->get('new2');
        if ($new === '' || $new2 === '') {
            $this->session->getFlashBag()->add('error', 'Nowe hasło nie może być puste');
            return false;
        }
        if ($new !== $new2) {
            $this->session->getFlashBag()->add('error', 'Nowe hasła nie są identyczne');
            return false;
        }
        if (strlen($new) < 8) {
            $this->session->getFlashBag()->add('error', 'Nowe hasło musi zawierać co najmniej 8 znaków');
            return false;
        }
        $encodedPassword = $this->encoder->encodePassword($user, $new);
        $user->setPassword($encodedPassword);
        $this->em->flush();
        $this->session->getFlashBag()->add('success', 'Z powodzeniem zmieniono hasło');

        return true;
    }

    private function saveSettings(UserSettings $settings, User $user): void
    {
        $this->session->get('userSession')->setUserSettings($settings);
        $user->setSettings($settings->getAll());

        $this->em->flush();
    }

    private function deleteAvatarChange($foo, User $user): bool
    {
        $user->setAvatar('');
        $this->em->flush();
        $this->session->getFlashBag()->add('success', 'Usunięto avatar');
        return true;
    }

    private function avatarChange(string $value, User $user): bool
    {
        if (empty($value)) {
            $this->session->getFlashBag()->add('error', 'To pole nie może być puste');
            return false;
        }
        $size = getimagesize($value);
        if ($size[0] === 250 && $size[1] === 300) {
            $user->setAvatar($value);
            $this->em->flush();
            $this->session->getFlashBag()->add('success', 'Zmieniono avatar');
            return true;
        } else {
            $this->session->getFlashBag()->add('error', 'Avatar ma nieprawidłowe wymiary');
            return false;
        }
    }

    private function teamChange(int $value, User $user): bool
    {
        $this->setSettingInSession($value, $user, 'team') ?
            $message = 'Odblokowano widok drużyny' :
            $message = 'Zablokowano widok drużyny';
        $this->addSuccessMessage($message);

        return true;
    }

    private function marketChange(int $value, User $user): bool
    {
        $this->setSettingInSession($value, $user, 'market') ?
            $message = 'Własne oferty będą widoczne na targu' :
            $message = 'Własne oferty nie będą widoczne na targu';
        $this->addSuccessMessage($message);

        return true;
    }

    private function clockChange(int $value, User $user): bool
    {
        $this->setSettingInSession($value, $user, 'clock') ?
            $message = 'Zegar będzie wyświetlany' :
            $message = 'Zegar nie będzie wyświetlany';
        $this->addSuccessMessage($message);

        return true;
    }

    private function tooltipChange(int $value, User $user): bool
    {
        $this->setSettingInSession($value, $user, 'tooltip') ?
            $message = 'Tooltipy będą wyświetlane' :
            $message = 'Tooltipy nie będą wyświetlane';
        $this->addSuccessMessage($message);

        return true;
    }

    private function hintsChange(int $value, User $user): bool
    {
        $this->setSettingInSession($value, $user, 'hints') ?
            $message = 'Podpowiedzi będą wyświetlane' :
            $message = 'Podpowiedzi nie będą wyświetlane';
        $this->addSuccessMessage($message);

        return true;
    }

    private function tableChange(int $value, User $user): bool
    {
        $this->setSettingInSession($value, $user, 'table') ?
            $message = 'Tabelka będzie wyświetlana po prawej stronie' :
            $message = 'Tableka będzie wyświetlana po lewej stronie';
        $this->addSuccessMessage($message);
        $this->createCss($user);

        return true;
    }

    private function healChange(int $value, User $user): bool
    {
        $this->setSettingInSession($value, $user, 'heal') ?
            $message = 'Przycisk leczenia będzie wyświetlany' :
            $message = 'Przycisk leczenia nie będzie wyświetlany';
        $this->addSuccessMessage($message);

        return true;
    }

    private function sodaChange(int $value, User $user): bool
    {
        $this->setSettingInSession($value, $user, 'soda') ?
            $message = 'Przycisk wypicia sody będzie wyświetlany' :
            $message = 'Przycisk wypicia sody nie będzie wyświetlany';
        $this->addSuccessMessage($message);

        return true;
    }

    private function waterChange(int $value, User $user): bool
    {
        $this->setSettingInSession($value, $user, 'water') ?
            $message = 'Przycisk wypicia wody będzie wyświetlany' :
            $message = 'Przycisk wypicia wody nie będzie wyświetlany';
        $this->addSuccessMessage($message);

        return true;
    }

    private function lemonadeChange(int $value, User $user): bool
    {
        $this->setSettingInSession($value, $user, 'lemonade') ?
            $message = 'Przycisk wypicia lemoniady będzie wyświetlany' :
            $message = 'Przycisk wypicia lemoniady nie będzie wyświetlany';
        $this->addSuccessMessage($message);

        return true;
    }

    private function cheriChange(int $value, User $user): bool
    {
        $this->setSettingInSession($value, $user, 'cheri') ?
            $message = 'Przycisk uleczenia drużyny Cheri Berry będzie wyświetlany' :
            $message = 'Przycisk uleczenia drużyny Cheri Berry nie będzie wyświetlany';
        $this->addSuccessMessage($message);

        return true;
    }

    private function wikiChange(int $value, User $user): bool
    {
        $this->setSettingInSession($value, $user, 'wiki') ?
            $message = 'Przycisk uleczenia drużyny Wiki Berry będzie wyświetlany' :
            $message = 'Przycisk uleczenia drużyny Wiki Berry nie będzie wyświetlany';
        $this->addSuccessMessage($message);

        return true;
    }

    private function feedChange(int $value, User $user): bool
    {
        $this->setSettingInSession($value, $user, 'feed') ?
            $message = 'Przycisk nakarm drużynę będzie wyświetlany' :
            $message = 'Przycisk nakarm drużynę nie będzie wyświetlany';
        $this->addSuccessMessage($message);

        return true;
    }

    private function setSettingInSession(int $value, User $user, string $setting): int
    {
        $settings = $this->session->get('userSession')->getUserSettings();
        if (!in_array($value, [0, 1])) {
            $value = $settings->{'get'.ucfirst($setting)}();
        }
        $settings->{'set'.ucfirst($setting)}($value);
        $this->saveSettings($settings, $user);
        return $value;
    }

    private function setPanelsInSession(int $value, User $user): int
    {
        $settings = $this->session->get('userSession')->getUserSettings();
        if (!in_array($value, [0, 1, 2, 3, 4, 5, 6])) {
            $value = $settings->getPanels();
        }
        $settings->setPanels($value);
        $this->saveSettings($settings, $user);
        return $value;
    }

    private function addSuccessMessage(string $message): void
    {
        $this->session->getFlashBag()->add('success', $message);
    }

    private function createCss(User $user): void
    {
        /** @var UserSettings $settings */
        $settings = $this->session->get('userSession')->getUserSettings();
        switch ($settings->getPanels()) {
            case 0://zielony
                $css = '';
                break;
            case 1://niebieski
                $css = '.modal-header, .panel-success>.panel-heading {background-color:rgba(51, 122, 183, 0.45);border-color:#337ab7;}.panel.panel-success{border-color:#337ab7;}';
                break;
            case 2://pomarańczowy
                $css = '.modal-header, .panel-success>.panel-heading {background-color:rgba(240, 173, 78, 0.45);border-color:#f0ad4e;}.panel.panel-success{border-color:#f0ad4e;}';
                break;
            case 3://czerwony
                $css = '.modal-header, .panel-success>.panel-heading {background-color:rgba(217, 83, 79, 0.45);border-color:#d9534f;}.panel.panel-success{border-color:#d9534f;}';
                break;
            case 4://błękitny
                $css = '.modal-header, .panel-success>.panel-heading {background-color:rgba(91, 192, 222, 0.45);border-color:#5bc0de;}.panel.panel-success{border-color:#5bc0de;}';
                break;
            case 5://ZÓŁTY
                $css = '.modal-header, .panel-success>.panel-heading {background-color:rgba(255, 235, 59, 0.45);border-color:#ffeb3b;}.panel.panel-success{border-color:#ffeb3b;}';
                break;
            case 6://FIOLETOWY
                $css = '.modal-header, .panel-success>.panel-heading {background-color:rgba(140, 114, 203, 0.45);border-color:#8C72CB;}.panel.panel-success{border-color:#8C72CB;}';
                break;
        }
        $css .= '.container-fluid{background-color:' . $settings->getBackground() . ';}';

        switch ($settings->getTable()) {
            case '1':
                $css .= '#lewo{float:right;}';
                break;
        }
        $plik = fopen('./pliki/css/' . $user->getId() . '.css', "w");
        fputs($plik, $css);//zapis do pliku
        fclose($plik);
    }

    private function setBackgroundInSession(string $value, User $user): string
    {
        $settings = $this->session->get('userSession')->getUserSettings();
        if (!ctype_xdigit(ltrim($value, '#'))) {
            $value = '#1c5b4e';
        }
        $settings->setBackground($value);
        $this->saveSettings($settings, $user);
        return $value;
    }
}
