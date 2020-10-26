<?php


namespace Evrinoma\MenuBundle\Manager;

use Evrinoma\UtilsBundle\Manager\BaseEntityInterface;
use Evrinoma\UtilsBundle\Rest\RestInterface;

/**
 * Interface MenuManagerInterface
 *
 * @package Evrinoma\MenuBundle\Manager
 */
interface MenuManagerInterface extends RestInterface, BaseEntityInterface
{
    public function setDto($dto): MenuManagerInterface;

    public function get($options = []): MenuManagerInterface;

    public function delete(): void;

    public function create(): void;
}