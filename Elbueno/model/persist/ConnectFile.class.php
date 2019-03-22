<?php
//se guarda en el atributo mode
class ConnectFile {

    private $file; // ruta y nombre del fichero
    private $mode; // modo de acceso al fichero
    private $handle; // puntero al fichero
    
    public function __construct($file) {
        //guarda el nombre del fichero en el file
        $this->file=$file;
    }

    public function getFile() {
        return $this->file;
    }

    public function getMode() {
        return $this->mode;
    }

    public function getHandle() {
        return $this->handle;
    }

    public function setFile($file) {
        $this->file = $file;
    }

    public function setMode($mode) {
        $this->mode = $mode;
    }

    public function setHandle($handle) {
        $this->handle = $handle;
    }
    
    public function openFile($mode):bool {
        //le paso el modo, lo guardo en la clase
        $this->mode=$mode;
        //fopen retorna el puntero del fichero
        $this->handle=fopen($this->file, $this->mode);
        // TRUE si abre el fichero correctamente
        $result=($this->handle)?TRUE:FALSE;
        
        return $result;
    }
    
    public function closeFile() {
        //cierra automaticamente pero es mejor ponerlo por si acaso
        fclose($this->handle);
    }

    public function writeFile($data):bool {
        $result=FALSE;
        
        if (count($data)>0) {
            // abre el fichero en modo write
            if ($this->openFile("w")) {
                foreach ($data as $line) {
                    //fput y fget en el fichero(word en moodle)
                    //va grabando linea x linea
                    fputs($this->getHandle(), $line);
                }
            }
            $this->closeFile();            
            $result=TRUE;
        }
        
        return $result;
    }
    
}
