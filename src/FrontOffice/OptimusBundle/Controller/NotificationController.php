<?php

namespace FrontOffice\OptimusBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FrontOffice\OptimusBundle\Event\NotificationSeenEvent;
use FrontOffice\OptimusBundle\FrontOfficeOptimusEvent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FrontOffice\UserBundle\Entity\User;
use FrontOffice\OptimusBundle\Entity\Member;
use FrontOffice\OptimusBundle\Entity\NotificationSeen;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Notification controller.
 *
 * @Route("/notification")
 */
class NotificationController extends Controller {

    /**
     * 
     *
     * @Route("/participe", name="participe_notification", options={"expose"=true})
     * @Method("GET|POST")
     * @Template()
     */
    public function participeNotifAction() {
        $c = 0;
        $tt = array();
        $res = array();
        $resjour = array();
        $resCompjour = array();
        $resProgramJour = array();
        $tab1 = array("participation", "AnnulerParticip", "update", "delete", "comment", "photo");
        $tab2 = array("modifClub", "suppClub", "AccDemClub", "quiteClub", "DeleteMemClub", "addProgram", "modifProgram", "suppProgram");
        //$notifsParticip = new ArrayCollection();
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();
        $amis = $em->getRepository('FrontOfficeUserBundle:User')->getFrinds($user->getId());

        $eventjours = $em->getRepository('FrontOfficeOptimusBundle:Event')->getEventJour();
        $competitionjours = $em->getRepository('FrontOfficeOptimusBundle:Competition')->getCompetitionJour();

        foreach ($eventjours as $eventjour) {
            foreach ($user->getParticipations() as $participe) {
                if ($participe->getEvent()->getId() == $eventjour->getId()) {
                    $resjour[] = $eventjour;
                }
            }
        }
        foreach ($competitionjours as $competitionjour) {
            foreach ($user->getAdherent() as $membre) {
                foreach ($membre->getParticips() as $participe) {
                    if ($participe->getParticips()->getCompetition()->getId() == $competitionjour->getId() && $membre->getConfirmed()== 1) {
                        $resCompjour[] = $competitionjour;
                    }
                }
            }
        }
        foreach ($user->getAdherent() as $membre) {
                if($membre->getConfirmed()== 1 ){
                    $AlertProgrammes = $em->getRepository('FrontOfficeOptimusBundle:Program')->getProgramJour($membre->getClubad()->getId());
                        foreach ($AlertProgrammes as $AlertProgramme) {
                    $resProgramJour[] = $AlertProgramme;
                    
                        }
                }
            }

        if ($user->getConfigNotif()->getEvent()) {
            foreach ($amis as $ami) {
                $isAmi = $em->getRepository('FrontOfficeUserBundle:User')->getIsAmis($user->getId(), $ami->getId());
                foreach ($ami->getNotificateur() as $notif) {
                    if ($notif->getType() == "add" && $notif->getDatenotification() > $isAmi[0]->getConfirmedAt() && $notif->getDatenotification() > $user->getConfigNotif()->getDateModifEvent()) {
                        $i = 0;

                        foreach ($user->getNotificationseen() as $notifSeen) {
                            if ($notifSeen->getNotifications()->getId() == $notif->getId()) {
                                $i = 1;
                            }
                        }
                        if ($i == 0) {

                            $res[$c] = $notif;
                            $c++;
                        }
                    }
                }
            }

            foreach ($user->getParticipations() as $participe) {

                foreach ($participe->getEvent()->getNotificationEvent() as $notif2) {
                    if ($user->getId() != $notif2->getNotificateur()->getId() && in_array($notif2->getType(), $tab1) && $notif2->getDatenotification() > $participe->getDatePaticipation() && $notif2->getDatenotification() > $user->getConfigNotif()->getDateModifEvent()) {
                        $i = 0;
                        foreach ($user->getNotificationseen() as $notifSeen) {
                            if ($notifSeen->getNotifications()->getId() == $notif2->getId()) {
                                $i = 1;
                            }
                        }
                        if ($i == 0) {

                            $res[$c] = $notif2;
                            $c++;
                        }
                    }
                }
            }
        }

        if ($user->getConfigNotif()->getEntraineur()) {
            $notificationentrain = $em->getRepository('FrontOfficeOptimusBundle:Notification')->getlisteEntraineur($user->getId());
            foreach ($notificationentrain as $val) {

                if ($user->getcreatedAt() < $val->getEntraineur()->getcreatedAt() && $val->getEntraineur()->getId() != $user->getId() && $val->getDatenotification() > $user->getConfigNotif()->getDateModifEntraineur()) {
                    $i = 0;
                    foreach ($user->getNotificationseen() as $notifSeen) {
                        if ($notifSeen->getNotifications()->getId() == $val->getId()) {
                            $i = 1;
                        }
                    }

                    if ($i == 0) {

                        $res[$c] = $val;
                        $c++;
                    }
                }
            }
        }

        $notificationstars = $em->getRepository('FrontOfficeOptimusBundle:Notification')->findBy(array("idVote" => "U" . $user->getId()));
        foreach ($notificationstars as $notifstar) {
            $i = 0;
            foreach ($user->getNotificationseen() as $notifSeen) {
                if ($notifSeen->getNotifications()->getId() == $notifstar->getId()) {
                    $i = 1;
                }
            }
            if ($i == 0) {
                $res[$c] = $notifstar;
                $c++;
            }
        }
        
        foreach ($user->getParticipations() as $participe) {
            $notifstarsEvents = $em->getRepository('FrontOfficeOptimusBundle:Notification')->findBy(array("idVote" => "E".$participe->getEvent()->getId()));
            
                foreach ($notifstarsEvents as $notif2) {
                    
                    if ($user->getId() != $notif2->getNotificateur()->getId() && $notif2->getDatenotification() > $participe->getDatePaticipation() && $notif2->getDatenotification() > $user->getConfigNotif()->getDateModifEvent()) {
                        $i = 0;
                        foreach ($user->getNotificationseen() as $notifSeen) {
                            if ($notifSeen->getNotifications()->getId() == $notif2->getId()) {
                                $i = 1;
                            }
                        }
                        if ($i == 0) {
                           
                            $res[$c] = $notif2;
                            $c++;
                        }
                    }
                }
            }
            
            foreach ($user->getAdherent() as $membre) {
                if($membre->getConfirmed()== 1 ){
                    $notifstarsClubs = $em->getRepository('FrontOfficeOptimusBundle:Notification')->findBy(array("idVote" => "C".$membre->getClubad()->getId()));
                    foreach ($notifstarsClubs as $notifclub) {
                       
                    if ($user->getId() != $notifclub->getNotificateur()->getId() && $notifclub->getDatenotification() > $membre->getDateconfirm()) {
                        $i = 0;
                        foreach ($user->getNotificationseen() as $notifSeen) {
                            if ($notifSeen->getNotifications()->getId() == $notifclub->getId()) {
                                $i = 1;
                            }
                        }
                        if ($i == 0) {

                            $res[$c] = $notifclub;
                            $c++;
                        }
                    }
                }
                }
            }
      
            foreach ($user->getAdherent() as $membre) {
                if($membre->getConfirmed()== 1 ){
                       foreach ($membre->getParticips() as $participe) {
                           if($participe->getParticips()->getCompetition()->getActive()== 1){
                            $notifstarsCompets = $em->getRepository('FrontOfficeOptimusBundle:Notification')->findBy(array("idVote" => "P".$participe->getParticips()->getCompetition()->getId()));
                            foreach ($notifstarsCompets as $notifcompet) {
                       
                    if ($user->getId() != $notifcompet->getNotificateur()->getId() && $notifcompet->getDatenotification() > $membre->getDateconfirm()) {
                        $i = 0;
                        foreach ($user->getNotificationseen() as $notifSeen) {
                            if ($notifSeen->getNotifications()->getId() == $notifcompet->getId()) {
                                $i = 1;
                            }
                        }
                        if ($i == 0) {
                            $tt[]=$notifcompet;
                            $res[$c] = $notifcompet;
                            $c++;
                        }
                    }
                }
                       }        
                }
                } 
            }
            
        $notifAcceptRefuse = $em->getRepository('FrontOfficeOptimusBundle:Notification')->findBy(array("entraineur" => $user), array("datenotification" => 'DESC'));
        foreach ($notifAcceptRefuse as $notifAR) {
            
            if ($notifAR->getType() == "accepte" || $notifAR->getType() == "refuse") {
                $i = 0;
                foreach ($user->getNotificationseen() as $notifSeen) {
                    if ($notifSeen->getNotifications()->getId() == $notifAR->getId()) {
                        $i = 1;
                    }
                }
                if ($i == 0) {
                   
                    $res[$c] = $notifAR;
                    $c++;
                }
            }
        }
        
        if ($user->getConfigNotif()->getClub()) {
            $notifClubRejs = $em->getRepository('FrontOfficeOptimusBundle:Notification')->getNotifEntraineur($user->getId());
            
            foreach ($notifClubRejs as $notifClubRej) {
                if ($notifClubRej->getDatenotification() > $user->getConfigNotif()->getDateModifClub()) {
                    $i = 0;
                    foreach ($user->getNotificationseen() as $notifSeen) {
                        if ($notifSeen->getNotifications()->getId() == $notifClubRej->getId()) {
                            $i = 1;
                        }
                    }
                    if ($i == 0) {
                            
                        $res[$c] = $notifClubRej;
                        $c++;
                    }
                }
            }

            $notifAddClubs = $em->getRepository('FrontOfficeOptimusBundle:Notification')->findBy(array("type" => "addClub"), array("datenotification" => 'DESC'));
            foreach ($notifAddClubs as $notifAddClub) {
                if ($notifAddClub->getDatenotification() > $user->getConfigNotif()->getDateModifClub() && $user->getId() != $notifAddClub->getNotificateur()->getId()) {
                    $i = 0;
                    foreach ($user->getNotificationseen() as $notifSeen) {
                        if ($notifSeen->getNotifications()->getId() == $notifAddClub->getId()) {
                            $i = 1;
                        }
                    }
                    if ($i == 0) {                   
                        $res[$c] = $notifAddClub;
                        $c++;
                    }
                }
            }
             
            
            foreach ($user->getAdherent() as $membre) {
                if($membre->getConfirmed()== 1 ){
                    $notifsClub = $em->getRepository('FrontOfficeOptimusBundle:Notification')->findBy(array("club" =>$membre->getClubad()), array("datenotification" => 'DESC'));
                    foreach ($notifsClub as $notifclub) {
                    if ($user->getId() != $notifclub->getNotificateur()->getId() && in_array($notifclub->getType(), $tab2) && $notifclub->getDatenotification() > $membre->getDateconfirm() && $notifclub->getDatenotification() > $user->getConfigNotif()->getDateModifClub()) {
                        $i = 0;
                        foreach ($user->getNotificationseen() as $notifSeen) {
                            if ($notifSeen->getNotifications()->getId() == $notifclub->getId()) {
                                $i = 1;
                            }
                        }
                        if ($i == 0) {
                               
                            $res[$c] = $notifclub;
                            $c++;
                        }
                    }
                }
                }
            }
            
        }
      
if( $res != null){
        foreach ($res as $val2) {
            $notifseen2 = new NotificationSeen();
            $notifseen2->setUsers($user);
            $notifseen2->setNotifications($val2);
            $em->persist($notifseen2);
            $em->flush();
        }
    }
        $ress = array();
        $ress = $res ;
        $res = null ;
        $notificationnonvu = $em->getRepository('FrontOfficeOptimusBundle:NotificationSeen')->findBy(array("users" => $user->getId(), "vu" => 0));
        $datenotificationseen = $em->getRepository('FrontOfficeOptimusBundle:NotificationSeen')->findBy(array("users" => $user->getId()), array("datenotificationseen" => 'DESC'));

        return $this->render('FrontOfficeOptimusBundle:Notification:notifParticipe.html.twig', array('datenotificationseen' => $datenotificationseen, 'count' => $notificationnonvu, 'res' => $ress, 'resjour' => $resjour,'resCompjour'=>$resCompjour, 'resProgramJour'=>$resProgramJour));
    }

}
