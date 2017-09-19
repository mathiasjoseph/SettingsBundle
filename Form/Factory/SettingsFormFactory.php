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

use Miky\Bundle\SettingsBundle\Schema\SchemaInterface;
use Miky\Component\Registry\ServiceRegistryInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormFactoryInterface;


final class SettingsFormFactory implements SettingsFormFactoryInterface
{
    /**
     * @var ServiceRegistryInterface
     */
    private $schemaRegistry;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @param ServiceRegistryInterface $schemaRegistry
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(ServiceRegistryInterface $schemaRegistry, FormFactoryInterface $formFactory)
    {
        $this->schemaRegistry = $schemaRegistry;
        $this->formFactory = $formFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function create($schemaAlias, $data = null, array $options = [])
    {
        /** @var SchemaInterface $schema */
        $schema = $this->schemaRegistry->get($schemaAlias);

        $builder = $this->formFactory->createBuilder('form', $data, array_merge_recursive(
            ['data_class' => null], $options
        ));

        $schema->buildForm($builder);
        $builder->add("submit", SubmitType::class, array(
            "label" => "miky_core.submit"
        ));

        return $builder->getForm();
    }
}
