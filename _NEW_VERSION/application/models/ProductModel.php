<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class ProductModel extends CI_Model
{
  private $TABLE_NAME = 'PRODUCT';
  //properties
  public $pid = 0;
  public $barcode = '';
  public $pname = '';
  public $brand = '';
  public $category = '';
  public $description = '';
  public $salesprice = 0.00;
  public $stockamount = 0;

  //construction
  function __construct()
  {
    //inherent parent construct if have
    parent::__construct();
    //connect to db
    $this->load->database();
    $this->load->model('SaleItemModel', 'saleItemModel');
  }

  /**
   * implement add a new product into database
   */
  public function add($pProduct)
  {
    try {
      //assign object to array data
      $data = array(
        'barcode' => $pProduct->barcode,
        'pname' => $pProduct->pname,
        'brand' => $pProduct->brand,
        'category' => $pProduct->category,
        'description' => $pProduct->description
      );
      //check product barcode exist
      $condition = "barcode =" . "'" . $data['barcode'] . "'";
      $this->db->select('*');
      $this->db->from($this->TABLE_NAME);
      $this->db->where($condition);
      $this->db->limit(1);
      $query = $this->db->get();
      if ($query->num_rows() == 0) {
        //execute in db
        $this->db->insert($this->TABLE_NAME, $data);

        if($this->db->affected_rows() > 0)
        {
          $productId = $this->db->insert_id();

          //insert sale items
          $this->load->model('SaleItemModel', 'saleItemModel');

          $oSaleItem = new saleItemModel();
          $oSaleItem->pid = $productId;
          $oSaleItem->salesprice = $pProduct->salesprice;
          $oSaleItem->stockamount = $pProduct->quantity;

          $this->saleItemModel->add($oSaleItem);

          //inseart stock
          $data = array(
            'pid' => $productId,
            'orderamount' => $pProduct->quantity
          );
          //insert data into STOCKORDER table
          $this->db->insert('STOCKORDER', $data);

          return true;
        }
        else {
          return false;
        }

      }
      else {
        return 'Barcode is already exist in the system';
      }
    } catch (Exception $e) {
      return 'Fail in add new stock';
    }

  }
  /**
   * implement update the product in database
   */
  public function update($pProduct)
  {

    try {
      $addStock = 0;
      //get add stock
      $query = " SELECT PRODUCT.pid, PRODUCT.barcode, PRODUCT.pname, PRODUCT.brand, PRODUCT.category, PRODUCT.description, SALEITEM.stockamount, SALEITEM.salesprice";
      $query.= " FROM PRODUCT LEFT JOIN SALEITEM ON SALEITEM.pid = PRODUCT.pid WHERE PRODUCT.pid = '$pProduct->pid'";

      $query = $this->db->query($query);

      foreach ($query->result('ProductModel') as $row)
      {
          $addStock = $pProduct->quantity - $row->stockamount;
      }

      //update product
      $data = array(
        'barcode' => $pProduct->barcode,
        'pname' => $pProduct->pname,
        'brand' => $pProduct->brand,
        'category' => $pProduct->category,
        'description' => $pProduct->description,
      );

      //excute in db
      $this->db->where('pid', $pProduct->pid);
      $this->db->update($this->TABLE_NAME, $data);

      //update in sale item
      $oSaleItem = new saleItemModel();
      $oSaleItem->pid = $pProduct->pid;
      $oSaleItem->salesprice = $pProduct->salesprice;
      $oSaleItem->stockamount = $pProduct->quantity;

      $this->saleItemModel->update($oSaleItem);

      //Insert StockOrder
      $data = array(
        'pid' => $pProduct->pid,
        'orderamount' => $addStock
      );
      //insert data into STOCKORDER table
      $this->db->insert('STOCKORDER', $data);
      //echo 'aaa' . $this->db->affected_rows();

      return true;
    } catch (Exception $e) {
      return 'Fail in update the stock';
    }
  }


  /**
   * implement delete a product in database
   */
  public function delete($pid)
  {
    //delete in sale items
    if($this->saleItemModel->delete($pid))
    {
      return true;
    }
    else {
      return 'Fail in delete the product';
    }
  }

  /**
   * implement get all of products in database
   */
  public function getAll()
  {
    $query = " SELECT PRODUCT.pid, PRODUCT.barcode, PRODUCT.pname, PRODUCT.brand, PRODUCT.category, PRODUCT.description, SALEITEM.stockamount, SALEITEM.salesprice";
    $query.= " FROM PRODUCT INNER JOIN SALEITEM ON SALEITEM.pid = PRODUCT.pid";

    $query = $this->db->query($query);

    //return result as array of object
    return $query->result('ProductModel');
  }

  /**
   * find products by search term
   */
   public function find($aSearchTerm)
   {
     $query = "SELECT SALEITEM.pid, PRODUCT.barcode, PRODUCT.pname, PRODUCT.brand, PRODUCT.category, PRODUCT.description, SALEITEM.salesprice, SALEITEM.stockamount

  		FROM SALEITEM

  		INNER JOIN PRODUCT AS PRODUCT
  		ON SALEITEM.pid = PRODUCT.pid

  		WHERE (PRODUCT.barcode  like '%$aSearchTerm%') OR
  			  (PRODUCT.brand    like '%$aSearchTerm%') OR
  			  (PRODUCT.pname    like '%$aSearchTerm%') OR
  			  (PRODUCT.category like '%$aSearchTerm%')

  		ORDER BY PRODUCT.pname";
      //execute
      $query = $this->db->query($query);
      $result = $query->result('ProductModel');
      //return
  		return $result;
   }

   /*
    * get product information : product name, price quantity by id
    */
   public function getProductNamePriceQuantity($pid)
   {
      $query = "SELECT SALEITEM.pid, PRODUCT.pname, SALEITEM.salesprice, SALEITEM.stockamount
      FROM SALEITEM

      INNER JOIN PRODUCT AS PRODUCT
      ON SALEITEM.pid = PRODUCT.pid

      WHERE SALEITEM.pid = '$pid'";

      //execute
      $query = $this->db->query($query);
      $result = $query->result('ProductModel');
      //return
      return $result;
   }

   public function getAllStockQuantity()
   {
      $query = "SELECT PRODUCT.barcode, PRODUCT.pname, PRODUCT.brand, PRODUCT.category, SALEITEM.salesprice, SALEITEM.stockamount
               FROM SALEITEM

               INNER JOIN PRODUCT AS PRODUCT
               ON SALEITEM.pid = PRODUCT.pid

               ORDER BY SALEITEM.stockamount ASC";
      //execute
      $query = $this->db->query($query);
      $result = $query->result('ProductModel');
      //return
      return $result;

   }
}
?>
