<?php
/**
 *	Handle sql query in product - stock secntion
 *  return CRUD query string
 */
?>

<?php
class ProductModel
{
	/**
	 *	Products
	 *	return sql query for inserting a product
	 */
	public static function insertProduct($barcode, $pname, $brand, $category, $description)
	{
		$query = "INSERT INTO PRODUCT (barcode, pname, brand, category, description)
			VALUES ('$barcode', '$pname', '$brand', '$category', '$description')";

		return $query;
	}

	/**
	 *	Products
	 *	return sql query for updating a product
	 *	into the table
	 */
	public static function updateProduct($pid,$barcode, $pname, $brand, $category, $description)
	{
		$query = "UPDATE PRODUCT SET";
		$query .= " barcode = '$barcode'";
		$query .= " , pname = '$pname'";
		$query .= " , brand = '$brand'";
		$query .= " , category = '$category'";
		$query .= " , description = '$description'";
		$query .= " WHERE pid = '$pid'";

		return $query;
	}

	/**
	 *	Products
	 *	return sql query for deleteing product by an id
	 *	into the table
	 */
	public static function deleteProduct($pid)
	{
		$query = " DELETE FROM PRODUCT WHERE pid = '$pid'";
		return $query;
	}

	/**
	 *	Salesiem
	 *	return sql query for deleteing saleitem by an product id
	 *	into the table
	 */
	public static function deleteSaleItem($pid)
	{
		$query = " DELETE FROM SALEITEM WHERE pid = '$pid'";
		return $query;
	}

	/**
	 *	Products
	 *	return sql query for selecting all of products
	 *	into the table
	 */
	public static function getProductList()
	{
		$query = " SELECT PRODUCT.pid, PRODUCT.barcode, PRODUCT.pname, PRODUCT.brand, PRODUCT.category, PRODUCT.description, SALEITEM.stockamount, SALEITEM.salesprice";
		$query.= " FROM PRODUCT LEFT JOIN SALEITEM ON SALEITEM.pid = PRODUCT.pid";
		return $query;
	}

	/**
	 *	SaleItem
	 *	return sql query for insearting sale item
	 *	into the table
	 */
	public static function inseartSaleItem($pid, $salesprice, $quantity)
	{
		$query = "INSERT INTO SALEITEM ( pid, salesprice, stockamount )
		VALUES ('$pid', '$salesprice', '$quantity')";
		return $query;
	}

	/**
	 *	SaleItem
	 *	return sql query for updating a sale item
	 *	into the table
	 */
	public static function updateSaleItem($pid, $salesprice, $quantity)
	{
		$query = "UPDATE SALEITEM SET";
		$query .= " salesprice = '$salesprice'";
		$query .= " , stockamount = '$quantity'";
		$query .= " WHERE pid = '$pid'";

		return $query;
	}


	/**
	 *	Transaction
	 *	return sql query for checking existance of a product in transaction
	 */
	public static function checkProductInTransaction($pid)
	{
		$query = "SELECT receiptcode FROM TRANSACTION WHERE pid = '$pid'";
		return $query;
	}

	/**
	 *	StockOrder
	 *	return sql query for checking existance of a product in transaction
	 */
	public static function checkProductInStockOrder($pid)
	{
		$query = "SELECT sid FROM STOCKORDER WHERE pid = '$pid'";
		return $query;
	}

	/**
	 *	Stock Order
	*	return sql query for insearting stock order when product quantity change
	 */
	public static function insertStockOrder( $pid, $amount )
	{
		$query = "INSERT INTO STOCKORDER ( pid, orderamount )
		VALUES ('$pid', '$amount')";

		return $query;
	}

	/**
   *	return sql query for getting current stockamount
   */
  public static function getCurrentStockAmount($pid)
  {
		$query = " SELECT PRODUCT.pid, PRODUCT.barcode, PRODUCT.pname, PRODUCT.brand, PRODUCT.category, PRODUCT.description, SALEITEM.stockamount, SALEITEM.salesprice";
		$query.= " FROM PRODUCT LEFT JOIN SALEITEM ON SALEITEM.pid = PRODUCT.pid WHERE PRODUCT.pid = '$pid'";
  	return $query;
  }

}
?>
