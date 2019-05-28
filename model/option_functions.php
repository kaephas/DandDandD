<?php
/**
 * Created by PhpStorm.
 * User: Kaephas
 * Date: 5/18/2019
 * Time: 10:03
 */

// Create list of stats
function generateStats()
{
    $stats = array();
    $stats[] = 'Strength';
    $stats[] = 'Dexterity';
    $stats[] = 'Constitution';
    $stats[] = 'Intelligence';
    $stats[] = 'Wisdom';
    $stats[] = 'Charisma';

    return $stats;
}

// Create list of classes
function generateClasses()
{
    $classes = array();
    $classes[] = "Artificer";
    $classes[] = "Barbarian";
    $classes[] = "Bard";
    $classes[] = "Cleric";
    $classes[] = "Druid";
    $classes[] = "Fighter";
    $classes[] = "Monk";
    $classes[] = "Paladin";
    $classes[] = "Ranger";
    $classes[] = "Rogue";
    $classes[] = "Sorcerer";
    $classes[] = "Warlock";
    $classes[] = "Wizard";

    return $classes;
}

// Create list of subclasses
function generateSubClasses()
{
    $subClass = array();
    $subClass['Artificer'] =
        array('Alchemist', 'Archivist', 'Artillerist', 'Battle Smith');
    $subClass['Barbarian'] =
        array('Ancestral Guardian', 'Battlerager', 'Berserker', 'Storm Herald', 'Totem Warrior', 'Zealot');
    $subClass['Bard'] =
        array('College of Glamour', 'College of Lore', 'College of Swords', 'College of Valor', 'College of Whispers');
    $subClass['Cleric'] =
        array('Arcana Domain', 'Death Domain', 'Forge Domain', 'Grave Domain', 'Knowledge Domain', 'Life Domain',
            'Light Domain', 'Nature Domain', 'Order Domain', 'Tempest Domain', 'Trickery Domain', 'War Domain');
    $subClass['Druid'] =
        array('Circle of Dreams', 'Circle of Spores', 'Circle of the Land', 'Circle of the Moon',
            'Circle of the Shepherd');
    $subClass['Fighter'] =
        array('Arcane Archer', 'Battle Master', 'Brute', 'Cavalier', 'Champion', 'Eldritch Knight', 'Gunslinger',
            'Purple Dragon Knight', 'Samurai');
    $subClass['Monk'] =
        array('Way of the Shadow', 'Way of the Drunken Master', 'Way of the Four Elements', 'Way of the Kensei',
            'Way of the Long Death', 'Way of the Sun Soul');
    $subClass['Paladin'] =
        array('Oath of Conquest', 'Oath of Devotion', 'Oath of Redemption', 'Oath of the Ancients', 'Oath of the Crown',
            'Oath of Vengeance', 'Oathbreaker');
    $subClass['Ranger'] =
        array('Beast Master', 'Gloom Stalker', 'Horizon Walker', 'Hunter', 'Monster Slayer');
    $subClass['Rogue'] =
        array('Arcane Trickster', 'Assassin', 'Inquisitive', 'Mastermind', 'Scout', 'Swashbuckler', 'Scout', 'Thief');
    $subClass['Sorcerer'] =
        array('Divine Soul', 'Draconic Bloodline', 'Giant Soul', 'Shadow Magic', 'Storm Sorcery', 'Wild Magic');
    $subClass['Warlock'] =
        array('The Archfey', 'The Celestial', 'The Fiend', 'The Great Old One', 'The Hexblade', 'The Undying');
    $subClass['Wizard'] =
        array('School of Abjuration', 'School of Conjuration', 'School of Divination', 'School of Enchantment',
            'School of Evocation', 'School of Illusion', 'School of Invention', 'School of Necromancy',
            'School of Transmutation', 'War Magic');

    return $subClass;
}

// Create list of alignments
function generateAlignments()
{
    $alignments = array();
    $alignments[] = 'Lawful Good';
    $alignments[] = 'Lawful Neutral';
    $alignments[] = 'Lawful Evil';
    $alignments[] = 'Neutral Good';
    $alignments[] = 'Neutral';
    $alignments[] = 'Neutral Evil';
    $alignments[] = 'Chaotic Good';
    $alignments[] = 'Chaotic Neutral';
    $alignments[] = 'Chaotic Evil';

    return $alignments;
}

// list of backgrounds
function generateBackgrounds()
{
    $backgrounds = array();
    $backgrounds[] = 'Acolyte';
    $backgrounds[] = 'Anthropologist';
    $backgrounds[] = 'Archaeologist';
    $backgrounds[] = 'Charlatan';
    $backgrounds[] = 'City Watch / Investigator';
    $backgrounds[] = 'Clan Crafter';
    $backgrounds[] = 'Cloistered Scholar';
    $backgrounds[] = 'Courtier';
    $backgrounds[] = 'Criminal / Spy';
    $backgrounds[] = 'Entertainer';
    $backgrounds[] = 'Faction Agent';
    $backgrounds[] = 'Far Traveler';
    $backgrounds[] = 'Folk Hero';
    $backgrounds[] = 'Gladiator';
    $backgrounds[] = 'Guild Artisan / Guild Merchant';
    $backgrounds[] = 'Haunted One';
    $backgrounds[] = 'Hermit';
    $backgrounds[] = 'Inheritor';
    $backgrounds[] = 'Knight';
    $backgrounds[] = 'Knight of the Order';
    $backgrounds[] = 'Mercenary Veteran';
    $backgrounds[] = 'Noble';
    $backgrounds[] = 'Outlander';
    $backgrounds[] = 'Pirate';
    $backgrounds[] = 'Sage';
    $backgrounds[] = 'Sailor';
    $backgrounds[] = 'Soldier';
    $backgrounds[] = 'Urban Bounty Hunter';
    $backgrounds[] = 'Urchin';
    $backgrounds[] = 'Uthgardt Tribe Member';
    $backgrounds[] = 'Waterdhavian Noble';

    return $backgrounds;
}

// Glasses
function generateGlasses() {
    $glasses = array('Cocktail', 'Highball', 'Collins', 'Lowball', 'Mug', 'Margarita',
                        'Hurricane', 'Shotglass', 'Coupe', 'Pint', 'Julep'
    );

    return $glasses;
}

// List of Ingredient Types
function generateIngTypes() {
    $categories = array(
        'cognac', 'gin', 'pisco', 'rum', 'tequila', 'vodka', 'whiskey', 'bitters', 'club soda', 'egg', 'fruit/juice',
        'liquor', 'milk/cream', 'mint', 'soft drink', 'sweetener', 'tonic', 'vermouth', 'misc'
    );

    return $categories;
}