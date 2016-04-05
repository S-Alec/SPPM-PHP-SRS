<?php
/**
 *	Handle insert new Product to database
 *
 */
?>

<?php
class ProductModel
{
	/**
	 *	Products
	 *	Insert String for the Product Table
	 * 	Salts + Hashes the Products password before inserting it
	 *	into the table
	 */
	public static function insertProduct($barcode, $pname, $brand, $category, $description)
	{
		$insertString = "INSERT INTO PRODUCT (barcode, pname, brand, category, description)
			VALUES ('$barcode', '$pname', '$brand', '$category', '$description')";

		return $insertString;
	}

	/**
	 *	Products
	 *	Update String for the Product Table
	 * 	Salts + Hashes the Products password before updateing it
	 *	into the table
	 */
	public static function updateProduct($pid,$barcode, $pname, $brand, $category, $description)
	{
		$insertString = "UPDATE PRODUCT SET";
		$insertString .= " barcode = '$barcode'";
		$insertString .= " , pname = '$pname'";
		$insertString .= " , brand = '$brand'";
		$insertString .= " , category = '$category'";
		$insertString .= " , description = '$description'";
		$insertString .= " WHERE pid = '$pid'";

		return $insertString;
	}

	/**
	 *	Products
	 *	Update String for the Product Table
	 * 	Salts + Hashes the Products password before updateing it
	 *	into the table
	 */
	public static function deleteProduct($pid)
	{
		$insertString = " DELETE FROM PRODUCT WHERE pid = '$pid'";
		return $insertString;
	}

	/**
	 *	Products
	 *	Update String for the Product Table
	 * 	Salts + Hashes the Products password before updateing it
	 *	into the table
	 */
	public static function getProductList()
	{
		$insertString = " SELECT PRODUCT.pid, PRODUCT.barcode, PRODUCT.pname, PRODUCT.brand, PRODUCT.category, PRODUCT.description, SALEITEM.stockamount";
		$insertString.= " FROM PRODUCT LEFT JOIN SALEITEM ON SALEITEM.pid = PRODUCT.pid";
		return $insertString;
	}
}
?>
