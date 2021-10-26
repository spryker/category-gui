<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CategoryGui;

use Orm\Zed\Category\Persistence\SpyCategoryNodeQuery;
use Orm\Zed\Category\Persistence\SpyCategoryQuery;
use Orm\Zed\Category\Persistence\SpyCategoryTemplateQuery;
use Spryker\Zed\CategoryGui\Dependency\Facade\CategoryGuiToCategoryFacadeBridge;
use Spryker\Zed\CategoryGui\Dependency\Facade\CategoryGuiToLocaleFacadeBridge;
use Spryker\Zed\CategoryGui\Dependency\Facade\CategoryGuiToStoreFacadeBridge;
use Spryker\Zed\CategoryGui\Dependency\Facade\CategoryGuiToTranslatorFacadeBridge;
use Spryker\Zed\CategoryGui\Dependency\Service\CategoryGuiToUtilEncodingServiceBridge;
use Spryker\Zed\CategoryGui\Exception\MissingStoreRelationFormTypePluginException;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Communication\Form\FormTypeInterface;
use Spryker\Zed\Kernel\Container;

/**
 * @method \Spryker\Zed\CategoryGui\CategoryGuiConfig getConfig()
 */
class CategoryGuiDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_LOCALE = 'FACADE_LOCALE';

    /**
     * @var string
     */
    public const FACADE_CATEGORY = 'FACADE_CATEGORY';

    /**
     * @var string
     */
    public const FACADE_STORE = 'FACADE_STORE';

    /**
     * @var string
     */
    public const FACADE_TRANSLATOR = 'FACADE_TRANSLATOR';

    /**
     * @var string
     */
    public const PLUGINS_CATEGORY_FORM = 'PLUGINS_CATEGORY_FORM';

    /**
     * @var string
     */
    public const PLUGINS_CATEGORY_FORM_TAB_EXPANDER = 'PLUGINS_CATEGORY_FORM_TAB_EXPANDER';

    /**
     * @var string
     */
    public const PLUGINS_CATEGORY_RELATION_READ = 'PLUGINS_CATEGORY_RELATION_READ';

    /**
     * @var string
     */
    public const PLUGIN_STORE_RELATION_FORM_TYPE = 'PLUGIN_STORE_RELATION_FORM_TYPE';

    /**
     * @var string
     */
    public const PROPEL_QUERY_CATEGORY = 'PROPEL_QUERY_CATEGORY';

    /**
     * @var string
     */
    public const PROPEL_QUERY_CATEGORY_TEMPLATE = 'PROPEL_QUERY_CATEGORY_TEMPLATE';

    /**
     * @var string
     */
    public const PROPEL_QUERY_CATEGORY_NODE = 'PROPEL_QUERY_CATEGORY_NODE';

    /**
     * @var string
     */
    public const SERVICE_UTIL_ENCODING = 'SERVICE_UTIL_ENCODING';

    /**
     * @uses \Spryker\Zed\Form\Communication\Plugin\Application\FormApplicationPlugin::SERVICE_FORM_CSRF_PROVIDER
     *
     * @var string
     */
    public const SERVICE_FORM_CSRF_PROVIDER = 'form.csrf_provider';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = parent::provideCommunicationLayerDependencies($container);

        $container = $this->addLocaleFacade($container);
        $container = $this->addCategoryFacade($container);
        $container = $this->addStoreFacade($container);
        $container = $this->addTranslatorFacade($container);
        $container = $this->addCategoryFormPlugins($container);
        $container = $this->addCategoryFormTabExpanderPlugins($container);
        $container = $this->addCategoryRelationReadPlugins($container);
        $container = $this->addStoreRelationFormTypePlugin($container);
        $container = $this->addCsrfProviderService($container);
        $container = $this->addUtilEncodingService($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function providePersistenceLayerDependencies(Container $container): Container
    {
        $container = $this->addCategoryPropelQuery($container);
        $container = $this->addCategoryTemplatePropelQuery($container);
        $container = $this->addCategoryNodePropelQuery($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addLocaleFacade(Container $container): Container
    {
        $container->set(static::FACADE_LOCALE, function (Container $container) {
            return new CategoryGuiToLocaleFacadeBridge(
                $container->getLocator()->locale()->facade(),
            );
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCategoryFacade(Container $container): Container
    {
        $container->set(static::FACADE_CATEGORY, function (Container $container) {
            return new CategoryGuiToCategoryFacadeBridge(
                $container->getLocator()->category()->facade(),
            );
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addUtilEncodingService(Container $container): Container
    {
        $container->set(static::SERVICE_UTIL_ENCODING, function (Container $container) {
            return new CategoryGuiToUtilEncodingServiceBridge(
                $container->getLocator()->utilEncoding()->service(),
            );
        });

        return $container;
    }

    /**
     * @module Category
     *
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCategoryPropelQuery(Container $container): Container
    {
        $container->set(static::PROPEL_QUERY_CATEGORY, $container->factory(function (): SpyCategoryQuery {
            return SpyCategoryQuery::create();
        }));

        return $container;
    }

    /**
     * @module Category
     *
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCategoryTemplatePropelQuery(Container $container): Container
    {
        $container->set(static::PROPEL_QUERY_CATEGORY_TEMPLATE, $container->factory(function (): SpyCategoryTemplateQuery {
            return SpyCategoryTemplateQuery::create();
        }));

        return $container;
    }

    /**
     * @module Category
     *
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCategoryNodePropelQuery(Container $container): Container
    {
        $container->set(static::PROPEL_QUERY_CATEGORY_NODE, $container->factory(function (): SpyCategoryNodeQuery {
            return SpyCategoryNodeQuery::create();
        }));

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCategoryFormPlugins(Container $container): Container
    {
        $container->set(static::PLUGINS_CATEGORY_FORM, function () {
            return $this->getCategoryFormPlugins();
        });

        return $container;
    }

    /**
     * @return array<\Spryker\Zed\CategoryGuiExtension\Dependency\Plugin\CategoryFormPluginInterface>
     */
    protected function getCategoryFormPlugins(): array
    {
        return [];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCategoryFormTabExpanderPlugins(Container $container): Container
    {
        $container->set(static::PLUGINS_CATEGORY_FORM_TAB_EXPANDER, function () {
            return $this->getCategoryFormTabExpanderPlugins();
        });

        return $container;
    }

    /**
     * @return array<\Spryker\Zed\CategoryGuiExtension\Dependency\Plugin\CategoryFormTabExpanderPluginInterface>
     */
    protected function getCategoryFormTabExpanderPlugins(): array
    {
        return [];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCategoryRelationReadPlugins(Container $container): Container
    {
        $container->set(static::PLUGINS_CATEGORY_RELATION_READ, function () {
            return $this->getCategoryRelationReadPlugins();
        });

        return $container;
    }

    /**
     * @return array<\Spryker\Zed\CategoryGuiExtension\Dependency\Plugin\CategoryRelationReadPluginInterface>
     */
    protected function getCategoryRelationReadPlugins(): array
    {
        return [];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCsrfProviderService(Container $container): Container
    {
        $container->set(static::SERVICE_FORM_CSRF_PROVIDER, function (Container $container) {
            return $container->getApplicationService(static::SERVICE_FORM_CSRF_PROVIDER);
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addStoreRelationFormTypePlugin(Container $container): Container
    {
        $container->set(static::PLUGIN_STORE_RELATION_FORM_TYPE, function () {
            return $this->getStoreRelationFormTypePlugin();
        });

        return $container;
    }

    /**
     * @throws \Spryker\Zed\CategoryGui\Exception\MissingStoreRelationFormTypePluginException
     *
     * @return \Spryker\Zed\Kernel\Communication\Form\FormTypeInterface
     */
    protected function getStoreRelationFormTypePlugin(): FormTypeInterface
    {
        throw new MissingStoreRelationFormTypePluginException(
            sprintf(
                'Missing instance of %s! You need to configure StoreRelationFormType ' .
                'in your own CategoryGuiDependencyProvider::getStoreRelationFormTypePlugin() ' .
                'to be able to manage categories.',
                FormTypeInterface::class,
            ),
        );
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addStoreFacade(Container $container): Container
    {
        $container->set(static::FACADE_STORE, function (Container $container) {
            return new CategoryGuiToStoreFacadeBridge(
                $container->getLocator()->store()->facade(),
            );
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addTranslatorFacade(Container $container): Container
    {
        $container->set(static::FACADE_TRANSLATOR, function (Container $container) {
            return new CategoryGuiToTranslatorFacadeBridge(
                $container->getLocator()->translator()->facade(),
            );
        });

        return $container;
    }
}
