<?php
class Controller_Doctrine extends Controller {

    public $em;

    public function __construct(Request $request, Response $response) {
        parent::__construct($request, $response);

        $this->em = EntityManager::instance();
    }
}