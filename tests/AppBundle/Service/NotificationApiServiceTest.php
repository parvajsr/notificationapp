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

    public function updateCountryCounter(Notification $notification, $device, Country $country, $option)
    {
        $device = strtolower($device);

        try {
            switch ($device) {
                case 'android':
                    if($option){
                        $counter = $country->getSentAndroid();
                        $country->setSentAndroid($counter+1);
                    }else{
                        $counter = $country->getClickAndroid();
                        $country->setClickAndroid($counter+1);
                    }
                   break;
                case 'ios':
                    if($option){
                        $counter = $country->getSentIos();
                        $country->setSentIos($counter+1);
                    }else{
                        $counter = $country->getClickIos();
                        $country->setClickIos($counter+1);
                    }
                    break;
            }
            $this->em->persist($country);
            $this->em->flush();

            return 'Success';

        } catch (\Exception $e) {
            return 'Not Found';
        }
    }

    /**
     * @param Notification $notification
     * @param $device
     * @return string
     */
    public function testupdateCounter()
    {
        $device = 'android';
        $client = static::createClient();
        $option = true;
        $notification = $client->getContainer()->get('doctrine')->getRepository(Notification::class)->find(125);
        try {

            switch ($device) {
                case 'android':
                    if($option){
                        $counter = $notification->getSentCountAndr();
                        $notification->setSentCountAndr($counter+1);
                    }else{
                        $counter = $notification->getClickCountAndr();
                        $notification->setClickCountAndr($counter+1);
                    }

                    break;
                case 'ios':
                    if($option){
                        $counter = $notification->getSentCountiOs();
                        $notification->setSentCountiOs($counter+1);
                    }else{
                        $counter = $notification->getClickCountiOs();
                        $notification->setClickCountiOs($counter+1);
                    }

                    break;
            }
            $this->em->persist($notification);
            $this->em->flush();

            return 'Success';

        } catch (\Exception $e) {
            return 'Not Found';
        }
    }

    /**
     * @param Notification $notification
     * @return array
     */
    public function testsendNotification(Notification $notification)
    {
        return $this->sendRequest('fcm/send', $notification->getBody(), 'POST');

    }

    /**
     * @param Notification $notification
     * @param $responseObject
     * @return bool
     */
    public function saveData(Notification $notification, $responseObject)
    {
        try{
            $messageId = isset($responseObject->message_id)? $responseObject->message_id: NULL;
            $notification->setMessageId($messageId);

            $this->em->persist($notification);
            $this->em->flush();

            return true;
        }catch (\Exception $e) {
            return false;
        }

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

        try {
            $response = $client->request($method='POST', $uri='fcm/send', ['headers' => $headers, 'form_params' => $data]);

            $this->assertEquals(200, $client->getResponse()->getStatusCode());
        } catch (ClientException $e) {
            $response = $e->getResponse();
        }

        return [
            'statusCode' => $response->getStatusCode(),
            'responseJson' => $response->getBody(),
            'responseObject' => json_decode($response->getBody()),
        ];
    }
}