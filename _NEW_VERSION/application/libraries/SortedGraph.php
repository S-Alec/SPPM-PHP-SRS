<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/graph/SortedGraphDataIterator.php';

class SortedGraph extends SortedGraphDataIterator
{
    function __construct($aGraphData = null)
    {
        if($aGraphData != null)
        {
         parent::__construct($aGraphData);
        }
    }
}
?>
