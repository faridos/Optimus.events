<?php

namespace FrontOffice\UserBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FrontOffice\OptimusBundle\Entity\Notification;
use FrontOffice\OptimusBundle\Entity\ConfigNotif;
use FrontOffice\OptimusBundle\Entity\Pays;
use FrontOffice\UserBundle\Event\UserRegisterEvent;
use FrontOffice\UserBundle\FrontOfficeUserEvents;
use \DateTime;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;

class RegistrationController extends BaseController {

    public function registerAction(Request $request) {
        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->get('fos_user.registration.form.factory');
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');
 $em = $this->getDoctrine()->getManager();
        $user = $userManager->createUser();
        $user->setEnabled(true);
        $user->setAmis(1);
        $user->setCompte(1);
        $user->setConnected(0);
        $user->setTypeNotification('All');
        $user->setCreatedAt(new DateTime());
       
        
        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);
            $userManager->updateUser($user);

           if ($user->getProfil() == "Entraineur") {
               $em = $this->getDoctrine()->getManager();
               $notif = new Notification();
            $notif->setNotificateur($user);
            $notif->setType('entraineur');
            $notif->setEntraineur($user);
            $em->persist($notif);
            $em->flush();
               
           }
          $request = $this->get('request');
            $paysregion = $request->get("regionpays");
       
        $pay = $em->getRepository("FrontOfficeOptimusBundle:Pays")->findOneBy(array('nom' => $paysregion));
        if(!$pay){
        $pays = new Pays();
        $pays->setNom($paysregion);
        $em->persist($pays);
        $em->flush();
        }
        
            $configNotif = new ConfigNotif();
        $configNotif->setUser($user);
        $configNotif->setClub(1);
        $configNotif->setEntraineur(1);
        $configNotif->setEvent(1);
         $em->persist($configNotif);
            $em->flush();
//                $usernotif = new UserRegisterEvent($user);
//                $dispatcher = $this->get('event_dispatcher');
//                $dispatcher->dispatch(FrontOfficeUserEvents::AFTER_ENTRAINEUR_REGISTER, $usernotif);
//            }
            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('fos_user_registration_confirmed');
                $response = new RedirectResponse($url);
            }

            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }

        return $this->render('FOSUserBundle:Registration:register.html.twig', array(
                    'form' => $form->createView(),
        ));
    }
     public function confirmAction(Request $request, $token)
    {
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');

        $user = $userManager->findUserByConfirmationToken($token);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with confirmation token "%s" does not exist', $token));
        }

        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $user->setConfirmationToken(null);
        $user->setEnabled(true);
        $user->setConnected(1);
        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_CONFIRM, $event);

        $userManager->updateUser($user);

        if (null === $response = $event->getResponse()) {
            $url = $this->generateUrl('fos_user_registration_confirmed');
            $response = new RedirectResponse($url);
        }

        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_CONFIRMED, new FilterUserResponseEvent($user, $request, $response));

        return $response;
    }

}
