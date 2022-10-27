<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitc9c5f0a34ae6a2504de19e415ef26897
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInitc9c5f0a34ae6a2504de19e415ef26897', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitc9c5f0a34ae6a2504de19e415ef26897', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitc9c5f0a34ae6a2504de19e415ef26897::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
