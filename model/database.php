<?php
/**
 * Database class managing connection and queries
 *
 * @author Kaephas & Zane
 * @version 1.0
 * @date 5-23-19
 *
 * database.php
 *
 */

// TODO: Demonstrating table structure

//CREATE TABLE drink (
//    name VARCHAR(40) PRIMARY KEY NOT NULL,
//   glass VARCHAR(20) NOT NULL,
//   image VARCHAR(40) DEFAULT 'images/default.jpg',
//   recipe TEXT NOT NULL,
//   alcoholic TINYINT(1) DEFAULT 1,
//   shots DOUBLE DEFAULT 0
//);
//
//CREATE TABLE ingredient (
//    ing_name VARCHAR(40) PRIMARY KEY,
//  type VARCHAR(20) NOT NULL
//);
//
//CREATE TABLE drink_ing (
//    name VARCHAR(40) NOT NULL,
//  ing_name VARCHAR(40) NOT NULL,
//  qty VARCHAR(20) NOT NULL,
//  PRIMARY KEY (name, ing_name, qty),
//  FOREIGN KEY (name) REFERENCES drink(name),
//  FOREIGN KEY (ing_name) REFERENCES ingredient(ing_name)
//);
//
//CREATE TABLE characteristic (
//  trait VARCHAR(40) PRIMARY KEY,
//  type VARCHAR(20) NOT NULL
//);
//
//CREATE TABLE admin
//(
//    username VARCHAR(40) PRIMARY KEY,
//  password VARCHAR(255) NOT NULL
//);

// get username and database info
$user = $_SERVER['USER'];
require "/home/$user/config.php";

/**
 * Class Database
 * @author Kaephas & Zane
 * @version 1.0
 *
 * Has functions for connecting to a database and running queries needed for drinks/characters
 */
class Database
{
    private $_dbh;

    /**
     * Database constructor.
     * Runs the database connection method.
     * @return void
     */
    function __construct()
    {
        $this->connect();
    }

    /**
     * Connects to the database
     *
     * @return PDO  the PHP Database Object
     */
    function connect()
    {
        try {
            // instantiate a database object
            $this->_dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            return $this->_dbh;
        } catch(PDOException $e){
            echo 'Unable to connect to database: ' . $e->getMessage();
            return null;
        }
    }


    /**
     * Adds a new drink to the database
     *
     * @param Drink $drink   Drink Object to be added
     * @return bool     If the addition occurred
     */
    function addDrink($drink)   // TODO: check this...
    {
        // compare ing types and instantly return with false

        if(!$this->_compareIngType($drink)) {
            return false;
        }

        // insert the drink
        $sql = "INSERT INTO drink (name, glass, image, recipe, alcoholic, shots)
                VALUES (:name, :glass, :image, :recipe, :alcoholic, :shots)";

        $statement = $this->_dbh->prepare($sql);

        $name = $drink->getName();
        $glass = $drink->getGlass();
        $image = $drink->getImage();
        $recipe = $drink->getRecipe();
        // set alcoholic/shots values accordingly
        if($drink instanceof AlcoholDrink) {
            $alcoholic = 1;
            $shots = $drink->getShots();
        } else {
            $alcoholic = 0;
            $shots = 0;
        }
        // TODO are these ever used?
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
        if($statement->execute()) {
            // Add ingredients to junction table
            $sql = "INSERT into drink_ing (name, ing_name, qty)
                VALUES (:name, :ing_name, :qty)";
            $statement = $this->_dbh->prepare($sql);

            $ings = $drink->getIngredients();
            $qtys = $drink->getQty();
            $types = $drink->getType();

            // drink name bound the same for all ingredients
            $statement->bindParam(':name', $name);
            // add each ingredient to junction table
            $ingsFound = array();
            for($i = 0; $i < count($ings); $i++) {
                // match qty to ingredient and bind and insert
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
                    // TODO is notFound ever used?
                    $_SESSION['notFound'] = $ings[$i];
                    $sqlNew = "INSERT INTO ingredient (ing_name, type)
                           VALUES (:ing_name, :type)";
                    $statementNew = $this->_dbh->prepare($sqlNew);
                    $statementNew->bindParam(':ing_name', ucwords($ings[$i]));
                    $statementNew->bindParam(':type', $types[$i]);
                    $statementNew->execute();
                }
            }
            // statement executed
            return true;
        } else {
            // statement failed
            return false;
        }
    }

    /**
     * @param Drink     $drink   Drink Object to update from
     * @param string    $oldName previous drink name to reference if drink name changed
     * @return bool     Indicates db update success
     */
    function updateDrink($drink, $oldName) {
        //  make sure ingredient => type matches existing pairs in database
        if(!$this->_compareIngType($drink)) {
            return false;
        }

        $sql = "UPDATE drink
                SET name=:name, glass=:glass, image=:image, recipe=:recipe, alcoholic=:alcoholic, shots=:shots
                WHERE name=:old";
        $statement = $this->_dbh->prepare($sql);

        $name = $drink->getName();
        $glass = $drink->getGlass();
        $image = $drink->getImage();
        $recipe = $drink->getRecipe();
        if($drink instanceof AlcoholDrink) {
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
                    $sqlNew = "INSERT INTO ingredient (ing_name, type)
                           VALUES (:ing_name, :type)";
                    $statementNew = $this->_dbh->prepare($sqlNew);
                    $statementNew->bindParam(':ing_name', $ings[$i]);
                    $statementNew->bindParam(':type', $types[$i]);
                    $statementNew->execute();
                }
            }
            $_SESSION['ingsFound'] = $ingsFound;
            return true;
        } else {
            return false;
        }
    }

    /**
     * Checks if a drink's ingredient types match the database
     *
     * @param Drink|AlcoholDrink $drink     The drink to be checked
     * @return bool $match      Whether the ingredient types match
     */
    private function _compareIngType($drink) {
        $sql = "SELECT ing_name, type FROM ingredient
                WHERE ing_name=:ing";
        $statement = $this->_dbh->prepare($sql);

        $ings = $drink->getIngredients();
        $types = $drink->getType();

        $match = true;
        foreach($ings as $index => $ing) {
            $statement->bindParam(':ing', $ing);
            $statement->execute();
            $result = $statement->fetch(2);
            // ingredient is already in database
            if($result) {
                if($types[$index] != $result['type']) {
                    $match = false;
                }
            }
        }
        return $match;
    }

    /**
     * Creates a new Drink object from info in database matching the name
     * @param string $drinkName   The name of the drink to be queried
     * @return Drink|AlcoholDrink $newDrink     Drink object created
     */
    function getDrink($drinkName)
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

        // create appropriate quantity, ingredient, and type arrays
        $qty = array();
        $type = array();
        $ingredients = array();
        foreach($rows as $ingredient) {
            $qty[] = $ingredient['qty'];
            $type[] = $ingredient['type'];
            $ingredients[] = $ingredient['ing_name'];
        }
        // TODO I dont' see drink['ingredients'] ever used => I believe matches old Drink structure
        $drink['ingredients'] = $rows;
        // create a new Drink or Alcoholic drink appropriately
        if($drink['alcoholic'] == 0) {
            $newDrink = new Drink($drinkName, $drink['glass'], $qty, $ingredients, $type, $drink['recipe'], $drink['image']);
        } else {
            $newDrink = new AlcoholDrink($drinkName, $drink['glass'], $qty, $ingredients, $type, $drink['recipe'], $drink['image']);
            $newDrink->setShots($drink['shots']);
        }

        return $newDrink;

    }

    /**
     * Gets a list of possible Drink matches for a Character's data and chooses the best one
     * @param Character $character  Character Object storing all choices
     * @return Drink|AlcoholDrink $match        The Drink found
     */
    function getDrinkMatch($character)
    {
        // get all types that match characteristics

        // get maximum stat
        $statsList = generateStats();
        $stats = array();
        for ($i = 0; $i < count($statsList); $i++) {
            $stats[$statsList[$i]] = $character->getStats()[$i];
        }
        $max = 0;
        $topStats = array();
        foreach($stats as $stat => $value) {
            if($value > $max) {
                $max = $value;
                $topStats = array($stat);
            }
            if($value == $max) {
                $topStats[] = $stat;
            }
        }
        $index = rand(0, count($topStats) - 1);
        $trait[] = $topStats[$index];

        $trait[] = $character->getSubclass();
        $trait[] = $character->getAlignment();
        $trait[] = $character->getBackground();

        // iterate over all types
        $types = array();
        $traitToType = array();
        $sql = "SELECT type FROM characteristic WHERE trait=:trait";
        $statement = $this->_dbh->prepare($sql);
        for ($i = 0; $i < count($trait); $i++) {
            $statement->bindParam(':trait', $trait[$i]);
            $statement->execute();
            $found = $statement->fetch(2);
            $types[] = $found['type'];
            $traitToType[$trait[$i]] = $found['type'];
        }

        // get all drinks that have each type
        $sql = "SELECT drink_ing.name AS name 
                FROM drink_ing, ingredient
                WHERE ingredient.type=:type AND drink_ing.ing_name = ingredient.ing_name";
        $statement = $this->_dbh->prepare($sql);
        // get any drink that has at least one of any type/trait
        $drinksList = array();
        foreach($types as $type) {
            $statement->bindParam(':type', $type);
            $statement->execute();
            $drinksFound = $statement->fetchAll(2);
            foreach($drinksFound as $drink) {
                $drinksList[] = $drink['name'];
            }
        }
        // remove duplicate drinks
        $drinks = array_unique($drinksList);

        // get non-alcoholic if necessary
        if($character->getAlcoholic() != 'yes') {
            $sql = "SELECT alcoholic from drink
                    WHERE name=:name";
            $statement = $this->_dbh->prepare($sql);
            $nonAlc = array();
            // iterate over each drink to see if it's non-alcoholic
            foreach($drinks as $each) {
                $statement->bindParam(':name', $each);
                $statement->execute();
                $result = $statement->fetch(2);
                if($result['alcoholic'] == 0) {
                    $nonAlc[] = $each;
                }
            }
            // if none found (there's not many non-alc atm), get ALL non as the options
            if(count($nonAlc) == 0) {
                $sql = "SELECT name from drink
                        WHERE alcoholic=0";
                $statement = $this->_dbh->prepare($sql);
                $statement->execute();
                $results = $statement->fetchAll(2);
                foreach($results as $row) {
                    $nonAlc[] = $row['name'];
                }
            }
            $drinks = $nonAlc;
        }
        // get the best drink option
        $match = $this->_getBestDrink($drinks, $types);

        // return a Drink object from the drink
        return $this->getDrink($match);
    }

    /**
     * Calculates the best drink by finding the drink with the most common ingredient types
     * or random-ing between a set if a tie
     * @param array $drinks     array of drink names
     * @param array $types      array of ingredient types
     * @return string $match    the name of the best drink
     */
    private function _getBestDrink(array $drinks, array $types)
    {
        // get all drinks that have the most of the matching types
        $sql = "SELECT drink_ing.name AS name, ingredient.type AS type
                FROM drink_ing, ingredient
                WHERE drink_ing.name=:name AND drink_ing.ing_name=ingredient.ing_name";
        $statement = $this->_dbh->prepare($sql);

        $maxTypes = 0;
        $maxDrink = array();
        $drinksToTypes = array();
        // check how many of each type are in all the drinks that contain at least 1 of the type
        foreach ($drinks as $index => $drink) {
            $drinksToTypes[$drink] = "Typelist: ";
            $count = 0;
            $statement->bindParam(':name', $drink);
            $statement->execute();
            $result = $statement->fetchAll(2);
            $drinkTypes = array();
            // create an array of just the types in the drink
            foreach ($result as $row) {
                $drinkTypes[] = $row['type'];
                $drinksToTypes[$drink] .= ", " . $row['type'];
            }
            // count how many of the character types are in the drink
            foreach ($types as $type) {
                if (in_array($type, $drinkTypes)) {
                    $count++;
                }
            }
            // if most matches found, make a new array or update current array if tied
            if ($count > $maxTypes) {
                $maxDrink = array($drink);
                $maxTypes = $count;
            } elseif ($count == $maxTypes) {

                $maxDrink[] = $drink;
            }
        }

        // randomly select one
        $index = rand(0, count($maxDrink) - 1);
        $match = $maxDrink[$index];
        return $match;
    }

    /**
     * Gets the complete list of drinks and all their properties from the database
     * @return array $rows  array of drink names, glass type, and shots
     */
    function getAllDrinks()
    {
        $db = $this->_dbh;

        $sql = "SELECT name, glass, shots FROM drink";
        $statement = $db->prepare($sql);
        $statement->execute();
        $rows = $statement->fetchAll(2);

        // append " shots" for table readability
        for($i = 0; $i < count($rows); $i++) {
            $rows[$i]['shots'] = $rows[$i]['shots'] . " shots";
        }

        return $rows;
    }

    /**
     * Deletes a drink and its ingredients from junction table
     *
     * @param string $drinkName    Name of drink to be deleted
     * @return string $success       Indicates which step(s) were successful
     */
    function deleteDrink($drinkName) {
        $success = 'neither';

        $sql = "DELETE FROM drink
                WHERE drink.name=:name";
        $statement = $this->_dbh->prepare($sql);

        $statement->bindParam(':name', $drinkName);
        // delete from drink table
        if($statement->execute()) {
            $success = "first";
            $sql = "DELETE FROM drink_ing
                    WHERE name=:name";
            $statement = $this->_dbh->prepare($sql);
            $statement->bindParam(':name', $drinkName);
            // delete from drink_ing junction table
            if($statement->execute()) {
                $success = "both";
            }
        }
        return $success;
    }

    /**
     * Confirms that a password matches admin username
     * @param string $username  the username to check
     * @param string $password  the password to check
     * @return bool     if password matches
     */
    function validAdmin($username, $password){

        global $f3;

        $sql = "SELECT username, password FROM admin
                WHERE username=:username";
        $statement = $this->_dbh->prepare($sql);

        $statement->bindParam(':username', $username);

        if($statement->execute()) {
            // successful execution but 0 matches found
            if($statement->rowCount() < 1) {
                $f3->set('errors["login"]', 'Username not found.');
                return false;
            } else {
                $result = $statement->fetch(2);
                $pw = $result['password'];
                // "unhash" the password and compare
                if(password_verify($password, $pw)) {
                    return true;
                } else {
                    $f3->set('errors["login"]', "Password doesn't match.");
                    return false;
                }
            }
        } else {    // couldn't connect to DB
            $f3->set('errors["login"]', "Database error.");
            return false;
        }

    }

    // TODO look here for updating passwords

    /**
     * If visiting /setPW route, can set a new username and password
     *  => used to set initial values in DB as hashed for initial setup only
     * change $username and $password to desired values
     * @return void
     */
    function runOnce() {
        echo 'Inserting new password';

        $sql = "INSERT INTO admin
            VALUES(:username, :password)";
        $statement = $this->_dbh->prepare($sql);
        $username = 'Zane';
        $password = password_hash("Zane", PASSWORD_DEFAULT);
        $statement->bindParam(':password', $password);
        $statement->bindParam(':username', $username);
        if($statement->execute()) {
            echo "<br>Inserted.";
        } else {
            echo "<br>Not inserted.";
        }

    }
}

