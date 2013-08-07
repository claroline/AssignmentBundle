<?php

namespace Claroline\AssignmentBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as EXT;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Claroline\AssignmentBundle\Entity\Assignment;
use Claroline\AssignmentBundle\Form\AssignmentType;
use Claroline\AssignmentBundle\Manager\AssignmentManager;
use Claroline\CoreBundle\Entity\Resource\File;
use Claroline\CoreBundle\Entity\User;
use Claroline\CoreBundle\Form\FileType;
use JMS\DiExtraBundle\Annotation as DI;

class AssignmentController
{
    private $formFactory;
    private $assignmentManager;
    private $request;
    private $router;

    /**
     * @DI\InjectParams({
     *     "formFactory"       = @DI\Inject("form.factory"),
     *     "assignmentManager" = @DI\Inject("claroline.manager.assignment_manager"),
     *     "request"           = @DI\Inject("request"),
     *     "router"            = @DI\Inject("router")
     * })
     */
    public function __construct(
        FormFactory $formFactory,
        AssignmentManager $assignmentManager,
        Request $request,
        RouterInterface $router
    )
    {
        $this->formFactory = $formFactory;
        $this->assignmentManager = $assignmentManager;
        $this->request = $request;
        $this->router = $router;
    }

    /**
     * @EXT\Route(
     *     "/{assignment}/open",
     *     name="open_assignment"
     * )
     * @EXT\Method("GET")
     * @EXT\Template()
     *
     * Displays the user creation form.
     */
    public function openAction(Assignment $assignment)
    {
        return array('_resource' => $assignment);
    }

    /*
     * @EXT\Route(
     *     "/{assignment}/open/edit/form",
     *     name="open_assignment"
     * )
     * @EXT\Method("GET")
     * @EXT\Template()
     *
     * Displays the user creation form.
     */
    public function editFormAction(Assignment $assignment)
    {
        $form = $this->formFactory->create(new AssignmentType, new Assignment());

        return array(
            'form' => $form->createView(),
            'resourceType' => 'claroline_assignment',
            'assignment' => $assignment
        );
    }

    public function submitEditFormAction(Assignment $assignment)
    {

    }

    /**
     * @EXT\Route(
     *     "/{assignment}/submit/file/form",
     *     name="submit_file_form_assignment"
     * )
     * @EXT\Method("GET")
     * @EXT\Template()
     */
    public function submitFileFormAction(Assignment $assignment)
    {
        $form = $this->formFactory->create(new FileType, new File());

        return array('_resource' => $assignment, 'form' => $form->createView());
    }

    /**
     * @EXT\Route(
     *     "/{assignment}/submit/file",
     *     name="submit_file_assignment"
     * )
     * @EXT\Method("POST")
     */
    public function submitFileAction(Assignment $assignment)
    {
        $form = $this->formFactory->create(new FileType, new File());
        $form->handleRequest($this->request);

        if ($form->isValid()) {
            $this->assignmentManager->submitFile($form->getData(), $form->get('file')->getData(), $assignment);
            $route = $this->router->generate('open_assignment', array('assignment' => $assignment->getId()));

            return new RedirectResponse($route);
        } else {
            //do sthg smart
        }
    }

    /**
     * @EXT\Route(
     *     "/delete/file/{file}",
     *     name="delete_file_assignment"
     * )
     * @EXT\Method("GET")
     */
    public function deleteFileAction(File $file)
    {
        $this->assignmentManager->deleteFile($file);

        return new Response('success');
    }

    /**
     * @EXT\Route(
     *     "/open/file/{file}",
     *     name="open_file_assignment"
     * )
     * @EXT\Method("GET")
     * @EXT\ParamConverter("user", options={"authenticatedUser" = true})
     */
    public function openFileAction(File $file, User $user)
    {
        if ($file->getCreator() === $user || $file->getProprietary() === $user) {
            $route = $this->router
                ->generate('claro_resource_open', array('resourceId' => $file->getId(), 'resourceType' => 'file'));

            return new RedirectResponse($route);
        } else {
            throw new AccessDeniedException();
        }
    }
}