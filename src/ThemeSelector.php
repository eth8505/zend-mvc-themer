<?php

    namespace Eth8505\ZendMvcThemer;

    use Eth8505\ZendMvcThemer\Resolver\ThemeResolverInterface;
    use Zend\EventManager\AbstractListenerAggregate;
    use Zend\EventManager\EventManagerInterface;
    use Zend\Mvc\MvcEvent;
    use Zend\ServiceManager\ServiceManager;

    /**
     * Theme selector listener, will inject the "theme" service into the global service manager
     * Note that this needs to be attached before any of the injectors, as they depend on the theme
     */
    class ThemeSelector extends AbstractListenerAggregate {

        /**
         * @var ThemeResolverInterface
         */
        private $resolver;

        /**
         * Constructor
         *
         * @param ThemeResolverInterface $resolver
         */
        public function __construct(ThemeResolverInterface $resolver)
        {
            $this->resolver = $resolver;
        }

        /**
         * @param MvcEvent $e
         */
        public function __invoke(MvcEvent $e)
        {

            $theme = $this->resolver->resolve();

            if (empty($theme)) {
                throw new \UnexpectedValueException('No theme found');
            }

            /** @var ServiceManager $serviceManager */
            $serviceManager = $e->getApplication()
                ->getServiceManager();

            $serviceManager->setService('theme', $theme);

        }

        /**
         * @inheritdoc
         */
        public function attach(EventManagerInterface $events, $priority = 1)
        {
            $this->listeners[] = $events->attach(MvcEvent::EVENT_RENDER, $this, $priority);
        }

    }