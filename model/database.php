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
     * @param $drink Drink   Drink Object to be added
     */
    function addDrink($drink)   // TODO: check this...
    {   // insert
        $sql = "INSERT INTO drink (name, glass, image, recipe, alcoholic, shots)
                VALUES (:name, :glass, :image, :recipe, :alcoholic, :shots)";

        $statement = $this->_dbh->prepare($sql);

        $name = $drink->getName();
        $glass = $drink->getGlass();
        $image = $drink->getImage();
        $recipe = $drink->getRecipe();
        if(get_class($drink) == 'AlcoholDrink') {
            $alcoholic = 1;
            $shots = $drink->getShots();
        } else {
            $alcoholic = 0;
            $shots = 0;
        }
        $_SESSION['name1'] = $name;
        $_SESSION['glass1'] = $glass;
        $_SESSION['image1'] = $image;
        $_SESSION['recipe1'] = $recipe;
        $_SESSION['alcoholic1'] = $alcoholic;
        $_SESSION['shots1'] = $shots;

        $statement->bindParam(':name', $name);
        $statement->bindParam(':glass', $glass);
        $statement->bindParam(':image', $image);
        $statement->bindParam(':recipe', $recipe);
        $statement->bindParam(':alcoholic', $alcoholic);
        $statement->bindParam(':shots', $shots);
        // execute update statement
//        $_SESSION['success'] = "Great Failure!";
        if($statement->execute()) {
//            $_SESSION['success'] = "Great success!";
            // Add ingredients to table
            $sql = "INSERT into drink_ing (name, ing_name, qty)
                VALUES (:name, :ing_name, :qty)";
            $statement = $this->_dbh->prepare($sql);

            $ings = $drink->getIngredients();
            // TODO: remove eventually -> displayed on test pages
            $_SESSION['allIngs'] = $ings;
            $qtys = $drink->getQty();
            $types = $drink->getType();

            $statement->bindParam(':name', $name);
            // add each ingredient to junction table
            $ingsFound = array();
            for($i = 0; $i < count($ings); $i++) {
                $statement->bindParam(':ing_name', ucwords($ings[$i]));
                $statement->bindParam(':qty', $qtys[$i]);
                $statement->execute();

                // check if ingredient is in ingredient table
                $sqlIng = "SELECT ing_name FROM ingredient
                        WHERE ing_name=:ing";
                $statementIng = $this->_dbh->prepare($sqlIng);
                $statementIng->bindParam(':ing', ucwords($ings[$i]));
                $statementIng->execute();
                $result = $statementIng->fetch(2);
                $ingsFound[] = $result;
                // if ingredient not in table already
                if(empty($result)) {
                    $_SESSION['notFound'] = $ings[$i];
                    $sqlNew = "INSERT INTO ingredient (ing_name, type)
                           VALUES (:ing_name, :type)";
                    $statementNew = $this->_dbh->prepare($sqlNew);
                    $statementNew->bindParam(':ing_name', ucwords($ings[$i]));
                    $statementNew->bindParam(':type', $types[$i]);
                    $statementNew->execute();
                }
            }
        }
    }

    /**
     * @param $drink    Drink   Drink Object to update from
     */
    function updateDrink($drink, $oldName) {

        $sql = "UPDATE drink
                SET name=:name, glass=:glass, image=:image, recipe=:recipe, alcoholic=:alcoholic, shots=:shots
                WHERE name=:old";
        $statement = $this->_dbh->prepare($sql);

        $name = $drink->getName();
        $glass = $drink->getGlass();
        $image = $drink->getImage();
        $recipe = $drink->getRecipe();
        if(get_class($drink) == 'AlcoholDrink') {
            $alcoholic = 1;
            $shots = $drink->getShots();
        } else {
            $alcoholic = 0;
            $shots = 0;
        }
        $statement->bindParam(':old', $oldName);
        $statement->bindParam(':name', $name);
        $statement->bindParam(':glass', $glass);
        $statement->bindParam(':image', $image);
        $statement->bindParam(':recipe', $recipe);
        $statement->bindParam(':alcoholic', $alcoholic);
        $statement->bindParam(':shots', $shots);
        // execute update statement
        if($statement->execute()) {
            // ingredients
            // first clear database of ingredients for that drink
            $sql = "DELETE FROM drink_ing
                WHERE name=:old";
            $statement = $this->_dbh->prepare($sql);
            $statement->bindParam(':old', $oldName);
            // delete all entries in junction table matching old drink name (if it changed)
            $statement->execute();

            // then update with new values
            $sql = "INSERT into drink_ing (name, ing_name, qty)
                VALUES (:name, :ing_name, :qty)";
            $statement = $this->_dbh->prepare($sql);

            $ings = $drink->getIngredients();
            // TODO: remove session variable when done testing
            $_SESSION['allIngs'] = $ings;
            $qtys = $drink->getQty();
            $types = $drink->getType();

            $statement->bindParam(':name', $name);
            // add each ingredient to junction table
            $ingsFound = array();
            for($i = 0; $i < count($ings); $i++) {
                $statement->bindParam(':ing_name', $ings[$i]);
                $statement->bindParam(':qty', $qtys[$i]);
                $statement->execute();

                // check if ingredient is in ingredient table
                $sqlIng = "SELECT ing_name FROM ingredient
                        WHERE ing_name=:ing";
                $statementIng = $this->_dbh->prepare($sqlIng);
                $statementIng->bindParam(':ing', $ings[$i]);
                $statementIng->execute();
                $result = $statementIng->fetch(2);
                $ingsFound[] = $result;
                // if ingredient not in table already
                if(empty($result)) {
                    // TODO: remove session variable when done testing
                    $_SESSION['notFound'] = $ings[$i];
                    $sqlNew = "INSERT INTO ingredient (ing_name, type)
                           VALUES (:ing_name, :type)";
                    $statementNew = $this->_dbh->prepare($sqlNew);
                    $statementNew->bindParam(':ing_name', $ings[$i]);
                    $statementNew->bindParam(':type', $types[$i]);
                    $statementNew->execute();
                }
            }
            $_SESSION['ingsFound'] = $ingsFound;
        }
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

    /**
     * @param Character $character  Character Object storing all choices
     */
    function getDrinkMatch($character)
    {
        // get all types that match characteristics

        // iterate over all types

        // get all drinks that have each type

        // get all drinks that have the most of the matching types

        // randomly select one
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

    /**
     * Deletes a drink and it's ingredients from junction table
     *
     * @param string $drinkName    Name of drink to be deleted
     * @return int $success       If each step was successful
     */
    function deleteDrink($drinkName) {
        $success = 'neither';

        $sql = "DELETE FROM drink
                WHERE drink.name=:name";
        $statement = $this->_dbh->prepare($sql);

        $statement->bindParam(':name', $drinkName);
        if($statement->execute()) {
            $success = "first";
            $sql = "DELETE FROM drink_ing
                    WHERE name=:name";
            $statement = $this->_dbh->prepare($sql);
            $statement->bindParam(':name', $drinkName);
            if($statement->execute()) {
                $success = "both";
            }

        }
        
        return $success;
    }
}