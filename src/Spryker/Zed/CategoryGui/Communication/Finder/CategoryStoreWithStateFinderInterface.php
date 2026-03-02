<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CategoryGui\Communication\Finder;

use Generated\Shared\Transfer\StoreWithStateCollectionTransfer;

interface CategoryStoreWithStateFinderInterface
{
    public function getAllStoresWithStateByIdCategoryNode(int $idCategoryNode): StoreWithStateCollectionTransfer;

    /**
     * @param int $idCategoryNode
     *
     * @return array<int>
     */
    public function getInactiveStoreIdsByIdCategoryNode(int $idCategoryNode): array;
}
