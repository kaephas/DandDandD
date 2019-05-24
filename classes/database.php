<?php
/*
 * Kaephas/Zane
 * 5-23-19
 * database.php
 *
 * Database class
 */

require '/home/kaephasg/config.php';

class Database
{
    private $_dbh;

    function __construct()
    {
        $this->connect();
    }

    function connect()
    {
        try {
            // instantiate a database object
            $this->_dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            return $this->_dbh;
        } catch(PDOException $e){
            echo 'Unable to connect to database: ' . $e->getMessage();
        }
    }

    /**
     * Adds a new drink to the database
     *
     * @param $newDrink Drink   Drink Object to be added
     */
    function addDrink($newDrink)
    {

    }

    /**
     * Loads a view that shows and allows for editing drink info
     * @param $drinkName string   The name of the drink to be queried
     */
    function editDrink($drinkName)
    {

    }

    function getDrinkMatch()
    {

    }

    function getAllDrinks()
    {

    }
}