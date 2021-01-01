<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * Model Rental_model
 *
 * This Model for ...
 * 
 * @package		CodeIgniter
 * @category	Model
 * @author    Setiawan Jodi <jodisetiawan@fisip-untirta.ac.id>
 * @link      https://github.com/setdjod/myci-extension/
 * @param     ...
 * @return    ...
 *
 */

class Rental_model extends CI_Model {

  // ------------------------------------------------------------------------

  public function __construct()
  {
    parent::__construct();
  }

  public function get($id = null, $limit = 5, $offset = 0)
  {
    if ($id === null)
    {
     return $this->db->get('mobil', $limit, $offset)->result();
    } else{
      return $this->db->get_where('mobil', ['No_mobil' => $id])->result_array();
    }
  }

  public function count()
  {
    return $this->db->get('mobil')->num_rows();
  }

  public function add($data)
  {
    try{
      $this->db->insert('mobil',$data);
      $error=$this->db->error();
      if(!empty($error['code'])){
        throw new Exception('Terjadi kesalahan: '.$error['message']);
        return false;
      }
      return ['status'=>true,'data'=>$this->db->affected_rows()];
    } catch(Exception $ex) {
      return ['status'=>false,'msg'=>$ex->getMessage()];
    }
  }

  public function update($id, $data)
  {
    try{
      $this->db->update('mobil',$data,['No_mobil'=>$id]);
      $error=$this->db->error();
      if(!empty($error['code'])){
        throw new Exception('Terjadi kesalahan: '.$error['message']);
         return false;
      }
      return ['status'=>true,'data'=>$this->db->affected_rows()];
    } catch(Exception $ex) {
      return ['status'=>false,'msg'=>$ex->getMessage()];
    }
  }

  public function delete($id)
  {
    try{
      $this->db->delete('mobil', ['No_mobil' => $id]);
      $error=$this->db->error();
      if(!empty($error['code'])){
        throw new Exception('Terjadi kesalahan: '. $error['message']);
        return false;
      }
      return ['status'=>true,'data'=>$this->db->affected_rows()];
    } catch(Exception $ex) {
      return ['status'=>false,'msg'=>$ex->getMessage()];
    }
  }
}

/* End of file Rental_model.php */
/* Location: ./application/models/Rental_model.php */