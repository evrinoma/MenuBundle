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

namespace Evrinoma\MenuBundle\Tests\Functional\ValueObject\Menu;

use Evrinoma\TestUtilsBundle\ValueObject\Common\AbstractName;

class Name extends AbstractName
{
    protected static string $value = 'Service';
    protected static string $default = 'Test';

    public static function value(): string
    {
        return 'Test '.parent::value();
    }
}
