<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\NotificationConfig;
use AppBundle\Entity\Notification;
use AppBundle\Form\NotificationConfigType;
use AppBundle\Form\NotificationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Service\NotificationApiService;
use AppBundle\Entity\Country;

/**
 * Controller used to manage blog contents in the backend.
 *
 * Please note that the application backend is developed manually for learning
 * purposes. However, in your real Symfony application you should use any of the
 * existing bundles that let you generate ready-to-use backends without effort.
 *
 * See http://knpbundles.com/keyword/admin
 *
 * @Route("/admin/notification")
 * @Security("has_role('ROLE_ADMIN')")
 *
 * @author Ryan Weaver <weaverryan@gmail.com>
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 */
class NotificationController extends Controller
{
    /**
     * Lists all Notification entities.
     *
     * This controller responds to two different routes with the same URL:
     *   * 'admin_post_index' is the route with a name that follows the same
     *     structure as the rest of the controllers of this class.
     *   * 'admin_index' is a nice shortcut to the backend homepage. This allows
     *     to create simpler links in the templates. Moreover, in the future we
     *     could move this annotation to any other controller while maintaining
     *     the route name and therefore, without breaking any existing link.
     *
     * @Route("/", name="notification_index")
     * @Route("/", name="admin_notification_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $notification = $em->getRepository(Notification::class)->findAll();

        return $this->render('admin/notification/notification-list.html.twig', ['notifications' => $notification]);
    }

    /**
     * Creates a new Notification config entity.
     *
     * @Route("/new", name="admin_notification_new")
     * @Method({"GET", "POST"})
     *
     * NOTE: the Method annotation is optional, but it's a recommended practice
     * to constraint the HTTP methods each controller responds to (by default
     * it responds to all methods).
     */
    public function newAction(Request $request)
    {
        $notification = new NotificationConfig();
        $form = $this->createForm(NotificationConfigType::class, $notification)
            ->add('saveAndCreateNew', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($notification);
            $em->flush();

            $this->addFlash('success', ' Notification Config created_successfully');

            return $this->redirectToRoute('admin_notification_config');
        }

        return $this->render('admin/notification/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Creates a add Notification entity.
     *
     * @Route("/send", name="admin_notification_send")
     * @Method({"GET", "POST"})
     *
     * NOTE: the Method annotation is optional, but it's a recommended practice
     * to constraint the HTTP methods each controller responds to (by default
     * it responds to all methods).
     */
    public function notificationAction(Request $request)
    {
        $notification = new Notification();

        $form = $this->createForm(NotificationType::class, $notification);
        $form->handleRequest($request);

        $notificationService = $this->get(NotificationApiService::class);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $response = $notificationService->sendNotification($notification);

            if($response['statusCode'] == 200) {
                $this->addFlash('success', ' Notification sent successfully.');
                $notificationService->saveData($notification, $response['responseObject']);
            }

            return $this->redirectToRoute('admin_notification_index');
        }

        return $this->render('admin/notification/notification.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a Notification.
     *
     * @Route("/{id}", requirements={"id": "\d+"}, name="admin_notification_show")
     * @Method("GET")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $notification = $em->getRepository(Notification::class)->find($id);
        $countries = $em->getRepository(Country::class)->getCountries($id);

        return $this->render('admin/notification/show.html.twig', [
            'notification'  => $notification,
            'countries'     => $countries,
        ]);
    }

    /**
     * Creates a add Notification entity.
     *
     * @Route("/config", name="admin_notification_config")
     * @Method({"GET", "POST"})
     *
     * NOTE: the Method annotation is optional, but it's a recommended practice
     * to constraint the HTTP methods each controller responds to (by default
     * it responds to all methods).
     */
    public function notificationConfigListAction()
    {
        $em = $this->getDoctrine()->getManager();
        $notification = $em->getRepository(NotificationConfig::class)->findAll();

        return $this->render('admin/notification/notification-config-list.html.twig', ['notifications' => $notification]);
    }
}
