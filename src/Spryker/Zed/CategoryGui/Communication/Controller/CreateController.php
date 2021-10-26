<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CategoryGui\Communication\Controller;

use Spryker\Service\UtilText\Model\Url\Url;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Spryker\Zed\CategoryGui\Communication\CategoryGuiCommunicationFactory getFactory()
 * @method \Spryker\Zed\CategoryGui\Persistence\CategoryGuiRepositoryInterface getRepository()
 */
class CreateController extends CategoryAbstractController
{
    /**
     * @var string
     */
    protected const REQUEST_PARAM_ID_CATEGORY = 'id-category';

    /**
     * @var string
     */
    protected const REQUEST_PARAM_ID_PARENT_NODE = 'id-parent-node';

    /**
     * @var string
     */
    protected const REQUEST_PARAM_IS_ROOT = 'is-root';

    /**
     * @var string
     */
    protected const ROUTE_CATEGORY_CREATE = '/category-gui/create';

    /**
     * @uses \Spryker\Zed\CategoryGui\Communication\Controller\EditController::indexAction()
     *
     * @var string
     */
    protected const ROUTE_CATEGORY_EDIT = '/category-gui/edit';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|array
     */
    public function indexAction(Request $request)
    {
        $form = $this->getForm($request);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->handleCategoryCreateForm($form);
        }

        return $this->viewResponse([
            'categoryForm' => $form->createView(),
            'currentLocale' => $this->getCurrentLocale()->getLocaleName(),
            'categoryFormTabs' => $this->getFactory()->createCategoryFormTabs()->createView(),
        ]);
    }

    /**
     * @param \Symfony\Component\Form\FormInterface $form
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function handleCategoryCreateForm(FormInterface $form): RedirectResponse
    {
        $categoryResponseTransfer = $this->getFactory()
            ->createCategoryCreator()
            ->createCategory($form->getData());

        if (!$categoryResponseTransfer->getIsSuccessful()) {
            $this->addErrorMessages($categoryResponseTransfer->getMessages());

            return $this->redirectResponse(static::ROUTE_CATEGORY_CREATE);
        }

        $this->addSuccessMessages($categoryResponseTransfer->getMessages());

        return $this->redirectResponse(
            $this->createSuccessRedirectUrl($categoryResponseTransfer->getCategoryOrFail()->getIdCategoryOrFail()),
        );
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    protected function getForm(Request $request): FormInterface
    {
        if ($request->query->get(static::REQUEST_PARAM_IS_ROOT)) {
            return $this->getFactory()->createRootCategoryCreateForm();
        }

        return $this->getFactory()->createCategoryCreateForm(
            $this->readParentNodeId($request),
        );
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return int|null
     */
    protected function readParentNodeId(Request $request): ?int
    {
        $parentNodeId = $request->query->get(static::REQUEST_PARAM_ID_PARENT_NODE);

        if (!$parentNodeId) {
            return null;
        }

        return $this->castId($parentNodeId);
    }

    /**
     * @param int $idCategory
     *
     * @return string
     */
    protected function createSuccessRedirectUrl(int $idCategory): string
    {
        $url = Url::generate(
            static::ROUTE_CATEGORY_EDIT,
            [
                static::REQUEST_PARAM_ID_CATEGORY => $idCategory,
            ],
        );

        return $url->build();
    }
}
