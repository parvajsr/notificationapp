<?php
/**
 * Created by PhpStorm.
 * User: Parvaj
 * Date: 09/09/18
 * Time: 09:48 AM
 */

namespace Tests\AppBundle\Service;
use GuzzleHttp\Client;
use AppBundle\Entity\Notification;
use GuzzleHttp\Exception\ClientException;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\Country;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class NotificationApiServiceTest extends WebTestCase
{
    /**
     * @var string
     */
    private $api_end_point;

    /**
     * @var string
     */
    private $api_key;

    /**
     * NotificationApiService constructor.
     *
     * @param $em
     * @param $apiEndPoint
     * @param $apiKey
     */
    public function __construct()
    {
        $this->api_end_point    = 'https://fcm.googleapis.com';
        $this->api_key          = 'AIzaSyA2Kd0Rno2FoOWXlJp3RwMku4sZsRWvsUc';
    }


    /**
     * @param Notification $notification
     * @param $device
     * @param Country $country
     * @return string
     */

    public function testupdateCountryCounter()
    {
        $client = static::createClient();
        $country = $client->getContainer()->get('doctrine')->getRepository(Country::class)->find(10);
        $this->assertInstanceOf(Country::class, $country);

    }

    /**
     * @param Notification $notification
     * @param $device
     * @return string
     */
    public function testupdateCounter()
    {
        $client = static::createClient();
        $notification = $client->getContainer()->get('doctrine')->getRepository(Notification::class)->find(125);
        $this->assertInstanceOf(Notification::class, $notification);

    }


    public function testsendRequest()
    {
        $client = new Client(['base_uri' => $this->api_end_point]);
        $headers = [
            'Authorization' => "key={$this->api_key}",
            'Content-Type '=> 'application/json'
        ];
        $data = ["condition" => "'news' in topics",
                    "data" => [
                    "uid"=> "632474570930",
                    "contentTitle" => "title",
                ],
            ];

        $client->request($method='POST', $uri='fcm/send', ['headers' => $headers, 'form_params' => $data]);

     //   $this->assertEquals(200, $client->getResponse()->getStatusCode());

    }
}