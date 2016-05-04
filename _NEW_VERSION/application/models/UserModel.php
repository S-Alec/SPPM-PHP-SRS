<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class UserModel extends CI_Model
{
  private $TABLE_NAME = 'USER';
  //properties
  public $uid = 0;
  public $username = '';
  public $lname = '';
  public $password = '';
  public $role = '';
  public $rmove = 0;

  //construction
  function __construct()
  {
    //inherent parent construct if have
    parent::__construct();
    //connect to db
    $this->load->database();
  }

  /**
   * implement add a new user into database
   */
  public function add($pUser)
  {
    //assign object to array data
    $data = array(
      'username' => $pUser->username,
      'lname' => $pUser->lname,
      'password' => password_hash($pUser->password, PASSWORD_DEFAULT),
      'role' => $pUser->role
    );
    //check user exist
    $condition = "username =" . "'" . $data['username'] . "'";
    $this->db->select('*');
    $this->db->from($this->TABLE_NAME);
    $this->db->where($condition);
    $this->db->limit(1);
    $query = $this->db->get();
    if ($query->num_rows() == 0) {
      //execute in db
      $this->db->insert($this->TABLE_NAME, $data);
      //return
      return ($this->db->affected_rows() > 0) ? true : "Fail in add new user";
    }
    else {
      return 'Username is already exist in the system';
    }


  }
  /**
   * implement update the user in database
   */
  public function update($pUser)
  {

    if(empty(trim($pUser->password)))
    {
      //assign object to array data
      $data = array(
        'username' => $pUser->username,
        'lname' => $pUser->lname,
        'role' => $pUser->role
      );
    }
    else
    {
      //assign object to array data
      $data = array(
        'username' => $pUser->username,
        'lname' => $pUser->lname,
        'password' => password_hash($pUser->password, PASSWORD_DEFAULT),
        'role' => $pUser->role
      );
    }

    //excute in db
    $this->db->where('uid', $pUser->uid);
    $this->db->update($this->TABLE_NAME, $data);
    //return
    return ($this->db->affected_rows() > 0) ? true : 'Fail in update the user';
  }


  /**
   * implement delete a user in database
   */
  public function delete($uid)
  {
    //excute in db
    $this->db->where('uid', $uid);
    $this->db->delete($this->TABLE_NAME);
    //return
    return ($this->db->affected_rows() > 0) ? true : 'Fail in delete the user';
  }

  /**
   * implement get all of users in database
   */
  public function getAll()
  {
    //excute in db
    $query = $this->db->get($this->TABLE_NAME);
    //return result as array of object
    return $query->result('UserModel');
  }

  /**
   * authenticate the user
   */
  public function authenticate($username, $password)
  {
    $condition = "username =" . "'" . $username . "'";

    $this->db->select('*');
    $this->db->from($this->TABLE_NAME);
    $this->db->where($condition);
    $this->db->limit(1);

    $query = $this->db->get();
    if ($query->num_rows() == 1) {
      return $query->result('UserModel')[0];
    } else {
      return false;
    }
  }


}
?>
