<?php

    namespace Eth8505\ZendMvcThemer\Resolver;

    use Psr\Container\ContainerInterface;
    use Eth8505\ZendMvcThemer\Theme\ThemeInterface;
    use Eth8505\ZendMvcThemer\Theme\ThemePluginManager;

    /**
     * Theme resolver using the config to resolve the theme
     */
    class ConfigResolver implements ThemeResolverInterface {

        /**
         * @var string
         */
        private $themeName;

        /**
         * @var ContainerInterface
         */
        private $container;

        /**
         * Constructor
         *
         * @param string $theme
         * @param ThemePluginManager $container
         */
        public function __construct(string $theme, ThemePluginManager $container) {
            $this->themeName = $theme;
            $this->container = $container;
        }

        /**
         * @inheritdoc
         */
        public function resolve() : ThemeInterface
        {
            return $this->container->get($this->themeName);
        }

    }