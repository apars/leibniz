<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Survey extends CI_Controller {

  public function __construct()
  {
      parent::__construct();
      $this->load->helper('url');
      $this->load->model("survey_model");
  }

  public function index()
  {
    try{
        //$this->load->database();
        $data["active_surveys"] = $this->survey_model->getActiveSurveys();
        $this->load->view('templates/survey/header');
        $this->load->view('templates/survey/nav');
        $this->load->view('templates/survey/intro', $data);
        $this->load->view('templates/survey/footer');
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
  }
  
  public function loaddb()
  {
      $data["active_surveys"] = null;
      $this->load->view('templates/survey/header');
      $this->load->view('templates/survey/nav');
      $this->load->view('templates/survey/intro', $data);
      $this->load->view('templates/survey/footer');
  }
  
  public function importdb()
  {
      try{
          $dbasedir    = $this->config->item("usb_path").'survey.sql';
          $mysqlbin = $this->config->item("mysql_path");
          $mysqldumpbin = $this->config->item("mysqldump_path");
          $mysqladminbin = $this->config->item("mysqladmin_path");
          
          $sublocation = $this->config->item("db_prefix").date('m-d-Y_hia').$this->config->item("db_ext");
          $dbexpfile = $this->config->item("back_path").$sublocation;
          $shellcommand= $mysqldumpbin." -u ".$this->db->username." -p".$this->db->password." ".$this->db->database." > ".$dbexpfile."\n";
          exec($shellcommand);
          
          $dbexpfile = $this->config->item("usb_path").$sublocation;
          $shellcommand= $mysqldumpbin." -u ".$this->db->username." -p".$this->db->password." ".$this->db->database." > ".$dbexpfile."\n";
          exec($shellcommand);
          
          if(file_exists($dbasedir))
          {
            //Drop database only when new db file is available.
            $shellcommand= $mysqladminbin." -u ".$this->db->username." -p".$this->db->password." -f drop ".$this->db->database."\n";
            exec($shellcommand);
            //Import database.
            $shellcommand= $mysqlbin." -u ".$this->db->username." -p".$this->db->password." < ".$dbasedir."\n";
            exec($shellcommand);
          }
          redirect($this.base_url());
      } catch (Exception $ex) {

      }
  }
  
  public function thanks()
  {
    $data["active_surveys"] = "";
    $this->load->view('templates/survey/header');
    $this->load->view('templates/survey/nav');
    $this->load->view('templates/survey/thanks', $data);
    $this->load->view('templates/survey/footer');
  }
  
  public function aquestion($survey = "")
  {
    $surveyPrefix = "";
    $surveyData = $this->survey_model->getSurveyPrefix($survey);
    $data["valid_survey"] = true;
    $data["show_questions"] = true;
    $data["survey_errors"] = false;

    // check if the provided slug was valid
    if($surveyData != null) {

      // populate survery information
      $surveyPrefix = $surveyData->prefix;
      $data["survey_title"] = $surveyData->title;
      $data["survey_subtitle"] = $surveyData->subtitle;
    }
    else {
      $data["valid_survey"] = false; // display error
    }

    // check if the survey was submitted
    if($_SERVER['REQUEST_METHOD'] == 'POST' && $data["valid_survey"]) {
      $result = $this->survey_model->validateSubmission($surveyPrefix);
      if(array_key_exists("errors", $result)) {
        $data["errors"] = $result["errors"];
        $data["survey_errors"] = true;
      }
      else {
        $data["show_questions"] = false;
      }
    }
  }
  
  /**
   * renders an error if a survey parameter is not passed
   * as a parameter in the url
   */
  public function questions($survey = "")
  {
    $surveyPrefix = "";
    $surveyData = $this->survey_model->getSurveyPrefix($survey);
    $data["valid_survey"] = true;
    $data["show_questions"] = true;
    $data["survey_errors"] = false;

    // check if the provided slug was valid
    if($surveyData != null) {

      // populate survery information
      $surveyPrefix = $surveyData->prefix;
      $data["survey_title"] = $surveyData->title;
      $data["survey_subtitle"] = $surveyData->subtitle;
    }
    else {
      $data["valid_survey"] = false; // display error
    }

    // check if the survey was submitted
    if($_SERVER['REQUEST_METHOD'] == 'POST' && $data["valid_survey"]) {
      $result = $this->survey_model->validateSubmission($surveyPrefix);
      if(array_key_exists("errors", $result)) {
        $data["errors"] = $result["errors"];
        $data["survey_errors"] = true;
      }
      else {
        $data["show_questions"] = false;
      }
    }

    // check if the user specified a valid survey
    if(!empty($surveyPrefix)) {

      $data["questions"] = $this->survey_model->getSurveyData($surveyPrefix);
      ($data["questions"] === null) ? $data["valid_survey"] = false: "";
    }

    $data["active_surveys"] = "";
    $this->load->view('templates/survey/header', $data);
    $this->load->view('templates/survey/nav');
    $this->load->view('templates/survey/survey', $data);
    $this->load->view('templates/survey/footer');
  }
  
  public function export($survey = "")
  {
    $surveyPrefix = "";
    $surveyData = $this->survey_model->getSurveyPrefix($survey);
    $data["valid_survey"] = true;
    $data["show_questions"] = true;
    $data["survey_errors"] = false;
    $data["export_result"] = "";

    // check if the provided slug was valid
    if($surveyData != null) {
      // populate survery information
      $surveyPrefix = $surveyData->prefix;
      $data["survey_title"] = $surveyData->title;
      $data["survey_subtitle"] = $surveyData->subtitle;
    }
    $result = $this->survey_model->getSurveyDataForExport($surveyPrefix);
    $this->load->dbutil();
    $this->load->helper('file');
    //var_dump($result);
    $outfile = $this->config->item("usb_path").$this->config->item("exp_prefix").date('m-d-Y_hia').$this->config->item("exp_ext");
    $csvdata = $this->dbutil->csv_from_result($result);
        if ( ! write_file($outfile, $csvdata))
        {
            $data["export_result"] = "Export failed.";
        }
        else
        {
            $data["export_result"] = "File successfully exported.";
        }
    
    $data["active_surveys"] = "";
    $this->load->view('templates/survey/header', $data);
    $this->load->view('templates/survey/nav');
    $this->load->view('templates/survey/exported', $data);
    $this->load->view('templates/survey/footer');
    
  }
}