<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CategoryGui\Communication\Category;

use Generated\Shared\Transfer\CategoryResponseTransfer;

interface CategoryDeleterInterface
{
    public function deleteCategory(int $idCategory): CategoryResponseTransfer;
}
