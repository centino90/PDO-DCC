<?php
class Pages extends Controller
{
  public function __construct()
  {
    if (!isLoggedIn()) {
      redirect('users/login');
    }
    if (isLoggedIn() && !isCompleteInfo()) {
      redirect('users/registerPrcInfo');
    }
    if (isset($_SESSION['login_time_stamp']) && (time() - $_SESSION['login_time_stamp'] > 10 * 60)) {
      session_unset();
      session_destroy();
      redirect("users/login");
    } else {
      session_regenerate_id(true);
      $_SESSION['login_time_stamp'] = time();
    }

    $this->userModel = $this->model('User');
  }

  public function index()
  {
    // Get payment history
    $data = [
      'current_route' => __FUNCTION__,

      'posts' => 'dogger'
    ];

    // $this->view('pages/index', $data);
    unset($_SESSION['login_success']);
    redirect('pages/licenseInfo');
  }
  public function licenseInfo()
  {
    $fieldOfPracticeOptions = [
      'General Practice',
      'Endodontics',
      'Prosthodontics',
      'Orthodontics',
      'Oral and maxillofacial surgery',
      'Pedodontics',
      'Periodontics'
    ];
    $typeOfPracticeOptions = [
      'Government Dentist',
      'Clinic Owner',
      'Dental Associate',
      'School Dentist',
      'None Practicing'
    ];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      $user = $this->userModel->getUserById($_SESSION['user_id']);

      $data = [
        'current_route' => __FUNCTION__,
        'user_id' => $_SESSION['user_id'] ?? '',
        'field_practice_options' => $fieldOfPracticeOptions,
        'type_practice_options' => $typeOfPracticeOptions,

        'prc_number' => trim($_POST['prc_number']),
        'prc_registration_date' => trim($_POST['prc_registration_date']),
        'prc_expiration_date' => trim($_POST['prc_expiration_date']),
        'field_practice' => trim($_POST['field_practice']),
        'type_practice' => trim($_POST['type_practice']),

        'prc_number_err' => '',
        'prc_registration_date_err' => '',
        'prc_expiration_date_err' => '',
        'field_practice_err' => '',
        'type_practice_err' => '',
      ];

      // Validate prc info
      if (empty($data['prc_number'])) {
        $data['prc_number_err'] = 'Please enter your prc number';
      }
      if (empty($data['prc_registration_date'])) {
        $data['prc_registration_date_err'] = 'Please enter your prc registration date';
      }
      if (empty($data['prc_expiration_date'])) {
        $data['prc_expiration_date_err'] = 'Please enter your prc expiration date';
      }
      if (empty($data['field_practice'])) {
        $data['field_practice_err'] = 'Please select your field of practice';
      }
      if (empty($data['type_practice'])) {
        $data['type_practice_err'] = 'Please select your type of practice';
      }

      // Check if errors are empty
      if (empty($data['prc_number_err']) && empty($data['prc_registration_date_err']) && empty($data['prc_expiration_date_err']) && empty($data['field_practice_err']) && empty($data['type_practice_err'])) {
        if ($this->userModel->updatePrcInfo($data)) {
          flash('update_success', 'Your license profile was updated');
          redirect('pages/licenseInfo');
        } else {
          die('Something went wrong');
        }
      } else {
        // Load view with errors
        $this->view('pages/licenseInfo', $data);
      }
    } else {
      $user = $this->userModel->getUserById($_SESSION['user_id']);

      $data = [
        'current_route' => __FUNCTION__,
        'field_practice_options' => $fieldOfPracticeOptions,
        'type_practice_options' => $typeOfPracticeOptions,

        'prc_number' => $user->prc_number,
        'prc_registration_date' => $user->prc_registration_date,
        'prc_expiration_date' => $user->prc_expiration_date,
        'field_practice' => $user->field_practice,
        'type_practice' => $user->type_practice,

        'prc_number_err' => '',
        'prc_registration_date_err' => '',
        'prc_expiration_date_err' => '',
        'field_practice_err' => '',
        'type_practice_err' => '',
      ];

      $this->view('pages/licenseInfo', $data);
    }
  }
  public function personalInfo()
  {
    $genderOptions = [
      'Male',
      'Female'
    ];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      $user = $this->userModel->getUserById($_SESSION['user_id']);

      $data = [
        'current_route' => __FUNCTION__,
        'user_id' => $_SESSION['user_id'] ?? '',
        'gender_options' => $genderOptions,

        'first_name' => trim($_POST['first_name']),
        'middle_name' => trim($_POST['middle_name']),
        'last_name' => trim($_POST['last_name']),
        'birthdate' => trim($_POST['birthdate']),
        'gender' => trim($_POST['gender']),
        'contact_number' => trim($_POST['contact_number']),
        'fb_account_name' => trim($_POST['fb_account_name']),
        'address' => trim($_POST['address']),

        'first_name_err' => '',
        'middle_name_err' => '',
        'last_name_err' => '',
        'gender_err' => '',
        'fb_account_name_err' => '',
        'contact_number_err' => '',
        'birthdate_err' => '',
        'address_err' => '',
      ];

      // Validate Personal info
      if (empty($data['first_name'])) {
        $data['first_name_err'] = 'Please enter your firstname';
      }
      if (empty($data['middle_name'])) {
        $data['middle_name_err'] = 'Please enter your middlename';
      }
      if (empty($data['last_name'])) {
        $data['last_name_err'] = 'Please enter your lastname';
      }
      if (empty($data['birthdate'])) {
        $data['birthdate_err'] = 'Please enter your your birthdate';
      }
      if (empty($data['gender'])) {
        $data['gender_err'] = 'Please select your gender';
      }
      if (empty($data['contact_number'])) {
        $data['contact_number_err'] = 'Please enter your contact number';
      }
      if (empty($data['fb_account_name'])) {
        $data['fb_account_name_err'] = 'Please enter your fb account name';
      }
      if (empty($data['address'])) {
        $data['address_err'] = 'Please enter your home address';
      }

      if (
        empty($data['first_name_err']) && empty($data['middle_name_err'])
        && empty($data['last_name_err']) && empty($data['birthdate_err'])
        && empty($data['gender_err']) && empty($data['contact_number_err'])
        && empty($data['fb_account_name_err']) && empty($data['address_err'])
      ) {

        if ($this->userModel->updatePersonalInfo($data)) {
          flash('update_success', 'Your personal profile was updated');
          redirect('pages/personalInfo');
        } else {
          die('Something went wrong');
        }
      } else {
        // Load view with errors
        $this->view('pages/personalInfo', $data);
      }
    } else {
      $user = $this->userModel->getUserById($_SESSION['user_id']);

      $data = [
        'current_route' => __FUNCTION__,
        'gender_options' => $genderOptions,

        'first_name' => $user->first_name,
        'middle_name' => $user->middle_name,
        'last_name' => $user->last_name,
        'birthdate' => $user->birthdate,
        'gender' => $user->gender,
        'contact_number' => $user->contact_number,
        'fb_account_name' => $user->fb_account_name,
        'address' => $user->address,

        'first_name_err' => '',
        'middle_name_err' => '',
        'last_name_err' => '',
        'gender_err' => '',
        'fb_account_name_err' => '',
        'contact_number_err' => '',
        'birthdate_err' => '',
        'address_err' => '',
      ];

      $this->view('pages/personalInfo', $data);
    }
  }
  public function clinicInfo()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      $user = $this->userModel->getUserById($_SESSION['user_id']);

      $data = [
        'current_route' => __FUNCTION__,
        'user_id' => $_SESSION['user_id'] ?? '',

        'clinic_name' => trim($_POST['clinic_name']),
        'clinic_street' => trim($_POST['clinic_street']),
        'clinic_district' => trim($_POST['clinic_district']),
        'clinic_city' => trim($_POST['clinic_city']),
        'clinic_contact_number' => trim($_POST['clinic_contact_number']),

        'clinic_name_err' => '',
        'clinic_street_err' => '',
        'clinic_district_err' => '',
        'clinic_city_err' => '',
        'clinic_contact_number_err' => '',
      ];

      // Validate clinic info
      if (empty($data['clinic_name'])) {
        $data['clinic_name_err'] = 'Please enter your clinic name';
      }
      if (empty($data['clinic_street'])) {
        $data['clinic_street_err'] = 'Please enter your clinic street';
      }
      if (empty($data['clinic_district'])) {
        $data['clinic_district_err'] = 'Please enter your clinic district';
      }
      if (empty($data['clinic_city'])) {
        $data['clinic_city_err'] = 'Please enter your clinic city';
      }
      if (empty($data['clinic_contact_number'])) {
        $data['clinic_contact_number_err'] = 'Please enter your clinic contact number';
      }

      // Check if errors are empty
      if (
        empty($data['clinic_name_err']) && empty($data['clinic_street_err'])
        && empty($data['clinic_district_err']) && empty($data['clinic_city_err'])
        && empty($data['clinic_contact_number_err'])
      ) {

        if ($this->model('Clinic')->updateOrInsert($data)) {
          flash('update_success', 'Your clinic information was updated');
          redirect('pages/clinicInfo');
        } else {
          die('Something went wrong');
        }
      } else {
        // Load view with errors
        $this->view('pages/clinicInfo', $data);
      }
    } else {
      $clinic = $this->model('Clinic')->getClinicById($_SESSION['user_id']);

      $data = [
        'current_route' => __FUNCTION__,

        'clinic_name' => $clinic->name,
        'clinic_street' =>  $clinic->street,
        'clinic_district' =>  $clinic->district,
        'clinic_city' =>  $clinic->city,
        'clinic_contact_number' =>  $clinic->contact_number,

        'clinic_name_err' => '',
        'clinic_street_err' => '',
        'clinic_district_err' => '',
        'clinic_city_err' => '',
        'clinic_contact_number_err' => '',
      ];

      $this->view('pages/clinicInfo', $data);
    }
  }
}
