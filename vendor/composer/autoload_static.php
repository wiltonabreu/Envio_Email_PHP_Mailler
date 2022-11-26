<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf37461233f75f3698b2411a92db8a439
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
            $loader->prefixLengthsPsr4 = ComposerStaticInitf37461233f75f3698b2411a92db8a439::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf37461233f75f3698b2411a92db8a439::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitf37461233f75f3698b2411a92db8a439::$classMap;

        }, null, ClassLoader::class);
    }
}
