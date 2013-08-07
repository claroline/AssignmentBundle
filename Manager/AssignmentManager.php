<?php

namespace Claroline\AssignmentBundle\Manager;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Claroline\CoreBundle\Entity\Resource\File;
use Claroline\CoreBundle\Entity\User;
use Claroline\AssignmentBundle\Entity\Assignment;
use Claroline\CoreBundle\Manager\FileManager;
use Claroline\CoreBundle\Manager\ResourceManager;
use Claroline\CoreBundle\Manager\RoleManager;
use Claroline\CoreBundle\Persistence\ObjectManager;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * @DI\Service("claroline.manager.assignment_manager")
 */
class AssignmentManager
{
    private $resourceManager;
    private $roleManager;
    private $fileManager;
    private $sc;
    private $om;

    /**
     * Constructor.
     *
     * @DI\InjectParams({
     *     "resourceManager" = @DI\Inject("claroline.manager.resource_manager"),
     *     "fileManager"     = @DI\Inject("claroline.manager.file_manager"),
     *     "roleManager"     = @DI\Inject("claroline.manager.role_manager"),
     *     "security"        = @DI\Inject("security.context"),
     *     "om"              = @DI\Inject("claroline.persistence.object_manager"),
     * })
     */
    public function __construct(
        ResourceManager $resourceManager,
        FileManager $fileManager,
        SecurityContextInterface $security,
        RoleManager $roleManager,
        ObjectManager $om
    )
    {
        $this->resourceManager = $resourceManager;
        $this->fileManager = $fileManager;
        $this->sc = $security;
        $this->roleManager = $roleManager;
        $this->om = $om;
    }

    public function submitFile(File $file, UploadedFile $uploadedFile, Assignment $assignment)
    {
        $this->om->startFlushSuite();
        $file = $this->fileManager->associate($file, $uploadedFile);
        $file = $this->resourceManager->create(
            $file,
            $this->resourceManager->getResourceTypeByName('file'),
            $assignment->getCreator(),
            $assignment->getWorkspace(),
            $assignment,
            null,
            array()
        );
        $creator = $this->sc->getToken()->getUser();
        $file->setProprietary($creator);
        $this->om->endFlushSuite();

        return $assignment;
    }

    public function deleteFile(File $file)
    {
        $this->fileManager->delete($file);
    }

    public function delete(Assignment $assignment)
    {
        $children = $assignment->getChildren();
        $this->om->startFlushSuite();

        foreach ($children as $child) {
            $this->fileManager->delete($child);
        }

        $this->om->remove($assignment);
        $this->om->endFlushSuite();
    }

    public function create()
    {

    }

    public function edit()
    {

    }
}