<?php
namespace MainBundle\Services;

class UserListService
{
    private $entityManager;
    private $elasticaManager;

    public function __construct($entityManager, $elasticaManager)
    {
        $this->entityManager = $entityManager;
        $this->elasticaManager = $elasticaManager;
    }

    public function getUserList ($user, $limit = 0)
    {
      return $this->entityManager
          ->createQuery('
              SELECT u FROM MainBundle:User u WHERE u.id NOT IN
                (SELECT v.idFollow FROM SocialBundle:Follow v WHERE v.user = :myUser)
              AND u.id != :myUserId
              ')
          ->setMaxResults($limit)
          ->setMaxResults(100)
          ->setParameters(['myUser' => $user, 'myUserId' => $user->getId()])
          ->getResult();
    }

    public function searchUsers ($pattern)
    {
        $users = $this->elasticaManager;
        return $users->search("*".$pattern."*");
    }

    public function getSingleUser($id)
    {

    }
}
