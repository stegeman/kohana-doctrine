<?php
class Controller_Doctrine_Template extends Controller_Template {

    public $_em;

    public function before() {
        parent::before();

        $this->_em = EntityManager::instance();
    }
}