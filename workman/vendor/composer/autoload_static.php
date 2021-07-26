<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit60bfaddd63ed720834da66f1683c1872
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'Workerman\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Workerman\\' => 
        array (
            0 => __DIR__ . '/..' . '/workerman/workerman',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit60bfaddd63ed720834da66f1683c1872::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit60bfaddd63ed720834da66f1683c1872::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
