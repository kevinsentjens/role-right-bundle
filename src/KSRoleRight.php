<?php

namespace KS\RoleRightBundle;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

/**
 * Class KSRoleRight used for authenticating users
 * @author Kevin Sentjens <kevinsentjens.dev@gmail.com>
 */
class KSRoleRight
{
    /**
     * @var Security
     */
    private $security;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * KSRoleRight constructor.
     * @param Security $security
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(Security $security, EntityManagerInterface $entityManager)
    {
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $ksRight
     * @return bool
     */
    public function hasKSRight(string $ksRight): bool
    {
        $user = $this->getUserByEmail($this->security->getUser()->getUsername());
        if (!empty($user))
        {
            foreach ($user->getKsRoles() as $role)
            {
                foreach ($role->getKsRights() as $right)
                {
                    if ($ksRight === $right->getKsRight())
                    {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    /**
     * @param string $ksRole
     * @return bool
     */
    public function hasKSRole(string $ksRole): bool
    {
        $user = $this->getUserByEmail($this->security->getUser()->getUsername());
        if (!empty($user))
        {
            foreach ($user->getKsRoles() as $role)
            {
                if ($ksRole === $role->getKsRole())
                {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @param string $email
     * @return array|User
     */
    private function getUserByEmail(string $email)
    {
        $query = $this->entityManager->createQueryBuilder();
        $query->select('ev')
            ->from('App:User', 'ev')
            ->where('ev.email = :email')
            ->setParameter('email', $email)
            ->setMaxResults(1)
        ;
        $result = $query->getQuery()->getResult();
        if (!empty($result))
        {
            return $result[0];
        }
        return $query->getQuery()->getResult();
    }
}