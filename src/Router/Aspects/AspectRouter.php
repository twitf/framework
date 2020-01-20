<?php

namespace Twitf\Framework\Router\Aspects;

use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Hyperf\Utils\Filesystem\Filesystem;

/**
 * @Aspect()
 * Class RouterAspect
 * @package App\Aspect
 */
class AspectRouter extends AbstractAspect
{

    public $classes = [
        'Hyperf\HttpServer\Router\DispatcherFactory::initConfigRoute'
    ];

    /**
     * @param ProceedingJoinPoint $proceedingJoinPoint
     * @return mixed|void
     * @throws \Hyperf\Di\Exception\Exception
     */
    public function process(ProceedingJoinPoint $proceedingJoinPoint)
    {
        // Run Hyperf\HttpServer\Router\DispatcherFactory initConfigRoute()
        $proceedingJoinPoint->process();
        // Module routing cut
        $modules = make(Filesystem::class)->directories(BASE_PATH . DIRECTORY_SEPARATOR . 'modules');
        foreach ($modules as $module) {
            $routePath = $module . "/config/routes.php";
            if (file_exists($routePath)) {
                require_once $routePath;
            }
        }
    }
}
