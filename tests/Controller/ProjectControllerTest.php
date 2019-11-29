<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProjectControllerTest extends WebTestCase
{
    public function testOverview()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        static::assertResponseIsSuccessful();

//        $lanes = $crawler->filter('.lane');
//
//        static::assertCount(3, $lanes);
//
//        static::assertCount(1, $crawler->filter('.lane[data-lane-name="plan"]'));
//        static::assertCount(1, $crawler->filter('.lane[data-lane-name="sprint"]'));
//        static::assertCount(1, $crawler->filter('.lane[data-lane-name="done"]'));
    }
}
