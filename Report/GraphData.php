<?php
/**
 *	Holds a single record of graph data
 */
class GraphData
{
	private $fProductName;
	private $fDate;
	private $fQuantity;
	//private $fArrayGraphData;

	/**
	 *	Constructs a Graph Record	
	 */
	public function __construct( $aProductName, $aDate, $aQuantity )
	{
		$this->fProductName = $aProductName;
		$this->fDate = $this->correctDateFormat($aDate);
		$this->fQuantity = $aQuantity;
	}

	/**
	 *	Formats the date for the graph 
	 */
	private function correctDateFormat( $aDate )
	{
		$lDate = new DateTime( $aDate );
		return $lDate->format('Y-m-d');
	}

	/* Getters */

	public function getProductName()
	{
		return $this->fProductName;
	}

	public function getTransactionDate()
	{
		return $this->fDate;
	}

	public function getQuantity()
	{
		return $this->fQuantity;
	}

	public function setQuantity( $aQuantity )
	{
		$this->fQuantity = $aQuantity;
	}
}
?>