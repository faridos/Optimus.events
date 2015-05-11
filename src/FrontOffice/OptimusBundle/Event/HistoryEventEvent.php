<?php

namespace FrontOffice\OptimusBundle\Event;

use Symfony\Component\EventDispatcher\Event;

use FrontOffice\UserBundle\Entity\User;

class HistoryEventEvent extends Event {

    protected $event;
    protected $user;
    protected $action;

    public function __construct(User $user, \FrontOffice\OptimusBundle\Entity\Event $event, $action) {
        $this->event = $event;
        $this->user = $user;
        $this->action = $action;
    }
    public function getEvent() {
        return $this->event;
    }

    public function getUser() {
        return $this->user;
    }

    public function getAction() {
        return $this->action;
    }


}
