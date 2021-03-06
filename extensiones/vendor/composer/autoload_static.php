<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb8f6c9e7d89f38301c0a3f43c1d5ac7b
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb8f6c9e7d89f38301c0a3f43c1d5ac7b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb8f6c9e7d89f38301c0a3f43c1d5ac7b::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitb8f6c9e7d89f38301c0a3f43c1d5ac7b::$classMap;

        }, null, ClassLoader::class);
    }
}
