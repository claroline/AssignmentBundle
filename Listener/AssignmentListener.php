<?php

namespace Claroline\AssignmentBundle\Listener;

use Claroline\CoreBundle\Event\Event\CreateFormResourceEvent;
use Claroline\CoreBundle\Event\Event\CreateResourceEvent;
use Claroline\CoreBundle\Event\Event\OpenResourceEvent;
use Claroline\AssignmentBundle\Entity\Assignment;
use Claroline\AssignmentBundle\Form\AssignmentType;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * @DI\Service
 */
class AssignmentListener
{
    private $formFactory;
    private $templating;
    private $request;
    private $router;

    /**
     * @DI\InjectParams({
     *     "formFactory" = @DI\Inject("form.factory"),
     *     "templating"  = @DI\Inject("templating"),
     *     "request"     = @DI\Inject("request", strict = false),
     *     "router"      = @DI\Inject("router")
     * })
     */
    public function __construct(
        FormFactory $formFactory,
        Request $request,
        $templating,
        UrlGeneratorInterface $router
    )
    {
        $this->formFactory = $formFactory;
        $this->templating = $templating;
        $this->request = $request;
        $this->router = $router;
    }

    /**
     * @DI\Observe("create_form_claroline_assignment")
     */
    public function onCreateForm(CreateFormResourceEvent $event)
    {
        $form = $this->formFactory->create(new AssignmentType, new Assignment());
        $content = $this->templating->render(
            'ClarolineAssignmentBundle:Assignment:formCreation.html.twig',
            array(
                'form' => $form->createView(),
                'resourceType' => 'claroline_assignment'
            )
        );
        $event->setResponseContent($content);
        $event->stopPropagation();
    }

    /**
     * @DI\Observe("create_claroline_assignment")
     */
    public function onCreate(CreateResourceEvent $event)
    {
        $form = $this->formFactory->create(new AssignmentType, new Assignment());
        $form->handleRequest($this->request);

        if ($form->isValid()) {
            $assignment = $form->getData();
            $event->setResources(array($assignment));
            $event->stopPropagation();

            return;
        }

        $content = $this->templating->render(
            'ClarolineAssignmentBundle:Assignment:formCreation.html.twig',
            array(
                'form' => $form->createView(),
                'resourceType' => 'claroline_assignment'
            )
        );

        $event->setErrorFormContent($content);
        $event->stopPropagation();
    }

    /**
     * @DI\Observe("open_claroline_assignment")
     */
    public function onOpen(OpenResourceEvent $event)
    {
        $route = $this->router
            ->generate('open_assignment', array('assignment' => $event->getResource()->getId()));
        $event->setResponse(new RedirectResponse($route));
        $event->stopPropagation();
    }
}