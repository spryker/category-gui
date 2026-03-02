<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CategoryGui\Communication\Finder;

use Generated\Shared\Transfer\CategoryTransfer;
use Generated\Shared\Transfer\LocaleTransfer;

interface CategoryFinderInterface
{
    public function findCategoryByIdCategoryAndLocale(int $idCategory, ?LocaleTransfer $localeTransfer = null): ?CategoryTransfer;

    public function findCategoryWithLocalizedAttributesById(int $idCategory): ?CategoryTransfer;

    public function findParentCategory(CategoryTransfer $categoryTransfer, LocaleTransfer $localeTransfer): ?CategoryTransfer;

    /**
     * @param int|null $idCategory
     *
     * @return array<\Generated\Shared\Transfer\NodeTransfer>
     */
    public function getCategoryNodes(?int $idCategory = null): array;
}
