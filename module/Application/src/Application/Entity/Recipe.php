<?php

/**
 * Created by PhpStorm.
 * User: bezyx
 * Date: 15.03.2016
 * Time: 18:11
 */

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Section
 *
 * @ORM\Table(name="recipes")
 * @ORM\Entity
 */
class Recipe
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     */
    protected $id;

//    /**
//     * @var int
//     * @ORM\Column(type="integer", nullable=false)
//     */
//    protected $section_id;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=false)
     */
    protected $description;

    /**
     * @ORM\ManyToOne(targetEntity="Section", inversedBy="recipes")
     */
    private $section;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getSectionId()
    {
        return $this->section_id;
    }

    /**
     * @param int $section_id
     */
    public function setSectionId($section_id)
    {
        $this->section_id = $section_id;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * @param mixed $section
     */
    public function setSection($section)
    {
        $this->section = $section;
    }


}