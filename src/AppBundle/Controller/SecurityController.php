<?php
namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use AppBundle\Utils\AuthenticationService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     * @param AuthenticationUtils $authenticationUtils
     *
     * @return Response
     */
    public function loginAction(AuthenticationUtils $authenticationUtils): Response
    {
        // redirect user to homepage if user is logged in
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('game_index');
        }

        $errors = $authenticationUtils->getLastAuthenticationError();
        $lastUserName = $authenticationUtils->getLastUsername();

        return $this->render('auth/login.html.twig', [
            'errors' => $errors,
            'username' => $lastUserName
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
    }

    /**
     * @Route("/register", name="register")
     * @param Request $request
     * @param AuthenticationService $registerUserService
     *
     * @return Response
     * @throws \Exception
     */
    public function registerAction(Request $request, AuthenticationService $registerUserService): Response
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $passwordEncoder = $this->get('security.password_encoder');
            $user->setPassword($passwordEncoder->encodePassword($user, $user->getPassword()));

            $starterId = $request->request->all()['user']['pokemon'];
            if (!$registerUserService->registerUser($user, $starterId)) {
                throw new \Exception('Błąd podczas rejestracji użytkownika');
            }
            $this->addFlash('success', 'Pomyślnie zarejestrowano użytkownika. Teraz możesz się zalogować');
            return $this->redirectToRoute('login');
        }

        return $this->render('auth/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
