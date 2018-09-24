<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Notification;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Service\NotificationApiService;
use AppBundle\Entity\Country;

/**
 * Controller used to manage count notification in the backend.
 *
 * Please note that the application backend is developed manually for learning
 * purposes. However, in your real Symfony application you should use any of the
 * existing bundles that let you generate ready-to-use backends without effort.
 *
 * See http://knpbundles.com/keyword/admin
 *
 * @Route("/notification")
 *
 * @author Parvaj Sarker <parvajcse@gmail.com>
 */
class NotificationCountController extends Controller
{

    /**
     * @Route("/", name="notification_admin")
     * @Method("GET")
     */
    public function indexAction()
    {
        return $this->render('notification/index.html.twig');
    }


    /**
     * @Route("/sent-count/",  name="sent_notification")
     * @Method("GET")
     *
     * @return Response|JsonResponse
     */
    public function sentNotificationCountAction(Request $request)
    {
        $id             = $request->get('id', NULL);
        $device         = $request->get('device', 'android');
        $countryCode    = $request->get('countryCode', 'bd');

        $notificationService = $this->get(NotificationApiService::class);

        $notification = $this->getDoctrine()->getRepository(Notification::class)
            ->findOneBy(array( 'uid' => $id));

        if($notification == NULL) {
            return $this->json(['message' => 'Notification not found.']);
        }
        $option = true;
        if($countryCode != NULL) {
            $country = $this->getDoctrine()->getRepository(Country::class)
                ->findOneBy(['notification' => $notification, 'countryCode' => $countryCode]);

            if($country){
                 $notificationService->updateCountryCounter($notification, $device, $country, $option);
            }else{
                $notificationService->addCountry($notification, $device, $countryCode, $option);
            }
        }

        $responseString = $notificationService->updateCounter($notification, $device, $option);

        return $this->json(['message' => $responseString]);
    }

    /**
     * @Route("/click-count/", name="count_click_notification")
     * @Method("GET")
     *
     * @return Response|JsonResponse
     */
    public function clickCountNotificationAction(Request $request)
    {
        $id             = $request->get('id', NULL);
        $device         = $request->get('device', 'android');
        $countryCode    = $request->get('countryCode', 'bd');

        $notificationService = $this->get(NotificationApiService::class);

        $notification = $this->getDoctrine()->getRepository(Notification::class)
            ->findOneBy(array( 'uid' => $id));

        if($notification == NULL) {
            return $this->json(['message' => 'Notification not found.']);
        }
        $option = false;
        if($countryCode != NULL) {
            $country = $this->getDoctrine()->getRepository(Country::class)
                ->findOneBy(['notification' => $notification, 'countryCode' => $countryCode]);

            if($country){
                $notificationService->updateCountryCounter($notification, $device, $country, $option);
            }else{
                $notificationService->addCountry($notification, $device, $countryCode, $option);
            }
        }

        $responseString = $notificationService->updateCounter($notification, $device, $option);

        return $this->json(['message' => $responseString]);

    }
}
