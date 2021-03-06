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
   *  Finds all transaction data assosciated with a receipt
   */
  public static function findTransactionDetails( $aFromDate, $aToDate )
  {
    $lFrom = DateTime::createFromFormat('d/m/Y', $aFromDate);
    $lTo = DateTime::createFromFormat('d/m/Y', $aToDate);

    $aFromDate = $lFrom->format('Y-m-d');
    $aToDate = $lTo->format('Y-m-d');

    $query = "SELECT PRODUCT.pname, DATE(RECEIPT.transactiondate) AS 'date', SUM(TRANSACTION.quantity) AS 'quantity'

    	FROM RECEIPT

    	INNER JOIN TRANSACTION AS TRANSACTION
    	ON TRANSACTION.receiptcode = RECEIPT.receiptcode

    	INNER JOIN PRODUCT AS PRODUCT
    	ON PRODUCT.pid = TRANSACTION.pid

    	WHERE ( DATE(RECEIPT.transactiondate) >= '$aFromDate'
    			AND DATE(RECEIPT.transactiondate) <= '$aToDate' )

    	GROUP BY PRODUCT.pname, DATE(RECEIPT.transactiondate)
    	ORDER BY RECEIPT.transactiondate";

    return $query;
  }

  /**
   *  Get dates within a range 
   */
  public static function getReceiptsWithinRange( $aFromDate, $aToDate )
  {
    $lFrom = DateTime::createFromFormat('d/m/Y', $aFromDate);
    $lTo = DateTime::createFromFormat('d/m/Y', $aToDate);

    // Change time to appropriate range
    $lFrom->setTime(0, 0, 0);
    $lTo->setTime(23, 59, 59);

    // change format to acceptable SQL Format
    $aFromDate = $lFrom->format('Y-m-d H:i:s');
    $aToDate = $lTo->format('Y-m-d H:i:s');

    $query = "SELECT RECEIPT.receiptcode, RECEIPT.transactiondate, RECEIPT.totalspent, USER.username 

      FROM RECEIPT

      INNER JOIN USER AS USER
      ON USER.uid = RECEIPT.uid

      WHERE (RECEIPT.transactiondate >= '$aFromDate') AND
            (RECEIPT.transactiondate <= '$aToDate') 

      ORDER BY RECEIPT.transactiondate DESC";

    return $query;
  }

  /**
   *  Get all items that match the specific search terms
   */
  public static function getMatchingReceipts( $aSearchTerm )
  {
    $query = "SELECT RECEIPT.receiptcode, RECEIPT.transactiondate, RECEIPT.totalspent, USER.username 

      FROM RECEIPT

      INNER JOIN USER AS USER
      ON USER.uid = RECEIPT.uid

      WHERE (RECEIPT.receiptcode = '$aSearchTerm') OR
            (USER.username = '$aSearchTerm') OR
            (USER.lname = '$aSearchTerm') OR
            (USER.role = '$aSearchTerm') 

      ORDER BY RECEIPT.transactiondate";

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

  /**
   *  Get the entire stock quantity from the sales table
   *  and all the assosciated data
   */
  public static function getAllStockQuantity()
  {
    $query = "SELECT PRODUCT.barcode, PRODUCT.pname, PRODUCT.brand, PRODUCT.category, SALEITEM.salesprice, SALEITEM.stockamount
    FROM SALEITEM

    INNER JOIN PRODUCT AS PRODUCT
    ON SALEITEM.pid = PRODUCT.pid

    ORDER BY SALEITEM.stockamount ASC";
    
    return $query;
  }
}
?>