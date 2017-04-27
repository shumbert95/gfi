<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Offer
 *
 * @ORM\Table(name="offer")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OfferRepository")
 */
class Offer
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="string", length=10, unique=true)
     */
    private $reference;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="poste", type="string", length=255)
     */
    private $poste;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Tags", cascade={"persist"})
     * @ORM\JoinTable(name="offer_required_tags",
     *      joinColumns={@ORM\JoinColumn(name="offer_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")}
     * )
     */
    private $required_skills;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Tags", cascade={"persist"})
     * @ORM\JoinTable(name="offer_optional_tags",
     *      joinColumns={@ORM\JoinColumn(name="offer_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")}
     * )
     */
    private $optional_skills;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Quiz", cascade={"persist"})
     * @ORM\JoinTable(name="offer_quiz",
     *      joinColumns={@ORM\JoinColumn(name="offer_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="quiz_id", referencedColumnName="id")}
     * )
     */
    private $quizs;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;


    public function __construct()
    {
        $this->optional_skills = new ArrayCollection();
        $this->required_skills = new ArrayCollection();
        $this->quizs = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set reference
     *
     * @param string $reference
     *
     * @return Offer
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Offer
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set poste
     *
     * @param string $poste
     *
     * @return Offer
     */
    public function setPoste($poste)
    {
        $this->poste = $poste;

        return $this;
    }

    /**
     * Get poste
     *
     * @return string
     */
    public function getPoste()
    {
        return $this->poste;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Offer
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set required_skills
     *
     * @param string $required_skills
     *
     * @return Offer
     */
    public function setRequiredSkills($required_skills)
    {
        $this->required_skills = $required_skills;

        return $this;
    }

    /**
     * Get required_skills
     *
     * @return string
     */
    public function getRequiredSkills()
    {
        return $this->required_skills;
    }

    /**
     * Set optional_skills
     *
     * @param string $optional_skills
     *
     * @return Offer
     */
    public function setOptionalSkills($optional_skills)
    {
        $this->optional_skills = $optional_skills;

        return $this;
    }

    /**
     * Get optional_skills
     *
     * @return string
     */
    public function getOptionalSkills()
    {
        return $this->optional_skills;
    }

    /**
     * Set quizs
     *
     * @param string $quizs
     *
     * @return Offer
     */
    public function setQuizs($quizs)
    {
        $this->quizs = $quizs;

        return $this;
    }

    /**
     * Get quizs
     *
     * @return ArrayCollection
     */
    public function getQuizs()
    {
        return $this->quizs;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Offer
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    public function __toString()
    {
        return ''.$this->title;
    }

    public function getInfosAsArray()
    {
        $tags = array();
        foreach ($this->required_skills as $tag) {
            $tags['required_skills'] = $tag->getInfosAsArray();
        }
        foreach ($this->optional_skills as $tag) {
            $tags['optional_skills'] = $tag->getInfosAsArray();
        }
        return array(
            'id' => $this->id,
            'reference' => $this->reference,
            'title' => $this->title,
            'description' => $this->description,
            'poste' => $this->poste,
            'date' => $this->date,
            'skills' => $tags,
        );
    }
}

