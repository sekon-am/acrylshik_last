<?php
class Manproduct extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('Categorymodel','Categorymodel');
		$this->load->model('Authmodel','Authmodel');
		$this->load->model('Productmodel','Productmodel');
		$this->load->helper('fix');
		$this->Productmodel->setPermissions();
	}
	function dashboard() {
		$this->Authmodel->checkEditor();
		$this->load->view(
			'admin/table2edit',
			array(
				'title'	=> lang('Products'),
				'data'	=> $this->Productmodel->getAllProducts(),
				'table'	=> 'product',
				'field'	=> 'title',
			)
		);
	}
	function add() {
			$edit_form = $this->load->view('editor/product_add',array(
				'product'=>null,
				'categories'=>$this->Categorymodel->getCategories(),
				'rand'=>mt_rand(),
			),true);
			$this->load->view('modal',array(
				'title'	=> lang('Add product'),
				'content'	=> $edit_form,
				'save'	=> lang('Save'),
			));
	}
	function edit($id) {
		if( $product = $this->Productmodel->details($id) ) {
			$edit_form = $this->load->view('editor/product_add',array(
				'product'=>$product,
				'categories'=>$this->Categorymodel->getCategories(),
				'rand'=>mt_rand(),
			),true);
			$this->load->view('modal',array(
				'title'	=> lang('Edit product'),
				'content'	=> $edit_form,
				'save'	=> lang('Save'),
			));
		}
	}
	function save($id=0) {
		$name = $this->input->post('name');
		$category_id = $this->input->post('category_id');
		$txt = $this->input->post('txt');
		$seo_title = $this->input->post('seo_title');
		$seo_descr = $this->input->post('seo_descr');
		$seo_kwds  = $this->input->post('seo_kwds');
		$tpl = '';
		$res = null;
		if($id){
			$res = $this->Productmodel->update($id,$name,$category_id,$txt,$seo_title,$seo_descr,$seo_kwds);
		}else{
			$res = $this->Productmodel->insert($name,$category_id,$txt,$seo_title,$seo_descr,$seo_kwds);
		}
		$code = 'ERROR';
		if($res){
			$code = 'OK';
			if(!$id){
				$tpl = $this->load->view('admin/table-tr',array(
					'row'=>$this->Productmodel->details($this->db->insert_id()),
					'table'=>'product',
					'index'=>$this->input->post('count'),
				),true);
			}
		}
		header('Content-Type: application/json');
		echo json_encode(array('code' => $code, 'tr' => $tpl,));
	}
	function delete($id) {
		$this->Productmodel->delArticle($id);
		echo '{"code":"OK"}';
	}
	function lst() {
		$this->load->view('editor/lst-product');
	}
	function multiupload($id) {
		if(!$id)$id = $this->input->post('id');
		$dir = './uploads/products/' . $id . '/';
		if(!file_exists($dir)){
			mkdir($dir);
		}
		$this->load->library('uploadhandler',array(
			'options'=>array(
				'upload_dir'=>$dir,
				'upload_url'=>site_url($dir).'/',
				'script_url'=>site_url('manproduct/multiupload/'.$id.'/'),
			),
		));
	}
}