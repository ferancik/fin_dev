<?php 

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Transactions {
  var $CI;
  
   public function __construct() {
      $this->CI = & get_instance();
      $this->CI->load->model('admin/platobnemoduly/transactions_m','', TRUE);
  }
    
  public function addTransactions($data){
     $this->CI->transactions_m->insertTransactions($data);
  }
  
  public function getAllTransactions(){
     return  $this->CI->transactions_m->getAllTransactions();
  }
   public function delTransactions($id){
       $this->CI->transactions_m->delTransactions($id);
  }
}

