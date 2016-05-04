<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/graph/Graphdata.php';

class Graph extends GraphData
{
    function __construct($aProductName = null,$aDate = null,$aQuantity = null)
    {
      if($aProductName != null && $aDate != null && $aQuantity != null)
      {
        parent::__construct($aProductName, $aDate, $aQuantity);
      }

    }
}
?>
