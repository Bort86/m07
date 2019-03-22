<?php
require_once "view/SequenceView.class.php";
//require_once "model/SequenceModel.class.php";
//require_once "model/Sequence.class.php";
//require_once "util/SequenceMessage.class.php";

class SequenceController {

    private $view;
    private $model;
    
    const PATH="model/resource/sequences/";  
    const MAX_FILE_SIZE=1500000; // 1.5 MB
    const DELIMITER=":";  
    
    public function __construct() {
        // carga la vista
        $this->view=new SequenceView();

        // carga el modelo de datos
        //$this->model=new SequenceModel();
    }

    public function processRequest() {
        
        $request=NULL;
        $_SESSION['info']=array();
        $_SESSION['error']=array();
        
        // recupera la acción de un formulario
        if (filter_has_var(INPUT_POST, 'action')) {
            $request=filter_has_var(INPUT_POST, 'action')?filter_input(INPUT_POST, 'action'):NULL;
        }
        // recupera la opción de un menú
        else {
            $request=filter_has_var(INPUT_GET, 'option')?filter_input(INPUT_GET, 'option'):NULL;
        }
        
        switch ($request) {
            case "form_action":
                $this->form_action();
                break;
            case "download":
                $this->download();
                break;
            case "upload":
                $this->upload();
                break;
            //aquí entrará cuando al clickar en el enlace del documento que hayamos subido, lo muestra en el sequence view
            default:
                $this->view();
                //$this->view_JSON();
        }
    }

    public function view() {
        if (filter_has_var(INPUT_GET, 'seq')) {
            $file_name=filter_input(INPUT_GET, 'seq');
            
            $file_data=file_get_contents(self::PATH . $file_name, self::DELIMITER);
        }

        $this->form_action($file_data);
    }    
    
    
    public function view_JSON() {
        if (filter_has_var(INPUT_GET, 'seq')) {
            $file_name=filter_input(INPUT_GET, 'seq');
            
            $data_read=$this->read_file(self::PATH . $file_name, self::DELIMITER);
            
            //echo("<pre>" . json_encode($data_read, JSON_PRETTY_PRINT) . "</pre>");
            //die();
            
            $file_data=json_encode($data_read, JSON_PRETTY_PRINT);
        }

        $this->form_action($file_data);
    }    
    
    public function form_action($file_data=NULL) {
        $sequences=array();
        
        $file_dir = opendir(self::PATH);
        while ($file_name = readdir($file_dir)) {
            if (is_file(self::PATH . $file_name)) {
                array_push($sequences, $file_name);
            }
        }
        
        $this->view->display("view/form/SequenceForm.php", $sequences, $file_data);
    }    
    
    public function download() {
        if (filter_has_var(INPUT_POST, 'seq_down')) {
            $file_name=filter_input(INPUT_POST, 'seq_down');

            $file_info=finfo_open(FILEINFO_MIME);
            $file_mime=finfo_file($file_info, self::PATH . $file_name);
            finfo_close($file_info);

            header("Content-Type: $file_mime");
            header("Content-Disposition: attachment; filename=$file_name");

            ob_clean();   //output buffer clean
            readfile(self::PATH . $file_name);
            exit;        
        }
    }

    public function upload() {        
        if (!empty($_FILES['seq_up']['name'])) {
            if ($_FILES['seq_up']['size']>self::MAX_FILE_SIZE) {
                $_SESSION['error']="Max file size exceeded";
            }
            else {
                $file_name=basename($_FILES['seq_up']['name']);
                $file_path=self::PATH . $file_name;
                move_uploaded_file($_FILES['seq_up']['tmp_name'], $file_path);
                chmod($file_path, 0777);
            }
        }
        
        $this->form_action();
    }

    /**
     * Read the file content
     * @param type $file_name name of the file to be read
     * @param type $delimiter separator between keys and values
     * @return associative array with the data read from the file
     */
    function read_file(string $file_name, string $delimiter):array {
        $data=array();
        
        if (file_exists($file_name) && is_readable($file_name)) {
            $handle=fopen($file_name, 'r');
            if ($handle) {
                while (!feof($handle)) {
                    $line=fgets($handle);
                    if ($line) {
                        list($key, $value)=explode($delimiter, $line);
                        $data["$key"]=trim($value);
                    }
                }
                fclose($handle);     
            }
        }
        
        return $data;
    }    
    
}
