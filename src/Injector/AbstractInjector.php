<?php

    namespace Eth8505\ZendMvcThemer\Injector;

    use Eth8505\ZendMvcThemer\Theme\ThemeInterface;

    /**
     * Abstract base class for theme data injectors
     */
    abstract class AbstractInjector {

        /**
         * @var ThemeInterface
         */
        protected $theme;

        /**
         * Constructor
         *
         * @param ThemeInterface $theme
         */
        public function __construct(ThemeInterface $theme) {
            $this->theme = $theme;
        }

    }