<?php

namespace Julienbourdeau\LaravelMailView;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use function in_array;
use Laravel\Scout\Searchable;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Finder\Finder;

/**
 * @internal
 */
class MailViewFinder
{
    /**
     * @var array
     */
    private static $declaredClasses;

    /**
     * @var \Illuminate\Contracts\Foundation\Application
     */
    private $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function find(): Collection
    {
        return $this->getProjectClasses()->filter(function($className) {
            return Str::startsWith($className, 'Tests\MailView');
        })->mapWithKeys(function ($className) {
            $klass = new \ReflectionClass(new $className);
            $methods = collect($klass->getMethods(\ReflectionMethod::IS_PUBLIC))->map->getName();
            return [$klass->getShortName() => $methods];
        });
    }

    private function getProjectClasses(): Collection
    {
        if (self::$declaredClasses === null) {
            $configFiles = Finder::create()->files()->name('*.php')->in(base_path('tests'));

            foreach ($configFiles->files() as $file) {
                require_once $file;
            }

            self::$declaredClasses = collect(get_declared_classes());
        }

        return self::$declaredClasses;
    }
}
