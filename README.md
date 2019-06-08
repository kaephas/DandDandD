# DandDandD
## Requirements

#### Separates all database/business logic using the MVC pattern
- Database commands & form validation in Model folder (Scripts in Script Folder)
- HTML views in Views Folder
- Singular controller in root (index.php)
#### Routes all URLs and leverages a templating language using the Fat-Free framework
- Instantiates Fat-Free in index.php and uses hive throughout views and validation
- All pages directed through and routed from index (.htaccess)
#### Has a clearly defined database layer using PDO and prepared statements
- All SQL CRUD statements are in a database class using prepared statements
#### Data can be viewed, added, updated, and deleted
- View: View all drinks page
- Add: Add Drink page
- Updated: Edit Drink page
- Deleted: Delete Drink page
#### Has a history of commits from both team members to a Git repository
- 100+ commits on kaephas/DandDandD
#### Uses OOP, and defines multiple classes, including at least one inheritance relationship
- Character Class stores data from find drink form
- Drink Class gets all drink data to use in add/edit drink forms as well as drink match
- AlcoholDrink extends Drink storing # of shots and assisting with validation
#### Contains full Docblocks for all PHP files and follows PEAR standards
- Every php file has file and named function headers and use proper naming conventions and curly brace lines
#### Has full validation on the client side through JavaScript and server side through PHP
- all form pages use clientValid.js to verify that all forms are filled out
- if client-valid, all form data is processed through validate.php
#### BONUS: Incorporates Ajax that access data from a JSON file, PHP script, or API
- character.html runs getClassInfo.js which uses ajax to access data from a php script to 
dynamically generate an appropriate character class image and subclass dropdown