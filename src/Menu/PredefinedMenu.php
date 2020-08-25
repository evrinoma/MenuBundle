<?php


namespace Evrinoma\MenuBundle\Menu;


use Doctrine\ORM\EntityManagerInterface;
use Evrinoma\MenuBundle\Entity\MenuItem;
use Evrinoma\MenuBundle\Manager\MenuInterface;
use Evrinoma\UtilsBundle\Voter\RoleInterface;

/**
 * Class PredefinedMenu
 *
 * @package Evrinoma\MenuBundle\Menu
 */
final class PredefinedMenu implements MenuInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
//region SECTION: Public
    public function createMenu(EntityManagerInterface $em):void
    {
        $this->em = $em;
        $this->createLogout($em);
    }

    private function createLogout()
    {
        $logout = new MenuItem();
        $logout
            ->setRole([RoleInterface::ROLE_USER])
            ->setName('Logout')
            ->setRoute('fos_user_security_logout')
            ->setAttributes(['class' => 'logout']);
        $this->em->persist($logout);

        return $this;
    }
//endregion Public
    public function order(): int
    {
        return 1000;
    }
}