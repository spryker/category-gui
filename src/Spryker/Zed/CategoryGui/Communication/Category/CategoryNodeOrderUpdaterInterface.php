<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CategoryGui\Communication\Category;

interface CategoryNodeOrderUpdaterInterface
{
    /**
     * @param string $categoryNodesData
     *
     * @return void
     */
    public function updateCategoryNodeOrder(string $categoryNodesData): void;
}
