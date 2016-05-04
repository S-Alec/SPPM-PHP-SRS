<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class ReceiptModel extends CI_Model
{
  private $TABLE_NAME = 'RECEIPT';
  //properties
  public $receiptcode = 0;
  public $uid = 0;
  public $transactiondate = null;
  public $totalspent = 0.00;
  public $username = '';

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
  public function add($pReceipt)
  {
    //assign object to array data
    $data = array(
      'uid' => $pReceipt->uid,
      'totalspent' => $pReceipt->totalspent
    );

    //execute in db
    $this->db->insert($this->TABLE_NAME, $data);
    if($this->db->affected_rows() == 1)
    {
      $receiptId = $this->db->insert_id();

      return $receiptId;
    }
    return false;
  }

  /**
   * implement get matching receipts
   */
 public function getMatchingReceipts($aSearchTerm)
 {
   $query = "SELECT RECEIPT.receiptcode, RECEIPT.transactiondate, RECEIPT.totalspent, USER.username

     FROM RECEIPT

     INNER JOIN USER AS USER
     ON USER.uid = RECEIPT.uid

     WHERE (RECEIPT.receiptcode = '$aSearchTerm') OR
           (USER.username = '$aSearchTerm') OR
           (USER.lname = '$aSearchTerm') OR
           (USER.role = '$aSearchTerm')

     ORDER BY RECEIPT.transactiondate";

    $query = $this->db->query($query);
    $result = $query->result('ReceiptModel');
    return $result;
 }

 /**
  * implement find Receipts
  */
 public function getReceiptsWithinRange($aFromDate, $aToDate)
 {
    //set timezone
    if(!ini_get('date.timezone'))
    {
        date_default_timezone_set('GMT');
    }

    $lFrom = DateTime::createFromFormat('d/m/Y', $aFromDate);
    $lTo = DateTime::createFromFormat('d/m/Y', $aToDate);

    // Change time to appropriate range
    $lFrom->setTime(0, 0, 0);
    $lTo->setTime(23, 59, 59);

    // change format to acceptable SQL Format
    $aFromDate = $lFrom->format('Y-m-d H:i:s');
    $aToDate = $lTo->format('Y-m-d H:i:s');

    $query = "SELECT RECEIPT.receiptcode, RECEIPT.transactiondate, RECEIPT.totalspent, USER.username

    FROM RECEIPT

    INNER JOIN USER AS USER
    ON USER.uid = RECEIPT.uid

    WHERE (RECEIPT.transactiondate >= '$aFromDate') AND
          (RECEIPT.transactiondate <= '$aToDate')

    ORDER BY RECEIPT.transactiondate DESC";

   $query = $this->db->query($query);
   $result = $query->result('ReceiptModel');
   //return
   return $result;
 }

   /**
   *  Finds all transaction data assosciated with a receipt
   */
  public function findTransactionDetails($aFromDate, $aToDate)
  {

    //set timezone
    if(!ini_get('date.timezone'))
    {
        date_default_timezone_set('GMT');
    }

    $lFrom = DateTime::createFromFormat('d/m/Y', $aFromDate);
    $lTo = DateTime::createFromFormat('d/m/Y', $aToDate);

    $aFromDate = $lFrom->format('Y-m-d');
    $aToDate = $lTo->format('Y-m-d');

    $query = "SELECT PRODUCT.pname, DATE(RECEIPT.transactiondate) AS 'date', SUM(TRANSACTION.quantity) AS 'quantity'

      FROM RECEIPT

      INNER JOIN TRANSACTION AS TRANSACTION
      ON TRANSACTION.receiptcode = RECEIPT.receiptcode

      INNER JOIN PRODUCT AS PRODUCT
      ON PRODUCT.pid = TRANSACTION.pid

      WHERE ( DATE(RECEIPT.transactiondate) >= '$aFromDate'
          AND DATE(RECEIPT.transactiondate) <= '$aToDate' )

      GROUP BY PRODUCT.pname, DATE(RECEIPT.transactiondate)
      ORDER BY RECEIPT.transactiondate";

    $query = $this->db->query($query);
    $result = $query->result_array();
    //return
    return $result;
  }

}
?>
