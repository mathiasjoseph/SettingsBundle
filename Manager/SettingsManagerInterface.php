<?php

/*
 * This file is part of the Miky package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Miky\Bundle\SettingsBundle\Manager;

use Miky\Bundle\SettingsBundle\Model\SettingsInterface;


interface SettingsManagerInterface
{
    /**
     * @param string $schemaAlias
     * @param string|null $namespace
     *
     * @return SettingsInterface
     */
    public function load($schemaAlias, $namespace = null);

    /**
     * @param SettingsInterface $settings
     */
    public function save(SettingsInterface $settings);
}
