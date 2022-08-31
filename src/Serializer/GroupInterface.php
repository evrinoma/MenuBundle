<?php

declare(strict_types=1);

/*
 * This file is part of the package.
 *
 * (c) Nikolay Nikolaev <evrinoma@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Evrinoma\MenuBundle\Serializer;

interface GroupInterface
{
    public const API_POST_MENU = 'API_POST_MENU';
    public const API_PUT_MENU = 'API_PUT_MENU';
    public const API_GET_MENU = 'API_GET_MENU';
    public const API_CRITERIA_MENU = self::API_GET_MENU;
    public const API_POST_REGISTRY_MENU = 'API_POST_REGISTRY_MENU';
}
