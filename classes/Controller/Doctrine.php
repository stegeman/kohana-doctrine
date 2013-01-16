<?php
class Controller_Doctrine extends Controller {

    public $_em;

    public function before() {
        parent::before();

        $this->_em = EntityManager::instance();
    }
}