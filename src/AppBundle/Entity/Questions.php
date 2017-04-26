<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Questions
 *
 * @ORM\Table(name="questions")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\QuestionsRepository")
 */
class Questions
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
     * @ORM\Column(name="title", type="text")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="answer_one", type="text")
     */
    private $answerOne;

    /**
     * @var string
     *
     * @ORM\Column(name="answer_two", type="text")
     */
    private $answerTwo;

    /**
     * @var string
     *
     * @ORM\Column(name="answer_three", type="text")
     */
    private $answerThree;

    /**
     * @var string
     *
     * @ORM\Column(name="answer_four", type="text")
     */
    private $answerFour;

    /**
     * @var int
     *
     * @ORM\Column(name="time", type="integer")
     */
    private $time;


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
     * Set title
     *
     * @param string $title
     *
     * @return Questions
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
     * Set answerOne
     *
     * @param string $answerOne
     *
     * @return Questions
     */
    public function setAnswerOne($answerOne)
    {
        $this->answerOne = $answerOne;

        return $this;
    }

    /**
     * Get answerOne
     *
     * @return string
     */
    public function getAnswerOne()
    {
        return $this->answerOne;
    }

    /**
     * Set answerTwo
     *
     * @param string $answerTwo
     *
     * @return Questions
     */
    public function setAnswerTwo($answerTwo)
    {
        $this->answerTwo = $answerTwo;

        return $this;
    }

    /**
     * Get answerTwo
     *
     * @return string
     */
    public function getAnswerTwo()
    {
        return $this->answerTwo;
    }

    /**
     * Set answerThree
     *
     * @param string $answerThree
     *
     * @return Questions
     */
    public function setAnswerThree($answerThree)
    {
        $this->answerThree = $answerThree;

        return $this;
    }

    /**
     * Get answerThree
     *
     * @return string
     */
    public function getAnswerThree()
    {
        return $this->answerThree;
    }

    /**
     * Set answerFour
     *
     * @param string $answerFour
     *
     * @return Questions
     */
    public function setAnswerFour($answerFour)
    {
        $this->answerFour = $answerFour;

        return $this;
    }

    /**
     * Get answerFour
     *
     * @return string
     */
    public function getAnswerFour()
    {
        return $this->answerFour;
    }

    /**
     * Set time
     *
     * @param integer $time
     *
     * @return Questions
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return int
     */
    public function getTime()
    {
        return $this->time;
    }
}

