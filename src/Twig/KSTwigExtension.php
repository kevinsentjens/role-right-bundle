<?php


namespace KS\RoleRightBundle\Twig;


use App\Entity\KSRight;
use App\Entity\KSRole;
use KS\RoleRightBundle\KSRoleRight;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class KSTwigExtension extends AbstractExtension
{
    private $ksRoleRight;

    public function __construct(KSRoleRight $ksRoleRight)
    {
        $this->ksRoleRight = $ksRoleRight;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('has_role', [$this, 'hasKSRole']),
            new TwigFunction('has_right', [$this, 'hasKSRight'])
        ];
    }

    public function getFilters()
    {
        return [
            new TwigFilter('roleHasRight', [$this, 'roleHasRight']),
        ];
    }

    public function hasKSRole(string $ksRole): bool
    {
        return $this->ksRoleRight->hasKSRole($ksRole);
    }

    public function hasKSRight(string $ksRight): bool
    {
        return $this->ksRoleRight->hasKSRight($ksRight);
    }

    public function roleHasRight(KSRole $role, KSRight $right): bool
    {
        if ($role->getKsRights()->contains($right))
        {
            return true;
        }
        return false;
    }
}