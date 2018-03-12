<?php

    namespace Eth8505\ZendMvcThemer;

    use Eth8505\ZendMvcThemer\Theme\DefaultTheme;
    use Psr\Container\ContainerInterface;
    use Eth8505\ZendMvcThemer\Factory\InjectorFactory;
    use Eth8505\ZendMvcThemer\Factory\ThemeSelectorFactory;
    use Eth8505\ZendMvcThemer\Injector\MetaTagInjector;
    use Eth8505\ZendMvcThemer\Injector\ScriptInjector;
    use Eth8505\ZendMvcThemer\Injector\StylesheetInjector;
    use Eth8505\ZendMvcThemer\Resolver\ConfigResolver;
    use Eth8505\ZendMvcThemer\Resolver\Factory\ConfigResolverFactory;
    use Eth8505\ZendMvcThemer\Theme\Factory\ThemePluginManagerFactory;
    use Eth8505\ZendMvcThemer\Theme\ThemePluginManager;
    use Eth8505\ZendMvcThemer\Theme\ThemeProviderInterface;
    use Eth8505\ZendMvcThemer\ViewHelper\Factory\ThemeHelperFactory;
    use Eth8505\ZendMvcThemer\ViewHelper\ThemeHelper;
    use Zend\EventManager\EventInterface;
    use Zend\ModuleManager\Feature\BootstrapListenerInterface;
    use Zend\ModuleManager\Feature\ConfigProviderInterface;
    use Zend\ModuleManager\Feature\InitProviderInterface;
    use Zend\ModuleManager\Feature\ServiceProviderInterface;
    use Zend\ModuleManager\Feature\ViewHelperProviderInterface;
    use Zend\ModuleManager\Listener\ServiceListener;
    use Zend\ModuleManager\ModuleManager;
    use Zend\ModuleManager\ModuleManagerInterface;
    use Zend\Mvc\MvcEvent;
    use Zend\ServiceManager\Proxy\LazyServiceFactory;

    class Module implements ConfigProviderInterface, BootstrapListenerInterface, ServiceProviderInterface, ViewHelperProviderInterface, InitProviderInterface, ThemeProviderInterface {

        /**
         * @inheritdoc
         */
        public function getConfig()
        {
            return include __DIR__ . '/../config/module.config.php';
        }

        /**
         * @inheritdoc
         */
        public function init(ModuleManagerInterface $manager)
        {

            /** @var ModuleManager $manager */
            /** @var ContainerInterface $serviceManager */
            $serviceManager = $manager->getEvent()->getParam('ServiceManager');
            /** @var ServiceListener $serviceListener */
            $serviceListener = $serviceManager->get('ServiceListener');

            $serviceListener->addServiceManager(
                ThemePluginManager::class,
                'zend-mvc-themes',
                ThemeProviderInterface::class,
                'getThemeConfig'
            );

        }

        /**
         * @inheritdoc
         */
        public function onBootstrap(EventInterface $e)
        {

            /** @var MvcEvent $e */

            $app = $e->getApplication();
            $serviceManager = $app->getServiceManager();
            $eventManager = $app->getEventManager();

            $serviceManager->get(ThemeSelector::class)
                ->attach($eventManager);

            $eventManager
                ->attach(
                    MvcEvent::EVENT_RENDER,
                    $serviceManager->get(StylesheetInjector::class)
                );

            $eventManager
                ->attach(
                    MvcEvent::EVENT_RENDER,
                    $serviceManager->get(ScriptInjector::class)
                );

            $eventManager
                ->attach(
                    MvcEvent::EVENT_RENDER,
                    $serviceManager->get(MetaTagInjector::class)
                );

        }

        /**
         * @inheritdoc
         */
        public function getServiceConfig()
        {

            return [
                'factories' => [
                    ThemeSelector::class => ThemeSelectorFactory::class,
                    ConfigResolver::class => ConfigResolverFactory::class,
                    ThemePluginManager::class => ThemePluginManagerFactory::class,
                    StylesheetInjector::class => InjectorFactory::class,
                    ScriptInjector::class => InjectorFactory::class,
                    MetaTagInjector::class => InjectorFactory::class
                ],
                'lazy_services' => [
                    'class_map' => [
                        StylesheetInjector::class => StylesheetInjector::class,
                        ScriptInjector::class => ScriptInjector::class,
                        MetaTagInjector::class => MetaTagInjector::class
                    ]
                ],
                'delegators' => [
                    StylesheetInjector::class => [
                        LazyServiceFactory::class
                    ],
                    ScriptInjector::class => [
                        LazyServiceFactory::class
                    ],
                    MetaTagInjector::class => [
                        LazyServiceFactory::class
                    ]
                ]
            ];

        }

        /**
         * @inheritdoc
         */
        public function getViewHelperConfig()
        {

            return [
                'aliases' => [
                    'theme' => ThemeHelper::class
                ],
                'factories' => [
                    ThemeHelper::class => ThemeHelperFactory::class
                ]
            ];

        }

        /**
         * @inheritdoc
         */
        public function getThemeConfig()
        {
            return [
                'invokables' => [
                    DefaultTheme::class
                ]
            ];
        }

    }