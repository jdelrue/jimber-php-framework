# Jimber PHP Framework (JPF) #
## Using JPF ##
### SmartLibs ###

SmartLibs.php is a PHP file that should be included in any PHP file in the project. This is the file that handles further includes of libraries, Global variables, debugging settings and login checking. This file can be edited to the users needs.

Some Global variables examples:
```
class GlobalVars {

    static public $STARTPATH = "/website/"; //location of the website after domain eg. this for www.example.org/website/ *
    static public $DRIVEPATH = "/var/www/website/"; //location of the website on the drive *
    static public $RFBPATH = "lib/JPF/"; //Where JPF is located*
    static public $LOG = 1;
    static public $DATAPATH = "lib/JPF/Data/MySQL"; //where the data files are*
    static public $SITEKEY = 'thisshouldbechanged'; // Password for security. Just change it to a secret*
    static public $DATEFORMAT = 'd/m/Y'; //mose used dateformat
}
```

The libadd function can include a library. Mostly 2 libs have to be included:
```
libadd("lib.JPF");
libadd("lib.JPF.Data.MySQL");
```

This will basically look in the lib/JPF  and lib/JPF/Data/MySQL/ folder for a file require.php and include this one. This file has further include directives.

### Template engine ###
The template engine is used to seperate HTML and PHP code. It's short, simple and solid. A template file contains only html and looks as follows:
```
 <!-- BEGIN TITLEBLOCK -->
 <h1> {{TITLE}} </h1>
 <!-- END TITLEBLOCK -->

 <!-- BEGIN CONTENTBLOCK -->
 <p> {{CONTENT}} </p>
 <!-- END CONTENTBLOCK -->
```

There are 5 functions to know about:
```
 Template(file)
```
The constructor. Make a new template from a template file.
```
 AddFile(file)
```
Add another file to the template.
```
 DefineBlock(blockname)
```
Define a block that exists within the template.
```
 setVars(blockname,varname,value)
```
Set a var in a template block. Plural because all instances of the var are replaced.
```
 ParseBlock(blockname)
```
Parse a block to html. Returns the html.
```
 Show(blockname)
```
Will echo the block. Echo works fine but this is more controlled and adjustable.

Some interesting things:

**Blocks can be concatenated
```
 (block1->ParseBlock(blockname).block2->ParseBlock(blockname2)
```** Blocks can be set as vars for other blocks
```
 (block1->setVars(blockname, varname,block2->ParseBlock(blockname2))
```

#### Example ####

Say there is a file page.html containing the html code
```
 <!-- BEGIN DIVEXAMPLE -->
  <div class="example"> <p> Lorem ipsum something {{VAR}} </p></div>
 <!-- END DIVEXAMPLE -->

 <!-- BEGIN PAGEBLOCK -->
 <!doctype html>
 <html lang="en">
     <head>
         <meta charset="utf-8" />
         <title>Some title</title>
    
     </head>
     <body>
          <p> some text </p>
          {{MORECONTENT}}
     </body>
 </html>

 <!-- END PAGEBLOCK -->
```

Then it is possible to build the PHP file like this

```
<?
require_once("lib/SmartLibs.php");

libadd("lib.JPF");
libadd("lib.JPF.Data.MySQL");

$tpl = new Template("index.tpl");
$tpl->DefineBlock("PAGEBLOCK");
$tpl->DefineBlock("DIVEXAMPLE");
$tpl->setVars("DIVEXAMPLE", "VAR", "and something else");
$tpl->setVars("PAGEBLOCK", "MORECONTENT", $tpl->parseBlock("DIVEXAMPLE"));
$html = $tpl->ParseBlock("PAGEBLOCK");
$tpl->Show($html);

?>
```

### Entity generator ###

The entity generator will generate a very simple entity class for each table in the database. This class will extend the abstract Entity class which will provide the most functions. Currently only support for MySQL is provided. Support for other databases like PostgreSQL can easily be added.

The entity generator consists of following files:
  * Fetcher.php: Fetches the database structure
  * Generator.php: Generates the entity classes
  * Entity.php: Provides functionality

To use the entity generator simply surf to Fetcher.php. The only requirement is that the Data directory is writeable by the webserver.

This is an example of a generated entity, from the user table in a database:
```
 class User extends Entity {
     var $ID;
     var $name;
     var $pass;
     var $email;
     var $contactID;
     var $primaryKeys = array("ID");
    var $auto_increment = array("ID");
 function getClass() { return __CLASS__; }
 }
```

### Datagrids ###
Forms and grids with JPF are easy and efficient. Forms in Jimer are used to present, modify or insert data in the database. To use Forms or Grids, it's important to first understand the fields system.

#### Fields ####
```
 $fields = Array();
 
 // Define fields for form
 
 $fields[0] = new Field("Textbox", "name", "Company Name");
 $fields[0]->validator = "^[a-z -']+$";
 $fields[1] = new Field("Textbox", "address", "Address");
 $fields[2] = new Field("Textbox","email", "E-mail");
 $fields[3] = new Field("Textbox", "tel", "Tel.");
 $fields[4] = new Field("Textbox", "zip", "ZIP/Postcode");
 $fields[5] = new Field("Select", "countryID", "Country");
 $fields[5]->collection = Country::Select();
 $fields[5]->textfield = "printable_name";
 
 $form = new Form($fields, "", true,true);
 $form->type = "Company";
 
 $htm = $form->BuildStandardForm(); // returns html code
```
This is an example of a database driven form (default) with 5 fields. Let's analyze the first field as an example.
```
 $fields[0] = new Field("Textbox", "name", "Company Name");
```
The Field constructor is as follows:
```
  function field($type, $dbname, $showname, $disabled = false);
```
The type of the field (Text, Textbox, Select, Wiki, ...) determines how the field will be represented in HTML code and how the data will be handled upon submitting ,more information on this in the "Elements" section. Besides this the constructor needs the name, which is a column in the database, a representing name, shown on the page, and a flag wether to disable the element. In this case a textbox is generated, data binded to the "name" column in the Company database.

Another, more complex example is the fifth field:
```
 $fields[5] = new Field("Select", "countryID", "Country");
 $fields[5]->collection = Country::Select();
 $fields[5]->textfield = "printable_name";
```
This field is a HTML select box. The collection in the select box is gathered from the Select method of the Country column. The textfield represents the name of the column of this collection. So in the select box all "printable\_names" of each Country will be seen. This code is about the same:
```
 $fields[5] = new SelectField("Select", "countryID", "Country");
 $fields[5]->collection = Country::Select();
 $fields[5]->textfield = "printable_name";
```
The result is the same, but when coding intellisense will show the options that are usable for SelectField.

#### Showing the grid ####

Besides the fields the type is set for insert forms (default) and after this the HTML code can be generated using the BuildStandardForm method.
```
 BuildStandardForm($addPageNavigator = false);
```
A page navigator should not be added for this simple form. False is default.

#### A typical datagrid ####

Say we want a datagrid of all our customers. It could be built up as follows.
```

 $col = Contact::Select();
 $contactFields = Array();
 $contactFields[0] = new Field("Text", "name", "Name");
 $contactFields[1] = new Field("Text", "address", "Address");
 $contactFields[2] = new Field("Text", "email", "E-Mail");
 $contactFields[3] = new Field("Text", "companyID:name", "Company");
 $contactFields[4] = new Field("URL", "ID", "Edit");
 $contactFields[4]->preURL = "contact_details.php?pb=" . Encrypt("contact_mng.php") . "&amp;contact=";

 $contactgrid = new Grid($contactFields, $col, false);
 $contactgrid->sorting = true;
 if (isset($_GET['page'])) {
    $contactgrid->page = $_GET['page'];
 }
 $existinghtm = $contactgrid->BuildStandardGrid(true);

```

This will make a grid containing all contacts, showing information that is non editable. The first fields are trivial but the last one is an URL. The preURL option will put something in front of the URL. In this case the column will have the word "Edit' and link to the preURL string, concatenated with the ID.

Also, sorting is enabled. This makes column headers clickable, sorting also works accross pages. The page is set from the page variable posted to the page. The grid will change this page value by default, other pagevars can also be used. The last line builds the HTML code of the grid, including the pagenavigator (true).

#### Possible elements in DataGrids ####
At this moment following field types can be used:

  * Checkbox
  * Date
  * Datebox
  * Delete
  * Hidden
  * Image
  * LinkedText
  * SQLBox
  * Select
  * Text
  * Textarea
  * TextboxPassword
  * TextboxSuggest
  * Textpre
  * URL
  * Upload
  * WikiText

#### Linkthrough forms ####

Datagrids are fast and easy to make but not very flexible. For this reason, a Form can be handled as a LinkThrough element. In this case it will just post data to another page instead of editing or inserting directly in the database. A simple example:

Posting page:
```
$fieldsAddDongle = Array();
$fieldsAddDongle[0] = new Field("Textbox", "name", "Your name:");
$linkTrForm = new Form($fieldsAddDongle, "", true, true);
$linkTrForm->linktrough = "handling.php";

$linkTrFormHtm = $licextForm->BuildStandardForm();
```

Handling page:

```
echo $_SESSION['linktroughresult']['name'];
```

This requires a handling page but is very flexible and there is more data control.

### Tools ###



## Making a basic website with JPF ##

### Checkout the code ###
The easiest way to get JPF is by checking out the SVN repo.
```
svn checkout https://JPF-php-framework.googlecode.com/svn/trunk/lib 
```

### Create your database tables ###

Now it's time to create some database content. Start with the datastructure. For example there is a database containing users and a table with all the rooms in a building and what user is responsible for it.
```

CREATE TABLE IF NOT EXISTS `rooms` (
  `ID` int(50) NOT NULL AUTO_INCREMENT,
  `roomNumber` varchar(50) NOT NULL,
  `userID` int(50) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

```

### Modify the config ###
Modify the config setting the required variables and connecting to the database. This is all done in JPFLibs.php

```
/*
 * Add vars that will be globally used in your project here. Or extend
 * the class in an included file.
 * JPFLibs manager is part of JPF framework
 */

class GlobalVars {

    static public $STARTPATH = "/jimbertestWebsite/";
    static public $DRIVEPATH = "/var/www/jimbertestWebsite/";
    static public $JPFPATH = "lib/JPF/";
    static public $SITEKEY = 'justakeythatnooneknows';
    static public $DATEFORMAT = 'd/m/Y';
    
    private static $debug;

    public static function getDebug() {
        return self::$debug;
    }
    public static function setDebug($debug){
         self::$debug = $debug;
    }

}
/*
* Connect to the database here
*/
    require_once $_SERVER['DOCUMENT_ROOT'].GlobalVars::$STARTPATH."lib/Jimber/Data/MySQL/SQL_Connector.php";

    $sqlconfig = new SQL_Connector("localhost","root","root", "jpftest");

    $mysqli =$sqlconfig->Connect();

```

### Generate the entities ###
Surf to jimbertestWebsite/lib/JPFEntityGen.php, click on generate entities. It should say "done". After this open the SQL\_Entities-ng.php file in the data directory. It should look like this.
```
<?
class rooms extends Entity {
	 var $ID;
	 var $roomNumber;
	 var $userID;
	 var $primaryKeys = array("ID");
	var $auto_increment = array("ID");
function getClass() { return __CLASS__; }
}
class users extends Entity {
	 var $ID;
	 var $name;
	 var $password;
	 var $primaryKeys = array("ID");
public static function getClass() { return __CLASS__; }
}
?>
```

At any time, when the database structure has been modified this should be repeated. Be aware that the Data folder should be writable by the webserver. This is of course best done on a development machine, not on the public webserver :]

### Create the templates ###

To get some HTML content on the screen it is always the best idea to create a template. Avoid any HTML straight from PHP. So this could be the content of your main page, index.tpl:

```
 <!-- BEGIN DIVEXAMPLE -->
  <div class="example"> <p> Lorem ipsum something {{VAR}} </p></div>
 <!-- END DIVEXAMPLE -->

 <!-- BEGIN PAGEBLOCK -->
 <!doctype html>
 <html lang="en">
     <head>
         <meta charset="utf-8" />
         <title>Some title</title>
    
     </head>
     <body>
          <p> some text </p>
          {{MORECONTENT}}
     </body>
 </html>

 <!-- END PAGEBLOCK -->

```

Next the index.php page is created. This will put everything together and show some data:

```
<?
$debug=1;
require_once("lib/JPFLibs.php");

libadd("lib.JPF");
libadd("lib.JPF.Data.MySQL");
$tpl = new Template("index.tpl");
$tpl->DefineBlock("PAGEBLOCK");
$tpl->DefineBlock("DIVEXAMPLE");



if(isset($_GET['insert'])){
        $user = new users();

        $user->name = "Jack Daniels";
        $user->password = "drunk";
        $user->Add();

        $otheruser = new users();

        $otheruser->name = "Coca Cola";
        $otheruser->password = "sober";
        $otheruser->Add();

        $room = new rooms();
        $room->roomNumber = 7;
        $room->userID=1;
        $room->Add();
}

$fields = Array();

$fields[0] = new Field("Text", "name", "Name");

$users = Users::Select();

$grid = new Grid($fields,$users,false);


$tpl->setVars("DIVEXAMPLE", "VAR", $grid->BuildStandardGrid(true));
$tpl->setVars("PAGEBLOCK", "MORECONTENT", $tpl->parseBlock("DIVEXAMPLE"));
$html = $tpl->ParseBlock("PAGEBLOCK");
$tpl->Show($html);

?>
```

First surf to index.php?insert=1 to insert some data. Then surf to index.php, it will show the freshly inserted data in a minimal datagrid.