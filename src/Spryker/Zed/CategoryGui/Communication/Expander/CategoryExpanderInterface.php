<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CategoryGui\Communication\Expander;

use Generated\Shared\Transfer\CategoryTransfer;

interface CategoryExpanderInterface
{
    public function expandCategoryWithLocalizedAttributes(CategoryTransfer $categoryTransfer): CategoryTransfer;
}
