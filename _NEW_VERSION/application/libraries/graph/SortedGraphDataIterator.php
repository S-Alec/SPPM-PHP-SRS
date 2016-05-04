<?php
/**
 *	Sorts a GraphData array by transaction dates and products
 */

//require_once(dirname(__FILE__)."/GraphData.php");

class SortedGraphDataIterator implements Iterator
{
	private $fGraphData;
	private $fIndex;
	private $fAssosciativeArray;

	public function __construct($aGraphData = null)
	{
		$this->fAssosciativeArray = array();
		$this->fIndex = 0;
		$this->fGraphData = $aGraphData;
	}

	/**
	 *	Position iterator at beginning
	 */
	public function rewind()
	{
		$this->fIndex = -1;
		$this->next();
	}

	/**
	 *	Return the current array values
	 */
	public function current()
	{
		return $this->fAssosciativeArray;
	}

	/**
	 *	Return key to current element
	 */
	public function key()
	{
		return $this->fIndex;
	}

	/**
	 *	Move forward to the next element
	 *	formatting the array
	 */
	public function next()
	{
		++$this->fIndex;

		if( $this->valid() )
		{
			// Store current datein assosciative array
			$this->fAssosciativeArray["date"] = $this->fGraphData[$this->fIndex]->getTransactionDate();

			// Store current product in Assosciative array
			$this->fAssosciativeArray[$this->fGraphData[$this->fIndex]->getProductName()] = $this->fGraphData[$this->fIndex]->getQuantity();

			// Scan through and map similar products
			for( $i = $this->fIndex + 1; $i < count($this->fGraphData); $i++ )
			{
				// Check if two transaction dates exist
				if( $this->fGraphData[$this->fIndex]->getTransactionDate() === $this->fGraphData[$i]->getTransactionDate() )
				{
					// Increment fIndex
					++$this->fIndex;

					// add product to assosciative array
					$this->fAssosciativeArray[$this->fGraphData[$this->fIndex]->getProductName()] = $this->fGraphData[$this->fIndex]->getQuantity();
				}
				else
				{
					// if dates don't match then break
					break;
				}
			}
		}
	}

	/**
	 *	Check if current position is valid
	 */
	public function valid()
	{
		return isset($this->fGraphData[$this->fIndex]);
	}
}
?>
