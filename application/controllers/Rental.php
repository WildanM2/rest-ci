<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Don't forget include/define REST_Controller path

/**
 *
 * Controller Rental
 *
 * This controller for ...
 *
 * @package   CodeIgniter
 * @category  Controller REST
 * @author    Setiawan Jodi <jodisetiawan@fisip-untirta.ac.id>
 * @author    Raul Guerrero <r.g.c@me.com>
 * @link      https://github.com/setdjod/myci-extension/
 * @param     ...
 * @return    ...
 *
 */

use chriskacerguis\RestServer\RestController;

class Rental extends RestController
{
    
  public function __construct()
  {
    parent::__construct();
    $this->load->model('rental_model', 'rnt');
    $this->methods['index_get']['limit'] = 2;
  }

  public function index_get()
  {
    $id = $this->get('No_mobil', true);
    if ($id === null){
      $p = $this->get('page');
      $p = (empty($p) ?  1 : $p);
      $total_data= $this->rnt->count();
      $total_page = ceil($total_data / 5);
      $start = ($p - 1) * 5;
    $list = $this->rnt->get(null, 5, $start);
    if ($list) {
    $data = [
      'status' => true,
      'page' => $p,
      'total_data' => $total_data,
      'total_page' => $total_page,
      'data' => $list
    ];
   } else {
    $data=[
      'status'=>false,
      'msg'=> 'Data tidak ditemukan'
    ];
   }
    $this->response($data, RestController::HTTP_OK);
    } else {
      $data = $this->rnt->get($id);
      if ($data){
      $this->response(['status' => true,'data' => $data], RestController::HTTP_OK);
      } else{
        $this->response(['status' => false,'msg' => 'Harga ' . $id . ' tidak ditemukan'], RestController::HTTP_NOT_FOUND);
      }
    }
  }

  public function index_post()
  {
    $data = [
      'No_mobil'=>$this->post('No_mobil', true),
      'No_polisi'=>$this->post('No_polisi', true),
      'Nama_mobil'=>$this->post('Nama_mobil', true),
      'Warna'=>$this->post('Warna', true),
      'Harga_sewa'=>$this->post('Harga_sewa', true)
    ];
    $simpan=$this->rnt->add($data);
    if($simpan['status']){
      $this->response(['status'=>true,'msg'=>$simpan['data']. ' Data telah ditambahkan'], RestController::HTTP_CREATED);
    } else {
      $this->response(['status'=>false, 'msg'=>$simpan['msg']], RestController::HTTP_INTERNAL_ERROR);
    }
  }

  public function index_put()
  {
    $data = [
      'No_mobil'=>$this->put('No_mobil', true),
      'No_polisi'=>$this->put('No_polisi', true),
      'Nama_mobil'=>$this->put('Nama_mobil', true),
      'Warna'=>$this->put('Warna', true),
      'Harga_sewa'=>$this->put('Harga_sewa', true)
    ];
    $id=$this->put('No_mobil', true);
    if($id===null){
      $this->response(['status'=>false, 'msg'=> 'Masukkan Nomer Mobil yang akan dirubah'], RestController::HTTP_BAD_REQUEST);
    }
    $simpan=$this->rnt->update($id, $data);
    if($simpan['status']){
      $status=(int)$simpan['data'];
      if ($status>0)
      $this->response(['status'=>true,'msg'=>$simpan['data']. ' Data telah dirubah'], RestController::HTTP_OK);
      else
      $this->response(['status'=>false, 'msg'=> 'Tidak ada data yang dirubah'], RestController::HTTP_BAD_REQUEST);
    } else {
      $this->response(['status'=>false, 'msg'=>$simpan['msg']], RestController::HTTP_INTERNAL_ERROR);
    }
  }

  public function index_delete()
  {
    $id=$this->delete('No_mobil', true);
    if($id===null){
      $this->response(['status'=>false, 'msg'=> 'Masukkan Nomer Mobil yang akan dihapus'], RestController::HTTP_BAD_REQUEST);
    }
    $delete= $this->rnt->delete($id);
    if($delete['status']) {
      $status=(int)$delete['data'];
      if ($status>0)
      $this->response(['status'=>true,'msg'=>'Mobil nomer '. $id. ' data telah dihapus'], RestController::HTTP_OK);
      else
      $this->response(['status'=>false, 'msg'=> 'Tidak ada data yang dihapus'], RestController::HTTP_BAD_REQUEST);
    } else {
      $this->response(['status'=>false, 'msg'=>$delete['msg']], RestController::HTTP_INTERNAL_ERROR);
    }
  }
}


/* End of file Rental.php */
/* Location: ./application/controllers/Rental.php */