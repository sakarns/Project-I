<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitc779b9f5974b23b6ba1d45600ba48887
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

        spl_autoload_register(array('ComposerAutoloaderInitc779b9f5974b23b6ba1d45600ba48887', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitc779b9f5974b23b6ba1d45600ba48887', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitc779b9f5974b23b6ba1d45600ba48887::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
