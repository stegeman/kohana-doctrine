<?php
class Controller_Doctrine_Template extends Controller_Template {

    public $em;

    public function __construct(Request $request, Response $response) {
        parent::__construct($request, $response);

        $this->em = EntityManager::instance();
    }
}