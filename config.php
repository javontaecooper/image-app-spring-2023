<?php 
/**
 * configuration for image app
 * * Connect to database
 * * configure error display (production vs development)
 */

/* ------------------configure these variables----------------- */
// connecte the database

define('DEBUG_MODE', true);


$host = 'localhost';
$user = 'finsta_0523';
$pass = '?&Me?BA6dLs?JR+';
$dbname = 'javontae_finsta_may2023';


/* -------------------------stop editing------------------------ */


/* DISPLAY ERRORS
On a development server
	error_reporting should be set to E_ALL value;
	display_errors should be set to 1
	log_errors could be set to 1

On a production server
	error_reporting should be set to E_ALL value;
	display_errors should be set to 0
	log_errors should be set to 1
*/
if(DEBUG_MODE){
	//development
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	ini_set('log_errors', 1);
}else{
	//production
	//error_reporting(E_ALL);
	ini_set('display_errors', 0);
	ini_set('log_errors', 1);

}

/**
 * @link (https://phpbestpractices.org/#mysql)
 */
//connect!
$DB = new PDO(	"mysql:host=$host;dbname=$dbname;charset=utf8mb4",
	              $user,
	              $pass,
	                array(
	                   
	                )
	            );