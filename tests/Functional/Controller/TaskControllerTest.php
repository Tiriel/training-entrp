<?php

namespace App\Tests\Functional\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    /**
     * @group functional
     * @return void
     */
    public function testTasksArePresentAndOrderedOnTaskIndex(): void
    {
        $client = static::createClient();
        $user = static::getContainer()->get(UserRepository::class)->findOneBy([]);
        $client->loginUser($user);
        $crawler = $client->request('GET', '/task/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Task index');

        $rows = $crawler->filter('tbody > tr');
        $this->assertCount(10, $rows);
        $p1 = $rows->first()->filter('td')->eq(2)->text();
        $p2 = $rows->eq(1)->filter('td')->eq(2)->text();
        $this->assertGreaterThan($p2, $p1);
    }

    /**
     * @group functional
     * @return void
     */
    public function testTaskShowLinkOpensTaskDetailsPage(): void
    {
        $client = static::createClient();
        $user = static::getContainer()->get(UserRepository::class)->findOneBy([]);
        $client->loginUser($user);
        $crawler = $client->request('GET', '/task/');

        $rows = $crawler->filter('tbody > tr');
        $client->click($rows->first()->selectLink('show')->link());

        $this->assertSelectorTextContains('h1', 'Task');
        $this->assertSelectorTextContains('main > a', 'back to list');
    }
}
