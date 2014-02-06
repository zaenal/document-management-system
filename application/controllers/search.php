<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Search
 */
class Search extends CI_Controller {

   /**
    * CI_Controller Konstruktor + check ob user eingelogt ist
    */
   function __construct() {
      parent::__construct();
      $is_logged_in = $this->session->userdata('is_logged_in');

      if (!isset($is_logged_in) || $is_logged_in != TRUE) {
         redirect('login');
      }
   }

   /**
    * default index function lädt standard Suche
    */
   function index() {
      $data['view'] = 'search/search_view';
      $this->load->view('template/content', $data);
   }

   /**
    * erweiterte suche
    */
   function search_advanced() {
      $this->load->model('project_model');
      $this->load->model('classification_model');

      // projekte zur view laden
      $projects = $this->project_model->get_Project();
      if ($projects) {
         $data['projects'] = $projects;
      }

      // klassifizierung zur view laden
      $classifications = $this->classification_model->get_Classification();
      if ($classifications) {
         $data['classifications'] = $classifications;
      }

      $data['jQuery'] = TRUE;
      $data['view']   = 'search/search_advanced_view';
      $this->load->view('template/content', $data);
   }

    /**
     * anzeige der suchergebnisse
     */
    function show_result()
    {
        $this->load->model('document_model');

        // v = 1 bedeutet einfache Suche die erweiterte suche ruft show result mit v = 2 auf
        if ($this->input->get('v') == 1) {

            if ($this->input->post('title') == '' && $this->input->post('keywords') == '') {
                $documents = $this->document_model->get_Documents();
            } elseif ($this->input->post('keywords') == '') {
                $title = $this->input->post('title');
                $documents = $this->document_model->get_Documents($title, NULL);
            } elseif ($this->input->post('title') == '') {
                $keywords = explode(',', str_replace(' ', '', $this->input->post('keywords')));
                $documents = $this->document_model->get_Documents(NULL, $keywords);
            } else {
                $title = $this->input->post('title');
                $keywords = explode(',', str_replace(' ', '', $this->input->post('keywords')));
                $documents = $this->document_model->get_Documents($title, $keywords);
            }
        }
        else {
            if ($this->input->post('title') == '' && $this->input->post('keywords') == '' && $this->input->post('projects') == '' && $this->input->post('classification') == '') {
                $documents = $this->document_model->get_Documents(NULL, NULL, NULL, NULL);
            }
            elseif ($this->input->post('keywords') == '' && $this->input->post('classification') == '' && $this->input->post('projects') == '') {
                $title = $this->input->post('title');
                $documents = $this->document_model->get_Documents($title, NULL, NULL, NULL);
            }
            elseif ($this->input->post('title') == '' && $this->input->post('classification') == '' && $this->input->post('projects') == '') {
                $keywords = explode(',', str_replace(' ', '', $this->input->post('keywords')));
                $documents = $this->document_model->get_Documents(NULL, $keywords, NULL, NULL);
            }
            elseif ($this->input->post('classification') == '' && $this->input->post('projects') == '') {
                $title = $this->input->post('title');
                $keywords = explode(',', str_replace(' ', '', $this->input->post('keywords')));
                $documents = $this->document_model->get_Documents($title, $keywords, NULL, NULL);
            }
            elseif ($this->input->post('title') == '' && $this->input->post('keywords') == '' && $this->input->post('classification') == '') {
                $project = $this->input->post('projects');
                $documents = $this->document_model->get_Documents(NULL, NULL, $project, NULL);
            }
            elseif ($this->input->post('keywords') == '' && $this->input->post('projects') == '') {
                $title = $this->input->post('title');
                $project = $this->input->post('projects');
                $documents = $this->document_model->get_Documents($title, NULL, $project, NULL);
            }
            elseif ($this->input->post('title') == '' && $this->input->post('classification') == '') {
                $keywords = explode(',', str_replace(' ', '', $this->input->post('keywords')));
                $project = $this->input->post('projects');
                $documents = $this->document_model->get_Documents(NULL, $keywords, $project, NULL);
            }
            elseif ($this->input->post('classification') == '') {
                $title = $this->input->post('title');
                $keywords = explode(',', str_replace(' ', '', $this->input->post('keywords')));
                $project = $this->input->post('projects');
                $documents = $this->document_model->get_Documents($title, $keywords, $project, NULL);
            }
            elseif ($this->input->post('title') == '' && $this->input->post('keywords') == '' && $this->input->post('projects') == '') {
                $classification = $this->input->post('classification');
                $documents = $this->document_model->get_Documents(NULL, NULL, NULL, $classification);
            }
            elseif ($this->input->post('keywords') == '' && $this->input->post('projects') == '') {
                $title = $this->input->post('title');
                $classification = $this->input->post('classification');
                $documents = $this->document_model->get_Documents($title, NULL, NULL, $classification);
            }
            elseif ($this->input->post('title') == '' && $this->input->post('projects') == '') {
                $keywords = explode(',', str_replace(' ', '', $this->input->post('keywords')));
                $classification = $this->input->post('classification');
                $documents = $this->document_model->get_Documents(NULL, $keywords, NULL, $classification);
            }
            elseif ($this->input->post('projects') == '') {
                $title = $this->input->post('title');
                $keywords = explode(',', str_replace(' ', '', $this->input->post('keywords')));
                $classification = $this->input->post('classification');
                $documents = $this->document_model->get_Documents($title, $keywords, NULL, $classification);
            }
            elseif ($this->input->post('title') == '' && $this->input->post('keywords') == '') {
                $classification = $this->input->post('classification');
                $project = $this->input->post('projects');
                $documents = $this->document_model->get_Documents(NULL, NULL, $project, $classification);
            }
            elseif ($this->input->post('keywords') == '') {
                $title = $this->input->post('title');
                $classification = $this->input->post('classification');
                $project = $this->input->post('projects');
                $documents = $this->document_model->get_Documents($title, NULL, $project, $classification);
            }
            elseif ($this->input->post('title') == '') {
                $keywords = explode(',', str_replace(' ', '', $this->input->post('keywords')));
                $classification = $this->input->post('classification');
                $project = $this->input->post('projects');
                $documents = $this->document_model->get_Documents(NULL, $keywords, $project, $classification);
            }
            else {
                $title = $this->input->post('title');
                $keywords = explode(',', str_replace(' ', '', $this->input->post('keywords')));
                $classification = $this->input->post('classification');
                $project = $this->input->post('projects');
                $documents = $this->document_model->get_Documents($title, $keywords, $project, $classification);
            }
        }

        // wenn Ergebnisse gefunden wurden
        if ($documents) {
            $data['documents'] = $documents;

            $data['view'] = 'search/result_view';
            $this->load->view('template/content', $data);
        } // wenn nichts gefunden wurde
        else {
            $data['error'] = 'No items found, search again with other input';
            $data['view'] = 'search/search_view';
            $this->load->view('template/content', $data);
        }
    }


    /**
    * ajax backend function welche vom js script gecalled wird
    */
   function show_Hint() {
      //getten
      $model   = $this->input->get('model');
      $entered = $this->input->get('entered');

      //entsprechenden model laden
      $this->load->model($model);

      // alle möglichen einträge nach dem model laden die mit dem übergebenen buchstaben beginnen
      switch ($model) {
         case "project_model":
            $hints = $this->project_model->getHints($entered);
            break;
         case "author_model":
            $hints = $this->author_model->getHints($entered);
            break;
      }


      // den response string formatieren so das in der view ein dropdown damit gefüllt werden kann
      //$response = '<option value ="'.'">--- view all ---</option>';
      foreach ($hints->result() as $hint) {
         $response = '<option value=' . $hint->id . '>' . $hint->name . '</option>';
      }

      echo $response;
   }

   /**
    * loads the popup view
    */
   function popup() {
      $this->load->model('document_model');

      $doc_id = $this->input->get('doc_id');
      $data['document'] = $this->document_model->get_Document($doc_id);

      $this->load->model('keyword_model');
      $data['keywords'] = $this->keyword_model->get_Keyword_By_DocumentID($doc_id);

      $this->load->view('search/popup_view', $data);
   }

   /**
    * file download function
    *
    * @param $file_id
    */
   function dl_file($file_id) {
      $this->load->model('file_model');
      $this->file_model->download_File($file_id);
   }
}
/* End of file search.php */
/* Location: ./application/controllers/search.php */