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

namespace Evrinoma\MenuBundle\Serializer\Symfony;

use Evrinoma\UtilsBundle\Serialize\AbstractConfiguration;

class ConfigurationMenu extends AbstractConfiguration
{
    protected string $fileName = '/src/Serializer/Symfony/yml/MenuBundle/Model.Menu.AbstractMenuItem.yml';
}
