<?php

    namespace Eth8505\ZendMvcThemer\Theme\Factory;

    use Eth8505\ZendMvcThemer\Theme\ThemePluginManager;
    use Zend\Mvc\Service\AbstractPluginManagerFactory;

    class ThemePluginManagerFactory extends AbstractPluginManagerFactory {

        const PLUGIN_MANAGER_CLASS = ThemePluginManager::class;

    }