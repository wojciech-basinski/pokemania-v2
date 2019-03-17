<?php

namespace AppBundle\Controller;

use AppBundle\Form\GeneratePokemonForm;
use AppBundle\Utils\PokemonHelper;
use Knp\Menu\Renderer\TwigRenderer;
use Sonata\AdminBundle\Controller\CRUDController;
use Sonata\AdminBundle\Exception\ModelManagerException;
use Symfony\Bridge\Twig\AppVariable;
use Symfony\Bridge\Twig\Command\DebugCommand;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\Form\FormRenderer;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Response;

final class PokemonAdminController extends CRUDController
{
    /**
     * Create action.
     *
     * @throws AccessDeniedException If access is not granted
     * @throws \RuntimeException     If no editable field is defined
     *
     * @return Response
     */
    public function createAction()
    {
        $newObject = $this->admin->getNewInstance();
        $request = $this->getRequest();

        $generateForm = $this->createForm(GeneratePokemonForm::class);
        $generateForm->handleRequest($request);
        if (!$generateForm->isSubmitted() && !$request->query->get('uniqid')) {
            return $this->render('game/admin/generatePokemonForm.html.twig',[
                'form' => $generateForm->createView()
            ]);
        }
        if ($generateForm->isSubmitted() && $generateForm->isValid()) {
            $id = $generateForm['id']->getData();
            $level = $generateForm['level']->getData();
            if ($id < 0 || $id > 251) {
                $this->addFlash('error', 'Błędny id');
                return $this->render('game/admin/generatePokemonForm.html.twig',[
                    'form' => $generateForm->createView()
                ]);
            }
            if ($level < PokemonHelper::getInfo($id)['minLevel'] || $level > 100) {
                $this->addFlash('error', 'Za niski poziom');
                return $this->render('game/admin/generatePokemonForm.html.twig',[
                    'form' => $generateForm->createView()
                ]);
            }
            $newObject = PokemonHelper::generatePokemon($id, $level);
            $newObject->setCatched('pokeball');
        }

        // the key used to lookup the template
        $templateKey = 'edit';

        $this->admin->checkAccess('create');

        $class = new \ReflectionClass($this->admin->hasActiveSubClass() ? $this->admin->getActiveSubClass() : $this->admin->getClass());

        if ($class->isAbstract()) {
            return $this->renderWithExtraParams(
                '@SonataAdmin/CRUD/select_subclass.html.twig',
                [
                    'base_template' => $this->getBaseTemplate(),
                    'admin' => $this->admin,
                    'action' => 'create',
                ],
                null
            );
        }



        $preResponse = $this->preCreate($request, $newObject);
        if (null !== $preResponse) {
            return $preResponse;
        }

        $this->admin->setSubject($newObject);

        $form = $this->admin->getForm();

        if (!\is_array($fields = $form->all()) || 0 === \count($fields)) {
            throw new \RuntimeException(
                'No editable field defined. Did you forget to implement the "configureFormFields" method?'
            );
        }

        $form->setData($newObject);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $isFormValid = $form->isValid();

            // persist if the form was valid and if in preview mode the preview was approved
            if ($isFormValid && (!$this->isInPreviewMode() || $this->isPreviewApproved())) {
                $submittedObject = $form->getData();
                //add training
                $this->admin->setSubject($submittedObject);
                $this->admin->checkAccess('create', $submittedObject);

                try {
                    $newObject = $this->admin->create($submittedObject);

                    if ($this->isXmlHttpRequest()) {
                        return $this->renderJson([
                            'result' => 'ok',
                            'objectId' => $this->admin->getNormalizedIdentifier($newObject),
                            'objectName' => $this->escapeHtml($this->admin->toString($newObject)),
                        ], 200, []);
                    }

                    $this->addFlash(
                        'sonata_flash_success',
                        $this->trans(
                            'flash_create_success',
                            ['%name%' => $this->escapeHtml($this->admin->toString($newObject))],
                            'SonataAdminBundle'
                        )
                    );

                    // redirect to edit mode
                    return $this->redirectTo($newObject);
                } catch (ModelManagerException $e) {
                    $this->handleModelManagerException($e);

                    $isFormValid = false;
                }
            }

            // show an error message if the form failed validation
            if (!$isFormValid) {
                if (!$this->isXmlHttpRequest()) {
                    $this->addFlash(
                        'sonata_flash_error',
                        $this->trans(
                            'flash_create_error',
                            ['%name%' => $this->escapeHtml($this->admin->toString($newObject))],
                            'SonataAdminBundle'
                        )
                    );
                }
            } elseif ($this->isPreviewRequested()) {
                // pick the preview template if the form was valid and preview was requested
                $templateKey = 'preview';
                $this->admin->getShow();
            }
        }

        $formView = $form->createView();
        // set the theme for the current Admin Form
        $this->setFormTheme($formView, $this->admin->getFormTheme());

        // NEXT_MAJOR: Remove this line and use commented line below it instead
        $template = $this->admin->getTemplate($templateKey);
        // $template = $this->templateRegistry->getTemplate($templateKey);

        return $this->renderWithExtraParams($template, [
            'action' => 'create',
            'form' => $formView,
            'object' => $newObject,
            'objectId' => null,
        ], null);
    }

    /**
     * Sets the admin form theme to form view. Used for compatibility between Symfony versions.
     */
    private function setFormTheme(FormView $formView, array $theme = null): void
    {
        $twig = $this->get('twig');

        // BC for Symfony < 3.2 where this runtime does not exists
        if (!method_exists(AppVariable::class, 'getToken')) {
            $twig->getExtension(FormExtension::class)->renderer->setTheme($formView, $theme);

            return;
        }

        // BC for Symfony < 3.4 where runtime should be TwigRenderer
        if (!method_exists(DebugCommand::class, 'getLoaderPaths')) {
            $twig->getRuntime(TwigRenderer::class)->setTheme($formView, $theme);

            return;
        }

        $twig->getRuntime(FormRenderer::class)->setTheme($formView, $theme);
    }
}
