<?php

    use Eth8505\ZendMvcThemer\Resolver\ConfigResolver;
    use Eth8505\ZendMvcThemer\Theme\DefaultTheme;

    return [
        'zend-mvc-themer' => [
            'resolver' => ConfigResolver::class,
            'default-theme' => DefaultTheme::class
        ]
    ];