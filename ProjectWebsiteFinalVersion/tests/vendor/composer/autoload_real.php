<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitaede6f41a5228636c9cffbc2733d5e59
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

        spl_autoload_register(array('ComposerAutoloaderInitaede6f41a5228636c9cffbc2733d5e59', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitaede6f41a5228636c9cffbc2733d5e59', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitaede6f41a5228636c9cffbc2733d5e59::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
