<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd4019d0dfd12cae047a7357b0aa55e90
{
    public static $prefixLengthsPsr4 = array (
        'w' => 
        array (
            'wp360\\Helpful_Article\\' => 22,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'wp360\\Helpful_Article\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitd4019d0dfd12cae047a7357b0aa55e90::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd4019d0dfd12cae047a7357b0aa55e90::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitd4019d0dfd12cae047a7357b0aa55e90::$classMap;

        }, null, ClassLoader::class);
    }
}
