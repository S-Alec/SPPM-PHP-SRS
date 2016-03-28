<?php
/**
 *  Query the db for data
 */
?>
<?php
class QueryDB
{

  /**
   *  Get all user details for a given username
   */
  public static function getLoginDetails( $aUsername )
  {
    $query = "SELECT * FROM USER 
	  WHERE (username = '$aUsername')";

	return $query;
  }
}
?>