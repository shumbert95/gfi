<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Question
 *
 * @ORM\Table(name="question")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\QuestionsRepository")
 */
class Question
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
     * @ORM\Column(name="code", type="string", length=64, unique=true)
     */
    private $code;

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
     * @ORM\Column(name="answer_three", type="text", nullable=true)
     */
    private $answerThree;

    /**
     * @var string
     *
     * @ORM\Column(name="answer_four", type="text", nullable=true)
     */
    private $answerFour;

    /**
     * @var string
     *
     * @ORM\Column(name="good_answer", type="string")
     */
    private $goodAnswer;

    /**
     * @var int
     *
     * @ORM\Column(name="time", type="integer")
     */
    private $time;

    /**
     * @var int
     *
     * @ORM\Column(name="points", type="integer")
     */
    private $points;


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
     * Set code
     *
     * @param string $code
     *
     * @return Question
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
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

    /**
     * Set points
     *
     * @param integer $points
     *
     * @return Questions
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Get points
     *
     * @return int
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * Set goodAnswer
     *
     * @param integer $goodAnswer
     *
     * @return Question
     */
    public function setGoodAnswer($goodAnswer)
    {
        $this->goodAnswer = $goodAnswer;

        return $this;
    }

    /**
     * Get goodAnswer
     *
     * @return int
     */
    public function getGoodAnswer()
    {
        return $this->goodAnswer;
    }

    public function __toString()
    {
        return ''.$this->code;
    }

    public function getInfosAsArray()
    {
        return array('id' => $this->id,
            'code' => $this->code,
            'title' => $this->title,
            'answer_one' => $this->answerOne,
            'answer_two' => $this->answerTwo,
            'answer_three' => $this->answerThree,
            'answer_four' => $this->answerFour,
            'good_answer' => $this->goodAnswer,
            'points' => $this->points,
            'time' => $this->time,
        );
    }

}

