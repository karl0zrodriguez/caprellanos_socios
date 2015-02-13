<?php

require_model('socio.php');
//require_model('grupo_clientes.php');
//require_model('pais.php');
//require_model('serie.php');
//require_model('tarifa.php');

class asociados_perfiles extends fs_controller
{
   public $socio;
   public $offset;
   public $resultados;
//   public $grupo;
//   public $pais;
//   public $serie;
//   public $tarifa;
   
   public function __construct()
   {
      parent::__construct(__CLASS__, 'Socios', 'Asociados', FALSE, TRUE);
   }
   
   protected function process()
   {
      $this->custom_search = TRUE;
      $this->buttons[] = new fs_button_img('b_nuevo_socio', 'Nuevo', 'add.png', '#nuevo');
      $this->buttons[] = new fs_button('b_importar', 'Importar CSV');
      $this->buttons[] = new fs_button('b_exportar', 'Exportar XLS', $this->url().'&export=TRUE');
      $this->socio = new socio();
//      $this->grupo = new grupo_clientes();
//      $this->pais = new pais();
//      $this->serie = new serie();
//      $this->tarifa = new tarifa();
      
//      if( isset($_GET['delete_grupo']) )
//      {
//         $grupo = $this->grupo->get($_GET['delete_grupo']);
//         if($grupo)
//         {
//            if( $grupo->delete() )
//               $this->new_message('Grupo eliminado correctamente.');
//            else
//               $this->new_error_msg('Imposible eliminar el grupo.');
//         }
//         else
//            $this->new_error_msg('Grupo no encontrado.');
//      }
//      else if( isset($_POST['codgrupo']) )
//      {
//         $grupo = $this->grupo->get($_POST['codgrupo']);
//         if(!$grupo)
//         {
//            $grupo = new grupo_clientes();
//            $grupo->codgrupo = $_POST['codgrupo'];
//         }
//         $grupo->nombre = $_POST['nombre'];
//         
//         if($_POST['codtarifa'] == '---')
//            $grupo->codtarifa = NULL;
//         else
//            $grupo->codtarifa = $_POST['codtarifa'];
//         
//         if( $grupo->save() )
//            $this->new_message('Grupo guardado correctamente.');
//         else
//            $this->new_error_msg('Imposible guardar el grupo.');
//      }
      //elseif( isset($_GET['delete']) ) 
      if( isset($_GET['export']) )
        {
            $this->exportar_xml();
        }
        elseif(isset($_POST['archivo']))
        {
            $this->importar_xml();
        }
         elseif( isset($_GET['delete']) )
      {
         $socio = $this->socio->get($_GET['delete']);
         if($socio)
         {
            if( $socio->delete() )
               $this->new_message('Cliente eliminado correctamente.');
            else
               $this->new_error_msg('Ha sido imposible eliminar el socio.');
         }
         else
            $this->new_error_msg('Cliente no encontrado.');
      }
      else if( isset($_POST['cedula']) )
      {
         $socio = new socio();
         $socio->nacionalidad = $_POST['nacionalidad'];
         $socio->cedula = $_POST['cedula'];
         $socio->nombre_1 = $_POST['nombre_1'];
         $socio->nombre_2 = $_POST['nombre_2'];
         $socio->apellido_1 = $_POST['apellido_1'];
         $socio->apellido_2 = $_POST['apellido_2'];
         $socio->telefono_movil = $_POST['telefono_movil'];
         $socio->email = $_POST['email'];
         if( $socio->save() )
         {
//            $dircliente = new direccion_cliente();
//            $dircliente->codcliente = $cliente->codcliente;
//            $dircliente->codpais = $_POST['pais'];
//            $dircliente->provincia = $_POST['provincia'];
//            $dircliente->ciudad = $_POST['ciudad'];
//            $dircliente->codpostal = $_POST['codpostal'];
//            $dircliente->direccion = $_POST['direccion'];
//            $dircliente->descripcion = 'Principal';
//            if( $dircliente->save() )
               header('location: '.$socio->url());
//            else
//               $this->new_error_msg("¡Imposible guardar la dirección del cliente!");
         }
         else
            $this->new_error_msg("¡Imposible guardar los datos del socio!");
      }
      
      $this->offset = 0;
      if( isset($_GET['offset']) )
         $this->offset = intval($_GET['offset']);
      
      if($this->query != '')
      {
         $this->resultados = $this->socio->search($this->query, $this->offset);
      }
      else
         $this->resultados = $this->socio->all($this->offset);
   }
   
   public function anterior_url()
   {
      $url = '';
      
      if($this->query!='' AND $this->offset>'0')
      {
         $url = $this->url()."&query=".$this->query."&offset=".($this->offset-FS_ITEM_LIMIT);
      }
      else if($this->query=='' AND $this->offset>'0')
      {
         $url = $this->url()."&offset=".($this->offset-FS_ITEM_LIMIT);
      }
      
      return $url;
   }
   
   public function siguiente_url()
   {
      $url = '';
      
      if($this->query!='' AND count($this->resultados)==FS_ITEM_LIMIT)
      {
         $url = $this->url()."&query=".$this->query."&offset=".($this->offset+FS_ITEM_LIMIT);
      }
      else if($this->query=='' AND count($this->resultados)==FS_ITEM_LIMIT)
      {
         $url = $this->url()."&offset=".($this->offset+FS_ITEM_LIMIT);
      }
      
      return $url;
   }
   
   private function exportar_xml()
   {
        /// desactivamos el motor de plantillas
        $this->template = FALSE;
      
        /// creamos el xls
        header("Content-Type: application/vnd.ms-excel");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("content-disposition: attachment; filename=asociados.xls");
        $tabla="<table border='1'>"
            . "<tr>"
                . "<td>nacionalidad</td>"
                . "<td>cedula</td>"
                . "<td>nombre_1</td>"
                . "<td>nombre_2</td>"
                . "<td>apellido_1</td>"
                . "<td>apellido_2</td>"
                . "<td>sexo</td>"
                . "<td>estado_civil</td>"
                . "<td>fecha_nac</td>"
                . "<td>lugar_nac</td>"
                . "<td>cod_estado</td>"
                . "<td>cod_municipio</td>"
                . "<td>telefono_movil</td>"
                . "<td>telefono</td>"
                . "<td>email</td>"
            . "</tr>";
        
        foreach($this->socio->all_full() as $b)
        {
            $tabla.="<tr>"
                ."<td>".$b->nacionalidad."</td>"
                ."<td>".$b->cedula."</td>"
                ."<td>".$b->nombre_1."</td>"
                ."<td>".$b->nombre_2."</td>"
                ."<td>".$b->apellido_1."</td>"
                ."<td>".$b->nombre_2."</td>"
                ."<td>".$b->sexo."</td>"
                ."<td>".$b->estado_civil."</td>"
                ."<td>".$b->fecha_nac."</td>"
                ."<td>".$b->lugar_nac."</td>"
                ."<td>".$b->cod_estado."</td>"
                ."<td>".$b->cod_municipio."</td>"
                ."<td>".$b->telefono_movil."</td>"
                ."<td>".$b->telefono."</td>"
                ."<td>".$b->email."</td>"
            ."</tr>";
        }
        echo $tabla.="</table>";      
   }
   
   private function importar_xml()
   {
       
      if( is_uploaded_file($_FILES['farchivo']['tmp_name']) )
        {
           if( !file_exists("tmp/socios") )
              mkdir("tmp/socios");
           else if( file_exists("tmp/socios/socios.csv") )
              unlink("tmp/socios/socios.csv");

           copy($_FILES['farchivo']['tmp_name'], "tmp/socios/socios.csv");
        }
        else
           $this->new_error_msg("¡Imposible cargar el archivo!");
      $file = fopen("tmp/socios/socios.csv", 'r');
      if($file)
      {
        $i = 0;
        while(!feof($file))
        {
           //$linea = fgets($file);
           //$linea = split(';',$linea); 
           $linea = fgets($file);
           $linea = split(',',$linea); 
           $linea[0] = trim(str_replace("'","",$linea[0]));
           $linea[1] = trim(str_replace("'","",$linea[1]));
           $linea[2] = trim(str_replace("'","",$linea[2]));
           $linea[3] = trim(str_replace("'","",$linea[3]));
           $linea[4] = trim(str_replace("'","",$linea[4]));
           $linea[5] = trim(str_replace("'","",$linea[5]));
           $linea[6] = trim(str_replace("'","",$linea[6]));
           $linea[7] = trim(str_replace("'","",$linea[7]));
           $linea[8] = trim(str_replace("'","",$linea[8]));
           $linea[9] = trim(str_replace("'","",$linea[9]));
           $linea[10] = trim(str_replace("'","",$linea[10]));
           $importar = new socio();
           $importar->nacionalidad = $linea[0];
           $importar->cedula = $linea[1];
           $importar->nombre_1 = $linea[2];
           $importar->nombre_2 = $linea[3];
           $importar->apellido_1 = $linea[4];
           $importar->apellido_2 = $linea[5];
           $importar->sexo = $linea[6];
           $importar->estado_civil = $linea[7];
           $importar->fecha_nac = $linea[8];
           $importar->telefono_movil = $linea[9];
           $importar->telefono = $linea[10];
           if($linea[1]!=''){
                if(!$importar->save()){
                    $this->new_error_msg("Error al insertar ".$linea[1]);
                }
           }
        }
        fclose($file);
        header('location: index.php?page=asociados_perfiles');
      }
      else
         $this->new_error_msg("¡Error al leer el archivo!" );
   }
}
