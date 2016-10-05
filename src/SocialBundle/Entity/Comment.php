<?php

namespace SocialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * comment
 *
 * @ORM\Table(name="comment")
 * @ORM\Entity(repositoryClass="SocialBundle\Repository\commentRepository")
 */
class Comment
{
    /**
   * @ORM\ManyToOne(targetEntity="SocialBundle\Entity\Actuality", inversedBy="comment")
   */
    private $actuality;
    
       /**
   * @ORM\ManyToOne(targetEntity="MainBundle\Entity\User")
   * @ORM\JoinColumn(nullable=false)
   */
    private $user;
    
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
     * @Assert\NotBlank()
     * @ORM\Column(name="text", type="string", length=255)
     */
    private $text;

    /**
     * @var \DateTime
     * 
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    //CONSTRUCTOR
    public function __construct()
    {
        $this->date = new \Datetime();
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
     * Set text
     *
     * @param string $text
     *
     * @return comment
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return comment
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
     * Set actuality
     *
     * @param \SocialBundle\Entity\Actuality $actuality
     *
     * @return Comment
     */
    public function setActuality(\SocialBundle\Entity\Actuality $actuality)
    {
        $this->actuality = $actuality;

        return $this;
    }

    /**
     * Get actuality
     *
     * @return \SocialBundle\Entity\Actuality
     */
    public function getActuality()
    {
        return $this->actuality;
    }

    /**
     * Set user
     *
     * @param \MainBundle\Entity\User $user
     *
     * @return Comment
     */
    public function setUser(\MainBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \MainBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
