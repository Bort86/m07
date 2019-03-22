<?php
class ConnectFile {

    private $file; // ruta y nombre del fichero
    private $mode; // modo de acceso al fichero
    private $handle; // puntero al fichero
    
    public function __construct($file) {
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
        $this->mode=$mode;
        $this->handle=fopen($this->file, $this->mode);
        // TRUE si abre el fichero correctamente
        $result=($this->handle)?TRUE:FALSE;
        
        return $result;
    }
    
    public function closeFile() {
        fclose($this->handle);
    }

    public function writeFile($data):bool {
        $result=FALSE;
        
        if (count($data)>0) {
            // abre el fichero en modo write
            if ($this->openFile("w")) {
                foreach ($data as $line) {
                    fputs($this->getHandle(), $line);
                }
            }
            $this->closeFile();            
            $result=TRUE;
        }
        
        return $result;
    }
    
}
