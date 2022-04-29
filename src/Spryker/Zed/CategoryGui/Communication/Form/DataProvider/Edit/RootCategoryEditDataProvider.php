<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CategoryGui\Communication\Form\DataProvider\Edit;

use Generated\Shared\Transfer\CategoryTransfer;
use Spryker\Zed\CategoryGui\Communication\Finder\CategoryFinderInterface;
use Spryker\Zed\CategoryGui\Communication\Form\CategoryType;
use Spryker\Zed\CategoryGui\Communication\Form\RootCategoryType;
use Spryker\Zed\CategoryGui\Persistence\CategoryGuiRepositoryInterface;

class RootCategoryEditDataProvider
{
    /**
     * @var \Spryker\Zed\CategoryGui\Persistence\CategoryGuiRepositoryInterface
     */
    protected $categoryGuiRepository;

    /**
     * @var \Spryker\Zed\CategoryGui\Communication\Finder\CategoryFinderInterface
     */
    protected $categoryFinder;

    /**
     * @param \Spryker\Zed\CategoryGui\Persistence\CategoryGuiRepositoryInterface $categoryGuiRepository
     * @param \Spryker\Zed\CategoryGui\Communication\Finder\CategoryFinderInterface $categoryFinder
     */
    public function __construct(
        CategoryGuiRepositoryInterface $categoryGuiRepository,
        CategoryFinderInterface $categoryFinder
    ) {
        $this->categoryGuiRepository = $categoryGuiRepository;
        $this->categoryFinder = $categoryFinder;
    }

    /**
     * @param int $idCategory
     *
     * @return \Generated\Shared\Transfer\CategoryTransfer|null
     */
    public function getData(int $idCategory): ?CategoryTransfer
    {
        return $this->categoryFinder->findCategoryWithLocalizedAttributesById($idCategory);
    }

    /**
     * @return array<string, mixed>
     */
    public function getOptions(): array
    {
        return [
            RootCategoryType::OPTION_DATA_CLASS => CategoryTransfer::class,
            CategoryType::OPTION_CATEGORY_TEMPLATE_CHOICES => $this->categoryGuiRepository->getIndexedCategoryTemplateNames(),
        ];
    }
}
