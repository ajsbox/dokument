<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
-- ------~\__
-- CMSLogik |__________________
-- File: controllers/user.php |
-- ---------------------------/
*/

class User extends CI_Controller {

	//Will hold our user data.
	private $user;

	public function __construct()
	{
	    parent::__construct();
	    $this->load->library('auth');
	    $this->load->library('logik');
		//print_r($this->logik->get_level());exit;
	    if(!$this->session->userdata("username"))
	    {
			$this->session->sess_destroy();
			redirect($this->logik->setting('default_url'));
	    } elseif($this->logik->get_level()!=2) {
			$this->session->sess_destroy();
			redirect($this->logik->setting('default_url'));
		}
		$this->load->model('user_model');
		$this->user = $this->user_model->get_user();
		
		/////for pagination//////
		$dirName = explode('/', $this->logik->setting("default_url"));
		$size = count($dirName)-2;
		include_once $_SERVER['DOCUMENT_ROOT'].'/'.$dirName[$size].'/assets/pagination.php';
	}

	public function home_ajax() {
		////end docs pagination////
		$page_cls = new pagination(0, 0, 0);
		$page_id = $page_number = $this->input->post('page_number');
		
        $item_par_page = 10;
        $position = ($page_number*$item_par_page);
		$page_cls->start = $page_number;
		$page_cls->end = $item_par_page;
		if($page_number==0) {
			$page_number = 1;
		}
		if($page_number==0) {
			$noOfPage = 10;
		} else {
			$noOfPage = (1+$page_number)*$item_par_page;
		}
		$countPageUserDocs = $item_par_page*$page_number+$item_par_page ;
		$docs = $this->user_model->getUserDocuments();
		$userDocs = array();
		$countUserDocs = 0;
		$countAll = 0;
		//echo $page_cls->start.$page_cls->end;
		//echo $countPageUserDocs;
		if($this->input->post('search')!='') {
			$srchText = $this->input->post('search');
		} else {
			$srchText = '';
		}
		$latestDocs = array();
		$docCount = 0;
		foreach($docs as $key=>$doc) {
			$countAll += $this->user_model->countTotalValue($doc['table_name'], $srchText);
			$latestDoc = $this->user_model->getLatestRecord($doc['table_name'], 0, $noOfPage);
			$docCount++;
			
			//if(empty($srchText) and $page_number==-1 and !empty($latestDoc)) {
				if(count($latestDocs)<10) { 
					foreach($latestDoc as $k1=>$v1) {
						$latestDocs[$v1['created1']] = $v1;
						$latestDocs[$v1['created1']]['table_name'] = $doc['table_name'];
						if(count($latestDocs)==10) {
							//break;
						}
					}
				}
				foreach($latestDoc as $key1=>$value) {
					//if(!empty($latestDocs) and count($latestDocs)>10) {
						$f = 0;
						foreach($latestDocs as $ky=>$docm) {
							if($docm['created1'] < $value['created1']) {
								//unset($latestDocs[$docm['created']]);
								$latestDocs[$value['created1']] = $value;
								$latestDocs[$value['created1']]['table_name'] = $doc['table_name'];
								$f = 1;
							}
							if($f==1) {
								break;
							}
						}
					//} else {
					//	break;
					//}
				}
			//}
			
			if($countUserDocs>=$countPageUserDocs) {
				$page_cls->start=0;
				continue;
			}
			//echo $page_cls->start;
			if($page_cls->start==0) {
				$diff = 0;
			} else {
				$diff = $countPageUserDocs-$item_par_page;
			}
			$page_cls->start = $diff;
			$page_cls->end = $item_par_page-$countUserDocs;
			//echo $page_cls->start.$page_cls->end.$doc['table_name'];exit;
			$data = $this->user_model->get_table_data($doc['table_name'], $page_cls->start, $page_cls->end, $srchText);
			if(!empty($data)) {
				foreach($data as $k=>$v) {
					$data[$k]['groups'] = $this->user_model->getGroupById($v['groups']);
					/*if(!empty($latestDocs)) {
						foreach($latestDocs as $sk=>$sv) {
							if($sv['id']==$v['id'] and $sv['table_name']==$doc['table_name']) {
								unset($data[$k]);
							}
						}
					}*/
				}
				$countUserDocs += count($data);
				$userDocs[$doc['table_name']] = $data;
				unset($data);
			}
			$page_cls->start=0;
		}
		//print_r(count($latestDocs));exit;
		if(!empty($latestDocs)  and empty($srchText)) {
			foreach($latestDocs as $k=>$v) {
				//$latestDocs[$k]['created'] = date('d, m Y', $v['created']);
				$latestDocs[$k]['groups'] = $this->user_model->getGroupById($v['groups']);
			}
			krsort($latestDocs); //echo $page_id;exit;
			$latestDocs = array_chunk($latestDocs,10);
			$userDocs = array($latestDocs[$page_id]);
		}

		//print_r($userDocs);exit;
		if(!empty($countAll) and $countAll>10) {
			//$countAll += 10;
		}
		$total_set =  $countAll;
        //break total recoed into pages
        $total = ceil($countAll/$item_par_page);
		//echo $total;exit;
        if($total_set>0) {
			$data = array(
				'TotalRows' => $total,
				'Rows' => $userDocs
			);
			$this->output->set_content_type('application/json');
			echo json_encode(array($data));
        }
		/*$_SESSION['first_page'] = array();
		if(empty($srchText) and $page_number==-1 and !empty($latestDoc)) {
			foreach($latestDocs as $key=>$v) {
				$_SESSION['first_page'][$key]['id'] = $v['id'];
				$_SESSION['first_page'][$key]['table_name'] = $v['table_name'];
			}
		} else {
			//unset($_SESSION['first_page']);
		}*/
		
        exit;
	}
	
	public function searchByAjax() {
		////search docs pagination////
		$page_cls = new pagination(0, 0 , 0);
		$page_id = $page_number = $this->input->post('page_number');
		//print_r($this->input->post('searchFields'));exit;
        $item_par_page = 10;
        $position = ($page_number*$item_par_page);
		$page_cls->start = $page_number;
		$page_cls->end = $item_par_page;
		if($page_number==0) {
			$page_number = 1;
		}
		$countPageUserDocs = $item_par_page*$page_number+$item_par_page ;
		//$docs = $this->user_model->getUserDocuments();
		if(empty($_POST['doc_type']) and empty($_POST['groups'])) {
			$docs = $this->user_model->getUserDocuments();
		} else {
			$docs = $this->user_model->searchUserDocuments($_POST);
		}
		$userDocs = array();
		$countUserDocs = 0;
		$countAll = 0;
		//echo $page_cls->start.$page_cls->end;
		//echo $countPageUserDocs;
		if($this->input->post('search')!='') {
			$srchText = $this->input->post('search');
		} else {
			$srchText = '';
		}
		unset($_POST['page_number']);
		unset($_POST['search']);
		unset($_POST['submit']);
		foreach($docs as $key=>$doc) {
			$countAll += $this->user_model->countTotalValueBySearch($doc['table_name'], $_POST, $srchText);
			if($countUserDocs>=$countPageUserDocs) {
				$page_cls->start=0;
				continue;
			}
			//echo $page_cls->start;
			if($page_cls->start==0) {
				$diff = 0;
			} else {
				$diff = $countPageUserDocs-$item_par_page;
			}
			$page_cls->start = $diff;
			$page_cls->end = $item_par_page-$countUserDocs;
			//echo $page_cls->start.$page_cls->end.$doc['table_name'];exit;
			
			$data = $this->user_model->get_table_data_search($doc['table_name'], $_POST, $page_cls->start, $page_cls->end, $srchText);
			if(!empty($data)) {
				$countUserDocs += count($data);
				foreach($data as $k=>$v) {
					$data[$k]['groups'] = $this->user_model->getGroupById($v['groups']);
					//$data[$k]['created'] = date('d, F Y', $data[$k]['created']);
					if(!empty($data[$k]['modified'])) {
						$data[$k]['modified'] = date('d, m Y', $data[$k]['modified']);
					} else {
						$data[$k]['modified'] = '----';
					}
				}
				
				$userDocs[$doc['table_name']] = $data;
				unset($data);
			}
			$page_cls->start=0;
		}
		//print_r($userDocs);exit;
		$userDocs1 = array();
		
		if(!empty($userDocs)) {
			foreach($userDocs as $k=>$v) {
				foreach($v as $v1) { 
					$userDocs1[$v1['created']] = $v1;
					//$userDocs1[$v1['created']]['groups'] = $this->user_model->getGroupById($v1['groups']);
					$userDocs1[$v1['created']]['created'] = date('d, m Y', $v1['created']+21600);
					$userDocs1[$v1['created']]['table'] =  $k;
				}
			}
			krsort($userDocs1);
			$userDocs1 = array_chunk($userDocs1,10);
			$userDocs1 = array($userDocs1[$page_id]);
		}
		
		//print_r($userDocs1);exit;
		$total_set =  $countAll;
        //break total recoed into pages
        $total = ceil($countAll/$item_par_page);
        if($total_set>0) {

			$data = array(
				'TotalRows' => $total,
				'Rows' => $userDocs1
			);     
				
			$this->output->set_content_type('application/json');
			
			echo json_encode(array($data));
        }
        exit;
	}
	
	public function sent_ajax() {
		////end docs pagination////
		$page_cls = new pagination(0, 0 , 0);
		$page_number = $this->input->post('page_number');
		
        $item_par_page = 10;
        $position = ($page_number*$item_par_page);
		$page_cls->start = $page_number;
		$page_cls->end = $item_par_page;
		if($page_number==0) {
			//$page_number = 1;
		}
		
		$docs = $this->user_model->getUserDocuments();
		$userDocs = array();
		$countUserDocs = 0;
		$countAll = 0;
		//echo $page_cls->start.$page_cls->end;
		//echo $countPageUserDocs;
		if($this->input->post('search')!='') {
			$srchText = $this->input->post('search');
		} else {
			$srchText = '';
		}
		$sentDocuments = $this->user_model->getUserSentDocs();
		$sentDocs = array();
		$countSent = 0;
		$pageNo = 0;
		$totalSent = 0;
		foreach($sentDocuments as $key=>$document) {
			$totalSent += $this->user_model->totalSentDocs($document['table_name'], $document['document_id'], $srchText);
			$pageNo = (($page_number)*$item_par_page);
			$countSent++;
			$lastRec = $pageNo+$item_par_page;
			if($countSent<=$pageNo or $countSent > $lastRec) {
				continue;
			}
			if($countSent <= $lastRec) {
				 $data = $this->user_model->getDocumentsByTableName($document['table_name'], $document['document_id'], $srchText);
				 if(!empty($data)) {
					//foreach($data as $k=>$v) {
						$data['groups'] = $this->user_model->getGroupById($data['groups']);
					//}
					$sentDocs[$key] = $data;
					$sentDocs[$key]['table_name'] = $document['table_name'];
				 }
				
			}
		}
		$total_set = $totalSent;
		
        //break total recoed into pages
        $total = ceil($totalSent/$item_par_page);
        if($total_set>0) {

			$data = array(
				'TotalRows' => $total,
				'Rows' => $sentDocs
			);     
				
			$this->output->set_content_type('application/json');
			echo json_encode(array($data));
        }
        exit;
	}
	
	public function recieve_ajax() {

		$page_cls = new pagination(0, 0 , 0);
		$page_number = $this->input->post('page_number');
		
        $item_par_page = 10;
        $position = ($page_number*$item_par_page);
		$page_cls->start = $page_number;
		$page_cls->end = $item_par_page;
		if($page_number==0) {
			//$page_number = 1;
		}
		
		$docs = $this->user_model->getUserDocuments();
		$userDocs = array();
		$countUserDocs = 0;
		$countAll = 0;
		//echo $page_cls->start.$page_cls->end;
		//echo $countPageUserDocs;
		if($this->input->post('search')!='') {
			$srchText = $this->input->post('search');
		} else {
			$srchText = '';
		}
		$sentDocuments = $this->user_model->getUserRevieveDocs();
		$sentDocs = array();
		$countSent = 0;
		$pageNo = 0;
		$totalSent = 0;
		foreach($sentDocuments as $key=>$document) {
			$totalSent += $this->user_model->totalRecievDocs($document['table_name'], $document['document_id'], $srchText);
			$pageNo = (($page_number)*$item_par_page);
			$countSent++;
			$lastRec = $pageNo+$item_par_page;
			if($countSent<=$pageNo or $countSent > $lastRec) {
				continue;
			}
			if($countSent <= $lastRec) {
				 $data = $this->user_model->getDocumentsByTableName($document['table_name'], $document['document_id'], $srchText);
				 if(!empty($data)) {
					$data['groups'] = $this->user_model->getGroupById($data['groups']);
					$sentDocs[$key] = $data;
					$sentDocs[$key]['table_name'] = $document['table_name'];
				 }
			}
		}
		$total_set = $totalSent;
        //break total recoed into pages
        $total = ceil($totalSent/$item_par_page);
        if($total_set>0) {
			$data = array(
				'TotalRows' => $total,
				'Rows' => $sentDocs
			);
			$this->output->set_content_type('application/json');
			echo json_encode(array($data));
        }
        exit;
	}
	
	public function home()
	{
		$docTypes = $this->user_model->getDocTypes();
		$this->load->view('tmp', array('tmp' => 'user/manage_table', 'docTypes'=>$docTypes));
	}

	public function settings()
	{
		$js_path=$this->logik->setting("default_url")."assets/form/";
        array_push($this->setting_model->external_js,$js_path."js/validation");
		$this->load->view('tmp', array('tmp' => 'user/settings'));
	}

	public function update_profile() {
		if(!empty($_POST)) {
			//array_pop($_POST);
			if(isset($_FILES['image'])) {
				$time = time();
				if(move_uploaded_file($_FILES['image']['tmp_name'],"image_gallery/user/".$time."-".$_FILES['image']['name'])) {
					@unlink("image_gallery/user/".$this->auth_model->get_user()->image);
					$_POST['image']=$time.'-'.$_FILES['image']['name'];
				}
			}
			$this->user_model->update_user($_POST);
			$this->auth_model->saveUserHistory($this->lang->line("action_update_profile"));
		}
		$js_path=$this->logik->setting("default_url")."assets/form/";
        array_push($this->setting_model->external_js,$js_path."js/validation");
		$this->load->view('tmp', array('tmp' => 'user/settings', 'user_update' => '1'));
	}

	public function update_password() {
		$js_path=$this->logik->setting("default_url")."assets/form/";
        array_push($this->setting_model->external_js,$js_path."js/validation");
		if($this->user_model->check_password($this->input->post('old_password')) === FALSE) {
			$this->load->view('tmp', array('tmp' => 'user/settings', 'password_error' => '1'));
		} else {
			$this->db->where("setting", "password_length");
			$this->db->where("value", 1);
			$pwdLength = $this->db->get("settings")->row_array();
			$valPass = '';
			if(!empty($pwdLength)) {
				$valPass = '|min_length[8]';
			}
			$this->form_validation->set_rules('new_password1', 'Password', 'trim|required'.$valPass.'|max_length[25]');
			$this->form_validation->set_rules('new_password2', 'Password Confirmation', 'trim|required|matches[new_password1]');
			if($this->form_validation->run() === FALSE) {
				$this->load->view('tmp', array('tmp' => 'user/settings'));
			} else {
				$this->user_model->update_password($this->input->post('new_password1'));
				$this->auth_model->saveUserHistory($this->lang->line("action_update_password"));
				$this->load->view('tmp', array('tmp' => 'user/settings', 'password_update' => '1'));
			}
		}
	}
	
	/////dhiru 1-05-2014////
	public function documents() {
		
		$isValid = $this->user_model->checkValidRoles('Cargar');
		if(!$isValid) {
			//redirect($this->logik->setting('default_url').'user/my_documents');
		}
		$updated = 0;
		if(!empty($_POST)) {
			unset($_POST['name_form']);
			unset($_POST['zebra_honeypot_form']);
			unset($_POST['zebra_csrf_token_form']);
			unset($_POST['documents']);
			//unset($_POST['doc_id']);
		
			$tblName = $_POST['table'];
			unset($_POST['table']);
			unset($_POST['btnsubmit']);
			//print_r(key($_FILES));exit;
			unset($_POST['MAX_FILE_SIZE']);
			//unset($_POST['upload_default']);
			if(isset($_FILES)) {
				foreach($_FILES as $key=>$file) {
					$time = time();
					$path = "assets/app/file_upload/uploads/";
					if(!is_dir($path.$tblName)) {
						mkdir($path.$tblName, 0777);
					}
					//print_r($_FILES[$key]['tmp_name']);exit;	//if(move_uploaded_file($_FILES[$key]['tmp_name'],"document_files/".$tblName."/".$time."-".$_FILES[$key]['name'])) {
					
					if(move_uploaded_file($_FILES[$key]['tmp_name'], $path.$tblName.'/'.$time.'-'.$_FILES[$key]['name'])) {
						$_POST[$key] = $time.'-'.$_FILES[$key]['name'];
						$_POST['file_names'][] = $time.'-'.$_FILES[$key]['name'];
						
					}
				}
			}
			
			if(file_exists($path.'scan_cache')) {
				$files = scandir($path.'scan_cache');
				if(!empty($files[2])) {
					if(copy($path.'scan_cache/'.$files[2], $path.$tblName.'/'.$files[2])) {
						unlink($path.'scan_cache/'.$files[2]);
						$_POST['scan_file'] = $files[2];
					}
				}
			}
			if(empty($_POST['scan_file']) and empty($_POST['upload_default']) and empty($_POST['file_names'])) {
				$updated = 2;
			} else {
				unset($_POST['upload_default']);
				$docId = $this->user_model->saveDocumentByUser($_POST, $tblName);
				if(isset($_POST['numero_de_documento'])) {
					$docNum = $_POST['numero_de_documento'];
				} else {
					$docNum = $_POST['document__id'];
				}
				$this->auth_model->saveDocumentHistory($this->lang->line("action_create_doc"), $docNum, $tblName);
				$this->auth_model->saveUserHistory($this->lang->line("action_create_doc"), $docId, $tblName);
				$updated = 1;
			}
		}
		//$js_path=$this->logik->setting("default_url")."assets/app/jquery.fancybox/";
	//	array_push($this->setting_model->external_js,$js_path."jquery-1.4.3.min");
		//array_push($this->setting_model->external_js,$js_path."fancybox/jquery.mousewheel-3.0.4.pack");
	//	array_push($this->setting_model->external_js,$js_path."fancybox/jquery.fancybox-1.3.2");
		$js_path=$this->logik->setting("default_url")."assets/form/";
        array_push($this->setting_model->external_js,$js_path."js/document");
		$this->load->view('tmp', array('tmp' => 'user/documents', 'docs' => $this->user_model->getUserDocuments(), 'update'=>$updated));
	}
	
	public function loadDocumentForm() {
		$js_path=$this->logik->setting("default_url")."assets/form/";
        array_push($this->setting_model->external_js,$js_path."js/file_style");
		$path = 'assets/app/file_upload/uploads/';
		if(!is_dir($path.'scan_cache')) {
			mkdir($path.'scan_cache', 0777);
		} else {
			$oldFiles = scandir($path.'scan_cache');
			foreach($oldFiles as $fle) { 
				if($fle!='.' and $fle!='..') {
					unlink($path."scan_cache/".$fle);
				}
			}
		}
		
		if(!empty($_POST['doc_id'])) {
			$docs = $this->user_model->getUserDocumentById($_POST['doc_id']);
			if($docs) {
				$frmData = str_replace("\\", "", $docs['elements']);
				$frmData = json_decode($frmData);
				if(isset($frmData->elements[0]->title) and $frmData->elements[0]->title=='Document__ID') {	
					$functionCall = "validate1";
				} else {
					$functionCall = "validate";
				}
				$this->load->view('jqueryform/Zebra_Form');
				echo '<div id="valid_upload" style="display:none;color:#FF0000;"><strong>Error ! </strong> '.$this->lang->line("document_upload_file").' !</div><div id="valid_desc" style="display:none;color:#FF0000;"><strong>Error ! </strong> * '.$this->lang->line("document_description_required").' !</div><div id="valid_id" style="display:none;color:#FF0000;"><strong>Error ! </strong> * '.$this->lang->line("document_id_required").' !</div><div id="valid_group" style="display:none;color:#FF0000;"><strong>Error ! </strong> * groep is een verplicht veld selecteert u !</div>';
				echo '<form action="" method="post" class="form-horizontal" enctype="multipart/form-data" onSubmit="return '.$functionCall.'();" style="padding-left:35px;">';
				$form = new Zebra_Form('form', 'post', 'documents', array('autocomplete' => 'off'));
				
				
				//$form->add('label', 'groups13', 'group11', 'Groups');
				//$obj = $form->add('select', 'groups');
				
				echo "<div style='margin-left:-28px;display:none;'>Groups</div><br>";
				$groups = $this->auth_model->get_user()->document_groups;
				//$groups = $this->auth_model->get_user()->roles;
				//$groups = unserialize($groups);
				//$groups = explode(",", $groups);
				echo "<select name='groups' id='groups' style='margin-left:-28px;display:none;'>";
				//foreach($groups as $key=>$option) {
					//$options[$option] = $this->user_model->getGroupNameById($option)->name;
					//$isCargar = $this->user_model->checkRolesByIds($option);
					//if($isCargar) {
				echo "<option value='".$groups."'>".$this->user_model->getGroupNameById($groups)->name."</option>";
					//}
				//}
				echo "</select>";
				echo '<div style="margin-left:-29px; display:none;">';
				echo "<input type='file' name='upload_default' id='upload_default'></div>";
				//$obj->add_options($options);05-2014////
				foreach($frmData->elements as $def) {
					$title = strtolower(str_replace(" ", "_", $def->title));
					if($def->type=='select') {
						$form->add('label', 'label_email'.$title, 'email'.$title, str_replace('__', ' ',$def->title));
						$obj = $form->add($def->type, $title, '');
						$a = array();
						foreach($def->options as $option) {
							$a[$option->option] = $option->option;
						}
						$obj->add_options($a);
						/*$optionTxt = '<select name="'.$title.'" style="margin-left:-28px;"><option value="">- Seleccionar -</option>';
						foreach($def->options as $option) {
							$optionTxt .= '<option value="'.$option->option.'">'.$option->option.'</option>';
						}
						$optionTxt .= '</select>';
						echo $optionTxt;*/
					} else {
						$form->add('label', 'label_email'.$title, 'email'.$title, str_replace('__', ' ',$def->title));
						$obj = $form->add($def->type, $title, '', array('autocomplete' => 'off', "title"=>$def->guidelines));
					}
					//$a[] = $def->type;
					 // $form->add('hidden', 'table', $def->name);
					//$obj = $form->add('text', $title);
					/*$obj->set_rule(array(
						'required'  =>  array('error', ' is required!'),
					));*/
					$obj->set_rule(array(
						'required'  =>  array('error', 'A Microsoft Word document is required!'),
						'upload'    =>  array('tmp', ZEBRA_FORM_UPLOAD_RANDOM_NAMES, 'error', 'Could not upload file!<br>Check that the "tmp" folder exists inside the "examples" folder and that it is writable'),
						'filetype'  =>  array('doc, docx', 'error', 'File must be a Microsoft Word document!'),
						'filesize'  =>  array(102400, 'error', 'File size must not exceed 100Kb!'),
					));
					/*if(!empty($def->guidelines)) {
						$form->add('label', 'label_email'.$def->guidelines, 'email'.$def->guidelines, '(<i>'.str_replace('__', ' ', $def->guidelines).'</i>)', array('style'=>'font-size:12px; color:#898989;'));
					}*/
				}
			}
			$frm = str_replace("\\", "", $docs['form_data']);
			$frm = json_decode($frm);

			$form->add('hidden', 'table', $docs['table_name']);
			$form->add('hidden', 'document_id', $_POST['doc_id']);
			$form->add('submit', 'btnsubmit', $this->lang->line("document_save"));
			if ($form->validate()) {
				show_results();
			} else {
				$form->render();
			}
			//echo "<div style='float:left;'><span style='float:left; margin:0px;height:20px;'><a href='".$this->logik->setting("default_url")."user/scan/1' class='scanView' style='margin:0px 0px 0px 0px;'><img src='".$this->logik->setting("default_url")."assets/img/scanner.png'  style='margin:0px 0px 0px 0px; padding:0px;' title='Scan bestand' width='30px'></a></span><span style='float:left; margin:0px;height:20px;'><img src='".$this->logik->setting("default_url")."assets/img/attach.jpg' style='cursor:pointer;margin:0px 0px 0px 0px; padding:0px;' title='upload bestand' width='25px' id='attachImg'></span></div>";
			
			echo '<input type="hidden" name="scan_file" id="scanFile">';
			echo '<input type="hidden" name="uploaded_file" id="uploadedFile">';
			
			echo '</form>';
			echo '<div id="transfer_head" style="color:#FFF;display:none;">';
				echo ucwords($frm->name);
			echo '</div>';
		} else {
			echo " ";
		}
	}
	
	public function loadEditDocumentTypes() {
		$sent = 0;
		if(!empty($_POST['submitFile'])) {
			if(!empty($_FILES)) {
				$time = time();
				$tblName = $_POST['file_table'];
				$path = "assets/app/file_upload/uploads/";
				if(!is_dir($path.$tblName)) {
					mkdir($path.$tblName, 0777);
				} //print_r($_FILES);exit;
				//print_r($_FILES[$key]['tmp_name']);exit;	//if(move_uploaded_file($_FILES[$key]['tmp_name'],"document_files/".$tblName."/".$time."-".$_FILES[$key]['name'])) {
				if(move_uploaded_file($_FILES['upload']['tmp_name'], $path.$tblName.'/'.$time.'-'.$_FILES['upload']['name'])) {
					if(file_exists($path.$tblName.'/'.$_POST['file_name'])) {
						unlink($path.$tblName.'/'.$_POST['file_name']);
					}
					$_POST['file_name'] = $time.'-'.$_FILES['upload']['name'];
					$_POST['original_file_name'] = $_FILES['upload']['name'];
					$_POST['user'] = $this->session->userdata("username");
					$this->user_model->updateDocumentFile($_POST);
					$this->auth_model->saveUserHistory($this->lang->line("action_upload_file"), $_POST['document_id'], $tblName);
					$docItem = $this->user_model->getDocumentByIdandTbl($_POST['document_id'], $tblName);
					if(isset($docItem['numero_de_documento'])) {
						$docNum = $docItem['numero_de_documento'];
					} else {
						$docNum = $docItem['document__id'];
					}
					$this->auth_model->saveDocumentHistory($this->lang->line("action_upload_file"), $docNum, $tblName);
				}
			}
		} elseif(!empty($_POST['sendEx'])) {
			$this->db->select("email");
			$this->db->where("level", 1);
			$admin = $this->db->get("accounts")->row_array();
			$config = Array(
			  /*'protocol' => 'smtp',
			  'smtp_host' => 'ssl://smtp.googlemail.com',
			  'smtp_port' => 465,
			  'smtp_user' => 'abc@gmail.com', 
			  'smtp_pass' => 'passwrd',*/
			  'mailtype' => 'html',
			  'charset' => 'iso-8859-1',
			  'wordwrap' => TRUE
			);
			$subject = "Dokument Management System";
			$message = "This is a attached file from dokument management system <br>";
			$this->load->library('email', $config);
			foreach($_POST['sentFile'] as $file) {
				$this->email->attach($_SERVER['DOCUMENT_ROOT'].$file);
			}
			foreach($_POST['users'] as $user) {
				$this->email->clear();
				$this->email->set_newline("\r\n");
				$this->email->to($user);
				$this->email->from($admin['email']);
				$this->email->subject($subject);
				$this->email->message($message);
				$this->email->send();
				$sent = 1;
			}
			if($sent==1) {
				redirect($this->logik->setting('default_url').'user/loadEditDocumentTypes/'.$_POST['table'].'/'.$_POST['id'].'/sent');
			}
		}
		if($this->uri->segment(3) and $this->uri->segment(4)) {
			$js_path=$this->logik->setting("default_url")."assets/app/jquery.fancybox/";
       		array_push($this->setting_model->external_js,$js_path."jquery-1.4.3.min");
       		array_push($this->setting_model->external_js,$js_path."fancybox/jquery.mousewheel-3.0.4.pack");
       		array_push($this->setting_model->external_js,$js_path."fancybox/jquery.fancybox-1.3.2");
			$users = $this->user_model->getUsersByGroupId();
			$docs = $this->user_model->getDocumentsByTableName($this->uri->segment(3), $this->uri->segment(4));
			//$files = $this->user_model->getDocumentFileById($this->uri->segment(3), $this->uri->segment(4));
			//$Docfiles = $this->user_model->getDocumentMainFiles($this->uri->segment(3), $this->uri->segment(4));
			//$isScanner = $this->user_model->checkValidRoles('Cargar');
			//$isDownload = $this->user_model->checkValidRoles('Descargar');
			//$isModifier = $this->user_model->checkValidRoles('Modificar');
			//if($isScanner) {
	
			if(!empty($docs)) {
				$this->load->view('tmp', array('tmp' => 'user/update_docs', 'docs'=>$docs, 'users'=>$users, 'sent'=>$sent, 'Exusers'=>$this->user_model->getExternalUsers(), "css_prop"=>1));
			} else {
				redirect($this->logik->setting('default_url').'user/my_documents');
			}
			/*} elseif($isDownload) {
				$this->load->view('tmp', array('tmp' => 'user/downloader_docs', 'files'=>$files, 'docFiles'=>$Docfiles));
			} elseif($isModifier) {
				$this->load->view('tmp', array('tmp' => 'user/viewer_docs', 'docs'=>$docs, 'files'=>$files, 'users'=>$users, 'docFiles'=>$Docfiles));
			} else {
				redirect($this->logik->setting('default_url').'user/my_documents');
			}*/
			//$br = 0;
			//$data .="<table class='display'>";
			/*foreach($docs as $key=>$doc) {
				if($key!='id' and $key!='user_id' and $key!='created' and $key!='modified') {
					if($br%2==0) $data .='<tr>';
					$data .= '<td>'.ucwords(str_replace('_', ' ', $key)).'</td>';
					$data .= '<td colspan="2"><input type="text" name="'.$key.'" value="'.$doc.'" id="'.$key.'">';
					if($key=='description') {
						$data .= '<br><div id="valid_desc" style="display:none;color:#FF0000;"><strong>Error ! </strong> * Description field required !</div>';
					}
					$data .= '</td>';
					
					if($br%2==1) $data .='</tr>';
					$br++;
				} elseif($key=='id') {
					$data .= '<input type="hidden" name="'.$key.'" value="'.$doc.'">';
					$data .= '<input type="hidden" name="table" value="'.$this->uri->segment(3).'" id="table">';
				}
			}
			//if($br%2==0) $data .='<tr>';
			$data .='<tr><td colspan="6"><input type="submit" value="Update" name="submit" onclick="return validateEditDoc()"><input type="submit" value="Send" name="send" onclick="retrun userValidate()"><input type="submit" value="Cancel" name="cancel">'.$option.'<br><div id="valid_user" style="display:none;color:#FF0000;"><strong>Error ! </strong> * Please select an user to send !</div></td></tr>';
			//$data .="</table>";
			$files = $this->user_model->getDocumentFileById($docs['id']);
			if(!empty($files)) {
				$fyle = '<tr><th colspan="2">File Name</th><th>User Name</th><th>Created Date</th><th></th></tr><tbody id="appendFile">';
				foreach($files as $file) {
					$fyle .='<tr style="text-align:center;"><td colspan="2">'.$file['file_name'].'</td><td>'.$file['user'].'</td><td>'.date('d, m Y', $file['created']).'</td><td></td></tr>';
				}
				$fyle .='</tbody>';
			} else {
				$fyle = '<tr><th colspan="2">File Name</th><th>User Name</th><th>Created Date</th><th></th></tr><tbody id="appendFile"><tr id="remTR"><td colspan="6">No Foles Uploaded</td></tr></tbody>';
			}*/	
			//echo $data.$fyle;exit;
		} else {
			redirect($this->logik->setting('default_url').'user/my_documents');
		}
	}
	public function viewDocFilesByAjax() {
		$page_cls = new pagination(0, 0 , 0);
		$page_number = $this->input->post('page_number');
		
        $item_par_page = 10;
        $position = ($page_number*$item_par_page);
		$page_cls->start = ($page_number*$item_par_page);
		$page_cls->end = $item_par_page;
		if($this->input->post('search')!='') {
			$srchText = $this->input->post('search');
		} else {
			$srchText = '';
		}
		$Docfiles = $this->user_model->getDocumentMainFiles($this->input->post('table_name'), $this->input->post('doc_id'), $srchText, $page_cls->start, $page_cls->end);
		$totalSent = $this->user_model->countDocumentFiles($this->input->post('table_name'), $this->input->post('doc_id'), $srchText);
		$total_set = $totalSent;
        //break total recoed into pages
        $total = ceil($totalSent/$item_par_page);
        if($total_set>0) {
			$data = array(
				'TotalRows' => $total,
				'Rows' => $Docfiles
			);
			$this->output->set_content_type('application/json');
			echo json_encode(array($data));
        }
        exit;
	}
	
	public function viewDocFilesByAjax1() {
		$page_cls = new pagination(0, 0 , 0);
		$page_number = $this->input->post('page_number');
		
        $item_par_page = 10;
        $position = ($page_number*$item_par_page);
		$page_cls->start = ($page_number*$item_par_page);
		$page_cls->end = $item_par_page;
		if($this->input->post('search')!='') {
			$srchText = $this->input->post('search');
		} else {
			$srchText = '';
		}
		$Docfiles = $this->user_model->getDocumentMainFiles1($this->input->post('table_name'), $this->input->post('doc_id'), $srchText, $page_cls->start, $page_cls->end);
		$totalSent = $this->user_model->countDocumentFiles1($this->input->post('table_name'), $this->input->post('doc_id'), $srchText);
		$total_set = $totalSent;
        //break total recoed into pages
        $total = ceil($totalSent/$item_par_page);
        if($total_set>0) {
			$data = array(
				'TotalRows' => $total,
				'Rows' => $Docfiles
			);
			$this->output->set_content_type('application/json');
			echo json_encode(array($data));
        }
        exit;
	}
	
	public function addFiles() {
		if(isset($_FILES) and !empty($_POST)) {
			$time = time();
			$path = "assets/app/file_upload/uploads/";
			if(!is_dir($path.$_POST['table_name'])) {
				mkdir($path.$_POST['table_name'], 0777);
			}
			//print_r($_POST);exit;	//if(move_uploaded_file($_FILES[$key]['tmp_name'],"document_files/".$_POST['table_name']."/".$time."-".$_FILES[$key]['name'])) {	
			if(move_uploaded_file($_FILES['upload']['tmp_name'], $path.$_POST['table_name'].'/'.$time.'-'.$_FILES['upload']['name'])) {
				$_POST['file_name'] = $time.'-'.$_FILES['upload']['name'];
				$_POST['original_file_name'] = $_FILES['upload']['name'];
			}
			$this->user_model->addFile($_POST);
			$this->auth_model->saveUserHistory($this->lang->line("action_upload_new_file"), $_POST['document_id'], $_POST['table_name']);
			
			$docItem = $this->user_model->getDocumentByIdandTbl($_POST['document_id'], $_POST['table_name']);
			if(isset($docItem['numero_de_documento'])) {
				$docNum = $docItem['numero_de_documento'];
			} else {
				$docNum = $docItem['document__id'];
			}
			$this->auth_model->saveDocumentHistory($this->lang->line("action_upload_new_file"), $docNum, $_POST['table_name']);
		}
		redirect($this->logik->setting('default_url').'user/upload/'.$_POST['table_name'].'/'.$_POST['document_id'].'/uploaded');
	}
	
	public function downloadDocFiles() {
		$file = $this->uri->segment(3);
		$file = "assets/app/file_upload/uploads/".$file;
		if (file_exists($file)) {
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename='.basename($file));
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($file));
			ob_clean();
			flush();
			readfile($file);
			exit;
		}
	}
	
	public function deleteFile() {
		if(!empty($_POST['file_id'])) {
			$this->db->select("table_name, file_name, document_id");
			$this->db->where("id", $_POST['file_id']);
			$row = $this->db->get("document_files")->row_array();
			$this->auth_model->saveUserHistory($this->lang->line("action_delete_doc_file"), $row['document_id'], $row['table_name']);
			
			$docItem = $this->user_model->getDocumentByIdandTbl($row['document_id'], $row['table_name']);
			if(isset($docItem['numero_de_documento'])) {
				$docNum = $docItem['numero_de_documento'];
			} else {
				$docNum = $docItem['document__id'];
			}
			$this->auth_model->saveDocumentHistory($this->lang->line("action_delete_doc_file"), $docNum, $row['table_name']);
			
			$path = "assets/app/file_upload/uploads/".$row['table_name'].'/'.$row['file_name'];
			if(file_exists($path)) {
				//unlink($path);
			}
			$this->db->query("update document_files set deleted=1 where id='".$_POST['file_id']."'");
			echo $_POST['file_id'];
		} else {
			echo "0";
		}
	}
	
	public function editDocumentTypes() {
		if(!empty($_POST)) {
			if(isset($_FILES)) {
				$countFile = 0;
				foreach($_FILES as $key=>$file) {
					$time = time();
					$path = "assets/app/file_upload/uploads/";
					if(!is_dir($path.$_POST['table'])) {
						mkdir($path.$_POST['table'], 0777);
					}
				//print_r($_FILES);exit;	//if(move_uploaded_file($_FILES[$key]['tmp_name'],"document_files/".$_POST['table']."/".$time."-".$_FILES[$key]['name'])) {
					
					if(move_uploaded_file($_FILES[$key]['tmp_name'], $path.$_POST['table'].'/'.$time.'-'.$_FILES[$key]['name'])) {
						$_POST[$key] = $time.'-'.$_FILES[$key]['name'];
						$_POST['file_names'][] = $time.'-'.$_FILES[$key]['name'];
						if(file_exists($path.$_POST['table']."/".$_POST['files'][$countFile])) {
							unlink($path.$_POST['table']."/".$_POST['files'][$countFile]);
						}
					}
					$countFile++;
				}
			}
			//unset($_POST['files']);
			$docItem = $this->user_model->getDocumentByIdandTbl($_POST['id'], $_POST['table']);
			if(isset($docItem['numero_de_documento'])) {
				$docNum = $docItem['numero_de_documento'];
			} else {
				$docNum = $docItem['document__id'];
			}
			
			if(isset($_POST['submit'])) {
				unset($_POST['submit']);
				unset($_POST['users']);
				$this->user_model->editDocumentTypes($_POST);
				$this->auth_model->saveUserHistory($this->lang->line("action_update_file"), $_POST['id'], $_POST['table']);
				
				$this->auth_model->saveDocumentHistory($this->lang->line("action_update_file"), $docNum, $_POST['table']);
			}
			if(isset($_POST['send'])) {
				if(!empty($_POST['users'])) {
					$this->user_model->sentDocumentTypes($_POST);
					$this->auth_model->saveUserHistory($this->lang->line("action_send_doc"), $_POST['id'], $_POST['table']);
					$this->auth_model->saveDocumentHistory($this->lang->line("action_send_doc"), $docNum, $_POST['table']);
				}
				echo json_encode(array('type'=>1));
				exit;
			}
			if(isset($_POST['delete'])) {
				$this->user_model->deleteDocument($_POST);
				$path = "assets/app/file_upload/uploads/";
				$oldFiles = scandir($path.$_POST['table']);
				/*foreach($oldFiles as $fle) { 
					if($fle!='.' and $fle!='..') {
						unlink($path.$_POST['table']."/".$fle);
					}
				}*/
				//remdir($path.$_POST['table']);
				$this->auth_model->saveUserHistory($this->lang->line("action_delete_doc"), $_POST['id'], $_POST['table']);
				$this->auth_model->saveDocumentHistory($this->lang->line("action_delete_doc"), $docNum, $_POST['table']);
			}
			redirect($this->logik->setting('default_url').'user/my_documents');
		}
	}
	
	public function sendDocuments() {
		$js_path=$this->logik->setting("default_url")."assets/app/jquery.fancybox/";
		array_push($this->setting_model->external_js,$js_path."jquery-1.4.3.min");
		array_push($this->setting_model->external_js,$js_path."fancybox/jquery.mousewheel-3.0.4.pack");
		array_push($this->setting_model->external_js,$js_path."fancybox/jquery.fancybox-1.3.2");
		$data['users'] = $this->user_model->getUsersByGroupId();
		$this->load->view('user/send_docs', $data);
	}
	
	public function searchDocuments() {
		if(!empty($_POST) or !empty($_SESSION['POST'])) {
			if(empty($_POST)) {
				$_POST = $_SESSION['POST'];
			} else {
				$_SESSION['POST'] = $_POST;
			}
		}
		$docTypes = $this->user_model->getDocTypes();
		$this->load->view('tmp', array('tmp' => 'user/search_docs', 'docTypes'=>$docTypes));
	}
	
	public function update_uploadity() {
		if($_POST) {
			$this->user_model->updateDocumentFiles($_POST);
		}
	}
	/////sanju 2-05-2014////
	
	public function my_documents()
	{
		$docTypes = $this->user_model->getDocTypes();
		$this->load->view('tmp', array('tmp' => 'user/manage_table', 'docTypes'=>$docTypes));
	}
	
	public function show_table()
	{	
		if(!empty($_POST['tablename'])) {
			//$rec = $this->user_model->get_table_data($_POST['tablename']);
			$this->load->view('tmp', array('tmp' => 'user/manage_table', 'rec' => $this->user_model->get_table_data($_POST['tablename'])));
			//print_r($rec);exit;
		} else {
			$this->load->view('tmp', array('tmp' => 'user/my_document'));
		}
	}
	
	public function user_graph()
	{
		$js_path=$this->logik->setting("default_url")."graph/";
		array_push($this->setting_model->external_js,$js_path."jquery.min");
		array_push($this->setting_model->external_js,$js_path."jqplot.barMy");
		array_push($this->setting_model->external_js,$js_path."excanvas.min");
		array_push($this->setting_model->external_js,$js_path."jquery.jqplot");
		array_push($this->setting_model->external_js,$js_path."jqplot.min");		
		
		$js_path=$this->logik->setting("default_url")."graph/plugins/";
		array_push($this->setting_model->external_js,$js_path."jqplot.dateAxisRenderer.min");
		array_push($this->setting_model->external_js,$js_path."jqplot.canvasTextRenderer.min");
		array_push($this->setting_model->external_js,$js_path."jqplot.canvasAxisTickRenderer.min");
		array_push($this->setting_model->external_js,$js_path."jqplot.categoryAxisRenderer.min");
		array_push($this->setting_model->external_js,$js_path."jqplot.barRenderer.min");
		//$this->load->view('tmp', array('tmp' => 'user/user_graph'));
		$this->load->view('tmp', array('tmp' => 'user/user_graph', 'doc' => $this->user_model->getdocu(), 'rol' => $this->user_model->getrol(), 'group' => $this->user_model->getgroups(), 'user' => $this->user_model->getaccounts()));
	}
	public function scan() {
		$this->load->view('scaner/index', array('docId'=>$this->uri->segment(3), 'table_name'=>$this->uri->segment(4), 'url'=>$this->logik->setting("default_url")));
	}
	
	public function editScan() {
		$this->load->view('scaner/edit-index', array('docId'=>$this->uri->segment(3), 'table_name'=>$this->uri->segment(4), 'file_name'=>$this->uri->segment(5), 'description'=>$this->uri->segment(6), 'url'=>$this->logik->setting("default_url"), 'main'=>$this->uri->segment(7)));
	}
	
	public function createScan() {
		$this->load->view('scaner/index_create', array('docId'=>$this->uri->segment(3), 'url'=>$this->logik->setting("default_url")));
	}

	public function upload() { //print_r($this->uri->segment(4));exit;
		if($this->uri->segment(5)) {
			$uploaded = true;
		} else {
			$uploaded = false;
		}
		$this->load->view('user/upload_docs', array('docId'=>$this->uri->segment(4), 'tableName'=>$this->uri->segment(3),'url'=>$this->logik->setting("default_url"), 'uploaded'=>$uploaded));
	}
	public function statistics() {
		$searchDoc = array();
		$searchUser = array();
		$searchGroup = array();
		if(!empty($_POST)) {
			if(isset($_POST['document'])) {
				array_pop($_POST);
				$searchDoc = $_POST;
			}
			if(isset($_POST['user'])) {
				array_pop($_POST);
				$searchUser = $_POST;
			}
			if(isset($_POST['group'])) {
				array_pop($_POST);
				$searchGroup = $_POST;
			}
		}
		/////for count document by doc type/////////
		$this->db->select("id, name, table_name, groups");
		$this->db->from("doc_types");
		$this->db->where("publish", 2);
		$documents = $this->db->get()->result_array();
		$userDocs = array();
		$byGroup = $documents;
		foreach($documents as $key=>$doc) {
			$documents[$key]['total_doc'] = $this->admin_model->countTotalDocsByTable($doc['table_name'], $searchDoc); 
			$userDocs = array_merge($userDocs, $this->admin_model->countByUsername($doc['table_name'], $searchUser));
			$byGroup[$key]['total_doc'] = $this->admin_model->countTotalDocsByTable($doc['table_name'], $searchGroup);
			if($documents[$key]['total_doc']==0) {
				unset($documents[$key]);
			}
		}
		/////for count document by user ///////////
		$users = $this->admin_model->getUsernames();
		foreach($users as $key => $user) {
			foreach($userDocs as $key1=>$docs) {
				if($docs['user_id'] == $user['username']) {
					if(isset($users[$key]['total_doc'])) {
						$users[$key]['total_doc'] += $docs['total'];
					} else {
						$users[$key]['total_doc'] = $docs['total'];
					}
				}
			}
			if(!isset($users[$key]['total_doc'])) {
				unset($users[$key]);
			}
		}
		/////for count document by group id//////
		$groups = $this->admin_model->getGroups();
		foreach($groups as $key=>$group) {
			foreach($byGroup as $document) {
				$grps = explode(",", $document['groups']);
				if(in_array($group['id'], $grps)) {
					if(isset($groups[$key]['total_doc'])) {
						$groups[$key]['total_doc'] += $document['total_doc'];
					} else {
						$groups[$key]['total_doc'] = $document['total_doc'];
					}
				}
			}
			if(!isset($groups[$key]['total_doc']) or $groups[$key]['total_doc']==0) {
				unset($groups[$key]);
			}
		}
		$this->load->view('tmp', array('tmp' => 'user/statistics', "documents"=>$documents, "users"=>$users, "groups"=>$groups));	
	}
	public function log() {
		$date = array();
		if(!empty($_POST)) {
			$date = $_POST;
		}
		$docs = $this->admin_model->getUserDocuments();
		$userDocs = array();
		foreach($docs as $key=>$doc) {
			$userDocs[$doc['table_name']] = $this->admin_model->getDocumentTableData($doc['table_name'], $date);
		}
		$userLogs = $this->admin_model->getUserLogs($date);
		$this->load->view('tmp', array('tmp' => 'user/log', 'rec'=>$userDocs, 'userLogs'=>$userLogs));	
	}
	
	public function graph() {
		$js_path=$this->logik->setting("default_url")."assets/app/js/";
		array_push($this->setting_model->external_js,$js_path."graph/jquery.jqplot.min");
        array_push($this->setting_model->external_js,$js_path."graph/plugins/jqplot.barRenderer.min");
		array_push($this->setting_model->external_js,$js_path."graph/plugins/jqplot.categoryAxisRenderer.min");
		array_push($this->setting_model->external_js,$js_path."graph/plugins/jqplot.pointLabels.min");
		
		$searchDoc = array();
		$searchUser = array();
		$searchGroup = array();
		if(!empty($_POST)) { //print_r($_POST);exit;
			if(isset($_POST['document'])) {
				array_pop($_POST);
				$searchDoc = $_POST;
			}
			if(isset($_POST['user'])) {
				array_pop($_POST);
				$searchUser = $_POST;
			}
			if(isset($_POST['group'])) {
				array_pop($_POST);
				$searchGroup = $_POST;
			}
		}
		/////for count document by doc type/////////
		$this->db->select("id, name, table_name, groups");
		$this->db->from("doc_types");
		$this->db->where("publish", 2);
		$documents = $this->db->get()->result_array();
		$userDocs = array();
		$byGroup = $documents;
		foreach($documents as $key=>$doc) {
			$documents[$key]['total_doc'] = $this->admin_model->countTotalDocsByTable($doc['table_name'], $searchDoc); 
			$userDocs = array_merge($userDocs, $this->admin_model->countByUsername($doc['table_name'], $searchUser));
			$byGroup[$key]['total_doc'] = $this->admin_model->countTotalDocsByTable($doc['table_name'], $searchGroup);
			if($documents[$key]['total_doc']==0) {
				unset($documents[$key]);
			}
		}
		/////for count document by user ///////////
		$users = $this->admin_model->getUsernames();
		foreach($users as $key => $user) {
			foreach($userDocs as $key1=>$docs) {
				if($docs['user_id'] == $user['username']) {
					if(isset($users[$key]['total_doc'])) {
						$users[$key]['total_doc'] += $docs['total'];
					} else {
						$users[$key]['total_doc'] = $docs['total'];
					}
				}
			}
			if(!isset($users[$key]['total_doc'])) {
				unset($users[$key]);
			}
		}
		/////for count document by group id//////
		$groups = $this->admin_model->getGroups();
		foreach($groups as $key=>$group) {
			foreach($byGroup as $document) {
				$grps = explode(",", $document['groups']);
				if(in_array($group['id'], $grps)) {
					if(isset($groups[$key]['total_doc'])) {
						$groups[$key]['total_doc'] += $document['total_doc'];
					} else {
						$groups[$key]['total_doc'] = $document['total_doc'];
					}
				}
			}
			if(!isset($groups[$key]['total_doc']) or $groups[$key]['total_doc']==0) {
				unset($groups[$key]);
			}
		}
		$this->load->view('tmp', array('tmp' => 'user/graph', "documents"=>$documents, "users"=>$users, "groups"=>$groups));	
	}
	
	public function isFileScaned() {
		//$path = $this->logik->setting("default_url").'assets/app/file_upload/uploads/';
		//echo "0";exit;
		if(file_exists($path.'scan_cache')) {
			$files = scandir($path.'scan_cache');
			if(!empty($files[2])) {
				echo '1';
			} else {
				echo '0';
			}
		}
	}
	
	public function ajaxUpdateFiles() {
		$this->db->where('document_id', $_POST['document_id']);
		$this->db->where('table_name', $_POST['table_name']);
		$this->db->from('document_files');
		$files = $this->db->count_all_results();
	
		$docs = $this->user_model->getLastDocFile($_POST, $files);
		if(!empty($docs)) {
			$docs[0]['total_files'] = $files;
		}
		echo json_encode($docs);exit;
	}
}