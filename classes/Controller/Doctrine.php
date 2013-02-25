<?php
class Controller_Doctrine extends Controller {

    public $_em;

    public function before() {
        parent::before();

        $this->_em = EntityManager::instance();
    }

    public function action_demo() {
        echo 1; die;
        $User = new \User\Entity\User();
        $User->setUsername("foo");
        $User->setPassword("bar");

        $this->_em->persist($User);
        $this->_em->flush();
        die;
    }
}