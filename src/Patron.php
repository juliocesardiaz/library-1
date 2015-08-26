<?php

    class Patron
    {
        private $patron_name;
        private $id;


        function __construct($patron_name, $id = null)
        {
            $this->patron_name = $patron_name;
            $this->id = $id;
        }

        function setPatronName($new_patron_name)
        {
            $this->patron_name = $new_patron_name;
        }

        function getPatronName()
        {
            return $this->patron_name;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO patrons (patron_name)
            VALUES ('{$this->getPatronName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_patrons = $GLOBALS['DB']->query("SELECT * FROM patrons;");
            $patrons = array();
            foreach($returned_patrons as $patron) {
                $patron_name = $patron['patron_name'];
                $id = $patron['id'];
                $new_patron = new Patron($patron_name, $id);
                array_push($patrons, $new_patron);
            }
            return $patrons;
        }

        static function deleteAll()
        {
          $GLOBALS['DB']->exec("DELETE FROM patrons;");
        }

    }
?>
