<?php
/**
 * Stores the D&D character data entered by the user
 *
 * @author Kaephas & Zane
 * @version 1.0
 */
class Character
{
    private $_name;
    private $_class;
    private $_subclass;
    private $_alignment;
    private $_background;
    private $_age;
    private $_stats;
    private $_alcoholic;
    private $_image;

    /**
     * Character constructor.
     * @param string $_name
     * @param string $_class
     * @param string $_subclass
     * @param string $_alignment
     * @param string $_background
     * @param int $_age
     * @param int[] $_stats
     * @param bool $_alcoholic
     * @param string $_image
     * @return void
     */
    public function __construct($_name, $_class, $_subclass, $_alignment, $_background,
                                $_age, $_stats, $_alcoholic, $_image)
    {
        $this->_age = $_age;
        $this->_alcoholic = $_alcoholic;
        $this->_alignment = $_alignment;
        $this->_background = $_background;
        $this->_class = $_class;
        $this->_image = $_image;
        $this->_name = $_name;
        $this->_stats = $_stats;
        $this->_subclass = $_subclass;
    }

    // getters

    /**
     * Gets the character's age
     * @return int $_age    the character's age
     */
    public function getAge()
    {
        return $this->_age;
    }

    /**
     * Gets the character's alcoholic drink preference
     * @return bool $_alcoholic     if the character drinks alcohol
     */
    public function getAlcoholic()
    {
        return $this->_alcoholic;
    }


    /**
     * Gets the character's alignment
     * @return string $_alignment   the character's alignment
     */
    public function getAlignment()
    {
        return $this->_alignment;
    }

    /**
     * Gets the character's background
     * @return string $_background  the character's background
     */
    public function getBackground()
    {
        return $this->_background;
    }

    /**
     * Gets the character's class
     * @return string $_class   The character's class
     */
    public function getClass()
    {
        return $this->_class;
    }

    /**
     * Gets the character's class image
     * @return string  $_image  the path of the image
     */
    public function getImage()
    {
        return $this->_image;
    }

    /**
     * Gets the name of the character
     * @return string $_name    The character's name
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Gets the character's stats
     * @return int[] $_stats    the character's stats
     */
    public function getStats()
    {
        return $this->_stats;
    }

    /**
     * Gets the character's subclass
     * @return string $_subclass    the character's subclass
     */
    public function getSubclass()
    {
        return $this->_subclass;
    }

    // setters

    /**
     * Sets the character's age
     * @param int $age  the character's new age
     * @return void
     */
    public function setAge($age)
    {
        $this->_age = $age;
    }

    /**
     * Sets the character's alcoholic drink preference
     * @param bool $alcoholic  the character's new alcoholic preference
     * @return void
     */
    public function setAlcoholic($alcoholic)
    {
        $this->_alcoholic = $alcoholic;
    }

    /**
     * Sets the character's alignment
     * @param string $alignment     the character's new alignment
     * @return void
     */
    public function setAlignment($alignment)
    {
        $this->_alignment = $alignment;
    }

    /**
     * Sets the character's background
     * @param string $background    the character's new background
     * @return void
     */
    public function setBackground($background)
    {
        $this->_background = $background;
    }

    /**
     * Sets the character's class
     * @param string $class     The character's new class
     * @return void
     */
    public function setClass($class)
    {
        $this->_class = $class;
    }

    /**
     * Sets the characters class image
     * @param string $image     the path of the new image
     */
    public function setImage($image)
    {
        $this->_image = $image;
    }

    /**
     * Sets the name of the character
     * @param string $name   The new name
     * @return void
     */
    public function setName($name)
    {
        $this->_name = $name;
    }

    /**
     * Sets the character's stats
     * @param int[] $stats  the character's new stats
     * @return void
     */
    public function setStats($stats)
    {
        $this->_stats = $stats;
    }

    /**
     * Sets the character's subclass
     * @param string $subclass  the character's new subclass
     * @return void
     */
    public function setSubclass($subclass)
    {
        $this->_subclass = $subclass;
    }

}