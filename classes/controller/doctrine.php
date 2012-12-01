<?php
class Controller_Doctrine extends Controller {

    public $em;

    public function before() {
        $this->em = EntityManager::instance();
    }
}