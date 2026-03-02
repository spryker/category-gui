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

class CategoryGuiToCategoryFacadeBridge implements CategoryGuiToCategoryFacadeInterface
{
    /**
     * @var \Spryker\Zed\Category\Business\CategoryFacadeInterface
     */
    protected $categoryFacade;

    /**
     * @param \Spryker\Zed\Category\Business\CategoryFacadeInterface $categoryFacade
     */
    public function __construct($categoryFacade)
    {
        $this->categoryFacade = $categoryFacade;
    }

    public function checkSameLevelCategoryByNameExists(string $name, CategoryTransfer $categoryTransfer): bool
    {
        return $this->categoryFacade->checkSameLevelCategoryByNameExists($name, $categoryTransfer);
    }

    public function create(CategoryTransfer $categoryTransfer): void
    {
        $this->categoryFacade->create($categoryTransfer);
    }

    public function getAllCategoryCollection(LocaleTransfer $localeTransfer): CategoryCollectionTransfer
    {
        return $this->categoryFacade->getAllCategoryCollection($localeTransfer);
    }

    public function delete(int $idCategory): void
    {
        $this->categoryFacade->delete($idCategory);
    }

    public function update(CategoryTransfer $categoryTransfer): void
    {
        $this->categoryFacade->update($categoryTransfer);
    }

    public function findCategory(CategoryCriteriaTransfer $categoryCriteriaTransfer): ?CategoryTransfer
    {
        return $this->categoryFacade->findCategory($categoryCriteriaTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CategoryNodeUrlCriteriaTransfer $categoryNodeUrlCriteriaTransfer
     *
     * @return array<\Generated\Shared\Transfer\UrlTransfer>
     */
    public function getCategoryNodeUrls(CategoryNodeUrlCriteriaTransfer $categoryNodeUrlCriteriaTransfer): array
    {
        return $this->categoryFacade->getCategoryNodeUrls($categoryNodeUrlCriteriaTransfer);
    }

    public function reorderCategoryNodeCollection(
        CategoryNodeCollectionRequestTransfer $categoryNodeCollectionRequestTransfer
    ): CategoryNodeCollectionResponseTransfer {
        return $this->categoryFacade->reorderCategoryNodeCollection($categoryNodeCollectionRequestTransfer);
    }
}
