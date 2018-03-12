<?php

    namespace Eth8505\ZendMvcThemer\Injector;

    use Zend\Mvc\MvcEvent;
    use Zend\View\Helper\BasePath;
    use Zend\View\Helper\HeadScript;

    /**
     * Injector to inject script files from the theme
     */
    class ScriptInjector extends AbstractInjector {

        /**
         * @inheritdoc
         */
        public function __invoke(MvcEvent $e)
        {

            if (empty($scripts = $this->theme->getScripts())) {
                return;
            }

            $helperManager = $e->getApplication()
                ->getServiceManager()
                ->get('ViewHelperManager');

            /** @var HeadScript $headScript */
            $headScript = $helperManager->get(HeadScript::class);
            /** @var BasePath $basePath */
            $basePath = $helperManager->get(BasePath::class);

            foreach ($scripts AS $script) {
                $headScript->appendFile($basePath($script));
            }

        }

    }