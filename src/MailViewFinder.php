<?php

namespace Julienbourdeau\MailView;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
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

    public static function getMethodAttributes(\ReflectionMethod $method)
    {
        return [
            'methodName' => $name = $method->getName(),
            'methodTitle' => self::methodToTitle($name),
            'className' => $method->getDeclaringClass()->getName(),
            'source' => static::getSourceCode($method),
            'comment' => static::getComment($method),
            'file' => $method->getFileName().':'.($method->getStartLine() - 1),
        ];
    }

    public static function getSourceCode(\ReflectionMethod $method)
    {
        $source = collect(file($method->getFileName()));
        $start_line = $method->getStartLine() - 1;
        $end_line = $method->getEndLine();

        return $source->slice($start_line, $end_line - $start_line)->map(function($line) {
            return preg_replace('/\n/', '', $line);
        })->toArray();
    }

    public static function getComment(\ReflectionMethod $method)
    {
        return Str::of($method->getDocComment())->after('/** ')->beforeLast(' */')->__toString();
    }

    public function findAll(): Collection
    {
        $namespace = config('mail-view.namespace');

        return $this->getProjectClasses()->filter(function($className) use ($namespace) {
            return Str::startsWith($className, $namespace);
        })->mapWithKeys(function ($className) {
            $klass = new \ReflectionClass(new $className);

            $methodList = collect($klass->getMethods(\ReflectionMethod::IS_PUBLIC))->map(function (\ReflectionMethod $method) {
                return static::getMethodAttributes($method);
            });

            return [$klass->getShortName() => $methodList];
        });
    }

    private function getProjectClasses(): Collection
    {
        if (self::$declaredClasses === null) {
            $configFiles = Finder::create()->files()->name('*.php')->in(base_path(config('mail-view.dir')));

            foreach ($configFiles->files() as $file) {
                require_once $file;
            }

            self::$declaredClasses = collect(get_declared_classes());
        }

        return self::$declaredClasses;
    }

    public static function methodToTitle($methodName)
    {
        return Str::of($methodName)->kebab()->replace('-', ' ')->title();
    }
}
