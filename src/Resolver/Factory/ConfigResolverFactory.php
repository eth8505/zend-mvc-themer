<?php

    namespace Eth8505\ZendMvcThemer\Resolver\Factory;

    use Interop\Container\ContainerInterface;
    use Eth8505\ZendMvcThemer\Resolver\ConfigResolver;
    use Eth8505\ZendMvcThemer\Theme\ThemePluginManager;
    use Zend\ServiceManager\Factory\FactoryInterface;

    class ConfigResolverFactory implements FactoryInterface {

        /**
         * @inheritdoc
         */
        public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
        {

            $theme = $container->get('config')['zend-mvc-themer']['theme'] ?? NULL;

            if (empty($theme)) {
                throw new \UnexpectedValueException('No theme configured in zend-mvc-themer/theme');
            }

            return new ConfigResolver(
                $theme,
                $container->get(ThemePluginManager::class)
            );

        }

    }