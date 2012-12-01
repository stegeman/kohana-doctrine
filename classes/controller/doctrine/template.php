<?php
class Controller_Doctrine_Template extends Controller_Template {

    public $em;

    public function before() {
        $this->em = EntityManager::instance();
    }
}