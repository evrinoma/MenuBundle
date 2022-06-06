<?php


namespace Evrinoma\MenuBundle\Menu;


use Doctrine\ORM\EntityManagerInterface;
use Evrinoma\MenuBundle\Entity\MenuItem;
use Evrinoma\SecurityBundle\Voter\RoleInterface;

/**
 * Class PredefinedMenu
 *
 * @package Evrinoma\MenuBundle\Menu
 */
final class PredefinedMenu implements MenuInterface
{
//region SECTION: Public
    public function create(EntityManagerInterface $em): void
    {
        $logout = new MenuItem();
        $logout
            ->setRole([RoleInterface::ROLE_SUPER_ADMIN, RoleInterface::ROLE_USER])
            ->setName('Logout')
            ->setRoute('security_logout')
            ->setAttributes(['class' => 'logout'])
            ->setTag($this->tag());

        $em->persist($logout);
    }

    public function order(): int
    {
        return 1000;
    }

    public function tag(): string
    {
        return MenuInterface::DEFAULT_TAG;
    }
//endregion Public
}