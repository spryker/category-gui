<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CategoryGui\Dependency\Facade;

use Generated\Shared\Transfer\CategoryCollectionTransfer;
use Generated\Shared\Transfer\CategoryCriteriaTransfer;
use Generated\Shared\Transfer\CategoryNodeCollectionRequestTransfer;
use Generated\Shared\Transfer\CategoryNodeCollectionResponseTransfer;
use Generated\Shared\Transfer\CategoryNodeUrlCriteriaTransfer;
use Generated\Shared\Transfer\CategoryTransfer;
use Generated\Shared\Transfer\LocaleTransfer;

interface CategoryGuiToCategoryFacadeInterface
{
    public function checkSameLevelCategoryByNameExists(string $name, CategoryTransfer $categoryTransfer): bool;

    public function create(CategoryTransfer $categoryTransfer): void;

    public function getAllCategoryCollection(LocaleTransfer $localeTransfer): CategoryCollectionTransfer;

    public function delete(int $idCategory): void;

    public function update(CategoryTransfer $categoryTransfer): void;

    public function findCategory(CategoryCriteriaTransfer $categoryCriteriaTransfer): ?CategoryTransfer;

    /**
     * @param \Generated\Shared\Transfer\CategoryNodeUrlCriteriaTransfer $categoryNodeUrlCriteriaTransfer
     *
     * @return array<\Generated\Shared\Transfer\UrlTransfer>
     */
    public function getCategoryNodeUrls(CategoryNodeUrlCriteriaTransfer $categoryNodeUrlCriteriaTransfer): array;

    public function reorderCategoryNodeCollection(
        CategoryNodeCollectionRequestTransfer $categoryNodeCollectionRequestTransfer
    ): CategoryNodeCollectionResponseTransfer;
}
