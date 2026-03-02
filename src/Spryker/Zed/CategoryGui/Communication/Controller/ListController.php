<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CategoryGui\Communication\Controller;

use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @method \Spryker\Zed\CategoryGui\Communication\CategoryGuiCommunicationFactory getFactory()
 * @method \Spryker\Zed\CategoryGui\Persistence\CategoryGuiRepositoryInterface getRepository()
 */
class ListController extends AbstractController
{
    public function indexAction(): array
    {
        $categoryTable = $this->getFactory()
            ->createCategoryTable();

        return $this->viewResponse([
            'categoryTable' => $categoryTable->render(),
        ]);
    }

    public function tableAction(): JsonResponse
    {
        $categoryTable = $this
            ->getFactory()
            ->createCategoryTable();

        return $this->jsonResponse(
            $categoryTable->fetchData(),
        );
    }
}
