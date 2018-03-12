<?php

    namespace Eth8505\ZendMvcThemer\Resolver;

    use Eth8505\ZendMvcThemer\Theme\ThemeInterface;

    /**
     * Interface definition for theme resolvers
     */
    interface ThemeResolverInterface {

        /**
         * Resolve theme via whatever means necessary and return a theme instance
         *
         * @return ThemeInterface
         */
        public function resolve() : ThemeInterface ;

    }