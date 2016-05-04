<?php
/**
 *	Holds a single record of graph data
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GraphData
{
	private $fProductName;
	private $fDate;
	private $fQuantity;
	//private $fArrayGraphData;

	/**
	 *	Constructs a Graph Record
	 */
	public function __construct($aProductName, $aDate,$aQuantity )
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
		//set timezone
		if(!ini_get('date.timezone'))
		{
				date_default_timezone_set('GMT');
		}

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
