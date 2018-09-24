<?php
/**
 * Created by PhpStorm.
 * User: Parvaj
 * Date: 09/09/18
 * Time: 09:48 AM
 */

namespace AppBundle\Service;
use GuzzleHttp\Client;
use AppBundle\Entity\Notification;
use GuzzleHttp\Exception\ClientException;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\Country;

class NotificationApiServiceTest
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
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * NotificationApiService constructor.
     *
     * @param $em
     * @param $apiEndPoint
     * @param $apiKey
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em               = $em;
        $this->api_end_point    = 'https://fcm.googleapis.com';
        $this->api_key          = 'AIzaSyA2Kd0Rno2FoOWXlJp3RwMku4sZsRWvsUc';
    }

    /**
     * @param Notification $notification
     * @param $device
     * @param $countryCode
     * @return string
     */
    public function addCountry(Notification $notification, $device, $countryCode, $option)
    {
        $device = strtolower($device);
        $country = new Country();
        try {
            switch ($device) {
                case 'android':
                    if($option){
                        $country->setSentAndroid(1);
                    }else{
                        $country->setClickAndroid(1);
                    }
                    break;
                case 'ios':
                    if($option){
                        $country->setSentIos(1);
                    }else{
                        $country->setClickIos(1);
                    }
                    break;
            }
            $country->setNotification($notification);
            $country->setCountryCode($countryCode);

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
    public function updateCounter(Notification $notification, $device, $option)
    {
        $device = strtolower($device);
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
    public function sendNotification(Notification $notification)
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

    private function sendRequest($uri, $data, $method = 'GET')
    {
        $client = new Client(['base_uri' => $this->api_end_point]);
        $headers = [
            'Authorization' => "key={$this->api_key}",
            'Content-Type '=> 'application/json'
        ];

        try {
            $response = $client->request($method, $uri, ['headers' => $headers, 'body' => $data]);
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