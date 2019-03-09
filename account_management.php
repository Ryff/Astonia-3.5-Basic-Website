<?php
require("config.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$sID = $_SESSION['user_id'];
$name = ucfirst(strtolower(($_POST['name'])));

if (strlen($name) <= 3)
{
    die("This Character name has to few characters, minimum is 4.");
}
if (strlen($name) >= 16)
{
    die("This Character name has to much characters, maximum is 15.");
}
if (ctype_alpha($_POST['username']) != true)
{
    die("Character name must contain only Letters");
}
$gender = 'unselected';
$class = 'unselected';
$select_gender = ($_POST['Gender']);
if ($select_gender == '1')
    $gender = 'M';
else if ($select_gender == '2')
    $gender = 'F';
$select_class = ($_POST['charclass']);
if ($select_class == '1')
    $class = 'M';
else if ($select_class == '2')
    $class = 'W';


$query ="SELECT 1 FROM chars WHERE name = :name";
$query_params = array(':name' => $_POST['name']);

try
{
    $mercit = $dbh2->prepare($query);
    $result = $mercit->execute($query_params);

} catch (PDOException $ex)
{
    die("Failed to run query: " . $ex->getMessage());
}
$row = $mercit->fetch();

if ($row)
{
    die("This Character name is already registered");
}

$genclass = $gender . $class;
$old_path = getcwd();

try 
{
 $output = shell_exec('sudo /home/astonia/astonia35_server/create_character "'.$sID.'" "'.$name.'" "'.$genclass.'"');


} catch(PDOException $ex)
{
	die("Unable to create character");
}
//header("Location: account_management.php"); ?>`
<?php include_once("analytics.php") ?>
