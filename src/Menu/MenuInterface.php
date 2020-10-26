<?php


namespace Evrinoma\MenuBundle\Menu;


use Doctrine\ORM\EntityManagerInterface;

/**
 * Interface MenuInterface
 *
 * @package Evrinoma\MenuBundle\Manager
 */
interface MenuInterface
{
    public const DEFAULT_TAG = 'default';
//region SECTION: Public
    public function create(EntityManagerInterface $em): void;
    public function tag(): string;
    public function order(): int;
//endregion Public
}