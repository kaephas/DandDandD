CREATE TABLE drink (
  name VARCHAR(40) PRIMARY KEY NOT NULL,
  glass VARCHAR(20) NOT NULL,
  image VARCHAR(40) DEFAULT 'images/default.jpg',
  recipe TEXT NOT NULL,
  alcoholic TINYINT(1) DEFAULT 1
);

CREATE TABLE ingredient (
  ing_name VARCHAR(40) PRIMARY KEY,
  type VARCHAR(20) NOT NULL
);

CREATE TABLE drink_ing (
  ing_ID INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(40),
  ing_name VARCHAR(40) NOT NULL,
  qty VARCHAR(20) NOT NULL
);

CREATE TABLE characteristic (
  trait VARCHAR(40) PRIMARY KEY,
  type VARCHAR(20) NOT NULL
);

# characteristics to ingredient type map
INSERT INTO characteristic (trait, type) VALUES
  ('Alchemist', 'sweetener'),
  ('Archivist', 'gin'),
  ('Artillerist', 'rum'),
  ('Battle Smith', 'bitters'),

  ('Ancestral', 'pisco'),
  ('Battlerager', 'liquor'),
  ('Berserker', 'whiskey'),
  ('Storm Herald', 'liquor'),
  ('Totem Warrior', 'vermouth'),
  ('Zealot', 'tonic'),

  ('Glamour', 'tequila'),
  ('Lore', 'fruit'),
  ('Swords', 'whiskey'),
  ('Valor', 'fruit'),
  ('Whispers', 'fruit'),

  ('Arcana', 'gin'),
  ('Death', 'kahlua'),
  ('Forge', 'liquor'),
  ('Grave', 'coffee'),
  ('Knowledge', 'gin'),
  ('Life', 'milk/cream'),
  ('Light', 'sweetener'),
  ('Nature', 'mint'),
  ('Tempest', 'rum'),
  ('Trickery', 'sugar'),
  ('War', 'whiskey'),

  ('Dreams', 'vodka'),
  ('Spores', 'cognac'),
  ('Land', 'fruit'),
  ('Moon', 'fruit'),
  ('Shepherd', 'fruit'),

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
  ('Way of the Elements', 'fruit'),
  ('Way of the Kensei', 'tonic'),
  ('Way of the Long Death', 'kahlua'),
  ('Way of the Sun Soul', 'rum'),

  ('Conquest', 'rum'),
  ('Devotion', 'fruit'),
  ('Redemption', 'egg'),
  ('Ancients', 'whiskey'),
  ('Crown', 'gin'),
  ('Vengeance', 'fruit'),
  ('Oathbreaker', 'brandy'),

  ('Beast Master', 'liquor'),
  ('Gloom Stalker', 'fruit'),
  ('Horizon Walker', 'fruit'),
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
  ('Draconic', 'whiskey'),
  ('Giant', 'liquor'),
  ('Shadow', 'egg'),
  ('Storm', 'rum'),
  ('Wild', 'vodka'),

  ('Archfey', 'fruit'),
  ('Celestial', 'milk/cream'),
  ('Fiend', 'sweetener'),
  ('Old One', 'vodka'),
  ('Hexblade', 'soft drink'),
  ('Undying', 'kahlua'),

  ('Abjuration', 'pisco'),
  ('Conjuration', 'soft drink'),
  ('Divination', 'tonic'),
  ('Enchantment', 'gin'),
  ('Evocation', 'tequila'),
  ('Illusion', 'club soda'),
  ('Invention', 'vodka'),
  ('Necromancy', 'kahlua'),
  ('Transmutation', 'liquor'),
  ('War Magic', 'whiskey'),

  ('Acolyte', 'milk/cream'),
  ('Anthropologist', 'fruit'),
  ('Archaeologist', 'fruit'),
  ('Charlatan', 'liquor'),
  ('City Watch / Investigator', 'liquor'),
  ('Clan Crafter', 'sweetener'),
  ('Cloistered Scholar', 'liquor'),
  ('Courtier', 'wine'),
  ('Criminal / Spy', 'soft drink'),
  ('Entertainer', 'tequila'),
  ('Faction Agent', 'wine'),
  ('Far Traveler', 'coconut'),
  ('Folk Hero', 'egg'),
  ('Gladiator', 'whiskey'),
  ('Guild Artisan/Merchant', 'kahlua'),
  ('Haunted One', 'vodka'),
  ('Hermit', 'fruit'),
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
  ('Urchin', 'chocolate'),
  ('Uthgardt Tribe Member', 'fruit'),
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
('Midori', 'liquor'),
('Milk', 'milk/cream'),
('Mint Leaves', 'mint'),
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
 'Fill a Collins glass with ince and add the greandine.
 Fill with 7UP.
 Stir, and garnish with a maraschino cherry and lemon wedge.', 0),
('Coca Cola', 'Highball',
 'Pour desired amount of Coca Cola over ice.', 0),
('Glass of water', 'Highball',
 'Not for the faint of heart...actually that\'s exactly who it\'s for.', 0);

INSERT INTO drink (name, glass, recipe)
VALUES
('Mojito', 'Collins',
 'Lightly muddle the mint in a shaker.
 Add the rum, lime juice, simple syrup and ice and give it a brief shake.
 Strain into a highball glass. Top with the club soda. Garnish with a mint sprig.'),
('Long Island Iced Tea', 'Highball',
 'Add all ingredients except the cola into a Collins glass with ice.
Top with a splash of the cola and stir briefly.
Garnish with a lemon wedge.
Serve with a straw.'),
('Cosmopolitan', 'Cocktail',
 'Add all ingredients into a shaker with ice and shake.
 Strain into a chilled cocktail glass.
 Garnish with a lime wheel.'),
('Margarita', 'Margarita',
 'Salt half the rim of the glass and set aside (optional).
 Add all ingredients into a shaker with ice and shake vigorously.
 Strain into the prepared glass over fresh ice.
 Garnish with a lime wedge.'),
('Amaretto Sour', 'Lowball',
 'Add all ingredients to a shaker and dry shake to combine.
 Add fresh ice to the shaker and shake again until chilled.
 Strain over fresh ice into an Old Fashioned glass.
 Garnish with lemon peel and brandied cherries, if desired.'),
('Vodka Lemonade', 'Highball',
 'Pour Vodka over ice and add Lemonade to taste.'),
('Tequila Lemonade', 'Highball',
 'Pour Tequila over ice and add Lemonade to taste.'),
('Adios ***', 'Highball',
 'Pour all ingredients (except soda) into the chilled glass with ice cubes.
 Top it with clear soda.
 Stir gently.'),
('Mai Tai', 'Lowball',
 'Add all ingredients into a shaker with crushed ice and shake vigorously until the shaker is well-chilled and frosty on the outside.
 Pour (unstrained) into a double Old Fashioned glass.
 Garnish with the rind of half of a juiced lime and a fresh mint sprig.'),
('Sex on the Beach', 'Highball',
 'Add all the ingredients into a shaker with ice and shake.
 Strain into a highball glass over fresh ice.
 Garnish with a cocktail umbrella.'),
('Alabama Slammer', 'Highball',
 'Add all the ingredients into a shaker with ice and shake.
 Strain into a highball glass over fresh ice.
 Garnish with an orange wheel and a cherry, and serve with a straw.');


INSERT INTO drink_ing (name, qty, ing_name)
VALUES
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
('Adios ***', '1/2oz', 'Vodka'),
('Adios ***', '1/2oz', 'Rum'),
('Adios ***', '1/2oz', 'Tequila'),
('Adios ***', '1/2oz', 'Gin'),
('Adios ***', '1/2oz', 'Blue Curacao'),
('Adios ***', '2oz', 'Sweet and Sour'),
('Adios ***', 'Splash', 'Club Soda'),
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
('Glass of Milk', 'Fill', 'Milk'),
('Shirley Temple', '1/4oz', 'Grenadine'),
('Shirley Temple', 'Fill', '7UP'),
('Coca Cola', 'Fill', 'Coke'),
('Agua con Gas', 'Fill', 'Club Soda');



B52	1/3oz Kahlua "1/3oz Bailey's" 1/3oz Grand Marnier Shotglass
"Layer the three spirits in a shot glass in the order they're listed."

Tequila Sunrise	2oz Tequila Blanca 4oz Orange Juice 1/4oz Grenadine Highball
"Add the tequila and then the orange juice to a chilled highball glass.
Float the grenadine on top.
Garnish with an orange slice and a cherry."

Screwdiver	2oz Vodka	Fill Orange Juice  Highball
"Add the vodka into a highball glass over ice.
Top with the orange juice."

Manhattan	2oz Bourbon or Rye	1oz Sweet Vermouth	2 dashes Angostura Bitters 1 dash Orange Bitters  Cocktail
"Add all the ingredients into a mixing glass with ice, and stir until well-chilled.
Strain into a chilled coupe.
Garnish with a brandied cherry."

Pina Colada	2oz Rum	1.5oz Cream of Coconut	1.5oz Pineapple Juice	1.2oz Lime Juice  Hurricane
"Add all ingredients into a shaker with ice and shake vigorously (20-30 seconds).
Strain into a chilled Hurricane glass over pebble ice.
Garnish with a pineapple wedge and pineapple leaf."

Lemon Drop 2oz Vodka	1/2oz Triple Sec	1oz Simple Syrup 1oz Lemon Juice   Cocktail
"Coat the rim of a cocktail glass with sugar and set aside (do this a few minutes ahead of time so the sugar can dry and adhere well to the glass).
Add all the ingredients into a shaker with ice and shake.
Strain into the prepared glass."

Rusty Nail	1.5oz Scotch	3/4oz Drambuie(liq) Lowball
"Add all ingredients into a rocks glass with ice and stir."

Vodka Martini	1.5oz Vodka	1/2oz Dry Vermouth  Cocktail
"Add both ingredients to a Martini glass.
Garnish with a lemon twist or olives."

Gin Martini	2 1/4 oz Gin 3/4oz Dry Vermouth 1 dash Orange Bitters Cocktail
"Add all the ingredients to a mixing glass and fill with ice.
Stir, and strain into a cocktail glass.
Garnish with a lemon twist."

White Russian	2oz Vodka	1oz Kahlua	Fill Heavy Cream   Lowball
"Add the vodka and Kahlúa to an Old Fashioned glass with ice.
Top with a large splash of heavy cream and stir."

Black Russian	2oz Vodka 1oz Kahlua    Lowball
"Add all the ingredients into a mixing glass with ice and stir.
Strain into an Old Fashioned glass over fresh ice."

Tom Collins	1.5oz Gin 3/4oz Lemon Juice 3/4oz Simple Syrup Fill Club Soda	(highball glass)
"Add the lemon juice, simple syrup and gin into a shaker with ice and shake well.
Strain into a Collins glass over fresh ice.
Top with club soda.
Garnish with a lemon wheel and cherry.
Serve with a straw."

Daiquiri	2oz Rum	1oz Lime Juice 3/4oz Simple Syrup		(Coupe)
"Add all the ingredients into a shaker with ice and shake.
Strain into a coupe glass.
Garnish with a lime wheel."

Kentucky Mule	2oz Bourbon	1/2oz Lime Juice Fill	Ginger Beer		Mug
"Add the bourbon and lime juice to a Moscow Mule mug or a highball glass.
Fill the mug or glass with ice and top with ginger beer.
Add mint sprigs for garnish."

Moscow Mule	2oz Vodka	1/2oz Lime Juice Fill Ginger Beer	  Mug
"Add the vodka and lime juice to a Moscow Mule mug or a highball glass.
Fill the mug or glass with ice and top with ginger beer.
Add mint sprigs for garnish."

Mexican Mule	2oz Tequila	1/2oz Lime Juice Fill Ginger Beer		Mug
"Add the tequila and lime juice to a Moscow Mule mug or a highball glass.
Fill the mug or glass with ice and top with ginger beer.
Add mint sprigs for garnish."

Old Fashoned	2 oz Bourbon 2 dashes Angostura Bitters	1/4oz Simple Syrup  Lowball
"Add all ingredients into a mixing glass with ice and stir.
Strain into an Old Fashioned glass over fresh ice.
Express the oil of an orange peel over glass and garnish with the peel."

Gin & Tonic	2oz Gin	Fill Tonic   Lowball
"Fill a double rocks glass with ice.
Add the gin and fill with tonic.
Garnish with a lime wedge."

Gin & Juice	1.5oz Gin Fill Juice   Collins
"Fill a Collins glass with ice and add the gin.
Fill with the juice and stir."

Gin Fizz	2oz Gin	1oz Lemon Juice 3/4oz Simple Syrup 1 Egg White 1oz Club Soda  Collins
"Add the first four ingredients to a shaker and dry-shake (without ice) for about 10 seconds.
Add 3 or 4 ice cubes and shake very well.
Double-strain into a chilled fizz glass and top with club soda."

Pisco Sour	2oz Pisco Quebranta	1/2oz Lime Juice 1/2oz Lemon Juice 1oz Simple Syrup 6 drops Angostura Bitters    Coupe
"Combine the first five ingredients in a shaker.
Dry shake for 15 seconds, then add ice and shake again to chill.
Double strain into a chilled coupe glass.
Dot the top with drops of Angostura bitters."

Gimlet	2.5oz Gin	1/2oz Lime Juice 1/2oz Simple Syrup   Lowball
"Add all ingredients into a shaker with ice and shake.
Strain into a chilled cocktail glass or an Old Fashioned glass filled with fresh ice.
Garnish with a lime wheel.
(You can substitute 1 oz lime cordial, such as Rose''s lime juice, for both the lime juice and simple syrup.)."

Sidecar	1.5oz Hennessy	1/2oz Cointreau	1/4oz Lemon Juice 1/4oz Demerara Syrup   Coupe
"Rim a coupe glass in sugar.
Add all the ingredients to a shaker with ice and shake.
Strain into the coupe glass.
Garnish with a lemon twist."

Paloma	2oz Tequila	1/2oz Lime Juice Pinch Salt Fill Grapefruit Jarritos		(highball)
"Add the tequila, lime juice and salt into a highball glass over ice.
Top off with the grapefruit soda and stir.
Garnish with a lime wheel."

Cuba Libre	2oz Rum	6oz Coke	1 Lime Wedge 5 dashes Angostura	Bitters
"Add all the ingredients to a highball glass filled with ice.
Garnish with a lime wedge."

Mint Julep	2oz Bourbon 1/2oz Simple Syrup 3 leaves Mint  Julep
"Express the essential oils in the mint and rub them inside the glass.
To the same glass, add simple syrup, bourbon, and crushed ice.
Stir.
Garnish with more ice and fresh mint."

Midori Sour	1oz Midori 1oz Vodka 1/2oz Lemon Juice 1/2oz Lime Juice Fill Club Soda  Collins
"Add all ingredients except the soda water into a Collins glass over ice and stir.
Top with the soda water.
Garnish with a lemon wheel."


# TOO COMPLICATED
# Bloody Mary	2oz Vodka	4oz Tomato Juice 1 Lemon Wedge 1 Lime Wedge 2 dashes Tabasco 2tsp Horseradish 2 dashes Worcestershire 1 pinch Celery salt, 1 pinch Black Pepper, 1 pinch Smoked Paprika    Pint
# "Pour some celery salt onto a small plate.
# Rub the juicy side of the lemon or lime wedge along the lip of a pint glass.
# Roll the outer edge of the glass in celery salt until fully coated.
# Fill with ice and set aside.
# Squeeze the lemon and lime wedges into a shaker and drop them in.
# Add the remaining ingredients and ice and shake gently.
# Strain into the prepared glass.
# Garnish with a parsley sprig, 2 speared green olives and a lime wedge and a celery stalk (optional)."

#ALREADY ADDED
#
# Mojito	2 oz Rum	3/4 oz Lime Juice	1/2 oz Simple Syrup 3	Mint Fill Club Soda Collins
# 'Lightly muddle the mint in a shaker.
# Add the rum, lime juice, simple syrup and ice and give it a brief shake.
# Strain into a highball glass.
# Top with the club soda.
# Garnish with a mint sprig.'
# #
#
#   Long Island Iced Tea	3/4 oz Vodka 3/4 oz Rum	3/4 oz Gin 3/4 oz Tequila	3/4 oz Triple Sec	3/4 oz Simple Syrup 3/4 oz Lemon Juice Highball
# 'Add all ingredients except the cola into a Collins glass with ice.
# Top with a splash of the cola and stir briefly.
# Garnish with a lemon wedge.
# Serve with a straw.'
# #
#
# Cosmopolitan	1.5oz Citrus Vodka	1oz Cointreau 1 dash Cranberry 1/2 oz Lime  Cocktail
# 'Add all ingredients into a shaker with ice and shake.
# Strain into a chilled cocktail glass.
# Garnish with a lime wheel.'
# #
#
#   Margarita	1.5oz Tequila	1oz Triple Sec	3/4oz Lime Juice 1/4oz Simple Syrup Cocktail
# 'Salt half the rim of the glass and set aside (optional).
# Add all ingredients into a shaker with ice and shake vigorously.
# Strain into the prepared glass over fresh ice.
# Garnish with a lime wedge.'
# #
#
#   Amaretto Sour	1.5oz Amaretto 3/4oz Bourbon 1oz Lemon Juice 1t Simple Syrup 1/2oz Egg white, beaten Lowball
# 'Add all ingredients to a shaker and dry shake to combine.
# Add fresh ice to the shaker and shake again until chilled.
# Strain over fresh ice into an Old Fashioned glass.
# Garnish with lemon peel and brandied cherries, if desired.'
#
# Vodka Lemonade	2oz Vodka	Fill Lemonade  Highball
# 'Pour Vodka over ice and add Lemonade to taste.'
#
#
#   Tequila Lemonade	2oz Tequila	Fill Lemonade Highball
# 'Pour Tequila over ice and add Lemonade to taste'
#
#   Adios   1/2oz Vodka	1/2oz Rum	1/2oz Tequila	1/2oz Gin	1/2oz Blue Curacao 2oz Sweet and Sour Splash Club Soda   Highball
# 'Pour all ingredients (except soda) into the chilled glass with ice cubes.
# Top it with clear soda.
# Stir gently.'
#
# Mai Tai	2oz Rum	1/2oz Orange Curacao 3/4oz Lime Juice 1/4 oz Orgeat 1/4oz Simple Syrup   Lowball
# 'Add all ingredients into a shaker with crushed ice and shake vigorously until the shaker is well-chilled and frosty on the outside.
# Pour (unstrained) into a double Old Fashioned glass.
# Garnish with the rind of half of a juiced lime and a fresh mint sprig.'
#
# Sex on the Beach	1.5oz Vodka	1/2oz peach schnapps 1.5oz Pineapple Juice	1.5oz Cranberry Juice 1/2oz Chambord  Highball
# 'Add all the ingredients into a shaker with ice and shake.
# Strain into a highball glass over fresh ice.
# Garnish with a cocktail umbrella.'
#
# Alabama Slammer	1oz Southern Comfort	1oz Sloe gin	1oz Amaretto	2oz orange juice  Highball
# 'Add all the ingredients into a shaker with ice and shake.
# Strain into a highball glass over fresh ice.
# Garnish with an orange wheel and a cherry, and serve with a straw.'