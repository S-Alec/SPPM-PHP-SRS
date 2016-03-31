<?php
/**
 *	Update data within the database
 */
?>
<?php
class UpdateDB
{
	/**
	 *
	 */
	public static function deductStockFromSalesTable($aPid, $aQuantity)
	{
		$lUpdate = "UPDATE SALEITEM 
			SET stockamount = (stockamount - '$aQuantity')
			WHERE pid = '$aPid'";

		return $lUpdate;
	}
}
?>