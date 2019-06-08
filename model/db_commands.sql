CREATE TABLE drink (
   name VARCHAR(40) PRIMARY KEY NOT NULL,
   glass VARCHAR(20) NOT NULL,
   image VARCHAR(40) DEFAULT 'images/default.jpg',
   recipe TEXT NOT NULL,
   alcoholic TINYINT(1) DEFAULT 1,
   shots DOUBLE DEFAULT 0
);

CREATE TABLE ingredient (
  ing_name VARCHAR(40) PRIMARY KEY,
  type VARCHAR(20) NOT NULL
);

CREATE TABLE drink_ing (
  name VARCHAR(40) NOT NULL,
  ing_name VARCHAR(40) NOT NULL,
  qty VARCHAR(20) NOT NULL,
  PRIMARY KEY (name, ing_name, qty),
  FOREIGN KEY (name) REFERENCES drink(name),
  FOREIGN KEY (ing_name) REFERENCES ingredient(ing_name)
);

CREATE TABLE characteristic (
  trait VARCHAR(40) PRIMARY KEY,
  type VARCHAR(20) NOT NULL
);

CREATE TABLE admin
(
  username VARCHAR(40) PRIMARY KEY,
  password VARCHAR(255) NOT NULL
);


# characteristics to ingredient type map
INSERT INTO characteristic (trait, type) VALUES
('Alchemist', 'sweetener'),
('Archivist', 'gin'),
('Artillerist', 'rum'),
('Battle Smith', 'bitters'),

('Ancestral Guardian', 'pisco'),
('Battlerager', 'liquor'),
('Berserker', 'whiskey'),
('Storm Herald', 'liquor'),
('Totem Warrior', 'vermouth'),
('Zealot', 'tonic'),

('College of Glamour', 'tequila'),
('College of Lore', 'fruit'),
('College of Swords', 'whiskey'),
('College of Valor', 'fruit/juice'),
('College of Whispers', 'fruit/juice'),

('Arcana Domain', 'gin'),
('Death Domain', 'kahlua'),
('Forge Domain', 'liquor'),
('Grave Domain', 'coffee'),
('Knowledge Domain', 'gin'),
('Life Domain', 'milk/cream'),
('Light Domain', 'sweetener'),
('Nature Domain', 'mint'),
('Tempest Domain', 'rum'),
('Trickery Domain', 'sugar'),
('War Domain', 'whiskey'),

('Circle of Dreams', 'vodka'),
('Circle of Spores', 'cognac'),
('Circle of the Land', 'fruit/juice'),
('Circle of the Moon', 'fruit/juice'),
('Circle of the Shepherd', 'fruit/juice'),

('Arcane Archer', 'vermouth'),
('Battle Master', 'gin'),
('Brute', 'vodka'),
('Cavalier', 'sweetener'),
('Champion', 'soft drink'),
('Eldritch Knight', 'gin'),
('Gunslinger', 'whiskey'),
('Purple Dragon Knight', 'pisco'),
('Samurai', 'bitters'),

('Way of the Shadow', 'bitters'),
('Way of the Drunken Master', 'whiskey'),
('Way of the Elements', 'fruit/juice'),
('Way of the Kensei', 'tonic'),
('Way of the Long Death', 'kahlua'),
('Way of the Sun Soul', 'rum'),

('Oath of Conquest', 'rum'),
('Oath of Devotion', 'fruit/juice'),
('Oath of Redemption', 'egg'),
('Oath of the Ancients', 'whiskey'),
('Oath of the Crown', 'gin'),
('Oath of Vengeance', 'fruit/juice'),
('Oathbreaker', 'brandy'),

('Beast Master', 'liquor'),
('Gloom Stalker', 'fruit/juice'),
('Horizon Walker', 'fruit/juice'),
('Hunter', 'soft drink'),
('Monster Slayer', 'sweetener'),

('Arcane Trickster', 'cognac'),
('Assassin', 'bitters'),
('Inquisitive', 'gin'),
('Mastermind', 'cognac'),
('Scout', 'soft drink'),
('Swashbuckler', 'rum'),
('Thief', 'sweetener'),

('Divine Soul', 'soft drink'),
('Draconic Bloodline', 'whiskey'),
('Giant Soul', 'liquor'),
('Shadow Magic', 'egg'),
('Storm Sorcery', 'rum'),
('Wild Magic', 'vodka'),

('The Archfey', 'fruit/juice'),
('The Celestial', 'milk/cream'),
('The Fiend', 'sweetener'),
('The Great Old One', 'vodka'),
('The Hexblade', 'soft drink'),
('The Undying', 'kahlua'),

('School of Abjuration', 'pisco'),
('School of Conjuration', 'soft drink'),
('School of Divination', 'tonic'),
('School of Enchantment', 'gin'),
('School of Evocation', 'tequila'),
('School of Illusion', 'club soda'),
('School of Invention', 'vodka'),
('School of Necromancy', 'kahlua'),
('School of Transmutation', 'liquor'),
('War Magic', 'whiskey'),

('Acolyte', 'milk/cream'),
('Anthropologist', 'fruit/juice'),
('Archaeologist', 'fruit/juice'),
('Charlatan', 'liquor'),
('City Watch / Investigator', 'liquor'),
('Clan Crafter', 'sweetener'),
('Cloistered Scholar', 'liquor'),
('Courtier', 'wine'),
('Criminal / Spy', 'soft drink'),
('Entertainer', 'tequila'),
('Faction Agent', 'wine'),
('Far Traveler', 'fruit/juice'),
('Folk Hero', 'egg'),
('Gladiator', 'whiskey'),
('Guild Artisan/Merchant', 'kahlua'),
('Haunted One', 'vodka'),
('Hermit', 'fruit/juice'),
('Inheritor', 'vermouth'),
('Knight', 'gin'),
('Knight of the Order', 'coffee'),
('Mercenary Veteran', 'whiskey'),
('Noble', 'mint'),
('Outlander', 'liquor'),
('Pirate', 'rum'),
('Sage', 'gin'),
('Sailor', 'rum'),
('Soldier', 'whiskey'),
('Urban Bounty Hunter', 'vodka'),
('Urchin', 'soft drink'),
('Uthgardt Tribe Member', 'fruit/juice'),
('Waterdhavian Noble', 'mint'),

('Strength', 'whiskey'),
('Dexterity', 'liquor'),
('Constitution', 'bitters'),
('Intelligence', 'gin'),
('Wisdom', 'club soda'),
('Charisma', 'vodka'),

('Lawful Good', 'soft drink'),
('Lawful Neutral', 'gin'),
('Lawful Evil', 'vermouth'),
('Neutral Good', 'liquor'),
('Neutral', 'club soda'),
('Neutral Evil', 'bitters'),
('Chaotic Good', 'tequila'),
('Chaotic Neutral', 'rum'),
('Chaotic Evil', 'vodka');

INSERT INTO ingredient(ing_name, type)
VALUES
('7UP', 'soft drink'),
('Amaretto', 'liquor'),
('Angostura Bitters',	'bitters'),
('Bailey\'s',	'liquor'),
('Blue Curacao', 'liquor'),
('Bourbon', 'whiskey'),
('Bourbon or Rye', 'whiskey'),
('Chambord', 'liquor'),
('Citrus Vodka', 'vodka'),
('Club Soda', 'club soda'),
('Cointreau', 'liquor'),
('Coke', 'soft drink'),
('Cranberry Juice', 'fruit/juice'),
('Cream of Coconut', 'fruit/juice'),
('Demerara Syrup', 'sweetener'),
('Drambuie', 'liquor'),
('Dry Vermouth', 'vermouth'),
('Egg White', 'egg'),
('Egg White, beaten', 'egg'),
('Gin', 'gin'),
('Ginger Beer', 'soft drink'),
('Grand Marnier', 'liquor'),
('Grapefruit Jarritos', 'soft drink'),
('Grenadine', 'misc'),
('Heavy Cream', 'milk/cream'),
('Hennessy', 'Cognac'),
('Kahlua', 'liquor'),
('Lemon Juice', 'fruit/juice'),
('Lemonade', 'fruit/juice'),
('Lime Juice', 'fruit/juice'),
('Lime Wedge', 'fruit/juice'),
('Juice', 'fruit/juice'),
('Midori', 'liquor'),
('Milk', 'milk/cream'),
('Mint Leaves', 'mint'),
('Mint', 'mint'),
('Orange Bitters', 'bitters'),
('Orange Curacao', 'liquor'),
('Orange Juice', 'fruit/juice'),
('Orgeat', 'sweetener'),
('Peach Schanpps', 'liquor'),
('Pineapple Juice', 'fruit/juice'),
('Pisco Quebranta', 'pisco'),
('Rum', 'rum'),
('Salt', 'misc'),
('Scotch', 'whiskey'),
('Simple Syrup', 'sweetener'),
('Sloe Gin', 'gin'),
('Southern Comfort', 'liquor'),
('Sweet and Sour', 'fruit/juice'),
('Sweet Vermouth', 'vermouth'),
('Tequila', 'tequila'),
('Tequila blanca', 'tequila'),
('Tonic', 'tonic'),
('Triple Sec', 'liquor'),
('Vodka', 'vodka');

INSERT INTO drink (name, glass, recipe, alcoholic)
VALUES
('Glass of Milk', 'Highball',
 'Pour desired amount of milk into glass.', 0),
('Shirley Temple', 'Collins',
 'Fill a Collins glass with ice and add the grenadine.
 Fill with 7UP.
 Stir, and garnish with a maraschino cherry and lemon wedge.', 0),
('Coca Cola', 'Highball',
 'Pour desired amount of Coca Cola over ice.', 0),
('Agua con Gas', 'Highball',
 'Not for the faint of heart...actually that\'s exactly who it\'s for.', 0);


INSERT INTO drink (name, glass, recipe, shots)
VALUES
('Mojito', 'Collins',
 'Lightly muddle the mint in a shaker.
Add the rum, lime juice, simple syrup and ice and give it a brief shake.
Strain into a highball glass. Top with the club soda. Garnish with a mint sprig.', 1.33),
('Long Island Iced Tea', 'Highball',
 'Add all ingredients except the cola into a Collins glass with ice.
Top with a splash of the cola and stir briefly.
Garnish with a lemon wedge.
Serve with a straw.', 2.5),
('Cosmopolitan', 'Cocktail',
 'Add all ingredients into a shaker with ice and shake.
Strain into a chilled cocktail glass.
Garnish with a lime wheel.', 1.67),
('Margarita', 'Margarita',
 'Salt half the rim of the glass and set aside (optional).
Add all ingredients into a shaker with ice and shake vigorously.
Strain into the prepared glass over fresh ice.
Garnish with a lime wedge.', 1.67),
('Amaretto Sour', 'Lowball',
 'Add all ingredients to a shaker and dry shake to combine.
Add fresh ice to the shaker and shake again until chilled.
Strain over fresh ice into an Old Fashioned glass.
Garnish with lemon peel and brandied cherries, if desired.', 1.5),
('Vodka Lemonade', 'Highball',
 'Pour Vodka over ice and add Lemonade to taste.', 1.33),
('Tequila Lemonade', 'Highball',
 'Pour Tequila over ice and add Lemonade to taste.', 1.33),
('AMF', 'Highball',
 'Pour all ingredients (except soda) into the chilled glass with ice cubes.
Top it with clear soda.
Stir gently.', 1.67),
('Mai Tai', 'Lowball',
 'Add all ingredients into a shaker with crushed ice.
Shake vigorously until the shaker is well-chilled and frosty on the outside.
Pour (unstrained) into a double Old Fashioned glass.
Garnish with the rind of half of a juiced lime and a fresh mint sprig.', 1.67),
('Sex on the Beach', 'Highball',
 'Add all the ingredients into a shaker with ice and shake.
Strain into a highball glass over fresh ice.
Garnish with a cocktail umbrella.', 1.33),
('Alabama Slammer', 'Highball',
 'Add all the ingredients into a shaker with ice and shake.
Strain into a highball glass over fresh ice.
Garnish with an orange wheel and a cherry, and serve with a straw.', 2),
('B52', 'Shotglass',
 'Layer the three spirits in a shot glass in the order they\'re listed.', 0.67),
('Tequila Sunrise', 'Highball',
 'Add the tequila and then the orange juice to a chilled highball glass.
Float the grenadine on top.
Garnish with an orange slice and a cherry.', 1.33),
('Screwdriver', 'Highball',
 'Add the vodka into a highball glass over ice.
Top with the orange juice.', 1.33),
('Manhattan', 'Cocktail',
 'Add all the ingredients into a mixing glass with ice, and stir until well-chilled.
Strain into a chilled coupe.
Garnish with a brandied cherry.', 1.5),
('Pina Colada', 'Hurricane',
 'Add all ingredients into a shaker with ice and shake vigorously (20-30 seconds).
Strain into a chilled Hurricane glass over pebble ice.
Garnish with a pineapple wedge and pineapple leaf.', 1.33),
('Lemon Drop', 'Cocktail',
 'Coat the rim of a cocktail glass with sugar and set aside
 (do this a few minutes ahead of time so the sugar can dry and adhere well to the glass).
Add all the ingredients into a shaker with ice and shake.
Strain into the prepared glass.', 1.67),
('Rusty Nail', 'Lowball',
 'Add all ingredients into a rocks glass with ice and stir.', 1.5),
('Vodka Martini', 'Cocktail',
 'Add both ingredients to a Martini glass.
Garnish with a lemon twist or olives.', 1),
('Gin Martini', 'Cocktail',
 'Add all the ingredients to a mixing glass and fill with ice.
Stir, and strain into a cocktail glass.
Garnish with a lemon twist.', 1.75),
('White Russian', 'Lowball',
 'Add the vodka and Kahlúa to an Old Fashioned glass with ice.
Top with a large splash of heavy cream and stir.', 2),
('Black Russian', 'Lowball',
 'Add all the ingredients into a mixing glass with ice and stir.
Strain into an Old Fashioned glass over fresh ice.', 2),
('Tom Collins', 'Collins',
 'Add the lemon juice, simple syrup and gin into a shaker with ice and shake well.
Strain into a Collins glass over fresh ice.
Top with club soda.
Garnish with a lemon wheel and cherry.
Serve with a straw.', 1),
('Daiquiri', 'Coupe',
 'Add all the ingredients into a shaker with ice and shake.
Strain into a coupe glass.
Garnish with a lime wheel.', 1.33),
('Kentucky Mule', 'Mug',
 'Add the bourbon and lime juice to a Moscow Mule mug or a highball glass.
Fill the mug or glass with ice and top with ginger beer.
Add mint sprigs for garnish.', 1.33),
('Moscow Mule', 'Mug',
 'Add the bourbon and lime juice to a Moscow Mule mug or a highball glass.
Fill the mug or glass with ice and top with ginger beer.
Add mint sprigs for garnish.', 1.33),
('Mexican Mule', 'Mug',
 'Add the bourbon and lime juice to a Moscow Mule mug or a highball glass.
Fill the mug or glass with ice and top with ginger beer.
Add mint sprigs for garnish.', 1.33),
('Old Fashioned', 'Lowball',
 'Add all ingredients into a mixing glass with ice and stir.
Strain into an Old Fashioned glass over fresh ice.
Express the oil of an orange peel over glass and garnish with the peel.', 1.33),
('Gin & Tonic', 'Lowball',
 'Fill a double rocks glass with ice.
Add the gin and fill with tonic.
Garnish with a lime wedge.', 1.33),
('Gin & Juice', 'Collins',
 'Fill a Collins glass with ice and add the gin.
Fill with the juice and stir.', 1),
('Gin Fizz', 'Collins',
 'Add all but club soda to a shaker and dry-shake (without ice) for about 10 seconds.
Add 3 or 4 ice cubes and shake very well.
Double-strain into a chilled fizz glass and top with club soda.', 1.33),
('Pisco Sour', 'Coupe',
 'Combine all but bitters in a shaker.
Dry shake for 15 seconds, then add ice and shake again to chill.
Double strain into a chilled coupe glass.
Dot the top with drops of Angostura bitters.', 1.33),
('Gimlet', 'Lowball',
 'Add all ingredients into a shaker with ice and shake.
Strain into a chilled cocktail glass or an Old Fashioned glass filled with fresh ice.
Garnish with a lime wheel.
(You can substitute 1 oz lime cordial, such as Rose\'s lime juice, for both the lime juice and simple syrup.).', 1.67),
('Sidecar', 'Coupe',
 'Rim a coupe glass in sugar.
Add all the ingredients to a shaker with ice and shake.
Strain into the coupe glass.
Garnish with a lemon twist.', 1.33),
('Paloma', 'Highball',
 'Add the tequila, lime juice and salt into a highball glass over ice.
Top off with the grapefruit soda and stir.
Garnish with a lime wheel.', 1.33),
('Cuba Libre', 'Lowball',
 'Add all the ingredients to a highball glass filled with ice.
Squeeze the lime wedge into the glass;
Garnish with a lime wedge.', 1.33),
('Mint Julep', 'Julep',
 'Express the essential oils in the mint and rub them inside the glass.
To the same glass, add simple syrup, bourbon, and crushed ice.
Stir.
Garnish with more ice and fresh mint.', 1.33),
('Midori Sour', 'Collins',
 'Add all ingredients except the soda water into a Collins glass over ice and stir.
Top with the soda water.
Garnish with a lemon wheel.', 1.33);

INSERT INTO drink_ing (name, qty, ing_name)
VALUES
('Glass of Milk', 'Fill', 'Milk'),
('Shirley Temple', '1/4oz', 'Grenadine'),
('Shirley Temple', 'Fill', '7UP'),
('Coca Cola', 'Fill', 'Coke'),
('Agua con Gas', 'Fill', 'Club Soda'),
('Mojito', '2oz', 'Rum'),
('Mojito', '3/4oz', 'Lime Juice'),
('Mojito', '1/2oz', 'Simple Syrup'),
('Mojito', '3', 'Mint Leaves'),
('Mojito', 'Fill', 'Club Soda'),
('Long Island Iced Tea', '3/4oz', 'Vodka'),
('Long Island Iced Tea', '3/4oz', 'Rum'),
('Long Island Iced Tea', '3/4oz', 'Gin'),
('Long Island Iced Tea', '3/4oz', 'Tequila'),
('Long Island Iced Tea', '3/4oz', 'Triple Sec'),
('Long Island Iced Tea', '3/4oz', 'Simple Syrup'),
('Long Island Iced Tea', '3/4oz', 'Lemon Juice'),
('Long Island Iced Tea', 'Splash', 'Coke'),
('Cosmopolitan', '1.5oz', 'Citrus Vodka'),
('Cosmopolitan', '1oz', 'Cointreau'),
('Cosmopolitan', '1 dash', 'Cranberry Juice'),
('Cosmopolitan', '1/2oz', 'Lime Juice'),
('Margarita', '1.5oz', 'Tequila'),
('Margarita', '1oz', 'Triple Sec'),
('Margarita', '3/4oz', 'Lime Juice'),
('Margarita', '1/4oz', 'Simple Syrup'),
('Amaretto Sour', '1.5oz', 'Amaretto'),
('Amaretto Sour', '3/4oz', 'Bourbon'),
('Amaretto Sour', '1oz', 'Lemon Juice'),
('Amaretto Sour', '1 tsp', 'Simple Syrup'),
('Amaretto Sour', '1/2oz', 'Egg White, beaten'),
('Vodka Lemonade', '2oz', 'Vodka'),
('Vodka Lemonade', 'Fill', 'Lemonade'),
('Tequila Lemonade', '2oz', 'Tequila'),
('Tequila Lemonade', 'Fill', 'Lemonade'),
('AMF', '1/2oz', 'Vodka'),
('AMF', '1/2oz', 'Rum'),
('AMF', '1/2oz', 'Tequila'),
('AMF', '1/2oz', 'Gin'),
('AMF', '1/2oz', 'Blue Curacao'),
('AMF', '2oz', 'Sweet and Sour'),
('AMF', 'Splash', 'Club Soda'),
('Mai Tai', '2oz', 'Rum'),
('Mai Tai', '1/2oz', 'Orange Curacao'),
('Mai Tai', '3/4oz', 'Lime Juice'),
('Mai Tai', '1/4oz', 'Orgeat'),
('Mai Tai', '1/4oz', 'Simple Syrup'),
('Sex on the Beach', '1.5oz', 'Vodka'),
('Sex on the Beach', '1/2oz', 'Peach Schnapps'),
('Sex on the Beach', '1.5oz', 'Pineapple Juice'),
('Sex on the Beach', '1.5oz', 'Cranberry Juice'),
('Sex on the Beach', '1/2oz', 'Chambord'),
('Alabama Slammer', '1oz', 'Southern Comfort'),
('Alabama Slammer', '1oz', 'Sloe Gin'),
('Alabama Slammer', '1oz', 'Amaretto'),
('Alabama Slammer', '2oz', 'Orange Juice'),
('B52', '1/3oz', 'Kahlua'),
('B52', '1/3oz', 'Bailey\'s'),
('B52', '1/3oz', 'Grand Marnier'),
('Tequila Sunrise', '2oz', 'Tequila Blanca'),
('Tequila Sunrise', '4oz', 'Orange Juice'),
('Tequila Sunrise', '1/4oz', 'Grenadine'),('Screwdriver', '2oz', 'Vodka'),
('Screwdriver', 'Fill', 'Orange Juice'),('Manhattan', '2oz', 'Bourbon or Rye'),
('Manhattan', '1oz', 'Sweet Vermouth'),
('Manhattan', '2 dashes', 'Angostura Bitters'),
('Manhattan', '1 dash', 'Orange Bitters'),('Pina Colada', '2oz', 'Rum'),
('Pina Colada', '1.5oz', 'Cream of Coconut'),
('Pina Colada', '1.5oz', 'Pineapple Juice'),
('Pina Colada', '1.5oz', 'Lime Juice'),
('Lemon Drop', '2oz', 'Vodka'),
('Lemon Drop', '1/2oz', 'Triple Sec'),
('Lemon Drop', '1oz', 'Simple Syrup'),
('Lemon Drop', '1oz', 'Lemon Juice'),
('Rusty Nail', '1.5oz', 'Scotch'),
('Rusty Nail', '3/4oz', 'Drambuie'),
('Vodka Martini', '1.5oz', 'Vodka'),
('Vodka Martini', '1/2oz', 'Dry Vermouth'),('Gin Martini', '2 1/4 oz', 'Gin'),
('Gin Martini', '3/4oz', 'Dry Vermouth'),
('Gin Martini', '1 dash', 'Orange Bitters'),
('White Russian', '2oz', 'Vodka'),
('White Russian', '1oz', 'Kahlua'),
('White Russian', 'Fill', 'Heavy Cream'),
('Black Russian', '2oz', 'Vodka'),
('Black Russian', '1oz', 'Kahlua'),
('Tom Collins', '1.5oz', 'Gin'),
('Tom Collins', '3/4oz', 'Lemon Juice'),
('Tom Collins', '3/4oz', 'Simple Syrup'),
('Tom Collins', 'Fill', 'Club Soda'),
('Daiquiri', '2oz', 'Rum'),
('Daiquiri', '1oz', 'Lime Juice'),
('Daiquiri', '3/4oz', 'Simple Syrup'),
('Kentucky Mule', '2oz', 'Bourbon'),
('Kentucky Mule', '1/2oz', 'Lime Juice'),
('Kentucky Mule', 'Fill', 'Ginger Beer'),
('Moscow Mule', '2oz', 'Vodka'),
('Moscow Mule', '1/2oz', 'Lime Juice'),
('Moscow Mule', 'Fill', 'Ginger Beer'),
('Mexican Mule', '2oz', 'Tequila'),
('Mexican Mule', '1/2oz', 'Lime Juice'),
('Mexican Mule', 'Fill', 'Ginger Beer'),
('Old Fashioned', '2oz', 'Bourbon'),
('Old Fashioned', '2 dashes', 'Angostura Bitters'),
('Old Fashioned', '1/4 oz', 'Simple Syrup'),
('Gin & Tonic', '2oz', 'Gin'),
('Gin & Tonic', 'Fill', 'Tonic'),
('Gin & Juice', '1.5oz', 'Gin'),
('Gin & Juice', 'Fill', 'Juice'),
('Gin Fizz', '2oz', 'Gin'),
('Gin Fizz', '1oz', 'Lemon Juice'),
('Gin Fizz', '3/4oz', 'Simple Syrup'),
('Gin Fizz', '1', 'Egg White'),
('Gin Fizz', '1oz', 'Club Soda'),
('Pisco Sour', '2oz', 'Pisco Quebranta'),
('Pisco Sour', '1/2oz', 'Lime Juice'),
('Pisco Sour', '1/2oz', 'Lemon Juice'),
('Pisco Sour', '1oz', 'Simple Syrup'),
('Pisco Sour', '6 drops', 'Angostura Bitters'),
('Gimlet', '2.5oz', 'Gin'),
('Gimlet', '1/2oz', 'Lime Juice'),
('Gimlet', '1/2oz', 'Simple Syrup'),
('Sidecar', '1.5oz', 'Hennessy'),
('Sidecar', '1/2oz', 'Cointreau'),
('Sidecar', '1/4oz', 'Lemon Juice'),
('Sidecar', '1.4oz', 'Demerara Syrup'),
('Paloma', '2oz', 'Tequila'),
('Paloma', '1/2oz', 'Lime Juice'),
('Paloma', 'pinch', 'Salt'),
('Paloma', 'Fill', 'Grapefruit Jarritos'),
('Cuba Libre', '2oz', 'Rum'),
('Cuba Libre', '6oz', 'Coke'),
('Cuba Libre', '1', 'Lime Wedge'),
('Cuba Libre', '5 dashes', 'Angostura Bitters'),
('Mint Julep', '2oz', 'Bourbon'),
('Mint Julep', '1/2oz', 'Simple Syrup'),
('Mint Julep', '3 leaves', 'Mint'),
('Midori Sour', '1oz', 'Midori'),
('Midori Sour', '1oz', 'Rum'),
('Midori Sour', '1/2oz', 'Lemon Juice'),
('Midori Sour', '1/2oz', 'Lime Juice'),
('Midori Sour', 'Fill', 'Club Soda');
