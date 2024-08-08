<?php

namespace App\Tests\Smoke;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouterInterface;

class SmokeTest extends WebTestCase
{
    protected static KernelBrowser $browser;

    public static function setUpBeforeClass(): void
    {
        static::$browser = static::createClient();
    }

    /**
     * @dataProvider providePublicUrlsAndStatusCodes
     * @group smoke
     */
    public function testPublicUrlIsNotServerError(string $method, string $url): void
    {
        static::$browser->request($method, $url);
        $user = static::getContainer()->get(UserRepository::class)->findOneBy([]);
        static::$browser->loginUser($user);
        if (\in_array(static::$browser->getResponse()->getStatusCode(), [301, 302, 307, 308])) {
            static::$browser->followRedirect();
        }

        $this->assertSame(200, static::$browser->getResponse()->getStatusCode());
    }

    public function providePublicUrlsAndStatusCodes(): \Generator
    {
        $router = static::getContainer()->get(RouterInterface::class);
        $collection = $router->getRouteCollection();
        static::ensureKernelShutdown();

        foreach ($collection as $routeName => $route) {
            /** @var Route $route */
            $variables = $route->compile()->getVariables();
            if (count(array_diff($variables, array_keys($route->getDefaults()))) > 0) {
                continue;
            }
            if ([] === $methods = $route->getMethods()) {
                $methods[] = 'GET';
            }
            foreach ($methods as $method) {
                $path = $router->generate($routeName);
                yield "$method $path" => [$method, $path];
            }
        }
    }
}
