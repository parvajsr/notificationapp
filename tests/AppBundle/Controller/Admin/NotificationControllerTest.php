<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Notification;



/**
 * Controller used to manage count notification in the backend.
 *
 * Please note that the application backend is developed manually for learning
 * purposes. However, in your real Symfony application you should use any of the
 * existing bundles that let you generate ready-to-use backends without effort.
 *
 * See http://knpbundles.com/keyword/admin
 *
 */
class NotificationControllerTest extends WebTestCase
{

    public function testIndex()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'parvaj_sarker',
            'PHP_AUTH_PW' => 'kitten',
        ]);

        $crawler = $client->request('GET', 'en/admin/notification/');

        $this->assertEquals(200,$client->getResponse()->getStatusCode());

    }


    public function testnotification()
    {
        $uid    = "247360758022";
        $body   = ["condition" => "news in topics",
                        "data" => [
                            "uid"=> "247360758022",
                            "contentTitle" => "title",
                        ],
                  ];

        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'parvaj_sarker',
            'PHP_AUTH_PW' => 'kitten',
        ]);

        $crawler = $client->request('POST', '/en/admin/notification/send',[
            'form_params' => [
             'body' => $body,
             'uid' => $uid
            ]
        ]);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }


    public function testshow()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'parvaj_sarker',
            'PHP_AUTH_PW' => 'kitten',
        ]);

        $crawler = $client->request('GET', 'en/admin/notification/',['id'=>'125']);
        $this->assertSame(200, $client->getResponse()->getStatusCode());

        //$newNotification = new Notification();
        $notification = $client->getContainer()->get('doctrine')->getRepository(Notification::class)->find(125);
        //$this->assertSame($newNotification, $notification);
        $this->assertInstanceOf(Notification::class, $notification);
    }
}
