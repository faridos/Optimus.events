<?php
namespace FrontOffice\OptimusBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * Reward
 *
 * @ORM\Table(name="reward") 
 * @ORM\Entity(repositoryClass="FrontOffice\OptimusBundle\Repository\RewardRepository") 
 */
 class Reward {   
 /** 
 * @var integer
 *   
 * @ORM\Column(name="id", type="integer")    
 * @ORM\Id     
 * @ORM\GeneratedValue(strategy="AUTO")     
 */
 private $id;  
 /**    
 * @ORM\ManyToOne(targetEntity="FrontOffice\UserBundle\Entity\User", inversedBy="reward")    
 * @ORM\JoinColumn(name="user_id", referencedColumnName="id" ,onDelete="CASCADE")    
 *
 */      
 protected $user;    
 /**
 * @ORM\ManyToOne(targetEntity="FrontOffice\OptimusBundle\Entity\Member", inversedBy="reward")   
 * @ORM\JoinColumn(name="member_id", referencedColumnName="id" ,onDelete="CASCADE")     
 *
 */      
 protected $member;
 /**
 * @ORM\ManyToOne(targetEntity="FrontOffice\OptimusBundle\Entity\Club", inversedBy="reward")    
 * @ORM\JoinColumn(name="club_id", referencedColumnName="id" ,onDelete="CASCADE")     
 *
 */  
 protected $club;   
 /**  
 * @var \Date  
 *   
 * @ORM\Column(name="Date_reward", type="date", nullable=false)  
 */   
 private $date;   
 /**    
 * @var string  
 * 
 * @ORM\Column(name="Titre", type="string", length=255)   
 */  
 private $titre;  
  /**    
 * @var string  
 * 
 * @ORM\Column(name="Couleur", type="string", length=255, nullable=false)   
 */  
 private $couler;  
 /**    
 * @var string   
 *    
 * @ORM\Column(name="Classement", type="string", length=255)   
 */ 
 private $classment;   
 public function __construct()    {    
 
 }  
 public function getId() { 
 return $this->id;  
 } 
 public function getPalm() { 
 return $this->palm;  
 }  
 public function getDate() {
 return $this->date;
 }  
 public function getTitre() {  
 return $this->titre;  
 } function getCouler() {
     return $this->couler;
 }

  
 public function getClassment() {  
 return $this->classment;  
 }  
 public function setId($id) {
 $this->id = $id;
 } 
 public function setPalm($palm) { 
 $this->palm = $palm; 
 }  
 function setDate(\DateTime $date) {
     $this->date = $date;
 }

  public function setTitre($titre) {
 $this->titre = $titre;   
 }   
 
 function setCouler($couler) {
     $this->couler = $couler;
 }

 public function setClassment($classment) {
 $this->classment = $classment;  
 }  
 public function getUser() { 
 return $this->user;  
 } 
 public function setUser($user) {
 $this->user = $user; 
 }   
 public function getClub() {
 return $this->club;   
 }   
 public function setClub($club) {
 $this->club = $club; 
 }  
 /**   
 * Set member  
 *    
 * @param \FrontOffice\OptimusBundle\Entity\Member $member   
 * @return Reward 
 */  
 public function setMember(\FrontOffice\OptimusBundle\Entity\Member $member = null)    { 
 $this->member = $member;
 return $this;    } 
 /** 
 * Get member    
 *   
 * @return \FrontOffice\OptimusBundle\Entity\Member     
 */  
 public function getMember() 
 {    
 return $this->member; 
 }
 }