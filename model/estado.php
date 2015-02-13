<?php


class estado extends fs_model
{
    public $cod_estado;
    public $estado;
    
    public function __construct($e=FALSE) {
        parent::__construct('estados', 'plugins/caja_ahorros/');
        if($e){
            $this->cod_estado=$e['cod_estado'];
            $this->estado=$e['estado'];
        }else{
            $this->cod_estado=NULL;
            $this->estado=NULL;
        }
    }
    
    protected function install() {
        return "INSERT INTO ".$this->table_name." (`cod_estado`, `estado`) VALUES
                (1, 'DISTRITO CAPITAL'),
                (2, 'ANZOATEGUI'),
                (3, 'APURE'),
                (4, 'ARAGUA'),
                (5, 'BARINAS'),
                (6, 'BOLIVAR'),
                (7, 'CARABOBO'),
                (8, 'COJEDES'),
                (9, 'FALCON'),
                (10, 'GUARICO'),
                (11, 'LARA'),
                (12, 'MERIDA'),
                (13, 'MIRANDA'),
                (14, 'MONAGAS'),
                (15, 'NUEVA ESPARTA'),
                (16, 'PORTUGUESA'),
                (17, 'SUCRE'),
                (18, 'TACHIRA'),
                (19, 'TRUJILLO'),
                (20, 'YARACUY'),
                (21, 'ZULIA'),
                (22, 'AMAZONAS'),
                (23, 'DELTA AMACURO'),
                (24, 'VARGAS');";
    }
    public function test() {
        ;
    }
    public function delete() {
        ;
    }
    public function exists() {
        ;
    }
    public function save() {
        ;
    }
    
    public function listar()
   {
        $listae=array();
        $data = $this->db->select("select * from estados;");
        if($data)
        {
            foreach ($data as $d){
                $listae[] = new estado($d);
            }
        }
        return $listae;
       
    }
    
    public function buscar($texto='')
   {
        $listae=array();
        $data = $this->db->select("select * from estados where cod_estado=".$this->var2str($texto).";");
        if($data)
        {
            foreach ($data as $d){
                $listae[] = new estado($d);
            }
        }
        return $listae;
       
    }
}
