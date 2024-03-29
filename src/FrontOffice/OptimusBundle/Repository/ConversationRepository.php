<?php

namespace FrontOffice\OptimusBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ClubRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ConversationRepository extends EntityRepository {

    public function getConversationUser($reciever)
    {
         $em = $this->getEntityManager();
          $qb = $em->createQuery("select conv from FrontOfficeOptimusBundle:Conversation conv"
                  . " where conv.user2 = :reciever  OR  conv.user1 = :reciever "
                  )
                  ->setParameter('reciever', $reciever);
          return $qb->getResult();
    }
    public function getUserConversation($reciever)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder('u,c.id');
        $qb->select('u')
                ->from('FrontOffice\UserBundle\Entity\User', 'u')
                ->Join('FrontOffice\OptimusBundle\Entity\Conversation', 'c')
                ->where('c.user1 = u and c.user2 = :id')
                ->orWhere('c.user2 = u.id and c.user1 = :id')
                ->setParameter('id', $reciever);
        return $qb->getQuery()->getResult();
    
    }

//    public function getProfileConversations($idprofil) {
//        $em = $this->getEntityManager();
//
//        $qb = $em->createQueryBuilder();
//
//        $qb->select('m')
//                ->from('FrontOffice\OptimusBundle\Entity\Conversation', 'm')
//                ->where('m.user1 = :id_user')
//                ->orwhere('m.user2 = :id_user')
//                ->orderBy('m.starttime', 'DESC')
//                ->setParameter('id_user', $idprofil);
//
//        return $qb->getQuery()->getResult();
//    }
//
//    public function getMessagesConversation($idconvers) {
//        $em = $this->getEntityManager();
//        $qb = $em->createQueryBuilder();
//        $qb->select(array('m'))
//                ->from('FrontOffice\OptimusBundle\Entity\Message', 'm')
//                
//                ->where('m.conversationroom := idconvers')
//                
//                ->setParameter('idconvers', $idconvers);
//      
//        return $qb->getQuery()->getArrayResult();
//    }
//    public function getLastConversation() {
//      $em = $this->getEntityManager();
//      $query = $em->createQuery("SELECT MAX(c.id) FROM FrontOfficeOptimusBundle:Conversation c ");
//              
//         return $conversation = $query->getArrayResult();
//    }
//    

    
}

