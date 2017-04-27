<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Participation
 *
 * @ORM\Table(name="participation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ParticipationRepository")
 */
class Participation
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
     * @var int
     *
     * @ORM\Column(name="note", type="integer")
     */
    private $note;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Quiz", inversedBy="participations", cascade={"merge", "persist"})
     */
    private $quiz;

    /**
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="participations", cascade={"merge", "persist"})
     */
    private $user;


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
     * Set note
     *
     * @param integer $note
     *
     * @return Participation
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return int
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Participation
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

    /**
     * Set quiz
     *
     * @param Quiz $quiz
     *
     * @return Participation
     */
    public function setQuiz($quiz)
    {
        $this->quiz = $quiz;

        return $this;
    }

    /**
     * Get quiz
     *
     * @return Participation
     */
    public function getQuiz()
    {
        return $this->quiz;
    }

    /**
     * Set user
     *
     * @param User $user
     *
     * @return Participation
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return Participation
     */
    public function getUser()
    {
        return $this->user;
    }

    public function getInfosAsArray()
    {
        return array('id' => $this->id,
            'quiz_id' => $this->quiz->getId(),
            'quiz_title' => $this->quiz->getTitle(),
            'note' => $this->note,
            'date' => $this->date,
            'user_id' => $this->user->getId());
    }
}

