<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

class Projects extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('login_model');
		$this->load->model('dashboard_model');
		$this->load->model('employee_model');
		$this->load->model('project_model');
		$this->load->model('Project_model');
		$this->load->model('settings_model');
		$this->load->model('leave_model');
		$this->load->model('logistic_model');
		$this->load->model('attendance_model');
	}

	public function index()
	{
		#Redirect to Admin dashboard after authentication
		if ($this->session->userdata('user_login_access') == 1)
			redirect('dashboard/Dashboard');
		$data = array();
		#$data['settingsvalue'] = $this->dashboard_model->GetSettingsValue();
		$this->load->view('login');
	}
	public function updateProject() {
		$id = $this->input->post('client'); // Client ID
        // Get data from POST request
		$data = array(
			'client_name'             => $this->input->post('clientname'),
			'dob'                     => $this->input->post('dob'),
			'age'                     => $this->input->post('age'),
			'gender'                  => $this->input->post('gender'),
			'religion'                => $this->input->post('religion'),
			'marital_status'          => $this->input->post('maritalstatus'),
			'nationality'             => $this->input->post('nationality'),
			'occupation'              => $this->input->post('occupation'),
			'brgy'                    => $this->input->post('brgy'),
			'mun'                     => $this->input->post('mun'),
			'prov'                    => $this->input->post('prov'),
			'zip'                     => $this->input->post('zip'),
			'contact_no'              => $this->input->post('contactno'),
			'client_email'            => $this->input->post('clientemail'),
			'emergency_contact_person'=> $this->input->post('emergencycontactperson'),
			'emergency_contact_number'=> $this->input->post('emergencycontactnumber')
		);

       // Update the project in the database using the model
    if ($this->Project_model->update_project($id, $data)) {
        // Success, redirect or set flashdata
        echo "Successfully Updated";
    } else {
		echo "Failed to Update";
    }
	
    }

	public function Field_visit()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$data['projects']    = $this->project_model->GetProjectsValue();
			$data['employee']    = $this->employee_model->emselect();
			$data['application'] = $this->project_model->GetF_i_e_l_dApplication();
			$this->load->view('backend/field_visit', $data);
		} else {
			redirect(base_url(), 'refresh');
		}
	}
	function All_Projects()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$data['employee'] = $this->employee_model->emselect();
			if ($this->session->userdata('user_type') == 'EMPLOYEE') {
				$id               = $this->session->userdata('user_login_id');
				$data['projects'] = $this->project_model->GetEmProjectsValue($id);
			} else {
				$data['projects'] = $this->project_model->GetProjectsValue();
			}

			$this->load->view('backend/projects', $data);
		} else {
			redirect(base_url(), 'refresh');
		}
	}
	public function Field_Application(){

		if($this->session->userdata('user_login_access') != False) { 
			$id = $this->input->post('fid');
			$projectID = $this->input->post('projectID');
			$fieldLocation = $this->input->post('fieldLocation');
			$emid = $this->input->post('emid');
			$startdate = $this->input->post('startdate');
			$enddate = $this->input->post('enddate');
			$totalDays = $this->input->post('totalDays');
			$notes = $this->input->post('notes');
			$actualReturnDate = $this->input->post('actualReturnDate');

			#$status = $this->input->post('status');
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters();
			$this->form_validation->set_rules('emid', 'employee', 'trim|required|xss_clean');

			if ($this->form_validation->run() == FALSE) {
				echo validation_errors();
				#redirect("projects/All_Projects");
			} else {
				$data = array();
				$data = array(
					'project_id' => $projectID,
					'emp_id' => $emid,
					'field_location' => $fieldLocation,
					'start_date' => $startdate,
					'approx_end_date' => $enddate,
					'total_days' => $totalDays,
					'notes' => $notes,
					'actual_return_date' => $actualReturnDate,
					'status' => 'Not Approve'
				);
				if(empty($id)){
					$success = $this->project_model->Add_FieldData($data);
					echo "Successfully Added";
				} else {
					$data = array(
						'project_id' => $projectID,
						'emp_id' => $emid,
						'field_location' => $fieldLocation,
						'start_date' => $startdate,
						'approx_end_date' => $enddate,
						'total_days' => $totalDays,
						'notes' => $notes,
						'actual_return_date' => $actualReturnDate
					);

					$success = $this->project_model->update_FieldData($id, $data);
					echo "Successfully Updated";
				}

			}
		}
		else{
			redirect(base_url() , 'refresh');
		}        
	}

	public function Add_Projects()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$id        = $this->input->post('proid');
			$title     = $this->input->post('protitle');
			$startdate = $this->input->post('startdate');
			$enddate   = $this->input->post('enddate');
			$details   = $this->input->post('details');
			$summery   = $this->input->post('summery');
			$status    = $this->input->post('prostatus');
			$progress  = $this->input->post('progress');
			$clientName = $this->input->post('clientname'); // Capture client name
			$dob		= $this->input->post('dob');        // Capture date of birth
			$age		= $this->input->post('age');        // Capture age
			$gender		= $this->input->post('gender');
			$religion	= $this->input->post('religion');
			$maritalstatus = $this->input->post('maritalstatus');
			$nationality = $this->input->post('nationality');
			$occupation = $this->input->post('occupation');
			$brgy = $this->input->post('brgy');
			$mun = $this->input->post('mun');
			$prov = $this->input->post('prov');
			$zip = $this->input->post('zip');
			$contactNo  = $this->input->post('contactno');  // Capture contact number
			$clientemail = $this->input->post('clientemail'); // Capture client email
			$emergencycontactperson = $this->input->post('emergencycontactperson'); // Capture contact person
			$emergencycontactnumber = $this->input->post('emergencycontactnumber'); // Capture emergency contact number

			$this->load->library('form_validation');

			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			$this->form_validation->set_rules('protitle', 'Project Title', 'trim|required|min_length[5]|max_length[220]|xss_clean');
			$this->form_validation->set_rules('details', 'Details', 'trim|min_length[10]|max_length[1024]|xss_clean');
			$this->form_validation->set_rules('summery', 'Summery', 'trim|xss_clean');
 			$this->form_validation->set_rules('clientname', 'Client Name', 'trim|required|xss_clean'); // Validation for client name
			$this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required|xss_clean'); // Validation for date of birth
			$this->form_validation->set_rules('age', 'Age', 'trim|required|xss_clean'); // Validation for age
			$this->form_validation->set_rules('gender', 'Gender','trim|required|xss_clean'); // Validation for gender
			$this->form_validation->set_rules('religion', 'Religion', 'trim|required|xss_clean'); // Validation for religion
			$this->form_validation->set_rules('maritalstatus', 'Marital Status', 'trim|required|xss_clean'); // Validation for marital status
			$this->form_validation->set_rules('nationality', 'Nationality', 'trim|required|xss_clean'); // Validation for nationality
			$this->form_validation->set_rules('occupation', 'Occupation', 'trim|required|xss_clean'); // Validation for occupation
			$this->form_validation->set_rules('brgy', 'Barangay', 'trim|required|xss_clean'); // Validation for barangay
			$this->form_validation->set_rules('mun', 'Municipality', 'trim|required|xss_clean'); // Validation for municipality
			$this->form_validation->set_rules('prov', 'Province', 'trim|required|xss_clean'); // Validation for province
			$this->form_validation->set_rules('zip', 'Zip Code', 'trim|required|xss_clean'); // Validation for zip code
			$this->form_validation->set_rules('contactno', 'Contact No', 'trim|required|xss_clean');  // Validation for contact number
			$this->form_validation->set_rules('clientemail', 'Client Email', 'trim|required|xss_clean'); // Validation for client email
			$this->form_validation->set_rules('emergencycontactperson', 'Emergency Contact Person', 'trim|required|xss_clean'); // Validation for emergency contact person
			$this->form_validation->set_rules('emergencycontactnumber', 'Emergency Contact Number', 'trim|required|xss_clean'); // Validation for emergency contact number

			if ($this->form_validation->run() == FALSE) {
				echo validation_errors();
				#redirect("projects/All_Projects");
			} else {
				$data = array();
				$data = array(
					'pro_name'                => $title,
					'pro_start_date'          => $startdate,
					'pro_end_date'            => $enddate,
					'pro_description'         => $details,
					'pro_summary'             => $summery,
					'progress'                => $progress,
					'pro_status'              => $status,
					'client_name'             => $clientName,
					'dob'                     => $dob,
					'age'                     => $age,
					'gender'                  => $gender,
					'religion'                => $religion,
					'marital_status'          => $maritalstatus,
					'nationality'             => $nationality,
					'occupation'              => $occupation,
					'brgy'                    => $brgy,
					'mun'                     => $mun,
					'prov'                    => $prov,
					'zip'                     => $zip,
					'contact_no'              => $contactNo,
					'client_email'            => $clientemail,
					'emergency_contact_person'=> $emergencycontactperson,
					'emergency_contact_number'=> $emergencycontactnumber
				);
				if (empty($id)) {
					$success = $this->project_model->Add_ProjectData($data);
					#$this->session->set_flashdata('feedback','Successfully Added');
					#redirect("projects/All_Projects");
					echo "Successfully Added";
				} else {
					$success = $this->project_model->update_ProjectData($id, $data);
					#$this->session->set_flashdata('feedback','Successfully Updated');
					#redirect("projects/view?P=" .base64_encode($id));
					echo "Successfully Updated";
				}

			}
		// } else {
		// 	redirect(base_url(), 'refresh');
		}
	}
	public function Update_Project()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$id        = $this->input->post('proid');
			$title     = $this->input->post('protitle');
			$startdate = $this->input->post('startdate');
			$enddate   = $this->input->post('enddate');
			$details   = $this->input->post('details');
			$summery   = $this->input->post('summery');
			$status    = $this->input->post('prostatus');

			$this->load->library('form_validation');

			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			$this->form_validation->set_rules('protitle', 'Project Title', 'trim|required|min_length[5]|max_length[220]|xss_clean');
			$this->form_validation->set_rules('startdate', 'Start Date', 'trim|required|xss_clean');
			$this->form_validation->set_rules('enddate', 'End Date', 'trim|required|xss_clean');
			$this->form_validation->set_rules('details', 'Details', 'trim|min_length[10]|max_length[1024]|xss_clean');
			$this->form_validation->set_rules('summery', 'Summery', 'trim|xss_clean');
			$this->form_validation->set_rules('prostatus', 'Status', 'trim|required|xss_clean');

			if ($this->form_validation->run() == FALSE) {
				echo validation_errors();
			} else {
				$data = array(
					'pro_name'        => $title,
					'pro_start_date'  => $startdate,
					'pro_end_date'    => $enddate,
					'pro_description' => $details,
					'pro_summary'     => $summery,
					'pro_status'      => $status
				);

				if (!empty($id)) {
					$success = $this->project_model->update_ProjectData($id, $data);
					echo "Successfully Updated";
				// } else {
				// 	echo "Project ID is required for update.";
				}
			}
		// } else {
		// 	redirect(base_url(), 'refresh');
		}
	}
	
	public function Add_Tasks()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$id        = $this->input->post('id');
			$emid      = $this->input->post('assignto[]');
			$proid     = $this->input->post('projectid');
			$title     = $this->input->post('tasktitle');
			$head      = $this->input->post('teamhead');
			$details   = $this->input->post('details');
			$startdate = $this->input->post('startdate');
			$enddate   = $this->input->post('enddate');
			$type      = $this->input->post('type');
			$status    = $this->input->post('status');
			$date      = date('Y-m-d');
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters();
			$this->form_validation->set_rules('tasktitle', 'tasktitle', 'trim|required|min_length[10]|max_length[150]|xss_clean');
			$this->form_validation->set_rules('details', 'details', 'trim|required|min_length[10]|max_length[2024]|xss_clean');
            
			if ($this->form_validation->run() == FALSE) {
				echo validation_errors();
				#redirect("projects/view?P=" .base64_encode($id));
			} else {
				$data = array();
				$data = array(
					'pro_id' => $proid,
					/*'ass_id' => $logid,*/
					/*'assign_to' => $head,*/
					'task_title' => $title,
					'description' => $details,
					'start_date' => $startdate,
					'end_date' => $enddate,
					'create_date' => $date,
					'task_type' => $type,
					/*                    'location'=> $location,*/
					'status' => $status,
					'approve_status' => 'Approve'
				);
				if (empty($id)) {
					$success  = $this->project_model->Add_Tasks($data);
					$insertid = $this->db->insert_id();
					$data     = array();
					$data     = array(
						'task_id' => $insertid,
						'project_id' => $proid,
						'assign_user' => $head,
						'user_type' => 'Team Head'
					);
					$success  = $this->project_model->insert_members_Data($data);
					$emid     = $this->input->post('assignto[]');
					foreach ($emid as $dataarray) {
						$data    = array();
						$data    = array(
							'task_id' => $insertid,
							'project_id' => $proid,
							'assign_user' => $dataarray,
							'user_type' => 'Collaborators'
						);
				$success = $this->project_model->insert_members_Data($data);
					}
					echo "Successfully Added";
				} /*else {
					$success = $this->project_model->Update_Tasks($id, $data);
					$success = $this->project_model->Delet_members_Data($id);
					$emid    = $this->input->post('assignto[]');
					foreach ($emid as $dataarray) {
						$data = array();
						$data = array(
							'project_id' => $proid,
							'assign_user' => $dataarray,
							'user_type' => 'Collaborators'
						);

						$success = $this->project_model->insert_members_Data($data);
					}
					echo "Successfully Updated";
				}*/

			}
		}


		else {
			redirect(base_url(), 'refresh');
		}
	}
	public function Add_Field_Tasks()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$id        = $this->input->post('id');
			$emid      = $this->input->post('assignto[]');
			$proid     = $this->input->post('projectid');
			$title     = $this->input->post('tasktitle');
			$head      = $this->input->post('teamhead');
			$details   = $this->input->post('details');
			$startdate = $this->input->post('startdate');
			$enddate   = $this->input->post('enddate');
			$type      = $this->input->post('type');
			$status    = $this->input->post('status');
			$location  = $this->input->post('location');
			$astatus   = $this->input->post('appstatus');
			$date      = date('d:m:y');
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters();
			$this->form_validation->set_rules('tasktitle', 'tasktitle', 'trim|required|min_length[10]|max_length[150]|xss_clean');

			$this->form_validation->set_rules('details', 'details', 'trim|required|min_length[10]|max_length[2024]|xss_clean');


			if ($this->form_validation->run() == FALSE) {
				echo validation_errors();
				#redirect("projects/view?P=" .base64_encode($id));
			} else {
				$data = array();
				$data = array(
					'pro_id' => $proid,
					/*'ass_id' => $logid,*/
					/*'assign_to' => $head,*/
					'task_title' => $title,
					'description' => $details,
					'start_date' => $startdate,
					'end_date' => $enddate,
					'create_date' => $date,
					'task_type' => $type,
					'location' => $location,
					'status' => $status,
					'approve_status' => $astatus
				);
				if (empty($id)) {
					$success  = $this->project_model->Add_Tasks($data);
					$insertid = $this->db->insert_id();
					$data     = array();
					$data     = array(
						'task_id' => $insertid,
						'project_id' => $proid,
						'assign_user' => $head,
						'user_type' => 'Team Head'
					);
					$success  = $this->project_model->insert_members_Data($data);
					$emid     = $this->input->post('assignto[]');
					foreach ($emid AS $dataarray) {
						$data    = array();
						$data    = array(
							'task_id' => $insertid,
							'project_id' => $proid,
							'assign_user' => $dataarray,
							'user_type' => 'Collaborators'
						);
						$success = $this->project_model->insert_members_Data($data);
					}
					echo "Successfully Added";
				} else {
					$success = $this->project_model->Update_Tasks($id, $data);
					$success = $this->project_model->Delet_members_Data($id);
					$emid    = $this->input->post('assignto[]');
					foreach ($emid AS $dataarray) {
						$data = array();
						$data = array(
							'task_id' => $insertid,
							'project_id' => $proid,
							'assign_user' => $dataarray,
							'user_type' => 'Collaborators'
						);

						$success = $this->project_model->insert_members_Data($data);
					}
					echo "Successfully Updated";
				}

			}
		}


		else {
			redirect(base_url(), 'refresh');
		}
	}
	public function Add_Logistic()
	{
		$projectid = $this->input->post('proid');
		$logid     = $this->input->post('logistic');
		$assignid  = $this->input->post('teamhead');
		$task      = $this->input->post('taskid');
		$logqty    = $this->input->post('qty');
		$startdate = $this->input->post('startdate');
		$enddate   = $this->input->post('enddate');
		$remarks   = $this->input->post('remarks');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters();
		$this->form_validation->set_rules('taskid', 'task', 'trim|required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			echo validation_errors();
			#redirect("loan/View");
		} else {
			$data = array();
			$data = array(
				'asset_id' => $logid,
				'assign_id' => $assignid,
				'project_id' => $projectid,
				'task_id' => $task,
				'log_qty' => $logqty,
				'start_date' => $startdate,
				'end_date' => $enddate,
				/*                    'back_date' => $backdate,
                'back_qty' => $backqty,*/
				'remarks' => $remarks
			);
			if (empty($id)) {
				$success = $this->logistic_model->Add_LogisticeSupport($data);
				#$this->session->set_flashdata('feedback','Successfully Added');
				#redirect("loan/View");
				#echo "Successfully Added";
				$assets  = $this->logistic_model->getAssetsQty($logid);
				$inqty   = $assets->in_stock - $logqty;
				$data    = array();
				$data    = array(
					'in_stock' => $inqty
				);
				$this->logistic_model->Update_Assets($logid, $data);
				echo "Successfully Updated";
			} else {
				$success = $this->logistic_model->Update_LogisticeSupport($id, $data);
				$assets  = $this->logistic_model->getAssetsQty($logid);
				$inqty   = $assets->in_stock + $backqty;
				$data    = array();
				$data    = array(
					'in_stock' => $inqty
				);
				$this->logistic_model->Update_Assets($logid, $data);
				echo "Successfully Updated";
			}

		}
	}
	public function Add_File()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$emid    = $this->input->post('assignto');
			$proid   = $this->input->post('proid');
			$details = $this->input->post('details');
			$date    = date('d:m:y');
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters();

			$this->form_validation->set_rules('details', 'details', 'trim|required|min_length[10]|max_length[300]|xss_clean');


			if ($this->form_validation->run() == FALSE) {
				echo validation_errors();
				#redirect("projects/view?P=" .base64_encode($id));
			} else {
				$file_name = $_FILES['img_url']['name'];
				$fileSize  = $_FILES["img_url"]["size"] / 1024;
				$fileType  = $_FILES["img_url"]["type"];

				$config = array(
					'file_name' => $file_name,
					'upload_path' => "./assets/images/projects",
					'allowed_types' => "gif|jpg|png|jpeg|pdf|doc|docx|mp3|mpeg",
					'overwrite' => False,
					'max_size' => "40480000",
					'max_height' => "3600",
					'max_width' => "3600"
				);

				$this->load->library('Upload', $config);
				$this->upload->initialize($config);
				if (!$this->upload->do_upload('img_url')) {
					echo $this->upload->display_errors();
					#redirect("projects/view?P=" .base64_encode($proid));
				}

				else {
					$path    = $this->upload->data();
					$img_url = $path['file_name'];
					$data    = array();
					$data    = array(
						'pro_id' => $proid,
						'file_details' => $details,
						'file_url' => $img_url,
						'assigned_to' => $emid
					);
					$success = $this->project_model->Add_Project_File($data);
					echo "Successfully Updated";
					#$this->session->set_flashdata('feedback','Successfully Updated');
					#redirect("projects/view?P=" .base64_encode($proid));
				}

			}
		} else {
			redirect(base_url(), 'refresh');
		}
	}
	public function Add_Pro_Notes()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$id      = $this->input->post('id');
			$emid    = $this->input->post('assignto');
			$proid   = $this->input->post('proid');
			$details = $this->input->post('details');
			$date    = date('Y-m-d');
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters();

			$this->form_validation->set_rules('details', 'details', 'trim|required|min_length[5]|max_length[2024]|xss_clean');
			//die($id);

			if ($this->form_validation->run() == FALSE) {
				echo validation_errors();
				#redirect("projects/view?P=" .base64_encode($id));
			} else {
				$data = array();
				$data = array(
					'pro_id' => $proid,
					'details' => $details,
					'assign_to' => $emid
				);
				if(empty($id)){
					$success = $this->project_model->Add_Project_Notes($data);
					#$this->session->set_flashdata('feedback','Successfully Updated');
					#redirect("projects/view?P=" .base64_encode($proid));
					echo "Successfully Added";
				} else {
					$success = $this->project_model->Update_Project_Notes($id, $data);
					#$this->session->set_flashdata('feedback','Successfully Updated');
					#redirect("projects/view?P=" .base64_encode($proid));
					echo "Successfully Updated";
				}


			}
		} else {
			redirect(base_url(), 'refresh');
		}
	}
	public function Add_Expenses()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$id      = $this->input->post('id');
			$emid    = $this->input->post('assignto');
			$proid   = $this->input->post('proid');
			$details = $this->input->post('details');
			$amount  = $this->input->post('amount');
			$date    = $this->input->post('date');
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters();

			$this->form_validation->set_rules('details', 'details', 'trim|required|min_length[10]|max_length[250]|xss_clean');


			if ($this->form_validation->run() == FALSE) {
				echo validation_errors();
				#redirect("projects/view?P=" .base64_encode($id));
			} else {
				$data = array();
				$data = array(
					'pro_id' => $proid,
					'details' => $details,
					'amount' => $amount,
					'assign_to' => $emid,
					'date' => $date
				);
				if (empty($id)) {
					$success = $this->project_model->Add_Project_expenses($data);
					#$this->session->set_flashdata('feedback','Successfully Updated');
					# redirect("projects/view?P=" .base64_encode($proid));
					echo "Successfully Added";
				} else {
					$success = $this->project_model->Updated_Project_expenses($id, $data);
					#$this->session->set_flashdata('feedback','Successfully Updated');
					# redirect("projects/view?P=" .base64_encode($proid));
					echo "Successfully Updated";
				}


			}
		} else {
			redirect(base_url(), 'refresh');
		}
	}
	public function view()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$id                  = base64_decode($this->input->get('P'));
			$data['employee']    = $this->employee_model->emselect();
			$data['proemployee'] = $this->employee_model->ProjectEmployee($id);
			$data['details']     = $this->project_model->GetprojectDetails($id);
			/*      $data['office'] = $this->project_model->GetTasksOfficeList($id);
            $data['filed'] = $this->project_model->GetTasksFiledList($id);
            $data['both'] = $this->project_model->GetTasksBothList($id);*/
			$data['files']       = $this->project_model->GetFilesList($id);
			$data['tasklist']    = $this->project_model->GetTasksAllList($id);

			$data['notes']        = $this->project_model->GetNotesList($id);
			$data['expenses']     = $this->project_model->GetExpensesList($id);
			$data['assets']       = $this->project_model->GetAllLogisticList();
			$data['logisticlist'] = $this->project_model->GetAllLogistice($id);
			$this->load->view('backend/projects_view', $data);
		} else {
			redirect(base_url(), 'refresh');
		}
	}
	public function All_Tasks()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$data['employee'] = $this->employee_model->emselect();
			$data['projects'] = $this->project_model->GetProjectsValue();
			$data['tasks']    = $this->project_model->GetAllTasksList();
			$data['assets']   = $this->project_model->GetAllLogisticList();
			$this->load->view('backend/tasks_view', $data);
		} else {
			redirect(base_url(), 'refresh');
		}
	}

	public function LogisTicById()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$id                     = $this->input->get('id');
			$data['logisticevalue'] = $this->project_model->GetLogisTicValue($id);
			#$data['employesvalue'] = $this->project_model->GetEmployesValue($id);
			echo json_encode($data);
		} else {
			redirect(base_url(), 'refresh');
		}
	}
	public function TasksById()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$id                    = $this->input->get('id');
			$data['tasksvalue']    = $this->project_model->GetTasksValue($id);
			$data['employesvalue'] = $this->project_model->GetEmployesValue($id);
			echo json_encode($data);
		} else {
			redirect(base_url(), 'refresh');
		}
	}
	public function ExpensesById()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$id                    = $this->input->get('id');
			$data['expensesvalue'] = $this->project_model->GetExpensesValue($id);
			echo json_encode($data);
		} else {
			redirect(base_url(), 'refresh');
		}
	}
	public function NotesById()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$id                     = $this->input->get('id');
			$data['notesbyidvalue'] = $this->project_model->GetNotesValueId($id);
			echo json_encode($data);
		} else {
			redirect(base_url(), 'refresh');
		}
	}
	public function projectbyId()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$id               = $this->input->get('id');
			$data['provalue'] = $this->project_model->GetprojectVal($id);
			echo json_encode($data);
		} else {
			redirect(base_url(), 'refresh');
		}
	}

	public function TasksDeletByid()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$id = $this->input->get('id');

			$imgvalue = $this->project_model->GetTasksValue($id);
			if (!empty($imgvalue->id)) {
				unlink("./assets/images/projects/$imgvalue->image");
				$success = $this->project_model->DeletPro($id);
				$success = $this->project_model->DeletAssignuser($id);
				echo 'Deleted Successfully';
			}
			#echo "Successfully Deletd";
		} else {
			redirect(base_url(), 'refresh');
		}
	}
	public function FileDeletById()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$id       = $this->input->get('id');
			$imgvalue = $this->project_model->GetFilebyFid($id);
			if (!empty($imgvalue->id)) {
				unlink("./assets/images/projects/$imgvalue->file_url");
				$success = $this->project_model->DeletProFile($id);
				echo 'Deleted Successfully';
			}
			#echo "Successfully Deletd";
		} else {
			redirect(base_url(), 'refresh');
		}
	}
	public function deletExpenses()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$id    = $this->input->get('D');
			$value = $this->project_model->DeletExpensesByid($id);
			echo "Successfully Deleted";
		} else {
			redirect(base_url(), 'refresh');
		}
	}
	public function DeletNotes()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$id    = $this->input->get('D');
			$value = $this->project_model->DletProjectData($id);
			echo "Successfully Deleted";
		} else {
			redirect(base_url(), 'refresh');
		}
	}
	public function pDelet()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$id    = base64_decode($this->input->get('D'));
			$value = $this->project_model->DletProjectData($id);
			redirect('Projects/All_Projects');
		} else {
			redirect(base_url(), 'refresh');
		}
	}
	public function AssetsDelet()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$id    = $this->input->get('D');
			$value = $this->project_model->DeletAssetssByid($id);
			redirect('Projects/All_Assets');
		} else {
			redirect(base_url(), 'refresh');
		}
	}
	
	/*Approve or reject the field visit*/
	public function authorizeFieldVisit()
	{

		if ($this->session->userdata('user_login_access') != False) {

			$fieldApplicationID = $this->input->post('fieldApplicationID');
			$approvalStatus     = $this->input->post('approvalStatus');

			$data = array();
			$data = array(
				'status' => $approvalStatus
			);

			$wasUpdated = $this->project_model->updateFieldVistApplication($fieldApplicationID, $data);

			if ($wasUpdated) {
				echo "Updated successfully";
			} else {
				echo "Something went wrong. Please check again.";
			}
		}
	}


	// Get the field visit data by id to edit
	public function getFieldVisitAppData()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$id   = $this->input->get('id');
			$data = $this->project_model->getFieldAuthDataByID($id);

			echo json_encode($data);
		} else {
			redirect(base_url(), 'refresh');
		}
	}
	public function closeAndUpdateFieldVisit()
	{

		// attendance_updated
		if ($this->session->userdata('user_login_access') != False) {

			$fieldApplicationID = $this->input->post('fieldApplicationID');
			$employeeID         = $this->input->post('employeeID');

			$data = array();
			$data = array(
				'attendance_updated' => 'done'
			);

			$wasUpdated = $this->project_model->fieldVisitDoneAndUpdateAttendance($fieldApplicationID, $data);

			if ($this->db->affected_rows()) {

				// Add attendance
				$attendanceDataFromFieldVisit = $this->project_model->selectDataFromFieldVisitByID($fieldApplicationID);

				$start_date = $attendanceDataFromFieldVisit[0]->start_date;
				$end_date   = $attendanceDataFromFieldVisit[0]->actual_return_date;

				$startDate = strtotime($start_date);
				$endDate = strtotime($end_date);
				for($i = $startDate; $i <= $endDate; $i = strtotime('+1 day', $i)){
					$date = date('Y-m-d', $i);
					$day = date("D", strtotime($date));
					if($day == "Fri"){
						$emcode = $this->employee_model->emselectByCode($employeeID);
						$emid = $emcode->em_id;
						$earnval = $this->leave_model->emEarnselectByLeave($emid); 
						$data = array();
						$data = array(
							'present_date' => $earnval->present_date + 1,
							'hour' => $earnval->hour + 480,
							'status' => '1'
						);
						$success = $this->leave_model->UpdteEarnValue($emid, $data);
						$duplicate = $this->attendance_model->getDuplicateVal($employeeID,$date);
						//print_r($duplicate);
						if(!empty($duplicate)){
							$data = array();
							$data = array(
								'emp_id' => $employeeID,
								'atten_date' => $date,
								'working_hour' => '480',
								'signin_time' => '09:00:00',
								'signout_time' => '17:00:00',
								'status' => 'E'
							);                            
							$this->attendance_model->bulk_Update($employeeID,$date,$data);
						} else {
							$data = array();
							$data = array(
								'emp_id' => $employeeID,
								'atten_date' => $date,
								'working_hour' => '480',
								'signin_time' => '09:00:00',
								'signout_time' => '17:00:00',
								'status' => 'E'
							);
							$this->project_model->insertAttendanceByFieldVisitReturn($data);    
						}
					} elseif($day != "Fri") {
						$da = date("Y-m-d", $i);
						$holiday = $this->leave_model->get_holiday_between_dates($da);
						if($holiday) {

							$emcode = $this->employee_model->emselectByCode($employeeID);
							$emid = $emcode->em_id;
							$earnval = $this->leave_model->emEarnselectByLeave($emid); 
							$data = array();
							$data = array(
								'present_date' => $earnval->present_date + 1,
								'hour' => $earnval->hour + 480,
								'status' => '1'
							);
							$success = $this->leave_model->UpdteEarnValue($emid, $data);
							$duplicate = $this->attendance_model->getDuplicateVal($employeeID,$date);
							//print_r($duplicate);
							if(!empty($duplicate)){
								$data = array();
								$data = array(
									'emp_id' => $employeeID,
									'atten_date' => $date,
									'working_hour' => '480',
									'signin_time' => '09:00:00',
									'signout_time' => '17:00:00',
									'status' => 'E'
								);                            
								$this->attendance_model->bulk_Update($employeeID,$date,$data);
							} else {                            
								$data = array();
								$data = array(
									'emp_id' => $employeeID,
									'atten_date' => $da,
									'working_hour' => '480',
									'signin_time' => '09:00:00',
									'signout_time' => '17:00:00',
									'status' => 'E'
								);
								$this->project_model->insertAttendanceByFieldVisitReturn($data);
							}
						} else {
							$date = date('Y-m-d', $i);
							$duplicate = $this->attendance_model->getDuplicateVal($employeeID,$date);
							//print_r($duplicate);    
							if(!empty($duplicate)){
								$data = array();
								$data = array(
									'emp_id' => $employeeID,
									'atten_date' => $date,
									'working_hour' => '480',
									'signin_time' => '09:00:00',
									'signout_time' => '17:00:00',
									'status' => 'A'
								);                            
								$this->attendance_model->bulk_Update($employeeID,$date,$data);
							} else {                             
								$data = array();
								$data = array(
									'emp_id' => $employeeID,
									'atten_date' => $date,
									'working_hour' => '480',
									'signin_time' => '09:00:00',
									'signout_time' => '17:00:00',
									'status' => 'A'
								);
								$this->project_model->insertAttendanceByFieldVisitReturn($data);
							}
						}
					}

				}

			}
		} else {
			redirect(base_url(), 'refresh');
		}
	}

}
?>