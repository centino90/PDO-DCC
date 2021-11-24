<?php
class Users extends Controller
{
  public function __construct()
  {
    $this->userModel = $this->model('User');
    // if (time() - $_SESSION["login_time_stamp"] > 20) {
    //   session_unset();
    //   session_destroy();
    //   redirect("users/login");
    // }
  }

  public function index()
  {
    redirect('users/login');
  }

  public function login()
  {
    if (isLoggedIn()) {
      redirect('pages');
    }

    // Check Facebook API request code
    if (isset($_GET['state']) && FB_APP_STATE == $_GET['state']) {
      // try and log the user in with $_GET vars from facebook 
      $fbLogin = tryAndLoginWithFacebook($_GET, $this);
    }

    //Check Google API request code
    if (isset($_GET['code'])) {
      $googleLogin = tryAndLoginWithGoogle($_GET, $this);
    }

    // Check for POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // Process form
      // Sanitize POST data
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      // Init data
      $data = [
        'email' => trim($_POST['email']),
        'password' => trim($_POST['password']),
        'email_err' => '',
        'password_err' => '',
      ];

      // Validate Email
      if (empty($data['email'])) {
        $data['email_err'] = 'Pleae enter email';
      }

      // Validate Password
      if (empty($data['password'])) {
        $data['password_err'] = 'Please enter password';
      }

      // Check for user/email
      if ($this->userModel->findUserByEmail($data['email'])) {
        // User found
      } else {
        // User not found
        $data['email_err'] = 'No user found';
      }

      // Make sure errors are empty
      if (empty($data['email_err']) && empty($data['password_err'])) {
        // Validated
        // Check and set logged in user
        $loggedInUser = $this->userModel->login($data['email'], $data['password']);

        if ($loggedInUser) {
          // Create Session
          $this->createUserSession($loggedInUser);
        } else {
          $data['password_err'] = 'Password incorrect';

          $this->view('users/login', $data);
        }
      } else {
        // Load view with errors
        $this->view('users/login', $data);
      }
    } else {
      // Init data
      $data = [
        'email' => '',
        'password' => '',
        'email_err' => '',
        'password_err' => '',
      ];

      // Load view
      $this->view('users/login', $data);
    }
  }

  public function register()
  {
    if (isLoggedIn()) {
      redirect('pages');
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
        'email' => trim($_POST['email']),
        'password' => trim($_POST['password']),
        'confirm_password' => trim($_POST['confirm_password']),
        'is_admin' => false,

        'email_err' => '',
        'password_err' => '',
        'confirm_password_err' => ''
      ];

      // Validate login credentials
      if (empty($data['email'])) {
        $data['email_err'] = 'Please enter email';
      } else {
        // Check email
        if ($this->userModel->findUserByEmail($data['email'])) {
          $data['email_err'] = 'Email is already taken';
        }
      }
      if (empty($data['password'])) {
        $data['password_err'] = 'Please enter password';
      } elseif (strlen($data['password']) < 6) {
        $data['password_err'] = 'Password must be at least 6 characters';
      }
      if (empty($data['confirm_password'])) {
        $data['confirm_password_err'] = 'Please confirm password';
      } else {
        if ($data['password'] != $data['confirm_password']) {
          $data['confirm_password_err'] = 'Passwords do not match';
        }
      }

      // Check if all errors are empty
      if (
        empty($data['email_err']) && empty($data['password_err'])
        && empty($data['confirm_password_err'])
      ) {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        if (!$this->userModel->register($data)) {
          die('Something went wrong');
        }

        $loggedInUser = $this->userModel->login($data['email'], trim($_POST['password']));
        if (!$loggedInUser) {
          redirect('users/login');
        }
        $this->createUserSession($loggedInUser);
      } else {
        // Load view with errors
        $this->view('users/register', $data);
      }
    } else {

      $data = [
        'email' => '',
        'password' => '',
        'confirm_password' => '',

        'email_err' => '',
        'password_err' => '',
        'confirm_password_err' => ''
      ];

      $this->view('users/register', $data);
    }
  }
  public function registerPrcInfo()
  {
    if (!isLoggedIn()) {
      redirect('users/login');
    }
    if (isLoggedIn() && isCompleteInfo()) {
      redirect('pages');
    }
    if (isset($_SESSION['login_time_stamp']) && (time() - $_SESSION['login_time_stamp'] > 10 * 60)) {
      session_unset();
      session_destroy();
      redirect("users/login");
    } else {
      session_regenerate_id(true);
      $_SESSION['login_time_stamp'] = time();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
        'user_id' => $_SESSION['user_id'] ?? '',

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
          $_SESSION['current_registration_step'] = 'registerPersonalInfo';
          redirect('users/registerPersonalInfo');
        } else {
          die('Something went wrong');
        }
      } else {
        // Load view with errors
        $this->view('users/registerPrcInfo', $data);
      }
    } else {
      $user = $this->userModel->getUserById($_SESSION['user_id']);

      $data = [
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

      $this->view('users/registerPrcInfo', $data);
    }
  }
  public function registerPersonalInfo()
  {
    if (!isLoggedIn()) {
      redirect('users/login');
    }
    if (isLoggedIn() && isCompleteInfo()) {
      redirect('pages');
    }
    if (isset($_SESSION['login_time_stamp']) && (time() - $_SESSION['login_time_stamp'] > 10 * 60)) {
      session_unset();
      session_destroy();
      redirect("users/login");
    } else {
      session_regenerate_id(true);
      $_SESSION['login_time_stamp'] = time();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
        'user_id' => $_SESSION['user_id'] ?? '',

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

      // Check if errors are empty
      if (
        empty($data['first_name_err']) && empty($data['middle_name_err'])
        && empty($data['last_name_err']) && empty($data['birthdate_err'])
        && empty($data['gender_err']) && empty($data['contact_number_err'])
        && empty($data['fb_account_name_err']) && empty($data['address_err'])
      ) {

        if ($this->userModel->updatePersonalInfo($data)) {
          $_SESSION['current_registration_step'] = 'registerClinicInfo';
          redirect('users/registerClinicInfo');
        } else {
          die('Something went wrong');
        }
      } else {
        // Load view with errors
        $this->view('users/registerPersonalInfo', $data);
      }
    } else {
      $user = $this->userModel->getUserById($_SESSION['user_id']);

      $data = [
        'first_name' => $user->first_name ?? isset($_POST['first_name']) ?? trim($_POST['first_name']) ?? '',
        'middle_name' => $user->middle_name ?? isset($_POST['middle_name']) ?? trim($_POST['middle_name']) ?? '',
        'last_name' => $user->last_name ?? isset($_POST['last_name']) ?? trim($_POST['last_name']) ?? '',
        'gender' => $user->gender ?? isset($_POST['gender']) ?? trim($_POST['gender']) ?? '',
        'fb_account_name' => $user->fb_account_name ?? isset($_POST['fb_account_name']) ?? trim($_POST['fb_account_name']) ?? '',
        'contact_number' => $user->contact_number ?? isset($_POST['contact_number']) ?? trim($_POST['contact_number']) ?? '',
        'birthdate' => $user->birthdate ?? isset($_POST['birthdate']) ?? trim($_POST['birthdate']) ?? '',
        'address' => $user->address ?? isset($_POST['address']) ?? trim($_POST['address']) ?? '',

        'first_name_err' => '',
        'middle_name_err' => '',
        'last_name_err' => '',
        'gender_err' => '',
        'fb_account_name_err' => '',
        'contact_number_err' => '',
        'birthdate_err' => '',
        'address_err' => '',
      ];

      $this->view('users/registerPersonalInfo', $data);
    }
  }
  public function registerClinicInfo()
  {
    if (!isLoggedIn()) {
      redirect('users/login');
    }
    if (isLoggedIn() && isCompleteInfo()) {
      redirect('pages');
    }
    if (isset($_SESSION['login_time_stamp']) && (time() - $_SESSION['login_time_stamp'] > 10 * 60)) {
      session_unset();
      session_destroy();
      redirect("users/login");
    } else {
      session_regenerate_id(true);
      $_SESSION['login_time_stamp'] = time();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
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
          $_SESSION['current_registration_step'] = 'registerEmergencyInfo';
          redirect('users/registerEmergencyInfo');
        } else {
          die('Something went wrong');
        }
      } else {
        // Load view with errors
        $this->view('users/registerClinicInfo', $data);
      }
    } else {
      $clinic = $this->model('Clinic')->getClinicById($_SESSION['user_id']);

      $data = [
        'clinic_name' => $clinic->name ?? isset($_POST['clinic_name']) ?? trim($_POST['clinic_name']) ?? '',
        'clinic_street' => $clinic->street ?? isset($_POST['clinic_street']) ?? trim($_POST['clinic_street']) ?? '',
        'clinic_district' => $clinic->district ?? isset($_POST['clinic_district']) ?? trim($_POST['clinic_district']) ?? '',
        'clinic_city' => $clinic->city ?? isset($_POST['clinic_city']) ?? trim($_POST['clinic_city']) ?? '',
        'clinic_contact_number' => $clinic->contact_number ?? isset($_POST['clinic_contact_number']) ?? trim($_POST['clinic_contact_number']) ?? '',

        'clinic_name_err' => '',
        'clinic_street_err' => '',
        'clinic_district_err' => '',
        'clinic_city_err' => '',
        'clinic_contact_number_err' => '',
      ];
      // Load view
      $this->view('users/registerClinicInfo', $data);
    }
  }
  public function registerEmergencyInfo()
  {
    if (!isLoggedIn()) {
      redirect('users/login');
    }
    if (isLoggedIn() && isCompleteInfo()) {
      redirect('pages');
    }
    if (isset($_SESSION['login_time_stamp']) && (time() - $_SESSION['login_time_stamp'] > 10 * 60)) {
      session_unset();
      session_destroy();
      redirect("users/login");
    } else {
      session_regenerate_id(true);
      $_SESSION['login_time_stamp'] = time();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
        'user_id' => $_SESSION['user_id'] ?? '',

        'emergency_person_name' => trim($_POST['emergency_person_name']),
        'emergency_address' => trim($_POST['emergency_address']),
        'emergency_contact_number' => trim($_POST['emergency_contact_number']),

        'emergency_person_name_err' => '',
        'emergency_address_err' => '',
        'emergency_contact_number_err' => '',
      ];

      // Validate case of emergency info
      if (empty($data['emergency_person_name'])) {
        $data['emergency_person_name_err'] = 'Please enter the name of your case of emergency contact';
      }
      if (empty($data['emergency_address'])) {
        $data['emergency_address_err'] = 'Please enter the name of their address';
      }
      if (empty($data['emergency_contact_number'])) {
        $data['emergency_contact_number_err'] = 'Please enter their contact number';
      }

      if (
        empty($data['emergency_person_name_err']) && empty($data['emergency_address_err'])
        && empty($data['emergency_contact_number_err'])
      ) {
        if ($this->userModel->updateEmergencyInfo($data)) {
          $user = $this->userModel->getUserById($_SESSION['user_id']);
          unset($_SESSION['current_registration_info']);
          $this->createUserSession($user);
        } else {
          die('Something went wrong');
        }
      } else {
        // Load view with errors
        $this->view('users/registerEmergencyInfo', $data);
      }
    } else {
      $user = $this->userModel->getUserById($_SESSION['user_id']);

      $data = [
        'emergency_person_name' => $user->emergency_person_name ?? isset($_POST['emergency_person_name']) ?? trim($_POST['emergency_person_name']) ?? '',
        'emergency_address' => $user->emergency_address ?? isset($_POST['emergency_address']) ?? trim($_POST['emergency_address']) ?? '',
        'emergency_contact_number' => $user->emergency_contact_number ?? isset($_POST['emergency_contact_number']) ?? trim($_POST['emergency_contact_number']) ?? '',

        'emergency_person_name_err' => '',
        'emergency_address_err' => '',
        'emergency_contact_number_err' => '',
      ];
      // Load view
      $this->view('users/registerEmergencyInfo', $data);
    }
  }
  // public function registerDuesInfo()
  // {
  //   if (!isLoggedIn()) {
  //     redirect('users/login');
  //   }
  //   if (isLoggedIn() && isCompleteInfo()) {
  //     redirect('pages');
  //   }
  //   // if ($_SESSION['current_registration_step'] != 'registerDuesInfo') {
  //   //   redirect('users/' . $_SESSION['current_registration_step']);
  //   // }

  //   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  //     $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

  //     $data = [
  //       'user_id' => $_SESSION['user_id'] ?? '',
  //       'payment_option' => trim($_POST['payment_option']),
  //       'payment_option_err' => ''
  //     ];

  //     // Validate payment option
  //     if (empty($data['payment_option'])) {
  //       $data['payment_option_err'] = 'Please select your payment option';
  //     }

  //     if (empty($data['payment_option_err'])) {
  //       if ($this->userModel->updateDuesInfo($data)) {
  //         $user = $this->userModel->getUserById($_SESSION['user_id']);
  //         unset($_SESSION['current_registration_info']);
  //         $this->createUserSession($user);

  //       } else {
  //         die('Something went wrong');
  //       }
  //     } else {
  //       // Load view with errors
  //       $this->view('users/registerDuesInfo', $data);
  //     }
  //   } else {
  //     $user = $this->userModel->getUserById($_SESSION['user_id']);

  //     $data = [
  //       'payment_option' => $user->payment_option ?? isset($_POST['payment_option']) ?? trim($_POST['payment_option']) ?? '',

  //       'payment_option_err' => ''
  //     ];

  //     // Load view
  //     $this->view('users/registerDuesInfo', $data);
  //   }
  // }

  public function createUserSession($user = '', $notThirdParty = true)
  {
    $_SESSION['user_id'] = $user->id;
    $_SESSION['user_email'] = $user->email;
    $_SESSION['user_name'] = ucwords($user->last_name) . ', ' . ucwords($user->first_name) . ' ' . ucwords(substr($user->middle_name, 0, 1) . '.');

    if (
      $notThirdParty && !empty($user->middle_name) && !empty($user->birthdate)
      && !empty($user->prc_number) && !empty($user->emergency_person_name)
    ) {
      $_SESSION['complete_info'] = true;
      $_SESSION["login_time_stamp"] = time();

      flash('login_status', 'You just signed in successfully!');
      redirect('pages');
    } else if (
      !$notThirdParty && !empty($user->middle_name) && !empty($user->birthdate)
      && !empty($user->prc_number) && !empty($user->emergency_person_name)
    ) {
      // die('yes');
      $_SESSION['complete_info'] = true;
      $_SESSION["login_time_stamp"] = time();

      flash('login_status', 'You just signed in successfully!');
      redirect('pages');
    } else {
      $_SESSION['complete_info'] = false;
      $_SESSION["login_time_stamp"] = time();
      flash('login_status', 'Proceed to finish registration', 'You are either signed in using 3rd party authenthication or missed some inputs along the steps.');
      redirect('users/registerPrcInfo');
    }
  }

  public function logout()
  {
    unset($_SESSION['user_id']);
    unset($_SESSION['user_email']);
    unset($_SESSION['user_name']);
    unset($_SESSION['complete_info']);
    unset($_SESSION['login_time_stamp']);
    session_destroy();
    redirect('users/login');
  }
}
