<?php
class Controller_Doctrine extends Controller {

    public $_em;

    public function before() {
        parent::before();

        $this->_em = EntityManager::instance();
    }

    public function action_demo() {
        echo "Create new User entity<br>";
        $User = new \User\Entity\User();
        $User->setUsername("foo");
        $User->setPassword("bar");
        $User->setModified(new DateTime());
        $User->setCreated(new DateTime());

        echo "Save new user to database<br>";
        try {
            $this->_em->persist($User);
            $this->_em->flush();
        } catch(Exception $e) {
            echo "User does already exist. You've run this script before.<br>";
        }

        unset($User);

        echo "Get user from database<br>";
        $User = $this->_em->getRepository("User\Entity\User")->findOneBy(array("username" => "foo"));

        echo "Id of the found user is: ".$User->getId();
    }
}