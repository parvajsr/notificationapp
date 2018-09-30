<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;


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
class NotificationCountControllerTest extends WebTestCase
{

//    public function testIndex()
//    {
//        $result = 12;
//        // assert that your calculator added the numbers correctly!
//        $this->assertEquals(12, $result);
//        $client = static::createClient();
//        $crawler = $client->request('GET', '/sent-count/?countryCode=bd&device=android&id=247360758022');
////        $url = $client->getContainer()->get('router')->generate('sent_notification');
////        $client->request('GET', $url);
////        $this->assertTrue($client->getResponse()->isSuccessful());
//        $this->assertEquals(
//            1,
//            $crawler->filter('html:contains("Success")')->count()
//        );
////        $client->request('GET', 'http://localhost:8000/en/notification/sent-count/?countryCode=bd&device=android&id=247360758022');
////        dump($crawler->filter('Secure'));
//
//      // $this->assertTrue($client->getResponse()->getStatusCode());
//    }


    public function testSentNotificationCount()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/en/notification/sent-count/',[
            'id' => '247360758022',
            'countryCode' => 'bd',
            'device' => 'android'
        ]);
        $resp = json_decode($client->getResponse()->getContent(),true);

        $this->assertEquals("Success",$resp['message']);

        $this->assertEquals(
            200,
            $client->getResponse()->getStatusCode()
        );
    }


    public function testClickCountNotification()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/en/notification/click-count/',[
            'id' => '247360758022',
            'countryCode' => 'bd',
            'device' => 'android'
        ]);
        $resp = json_decode($client->getResponse()->getContent(),true);
        $this->assertEquals("Success", $resp['message']);
        $this->assertEquals(
            200,
            $client->getResponse()->getStatusCode()
        );
    }

}
