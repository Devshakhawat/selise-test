<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitff98de985112b73df4e9d75783271443
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Selise\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Selise\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitff98de985112b73df4e9d75783271443::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitff98de985112b73df4e9d75783271443::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitff98de985112b73df4e9d75783271443::$classMap;

        }, null, ClassLoader::class);
    }
}
