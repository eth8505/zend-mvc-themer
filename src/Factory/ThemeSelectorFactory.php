<?php

    namespace Eth8505\ZendMvcThemer\Factory;

    use Interop\Container\ContainerInterface;
    use Eth8505\ZendMvcThemer\ThemeSelector;
    use Zend\ServiceManager\Factory\FactoryInterface;

    class ThemeSelectorFactory implements FactoryInterface {

        /**
         * @inheritdoc
         */
        public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
        {

            $resolverService = $container->get('config')['zend-mvc-themer']['resolver'] ?? NULL;

            if (empty($resolverService)) {
                throw new \UnexpectedValueException('No resolver configured in zend-mvc-themer/resolver');
            }

            return new ThemeSelector(
                $container->get($resolverService)
            );
        }

    }