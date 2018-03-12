<?php

    namespace Eth8505\ZendMvcThemer\Theme;

    use Zend\ServiceManager\AbstractPluginManager;

    class ThemePluginManager extends AbstractPluginManager {

        /**
         * @var string
         */
        protected $instanceOf = ThemeInterface::class;

    }