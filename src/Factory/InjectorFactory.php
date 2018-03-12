<?php

    namespace Eth8505\ZendMvcThemer\Factory;

    use Interop\Container\ContainerInterface;
    use Zend\ServiceManager\Factory\FactoryInterface;

    class InjectorFactory implements FactoryInterface {

        /**
         * @inheritdoc
         */
        public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
        {
            return new $requestedName($container->get('theme'));
        }

    }