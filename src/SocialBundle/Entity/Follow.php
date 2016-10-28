<?php

namespace SocialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Follow
 *
 * @ORM\Table(name="follow")
 * @ORM\Entity(repositoryClass="SocialBundle\Repository\FollowRepository")
 */
class Follow
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
   * @ORM\ManyToOne(targetEntity="MainBundle\Entity\User")
   * @ORM\JoinColumn(nullable=false)
   */
    private $user;

    /**
     * @var int
     *
     * @ORM\Column(name="idFollow", type="integer")
     */
    private $idFollow;

    /**
     * @var bool
     *
     * @ORM\Column(name="blocked", type="boolean")
     */
    private $blocked;

    public function __construct(\MainBundle\Entity\User $user)
    {
        $this->user = $user;
        $this->blocked = false;
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
     * Set idFollow
     *
     * @param integer $idFollow
     *
     * @return Follow
     */
    public function setIdFollow($idFollow)
    {
        $this->idFollow = $idFollow;

        return $this;
    }

    /**
     * Get idFollow
     *
     * @return int
     */
    public function getIdFollow()
    {
        return $this->idFollow;
    }

    /**
     * Set blocked
     *
     * @param boolean $blocked
     *
     * @return Follow
     */
    public function setBlocked($blocked)
    {
        $this->blocked = $blocked;

        return $this;
    }

    /**
     * Get blocked
     *
     * @return bool
     */
    public function getBlocked()
    {
        return $this->blocked;
    }
    /**
     * Set user
     *
     * @param \MainBundle\Entity\User $user
     *
     * @return Follow
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
