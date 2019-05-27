<?php
/*
 * Kaephas/Zane
 * 5-23-19
 * database.php
 *
 * Database class
 */

$user = $_SERVER['USER'];
require "/home/$user/config.php";

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
    {   // insert
        // name, glass, image, ingredients[ing => qty], type[ing => type], A:(shots)

    }

    /**
     * @param $drink    Drink   Drink Object to update from
     */
    function updateDrink($drink) {

    }

    /**
     * Loads a view that shows and allows for editing drink info
     * @param $drinkName string   The name of the drink to be queried
     * @return Drink|AlcoholDrink $newDrink     Drink object created
     */
    function editDrink($drinkName)
    {   // update
        // get drink table info
        $sql = "SELECT name, glass, image, recipe, alcoholic, shots FROM drink
                WHERE name=:name";
        $statement = $this->_dbh->prepare($sql);
        $statement->bindParam(':name', $drinkName);
        $statement->execute();
        $drink = $statement->fetch(2);

        // get ingredients, qty, type

        $sql = "SELECT drink_ing.ing_name, qty, type FROM drink_ing, ingredient
                WHERE drink_ing.name = :name AND drink_ing.ing_name = ingredient.ing_name";
        $statement = $this->_dbh->prepare($sql);

        $statement->bindParam(':name', $drinkName);
        $statement->execute();
        $rows = $statement->fetchAll(2);

        $qty = array();
        $type = array();
        $ingredients = array();
        foreach($rows as $ingredient) {
            $qty[] = $ingredient['qty'];
            $type[] = $ingredient['type'];
            $ingredients[] = $ingredient['ing_name'];
        }

        $drink['ingredients'] = $rows;
        if($drink['alcoholic'] == 0) {
            $newDrink = new Drink($drinkName, $drink['glass'], $qty, $ingredients, $type, $drink['recipe'], $drink['image']);
        } else {
            $newDrink = new AlcoholDrink($drinkName, $drink['glass'], $qty, $ingredients, $type, $drink['recipe'], $drink['image']);
            $newDrink->setShots($drink['shots']);
        }

        return $newDrink;


    }

    function getDrinkMatch()
    {

    }


    function getAllDrinks()
    {
        // select name
        $db = $this->_dbh;

        $sql = "SELECT name, glass, shots FROM drink";
        $statement = $db->prepare($sql);
        $statement->execute();
        $rows = $statement->fetchAll(2);

        for($i = 0; $i < count($rows); $i++) {
            $rows[$i]['shots'] = $rows[$i]['shots'] . " shots";
        }

        return $rows;
    }
}