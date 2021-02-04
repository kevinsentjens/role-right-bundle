<?php

namespace KS\RoleRightBundle;

use App\Entity\KSRight;
use App\Entity\KSRole;
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
     * Checks if user has given KSRight.
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
     * Checks if user has given KSRole
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

    /**
     * Get KSRight by name of the right. E.g. manage-users.
     * @param string $ksRight
     * @return array|KSRight
     */
    public function getKSRightByRightName(string $ksRight)
    {
        $query = $this->entityManager->createQueryBuilder();
        $query->select('ev')
            ->from('App:KSRight', 'ev')
            ->where('ev.ks_right = :ksRight')
            ->setParameter('ksRight', $ksRight)
            ->setMaxResults(1)
        ;
        $result = $query->getQuery()->getResult();
        if (!empty($result))
        {
            return $result[0];
        }
        return $query->getQuery()->getResult();
    }

    /**
     * Get KSRole by name of the role. E.g. SUPER_ADMIN.
     * @param string $ksRole
     * @return array|KSRole
     */
    public function getKSRoleByRoleName(string $ksRole)
    {
        $query = $this->entityManager->createQueryBuilder();
        $query->select('ev')
            ->from('App:KSRole', 'ev')
            ->where('ev.ks_role = :ksRole')
            ->setParameter('ksRole', $ksRole)
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