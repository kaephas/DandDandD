/*
 * Kaephas & Zane
 * 5-26-2019
 * getSubclasses.js
 *
 * generates a subclasses select list based on current classes option
 */

// store subclasses array (Still validate with php)

let subclasses = [];
subclasses['Artificer'] =
    ['Alchemist', 'Archivist', 'Artillerist', 'Battle Smith'];
subclasses['Barbarian'] =
    ['Ancestral Guardian', 'Battlerager', 'Berserker', 'Storm Herald', 'Totem Warrior', 'Zealot'];
subclasses['Bard'] =
    ['College of Glamour', 'College of Lore', 'College of Swords', 'College of Valor', 'College of Whispers'];
subclasses['Cleric'] =
    ['Arcana Domain', 'Death Domain', 'Forge Domain', 'Grave Domain', 'Knowledge Domain', 'Life Domain',
        'Light Domain', 'Nature Domain', 'Order Domain', 'Tempest Domain', 'Trickery Domain', 'War Domain'];
subclasses['Druid'] =
    ['Circle of Dreams', 'Circle of Spores', 'Circle of the Land', 'Circle of the Moon',
        'Circle of the Shepherd'];
subclasses['Fighter'] =
    ['Arcane Archer', 'Battle Master', 'Brute', 'Cavalier', 'Champion', 'Eldritch Knight', 'Gunslinger',
        'Purple Dragon Knight', 'Samurai'];
subclasses['Monk'] =
    ['Way of the Shadow', 'Way of the Drunken Master', 'Way of the Four Elements', 'Way of the Kensei',
        'Way of the Long Death', 'Way of the Sun Soul'];
subclasses['Paladin'] =
    ['Oath of Conquest', 'Oath of Devotion', 'Oath of Redemption', 'Oath of the Ancients', 'Oath of the Crown',
        'Oath of Vengeance', 'Oathbreaker'];
subclasses['Ranger'] =
    ['Beast Master', 'Gloom Stalker', 'Horizon Walker', 'Hunter', 'Monster Slayer'];
subclasses['Rogue'] =
    ['Arcane Trickster', 'Assassin', 'Inquisitive', 'Mastermind', 'Scout', 'Swashbuckler', 'Scout', 'Thief'];
subclasses['Sorcerer'] =
    ['Divine Soul', 'Draconic Bloodline', 'Giant Soul', 'Shadow Magic', 'Storm Sorcery', 'Wild Magic'];
subclasses['Warlock'] =
    ['The Archfey', 'The Celestial', 'The Fiend', 'The Great Old One', 'The Hexblade', 'The Undying'];
subclasses['Wizard'] =
    ['School of Abjuration', 'School of Conjuration', 'School of Divination', 'School of Enchantment',
        'School of Evocation', 'School of Illusion', 'School of Invention', 'School of Necromancy',
        'School of Transmutation', 'War Magic'];


$('#class').change(function() {
    let charClass = $(this).children("option:selected").val();
    console.log(charClass);

    // change option box
    let box = $('#sub');
    box.html(generateSubs(charClass));

    // change image
    let image = $('#classImg');
    let file = "images/" + charClass.toLowerCase() + ".jpg";
    image.prop('src', file);

});

function generateSubs(className) {
    let output = "";
    for(let sub of subclasses[className]) {
        output += '<option value="' + sub + '">' + sub + '</option>';
    }
    return output;
}

