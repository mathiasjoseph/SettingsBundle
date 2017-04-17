<?php

/*
 * This file is part of the Miky package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Miky\Bundle\SettingsBundle\Controller\Backend;

use Miky\Bundle\SettingsBundle\Form\Factory\SettingsFormFactoryInterface;
use Miky\Bundle\SettingsBundle\Manager\SettingsManagerInterface;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Exception\ValidatorException;


class SettingsAdminController extends FOSRestController
{
    /**
     * Get a specific settings data.
     * This controller action only used for Rest API.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function showAction(Request $request)
    {
        $schemaAlias = $request->attributes->get('schema');

        $this->isGrantedOr403($schemaAlias);

        $settings = $this->getSettingsManager()->load($schemaAlias);

        $view = $this
            ->view()
            ->setData($settings)
        ;

        return $this->handleView($view);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function updateAction(Request $request, $schema)
    {
        $schemaAlias = $schema;

        $this->isGrantedOr403($schemaAlias);

        $settingsManager = $this->getSettingsManager();
        $settings = $settingsManager->load($schemaAlias);

        $form = $this
            ->getSettingsFormFactory()
            ->create($schemaAlias, $settings)
        ;

        if ($form->handleRequest($request)->isValid()) {
            $messageType = 'success';
            try {
                $settingsManager->save($settings);
                $message = $this->getTranslator()->trans('miky.settings.update', [], 'flashes');
            } catch (ValidatorException $exception) {
                $message = $this->getTranslator()->trans($exception->getMessage(), [], 'validators');
                $messageType = 'error';
            }



            $request->getSession()->getBag('flashes')->add($messageType, $message);

            if ($request->headers->has('referer')) {
                return $this->redirect($request->headers->get('referer'));
            }
        }

        return $this->render($request->attributes->get('template', 'MikySettingsBundle:Backend:update.html.twig'), [
            'settings' => $settings,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @return SettingsManagerInterface
     */
    protected function getSettingsManager()
    {
        return $this->get('miky.settings.manager');
    }

    /**
     * @return SettingsFormFactoryInterface
     */
    protected function getSettingsFormFactory()
    {
        return $this->get('miky.settings.form_factory');
    }

    /**
     * @return TranslatorInterface
     */
    protected function getTranslator()
    {
        return $this->get('translator');
    }

    /**
     * Check that user can change given schema.
     *
     * @param string $schemaAlias
     *
     * @return bool
     */
    protected function isGrantedOr403($schemaAlias)
    {
        if (!$this->container->has('miky.authorization_checker')) {
            return true;
        }

        if (!$this->get('miky.authorization_checker')->isGranted(sprintf('miky.settings.%s', $schemaAlias))) {
            throw new AccessDeniedException();
        }
    }

    /**
     * @param Request $request
     *
     * @return bool
     */
    private function isApiRequest(Request $request)
    {
        return 'html' !== $request->getRequestFormat();
    }
}
