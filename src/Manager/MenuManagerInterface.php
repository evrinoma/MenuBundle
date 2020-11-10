<?php


namespace Evrinoma\MenuBundle\Manager;

use Evrinoma\UtilsBundle\Manager\EntityInterface;
use Evrinoma\UtilsBundle\Rest\RestInterface;

/**
 * Interface MenuManagerInterface
 *
 * @package Evrinoma\MenuBundle\Manager
 */
interface MenuManagerInterface extends RestInterface, EntityInterface
{
    public function setDto($dto): MenuManagerInterface;

    public function get($options = []): MenuManagerInterface;

    public function delete(): void;

    public function create(): void;
}