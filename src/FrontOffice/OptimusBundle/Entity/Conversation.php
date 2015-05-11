<?php

namespace FrontOffice\OptimusBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Conversation
 *
 * @ORM\Entity(repositoryClass="FrontOffice\OptimusBundle\Repository\ConversationRepository")
 * @ORM\Table(name="conversation")
 */
class Conversation {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="starttime", type="datetime")
     * 
     */
    private $starttime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endtime", type="datetime" , nullable=true  )
     * 
     */
    private $endtime;

    /**
     * @var user1
     * @ORM\ManyToOne(targetEntity="FrontOffice\UserBundle\Entity\User", inversedBy="conversations1")
     */
    protected $user1;

    /**
     * @var user2
     * @ORM\ManyToOne(targetEntity="FrontOffice\UserBundle\Entity\User", inversedBy="conversations2")
     */
    protected $user2;

    /**
     * 
     * @ORM\OneToMany(targetEntity="FrontOffice\OptimusBundle\Entity\Message", mappedBy="conversation", cascade={"persist","remove"})
     */
    protected $messages;

    public function __construct() {
        
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set starttime
     *
     * @param \DateTime $starttime
     * @return Conversation
     */
    public function setStarttime($starttime) {
        $this->starttime = $starttime;

        return $this;
    }

    /**
     * Get starttime
     *
     * @return \DateTime 
     */
    public function getStarttime() {
        return $this->starttime;
    }

    /**
     * Set endtime
     *
     * @param \DateTime $endtime
     * @return Conversation
     */
    public function setEndtime($endtime) {
        $this->endtime = $endtime;

        return $this;
    }

    /**
     * Get endtime
     *
     * @return \DateTime 
     * 
     */
    public function getEndtime() {
        return $this->endtime;
    }

    /**
     * Get user1
     *
     * @return \FrontOffice\UserBundle\Entity\User 
     */
    public function getUser1() {
        return $this->user1;
    }
    public function setUser1(\FrontOffice\UserBundle\Entity\User $user1) {
        $this->user1 = $user1;
    }

    
    /**
     * Set user2
     *
     * @param \FrontOffice\UserBundle\Entity\User $user2
     * @return Conversation
     */
    public function setUser2(\FrontOffice\UserBundle\Entity\User $user2 = null) {
        $this->user2 = $user2;

        return $this;
    }

    /**
     * Get user2
     *
     * @return \FrontOffice\UserBundle\Entity\User 
     */
    public function getUser2() {
        return $this->user2;
    }
    


    /**
     * Add messages
     *
     * @param \FrontOffice\OptimusBundle\Entity\Message $messages
     * @return Conversation
     */
    public function addMessage(\FrontOffice\OptimusBundle\Entity\Message $messages)
    {
        $this->messages[] = $messages;
    
        return $this;
    }

    /**
     * Remove messages
     *
     * @param \FrontOffice\OptimusBundle\Entity\Message $messages
     */
    public function removeMessage(\FrontOffice\OptimusBundle\Entity\Message $messages)
    {
        $this->messages->removeElement($messages);
    }

    /**
     * Get messages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMessages()
    {
        return $this->messages;
    }
}