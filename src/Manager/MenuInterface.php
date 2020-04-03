<?php


namespace Evrinoma\MenuBundle\Manager;


use Doctrine\ORM\EntityManagerInterface;

/**
 * Interface MenuInterface
 *
 * @package Evrinoma\MenuBundle\Manager
 */
interface MenuInterface
{
//region SECTION: Public
    public function createMenu(EntityManagerInterface $em): void;
    public function order(): int;
//endregion Public
}