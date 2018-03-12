<?php

    namespace Eth8505\ZendMvcThemer\Theme;

    /**
     * Hinting interface for modules to specify theme services
     */
    interface ThemeProviderInterface {

        /**
         * Get theme config
         *
         * @return array
         */
        public function getThemeConfig();

    }