<?php

    namespace Eth8505\ZendMvcThemer\ViewHelper\Factory;

    use Interop\Container\ContainerInterface;
    use Eth8505\ZendMvcThemer\ViewHelper\ThemeHelper;
    use Zend\ServiceManager\Factory\FactoryInterface;

    class ThemeHelperFactory implements FactoryInterface {

        /**
         * @inheritdoc
         */
        public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
        {
            return new ThemeHelper($container->get('theme'));
        }

    }