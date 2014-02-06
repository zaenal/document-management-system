<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class User_model
 */
class User_model extends CI_Model {

    /**
     * @param $first_name
     * @param $last_name
     * @param $email
     * @param $username
     * @param $password
     * @return bool
     */
    function create_User($first_name, $last_name, $email, $username, $password) {
      //ueberpruefung ob der username und email bereits verwendet wurde
      $this->db->where('username', $username);
      $query = $this->db->get('login_users');
      if ($query->num_rows == 1) {
          return FALSE;
      }
      $this->db->where('email', $email);
      $query = $this->db->get('login_users');
      if ($query->num_rows == 1) {
          return FALSE;
      }

      $insert_data = array(
         'first_name' => $first_name,
         'last_name'  => $last_name,
         'email'      => $email,
         'username'   => $username,
         'password'   => hash('sha256', $password)
      );

      // insert erfolgreich, dann wird $insert TRUE
      $result = $this->db->insert('login_users', $insert_data);

      return $result;
   }

   /**
    * @param null $id
    *
    * @return bool
    */
   function get_User($id = NULL) {
      if (!isset($id)) {
         $this->db->where('role', 2);
         $users = $this->db->get('login_users');

         if ($users->num_rows() > 0) {
            return $users;
         }

         return FALSE;
      }
      else {
         $this->db->where('users_id', $id);
         $user = $this->db->get('login_users');

         if ($user->num_rows() == 1) {
            return $user->row();
         }

         return FALSE;
      }
   }

   /**
    * @param $id
    * @param $data
    *
    * @return mixed
    */
   function update_User($id, $data) {
      $this->db->where('users_id', $id);
      $result = $this->db->update('login_users', $data);

      return $result;
   }

   /**
    * @param $id
    *
    * @return mixed
    */
   function delete_User($id) {
      $this->db->where('users_id', $id);
      $result = $this->db->delete('login_users');

      return $result;
   }

   /**
    * @return bool
    */
   function validate() {
      $this->db->where('password', hash('sha256', $this->input->post('password')));
      $this->db->where("(username='" . $this->input->post('login') . "' OR email='" . $this->input->post('login') . "')");
      $result = $this->db->get('login_users');

      // der user input stimmt mit der db überein wenn genau 1 reihe zurück kommt
      if ($result->num_rows() == 1) {
         return $result->row()->users_id;
      }

      return FALSE;
   }

   /**
    * @param $user_id
    *
    * @return bool
    */
   function get_Role($user_id) {
      $this->db->select('role');
      $this->db->where('users_id', $user_id);
      $result = $this->db->get('login_users');

      if ($result->num_rows() == 1) {
         return $result->row()->role;
      }

      return FALSE;
   }

   /**
    * checking the user input in signup
    */
   function checking($inputed, $id) {
      if ($id == 'email') {
         $this->db->where('email', $inputed);
         $result = $this->db->get('login_users');
          //falls was gefunden ist heisst der input vom user schon vorhanden ist, return false
          if ($result->num_rows() > 0) {
              return 'This Email is already used!';
          }
          return FALSE;
      }
      else if ($id == 'username') {
         $this->db->where('username', $inputed);
         $result = $this->db->get('login_users');
          //falls was gefunden ist heisst der input vom user schon vorhanden ist, return false
          if ($result->num_rows() > 0) {
              return 'This Username is already used!';
          }
          return FALSE;
      }
   }
}
/* End of file user_model.php */
/* Location: ./application/models/user_model.php */