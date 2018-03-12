<?php

    namespace Eth8505\ZendMvcThemer\Injector;

    use Zend\Mvc\MvcEvent;
    use Zend\View\Helper\HeadMeta;

    /**
     * Injector for meta tags
     */
    class MetaTagInjector extends AbstractInjector {

        /**
         * @param MvcEvent $e
         */
        public function __invoke(MvcEvent $e)
        {

            if (empty($metaTags = $this->theme->getMetaTags())) {
                return;
            }

            $helperManager = $e->getApplication()
                ->getServiceManager()
                ->get('ViewHelperManager');

            /** @var HeadMeta $headMeta */
            $headMeta = $helperManager->get(HeadMeta::class);

            foreach ($metaTags AS $metaTag) {

                if ($metaTag['type'] === 'name') {
                    $headMeta->appendName($metaTag['name'], $metaTag['content'], $metaTag['modifiers'] ?? []);
                } elseif ($metaTag['type'] == 'httpEquiv') {
                    $headMeta->appendHttpEquiv($metaTag['name'], $metaTag['content'], $metaTag['modifiers'] ?? []);
                } else {
                    throw new \UnexpectedValueException("Meta tag type {$metaTag['type']} is unknown");
                }

            }

        }

    }