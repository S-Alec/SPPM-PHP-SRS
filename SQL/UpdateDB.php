<?php
/**
 *	Update data within the database
 */
?>
<?php
class UpdateDB
{
	/**
	 *	Deduct stock for a particular sales item
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