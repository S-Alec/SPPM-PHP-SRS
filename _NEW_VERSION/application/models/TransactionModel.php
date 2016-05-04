<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class TransactionModel extends CI_Model
{
  private $TABLE_NAME = 'TRANSACTION';
  //properties
  public $receiptcode = 0;
  public $pid= 0;
  public $salesprice = 0.00;
  public $quantity = 0;
  public $barcode = '';
  public $pname = '';
  public $brand = '';
  public $category = '';
  public $description = '';


  //construction
  function __construct()
  {
    //inherent parent construct if have
    parent::__construct();
    //connect to db
    $this->load->database();
  }

  /**
   * implement add a new product into database
   */
  public function add($pTransaction)
  {

    //assign object to array data
    $data = array(
      'receiptcode' => $pTransaction->receiptcode,
      'pid' => $pTransaction->pid,
      'salesprice' => $pTransaction->salesprice,
      'quantity' => $pTransaction->quantity
    );

    //execute in db
    $this->db->insert($this->TABLE_NAME, $data);
    return ($this->db->affected_rows() > 0) ? true : false;
  }

  public function getTransactionDetails($aReceiptCode)
  {
  	$query = "SELECT PRODUCT.barcode, PRODUCT.pname, PRODUCT.brand, PRODUCT.category, PRODUCT.description, TRANSACTION.salesprice, TRANSACTION.quantity
  	FROM TRANSACTION

  	INNER JOIN PRODUCT AS PRODUCT
  	ON TRANSACTION.pid = PRODUCT.pid

  	WHERE TRANSACTION.receiptcode = '$aReceiptCode'";

    //execute
    $query = $this->db->query($query);
    $result = $query->result('TransactionModel');

  	return $result;
  }

}
?>
