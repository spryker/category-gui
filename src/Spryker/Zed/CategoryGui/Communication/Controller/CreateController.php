<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CategoryGui\Communication\Controller;

use ArrayObject;
use Spryker\Service\UtilText\Model\Url\Url;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Spryker\Zed\CategoryGui\Communication\CategoryGuiCommunicationFactory getFactory()
 * @method \Spryker\Zed\CategoryGui\Persistence\CategoryGuiRepositoryInterface getRepository()
 */
class CreateController extends AbstractController
{
    protected const REQUEST_PARAM_ID_CATEGORY = 'id-category';
    protected const REQUEST_PARAM_ID_PARENT_NODE = 'id-parent-node';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function indexAction(Request $request)
    {
        $this->getFactory()->getCategoryFacade()->syncCategoryTemplate();

        $idParentNode = $this->readParentNodeId($request);
        $form = $this->getFactory()->createCategoryCreateForm($idParentNode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoryResponseTransfer = $this->getFactory()
                ->createCategoryFormHandler()
                ->createCategory($form->getData());

            if ($categoryResponseTransfer->getIsSuccessful()) {
                $this->addSuccessMessages($categoryResponseTransfer->getMessages());

                return $this->redirectResponse(
                    $this->createSuccessRedirectUrl($categoryResponseTransfer->getCategory()->getIdCategory())
                );
            }

            $this->addErrorMessages($categoryResponseTransfer->getMessages());
        }

        return $this->viewResponse([
            'categoryForm' => $form->createView(),
            'currentLocale' => $this->getFactory()->getLocaleFacade()->getCurrentLocale()->getLocaleName(),
            'categoryFormTabs' => $this->getFactory()->createCategoryFormTabs()->createView(),
        ]);
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
            '/category-gui/edit',
            [
                static::REQUEST_PARAM_ID_CATEGORY => $idCategory,
            ]
        );

        return $url->build();
    }

    /**
     * @param \ArrayObject|\Generated\Shared\Transfer\MessageTransfer[] $messageTransfers
     *
     * @return void
     */
    protected function addSuccessMessages(ArrayObject $messageTransfers): void
    {
        foreach ($messageTransfers as $messageTransfer) {
            $this->addSuccessMessage($messageTransfer->getValue());
        }
    }

    /**
     * @param \ArrayObject|\Generated\Shared\Transfer\MessageTransfer[] $messageTransfers
     *
     * @return void
     */
    protected function addErrorMessages(ArrayObject $messageTransfers): void
    {
        foreach ($messageTransfers as $messageTransfer) {
            $this->addErrorMessage($messageTransfer->getValue());
        }
    }
}
