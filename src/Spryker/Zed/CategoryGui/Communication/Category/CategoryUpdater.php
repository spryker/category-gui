<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CategoryGui\Communication\Category;

use Exception;
use Generated\Shared\Transfer\CategoryResponseTransfer;
use Generated\Shared\Transfer\CategoryTransfer;
use Generated\Shared\Transfer\MessageTransfer;
use Spryker\Zed\CategoryGui\Dependency\Facade\CategoryGuiToCategoryFacadeInterface;

class CategoryUpdater implements CategoryUpdaterInterface
{
    /**
     * @var string
     */
    protected const SUCCESS_MESSAGE_CATEGORY_UPDATED = 'The category was updated successfully.';

    /**
     * @var \Spryker\Zed\CategoryGui\Dependency\Facade\CategoryGuiToCategoryFacadeInterface
     */
    protected $categoryFacade;

    /**
     * @param \Spryker\Zed\CategoryGui\Dependency\Facade\CategoryGuiToCategoryFacadeInterface $categoryFacade
     */
    public function __construct(CategoryGuiToCategoryFacadeInterface $categoryFacade)
    {
        $this->categoryFacade = $categoryFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\CategoryTransfer $categoryTransfer
     *
     * @return \Generated\Shared\Transfer\CategoryResponseTransfer
     */
    public function updateCategory(CategoryTransfer $categoryTransfer): CategoryResponseTransfer
    {
        $categoryResponseTransfer = (new CategoryResponseTransfer())
            ->setCategory($categoryTransfer)
            ->setIsSuccessful(true);

        try {
            $this->categoryFacade->update($categoryTransfer);
            $categoryResponseTransfer
                ->addMessage((new MessageTransfer())->setValue(static::SUCCESS_MESSAGE_CATEGORY_UPDATED));
        } catch (Exception $e) {
            $categoryResponseTransfer
                ->addMessage((new MessageTransfer())->setValue($e->getMessage()))
                ->setIsSuccessful(false);
        }

        return $categoryResponseTransfer;
    }
}
