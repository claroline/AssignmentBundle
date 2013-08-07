<?php

namespace Claroline\AssignmentBundle\Entity;

use Claroline\CoreBundle\Entity\Resource\Directory;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="claro_assignment")
 */
class Assignment extends Directory
{
    /**
     * @ORM\Column(type="string", name="instructions")
     */
    protected $instructions;

    /**
     * @ORM\Column(type="datetime", name="start_date", nullable=true)
     */
    protected $startDate;

    /**
     * @ORM\Column(type="datetime", name="end_date", nullable=true)
     */
    protected $endDate;

    /**
     * @ORM\Column(type="boolean", name="allow_late_upload")
     */
    protected $allowLateUpload;

    /**
     * @ORM\Column(type="boolean", name="is_public")
     */
    protected $isPublic;

    public function __construct()
    {
        parent::__construct();
        $this->files = new ArrayCollection();
    }

    public function setInstructions($instructions)
    {
        $this->instructions = $instructions;
    }

    public function getInstructions()
    {
        return $this->instructions;
    }

    public function setStartDate($date)
    {
        $this->startDate = $date;
    }

    public function getStartDate()
    {
        return $this->startDate;
    }

    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }

    public function getEndDate()
    {
        return $this->endDate;
    }

    public function setAllowLateUpload($bool)
    {
        $this->allowLateUpload = $bool;
    }

    public function isLateUploadAllowed()
    {
        return $this->allowLateUpload;
    }

    public function getAllowLateUpload()
    {
        return $this->allowLateUpload;
    }

    public function isPublic()
    {
        return $this->isPublic;
    }

    public function setIsPublic($bool)
    {
        $this->isPublic = $bool;
    }

    public function getIsPublic()
    {
        return $this->isPublic;
    }
}
