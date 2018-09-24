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

//    private $client = null;
//    private $baseUrl = 'http://localhost:8000/';
//
//    public function setUp()
//    {
//        $this->client = static::createClient([], [
//            'PHP_AUTH_USER' => 'parvaj_sarker',
//            'PHP_AUTH_PW' => 'kitten',
//        ]);
//
//    }

    public function testIndex()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'parvaj_sarker',
            'PHP_AUTH_PW' => 'kitten',
        ]);

        $crawler = $client->request('GET', 'en/admin/notification/');
        $crawler = $client->followRedirect();

        dump( $client->getResponse()->getStatusCode() );
        $this->assertEquals(200,$client->getResponse()->getStatusCode());

    }

/*
    public function testnotification()
    {
        $uid    = "247360758022";
        $body   = ["condition" => "news in topics",
                        "data" => [
                            "uid"=> "247360758022",
                            "contentTitle" => "title",
                        ],
                  ];

//        $client = static::createClient([], [
//            'PHP_AUTH_USER' => 'parvaj_sarker',
//            'PHP_AUTH_PW' => 'kitten',
//        ]);
//
//        $client->followRedirects();

        $crawler = $this->client->request('GET', $this->baseUrl.'/en/admin/notification/send');
        $this->assertEquals(
            1,
            $crawler->filter('html:contains("Send Notification")')->count()
        );
//        $form = $crawler->selectButton('Send Notification and Save')->form([
//            "notification[body]" => $body,
//            "notification[uid]" => $uid,
//        ]);
//        $client->submit($form);

     //   $this->assertSame(Response::HTTP_FOUND, $client->getResponse()->getStatusCode());

        $notification = $this->client->getContainer()->get('doctrine')->getRepository(Notification::class)->findOneBy([
            'uid' => $uid,
        ]);
        $this->assertNotNull($notification);

    }
*/

//    public function testshow()
//    {
//        $this->client = static::createClient([], [
//            'PHP_AUTH_USER' => 'parvaj_sarker',
//            'PHP_AUTH_PW' => 'kitten',
//        ]);
//        $this->client->followRedirects();
//        $crawler = $this->client->request('GET', 'en/admin/notification/125');
//        dump($this->client->getResponse()->getStatusCode()); die;
//        $this->assertEquals(
//            1,
//            $crawler->filter('html:contains("ttttttttt")')->count()
//        );
//
//        //  $this->assertSame(Response::HTTP_FOUND, $client->getResponse()->getStatusCode());
//
//
//        //$notification = $client->getContainer()->get('doctrine')->getRepository(Notification::class)->find(125);
//        //$this->assertSame($newBlogPostTitle, $notification);
//    }
}
