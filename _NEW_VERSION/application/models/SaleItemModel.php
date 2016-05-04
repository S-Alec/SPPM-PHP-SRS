<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class SaleItemModel extends CI_Model
{
  private $TABLE_NAME = 'SALEITEM';
  //properties
  public $pid = 0;
  public $salesprice = 0.00;
  public $stockamount= 0;

  //construction
  function __construct()
  {
    //inherent parent construct if have
    parent::__construct();
    //connect to db
    $this->load->database();
  }

  /**
   * implement add a new sale item into database
   */
  public function add($pSaleItem)
  {
    //insert sale items
    $data = array(
      'pid' => $pSaleItem->pid,
      'salesprice' => $pSaleItem->salesprice,
      'stockamount' => $pSaleItem->stockamount
    );
    //insert data into SALEITEM table
    $this->db->insert($this->TABLE_NAME, $data);

    return ($this->db->affected_rows() > 0) ? true : false;
  }

  /**
   * implement update a sale item into database
   */
  public function update($pSaleItem)
  {
    //update sale item
    $data = array(
      'salesprice' => $pSaleItem->salesprice,
      'stockamount' => $pSaleItem->stockamount
    );

    //excute in db
    $this->db->where('pid', $pSaleItem->pid);
    $this->db->update('SALEITEM', $data);
    //return
    return ($this->db->affected_rows() > 0) ? true : false;
  }



  public function deductStock($pid, $pQuantity)
  {
    //assign object to array data
    $query = "UPDATE SALEITEM
        			SET stockamount = (stockamount - '$pQuantity')
        			WHERE pid = '$pid'";

    $query = $this->db->query($query);
    //return
    return ($this->db->affected_rows() > 0) ? true : fale;

  }

  /**
   * implement delete a sale item in database
   */
  public function delete($pid)
  {
    //excute in db
    $this->db->where('pid', $pid);
    $this->db->delete($this->TABLE_NAME);
    //return
    return ($this->db->affected_rows() > 0) ? true : false;
  }
}
?>
