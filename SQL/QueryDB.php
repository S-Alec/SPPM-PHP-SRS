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

  /**
   *  Get all items that match a search term
   */
  public static function getMatchingProducts( $aSearchTerm )
  {
  	$query = "SELECT SALEITEM.pid, PRODUCT.barcode, PRODUCT.pname, PRODUCT.brand, PRODUCT.category, PRODUCT.description, SALEITEM.salesprice, SALEITEM.stockamount

  		FROM SALEITEM

  		INNER JOIN PRODUCT AS PRODUCT
  		ON SALEITEM.pid = PRODUCT.pid

  		WHERE (PRODUCT.barcode  = '$aSearchTerm') OR 
  			  (PRODUCT.brand    = '$aSearchTerm') OR 
  			  (PRODUCT.pname    = '$aSearchTerm') OR 
  			  (PRODUCT.category = '$aSearchTerm')

  		ORDER BY PRODUCT.pname";

  		return $query;
  }

  /**
   *	Get product details given product id
   */
  public static function getProductNamePriceQuantity($aPid)
  {
  	$query = "SELECT SALEITEM.pid, PRODUCT.pname, SALEITEM.salesprice, SALEITEM.stockamount
  		FROM SALEITEM
  		
      INNER JOIN PRODUCT AS PRODUCT
      ON SALEITEM.pid = PRODUCT.pid

      WHERE SALEITEM.pid = '$aPid'";

  	return $query;
  }

  /**
   *	Get all product details linked to a transaction code 
   *	identified by a receipt code
   */
  public static function getTransactionDetails( $aReceiptCode )
  {
  	$query = "SELECT PRODUCT.barcode, PRODUCT.pname, PRODUCT.brand, PRODUCT.category, PRODUCT.description, TRANSACTION.salesprice, TRANSACTION.quantity 
  	FROM TRANSACTION

  	INNER JOIN PRODUCT AS PRODUCT
  	ON TRANSACTION.pid = PRODUCT.pid 

  	WHERE TRANSACTION.receiptcode = '$aReceiptCode'";

  	return $query;
  }
}
?>