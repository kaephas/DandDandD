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
     * @param Drink $drink   Drink Object to be added
     * @return bool     If the addition occurred
     */
    function addDrink($drink)   // TODO: check this...
    {
        // compare ing types and instantly return with false

        if(!$this->_compareIngType($drink)) {
            return false;
        }

        // insert
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

            //TODO: remove after testing
            echo 'ings: ';
            print_r($ings);
            echo '<br>qtys: ';
            print_r($qtys);
            echo '<br>types: ';
            print_r($types);


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
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param Drink     $drink   Drink Object to update from
     * @param string    $oldName previous drink name to reference if drink name changed
     * @return bool     Indicates db update success
     */
    function updateDrink($drink, $oldName) {

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
            if($types[$index] != $result['type']) {
                $match = false;
            }
        }
        return $match;
    }


    /**
     * Loads a view that shows and allows for editing drink info
     * @param $drinkName string   The name of the drink to be queried
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
     * @return Drink|AlcoholDrink $match        The name of the drink match found
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

        // TODO: remove when done testing
        $_SESSION['allTraits'] = $trait;
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

        // TODO Remove when done testing
        $_SESSION['traitToType'] = $traitToType;

        // get all drinks that have each type
        $sql = "SELECT drink_ing.name AS name 
                FROM drink_ing, ingredient
                WHERE ingredient.type=:type AND drink_ing.ing_name = ingredient.ing_name";
        $statement = $this->_dbh->prepare($sql);

        $drinksList = array();
        foreach($types as $type) {
            $statement->bindParam(':type', $type);
            $statement->execute();
            $drinksFound = $statement->fetchAll(2);
            foreach($drinksFound as $drink) {
                $drinksList[] = $drink['name'];
            }
        }

        $drinks = array_unique($drinksList);

        // get non-alcoholic if necessary
        if($character->getAlcoholic() != 'yes') {
            $sql = "SELECT alcoholic from drink
                    WHERE name=:name";
            $statement = $this->_dbh->prepare($sql);
            $nonAlc = array();
            foreach($drinks as $each) {
                $statement->bindParam(':name', $each);
                $statement->execute();
                $result = $statement->fetch(2);
                if($result['alcoholic'] == 0) {
                    $nonAlc[] = $each;
                }
            }
            // if none found (there's not many non-alc atm)
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

        $match = $this->_getBestDrink($drinks, $types);

        return $this->getDrink($match);
//        return $match;
    }


    /**
     * @param array $drinks
     * @param array $types
     * @return mixed
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
            // if most matches found, make a new array
            if ($count > $maxTypes) {
                $maxDrink = array($drink);
                $maxTypes = $count;
            } elseif ($count == $maxTypes) {

                $maxDrink[] = $drink;
            }
        }
        // TODO: Remove when done testing
        $_SESSION['max'] = $maxTypes;
        $_SESSION['types'] = $types;
        $_SESSION['allDrinks'] = $drinks;
        $_SESSION['maxDrinks'] = $maxDrink;
        $_SESSION['drinksToTypes'] = $drinksToTypes;
        // TODO end remove
        // randomly select one
        $index = rand(0, count($maxDrink) - 1);
        $match = $maxDrink[$index];
        return $match;
    }


//    function testResult() {
//        $sql = "SELECT drink_ing.name AS name, ingredient.type AS type
//                FROM drink_ing, ingredient
//                WHERE drink_ing.name=:name AND drink_ing.ing_name=ingredient.ing_name";
//        $statement = $this->_dbh->prepare($sql);
//        $name = "Cuba Libre";
//        $statement->bindParam(':name', $name);
//        $statement->execute();
//        $result = $statement->fetchAll(2);
//
//        var_dump($result['type']);
//
//    }


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

