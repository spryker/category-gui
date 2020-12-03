<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CategoryGui\Dependency\QueryContainer;

class CategoryGuiToCategoryQueryContainerBridge implements CategoryGuiToCategoryQueryContainerInterface
{
    /**
     * @var \Spryker\Zed\Category\Persistence\CategoryQueryContainerInterface
     */
    protected $categoryQueryContainer;

    /**
     * @param \Spryker\Zed\Category\Persistence\CategoryQueryContainerInterface $categoryQueryContainer
     */
    public function __construct($categoryQueryContainer)
    {
        $this->categoryQueryContainer = $categoryQueryContainer;
    }

    /**
     * @param int $idLocale
     *
     * @return \Orm\Zed\Category\Persistence\SpyCategoryQuery
     */
    public function queryCategory(int $idLocale)
    {
        return $this->categoryQueryContainer->queryCategory($idLocale);
    }

    /**
     * @param int $idNode
     * @param int $idLocale
     * @param bool $excludeRootNode
     * @param bool $onlyParents
     *
     * @return mixed
     */
    public function queryPath(int $idNode, int $idLocale, bool $excludeRootNode = true, bool $onlyParents = false)
    {
        return $this->categoryQueryContainer->queryPath($idNode, $idLocale, $excludeRootNode, $onlyParents);
    }

    /**
     * @return mixed
     */
    public function queryCategoryTemplate()
    {
        return $this->categoryQueryContainer->queryCategoryTemplate();
    }

    /**
     * @param int $idCategory
     *
     * @return mixed
     */
    public function queryCategoryById(int $idCategory)
    {
        return $this->categoryQueryContainer->queryCategoryById($idCategory);
    }

    /**
     * @param int $idCategoryNode
     *
     * @return mixed
     */
    public function queryUrlByIdCategoryNode(int $idCategoryNode)
    {
        return $this->categoryQueryContainer->queryUrlByIdCategoryNode($idCategoryNode);
    }

    /**
     * @param int $idParentNode
     * @param int $idLocale
     *
     * @return \Orm\Zed\Category\Persistence\SpyCategoryNodeQuery
     */
    public function getCategoryNodesWithOrder(int $idParentNode, int $idLocale)
    {
        return $this->categoryQueryContainer->getCategoryNodesWithOrder($idParentNode, $idLocale);
    }

    /**
     * @param string $categoryKey
     *
     * @return mixed
     */
    public function queryCategoryByKey(string $categoryKey)
    {
        return $this->categoryQueryContainer->queryCategoryByKey($categoryKey);
    }

    /**
     * @return \Orm\Zed\Category\Persistence\SpyCategoryNodeQuery
     */
    public function queryRootNode()
    {
        return $this->categoryQueryContainer->queryRootNode();
    }

    /**
     * @return \Orm\Zed\Category\Persistence\SpyCategoryAttributeQuery
     */
    public function queryRootNodes()
    {
        return $this->categoryQueryContainer->queryRootNodes();
    }
}
