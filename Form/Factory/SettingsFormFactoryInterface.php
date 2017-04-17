<?php

/*
 * This file is part of the Miky package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Miky\Bundle\SettingsBundle\Form\Factory;

use Symfony\Component\Form\FormInterface;


interface SettingsFormFactoryInterface
{
    /**
     * @param string $schemaAlias
     * @param null|mixed $data
     * @param array $options
     *
     * @return FormInterface
     */
    public function create($schemaAlias, $data = null, array $options = []);
}
