<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string")
     */
    private $first_name;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string")
     */
    private $last_name;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string")
     */
    private $phone;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Tags", cascade={"persist"})
     * @ORM\JoinTable(name="user_skills",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")}
     * )
     */
    private $skills;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }


    /**
     * Set first_name
     *
     * @param string $first_name
     *
     * @return User
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;

        return $this;
    }

    /**
     * Get first_name
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set last_name
     *
     * @param string $last_name
     *
     * @return User
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;

        return $this;
    }

    /**
     * Get last_name
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set skills
     *
     * @param string $skills
     *
     * @return User
     */
    public function setSkills($skills)
    {
        $this->skills = $skills;

        return $this;
    }

    /**
     * Get skills
     *
     */
    public function getSkills()
    {
        return $this->skills;
    }

    /**
     * Add skill
     *
     * @param \AppBundle\Entity\Tags $skill
     * @return User
     */
    public function addSkill(\AppBundle\Entity\Tags $skill)
    {
        $this->skills[] = $skill;

        return $this;
    }

    /**
     * Remove skill
     *
     * @param \AppBundle\Entity\Tags $activities
     */
    public function removeActivity(\AppBundle\Entity\Tags $skill)
    {
        $this->skills->removeElement($skill);
    }
}