<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CategoryGui\Persistence;

use Orm\Zed\Category\Persistence\SpyCategoryNodeQuery;
use Orm\Zed\Category\Persistence\SpyCategoryQuery;
use Orm\Zed\Category\Persistence\SpyCategoryTemplateQuery;
use Spryker\Zed\CategoryGui\CategoryGuiDependencyProvider;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \Spryker\Zed\CategoryGui\CategoryGuiConfig getConfig()
 * @method \Spryker\Zed\CategoryGui\Persistence\CategoryGuiRepositoryInterface getRepository()
 */
class CategoryGuiPersistenceFactory extends AbstractPersistenceFactory
{
    public function getCategoryPropelQuery(): SpyCategoryQuery
    {
        return $this->getProvidedDependency(CategoryGuiDependencyProvider::PROPEL_QUERY_CATEGORY);
    }

    public function getCategoryTemplatePropelQuery(): SpyCategoryTemplateQuery
    {
        return $this->getProvidedDependency(CategoryGuiDependencyProvider::PROPEL_QUERY_CATEGORY_TEMPLATE);
    }

    public function getCategoryNodePropelQuery(): SpyCategoryNodeQuery
    {
        return $this->getProvidedDependency(CategoryGuiDependencyProvider::PROPEL_QUERY_CATEGORY_NODE);
    }
}
