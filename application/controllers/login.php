<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 *
 *
 */
class Login extends CI_Controller {

   /**
    *
    *
    *
    */
   function index() {
      $data['view'] = 'login/login_view';
      $this->load->view('template/content', $data);
   }

   /**
    * vergleicht den userinput mit der db zwecks login
    *
    *
    */
   function validate_login() {
      $this->load->model('user_model');
      $user_id = $this->user_model->validate();

      // Wenn die Eingaben in der DB vorhanden sind ist $query == TRUE
      if ($user_id) {

         // $user_data wird an den Session Cookie angehangen und in der DB gespeichert
         $session_data = array(
            'username'     => $this->input->post('login'),
            'role'         => $this->user_model->get_Role($user_id),
            'is_logged_in' => TRUE
         );
         $this->session->set_userdata($session_data);

         // weiterleitung in den geschützten Bereich
         redirect('search');

         // wenn die Eingaben nich in der DB sind, also der User nicht vorhanden ist
         // zurück zur Login Page inkl. Error Ausgabe
      }
      else {
         $data['error'] = 'Invalid Login or Password!';
         $data['view']  = 'login/login_view';
         $this->load->view('template/content', $data);
      }
   }

   /**
    * zeigt die signup page für die user registration
    *
    *
    */
   function signup() {
      $data['view'] = 'login/signup_view';
      $this->load->view('template/content', $data);
   }

   /**
    * prüft den userinput zur registration
    *
    *
    */
   function validate_signup() {
      // field name, error message, validation rules
      $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
      $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
      $this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');

      $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[6]');
      $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[32]');
      $this->form_validation->set_rules('password_confirm', 'Confirmation', 'trim|required|matches[password]');

      // wenn ein wert nicht korrekt validiert wurde alles auf anfang
      if ($this->form_validation->run() == FALSE) {
         $this->signup();
      }
      // ansonsten wird ein user in der db angelegt und die bestätigungs view angezeigt
      else {
         $this->load->model('login_model');
         if ($query = $this->login_model->create_member()) {

            $data['view'] = 'signup_successful';
            $this->load->view('template/content', $data);

         }
         // geht der db insert schief weil zb db verbindung abbricht etc pp
         // wird umgeleitet auf die signup view
         else {
            $data['view'] = 'signup_view';
            $this->load->view('template/content', $data);
         }
      }
   }

   /**
    * logout
    *
    *
    */
   function logout() {
      $this->session->sess_destroy();
      redirect('home');
   }
}
/* End of file login.php */
/* Location: ./application/controllers/login.php */