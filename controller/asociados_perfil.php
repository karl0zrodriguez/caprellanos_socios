<?php
/*
 * This file is part of FacturaSctipts
 * Copyright (C) 2014  Carlos Garcia Gomez  neorazorx@gmail.com
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 * 
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

require_model('socio.php');
require_model('estado.php');
require_model('municipio.php');
require_model('socio_direccion.php');
//require_model('direccion_cliente.php');
//require_model('divisa.php');
//require_model('forma_pago.php');
//require_model('grupo_clientes.php');
//require_model('pais.php');
//require_model('serie.php');

class asociados_perfil extends fs_controller
{
   public $socio;
   public $estado;
   public $municipio;
   public $socio_direccion;
//   public $divisa;
//   public $forma_pago;
//   public $grupo;
//   public $pais;
//   public $serie;
//   
   public function __construct()
   {
      parent::__construct(__CLASS__, 'Socio', 'Asociados', FALSE, FALSE);
   }
   
   protected function process()
   {
      $this->ppage = $this->page->get('asociados_perfiles');
      $this->estado = new estado();
      $this->municipio = new municipio();
      $this->socio_direccion = new socio_direccion();
//      $this->divisa = new divisa();
//      $this->forma_pago = new forma_pago();
//      $this->grupo = new grupo_clientes();
//      $this->pais = new pais();
//      $this->serie = new serie();
      
      /// cargamos el cliente
      $socio = new socio();
      $this->socio = FALSE;
      if( isset($_POST['id']) )
      {
         $this->socio = $socio->get( $_POST['id'] );
      }
      else if( isset($_GET['id']) )
         $this->socio = $socio->get($_GET['id']);
      
      /// ¿Hay que hacer algo más?
//      if( isset($_GET['delete_cuenta']) ) /// eliminar cuenta bancaria
//      {
//         $cuenta = $this->cuenta_banco->get($_GET['delete_cuenta']);
//         if($cuenta)
//         {
//            if( $cuenta->delete() )
//            {
//               $this->new_message('Cuenta bancaria eliminada correctamente.');
//            }
//            else
//               $this->new_error_msg('Imposible eliminar la cuenta bancaria.');
//         }
//         else
//            $this->new_error_msg('Cuenta bancaria no encontrada.');
//      }else
      if( isset($_GET['delete_dir']) ) /// eliminar dirección
      {
         $dir = new socio_direccion();
         $dir0 = $dir->get($_GET['delete_dir']);
         if($dir0)
         {
            if( $dir0->delete() )
            {
               $this->new_message('Dirección eliminada correctamente.');
            }
            else
               $this->new_error_msg('Imposible eliminar la dirección.');
         }
         else
            $this->new_error_msg('Dirección no encontrada.');
      }
      else if( isset($_POST['coddir']) ) /// añadir/modificar dirección
      {
         $dir = new socio_direccion();
         if($_POST['coddir'] != '')
            $dir = $dir->get($_POST['coddir']);
            $dir->cedula = $this->socio->cedula;
            $dir->urbanismo = $_POST['urbanismo'];
            $dir->urbanismo_nombre = $_POST['urbanismo_nombre'];
            $dir->carrera_avenida = $_POST['carrera_avenida'];
            $dir->calle = $_POST['calle'];
            $dir->sector = $_POST['sector'];
            $dir->vivienda = $_POST['vivienda'];
            $dir->vivienda_nombre = $_POST['vivienda_nombre'];
            $dir->piso = $_POST['piso'];
            $dir->numero = $_POST['numero'];
            $dir->telefono = $_POST['telefono'];
            $dir->descripcion = $_POST['descripcion'];
         if( $dir->save() )
         {
            $this->new_message("Dirección guardada correctamente.");
         }
         else
            $this->new_message("¡Imposible guardar la dirección!");
      }
//      else if( isset($_POST['iban']) ) /// añadir/modificar dirección
//      {
//         if( isset($_POST['codcuenta']) )
//         {
//            $cuentab = $this->cuenta_banco->get($_POST['codcuenta']);
//         }
//         else
//         {
//            $cuentab = new cuenta_banco_cliente();
//            $cuentab->codcliente = $_POST['codcliente'];
//         }
//         $cuentab->descripcion = $_POST['descripcion'];
//         
//         if($_POST['ciban'] != '')
//         {
//            $cuentab->iban = $this->calcular_iban($_POST['ciban']);
//         }
//         else
//            $cuentab->iban = $_POST['iban'];
//         
//         if( $cuentab->save() )
//         {
//            $this->new_message('Cuenta bancaria guardada correctamente.');
//         }
//         else
//            $this->new_error_msg('Imposible guardar la cuenta bancaria.');
//      }
//      else 
        if( isset($_POST['id']) ) /// modificar socio
      {
         $this->socio->id = $_POST['id'];
         $this->socio->cedula = $_POST['cedula'];
         $this->socio->nombre_1 = $_POST['nombre_1'];
         $this->socio->nombre_2 = $_POST['nombre_2'];
         $this->socio->apellido_1 = $_POST['apellido_1'];
         $this->socio->apellido_2 = $_POST['apellido_2'];
         $this->socio->sexo = $_POST['sexo'];
         $this->socio->estado_civil = $_POST['estado_civil'];
         $this->socio->fecha_nac = $_POST['fecha_nac'];
         $this->socio->estado = $_POST['estado'];
         $this->socio->municipio = $_POST['municipio'];
         $this->socio->telefono_movil = $_POST['telefono_movil'];
         $this->socio->telefono = $_POST['telefono'];
         $this->socio->email = $_POST['email'];
         $this->socio->status = $_POST['status'];
         $this->socio->zona = $_POST['zona'];
         $this->socio->personal = $_POST['personal'];
         $this->socio->areapersonal = $_POST['areapersonal'];
         $this->socio->tiponomina = $_POST['tiponomina'];
         $this->socio->empresaingreso = $_POST['empresaingreso'];
         $this->socio->cargo = $_POST['cargo'];
         $this->socio->codunidad = $_POST['codunidad'];
         $this->socio->unidad = $_POST['unidad'];
         $this->socio->ubicacion = $_POST['ubicacion'];
         $this->socio->centro_trabajo = $_POST['centro_trabajo'];
         
//         $this->socio->recargo = isset($_POST['recargo']);
         
//         $this->socio->codagente = NULL;
//         if($_POST['codagente'] != '---')
//            $this->socio->codagente = $_POST['codagente'];
//         
//         $this->socio->codgrupo = NULL;
//         if($_POST['codgrupo'] != '---')
//            $this->socio->codgrupo = $_POST['codgrupo'];
         
         if( $this->socio->save() )
         {
            $this->new_message("Datos del socio modificados correctamente.");
         }
         else
            $this->new_error_msg("¡Imposible modificar los datos del socio!");
      }
      
      if($this->socio)
      {
         $this->page->title = $this->socio->cedula;
         $this->buttons[] = new fs_button_img('b_eliminar', 'Eliminar', 'trash.png', '#', TRUE);
      }
      else
         $this->new_error_msg("¡Socio no encontrado!");
   }
   
   public function url()
   {
      if( !isset($this->socio) )
         return parent::url();
      else if($this->socio)
         return $this->socio->url();
      else
         return $this->ppage->url();
   }
   
//   public function this_year($previous = 0)
//   {
//      return intval(Date('Y')) - $previous;
//   }
//   
//   private function calcular_iban($ccc)
//   {
//      $codpais = substr($this->empresa->codpais, 0, 2);
//      
//      foreach($this->socio->get_direcciones() as $dir)
//      {
//         if($dir->domfacturacion)
//         {
//            $codpais = substr($dir->codpais, 0, 2);
//            break;
//         }
//      }
//      
//      $pesos = array('A' => '10', 'B' => '11', 'C' => '12', 'D' => '13', 'E' => '14', 'F' => '15',
//          'G' => '16', 'H' => '17', 'I' => '18', 'J' => '19', 'K' => '20', 'L' => '21', 'M' => '22',
//          'N' => '23', 'O' => '24', 'P' => '25', 'Q' => '26', 'R' => '27', 'S' => '28', 'T' => '29',
//          'U' => '30', 'V' => '31', 'W' => '32', 'X' => '33', 'Y' => '34', 'Z' => '35'
//      );
//      
//      $dividendo = $ccc.$pesos[substr($codpais, 0 , 1)].$pesos[substr($codpais, 1 , 1)].'00';	
//      $digitoControl =  98 - bcmod($dividendo, '97');
//      
//      if( strlen($digitoControl) == 1 )
//         $digitoControl = '0'.$digitoControl;
//      
//      return $codpais.$digitoControl.$ccc;
//   }
   
   /*
    * Devuelve un array con los datos estadísticos de las compras del socio
    * en los cinco últimos años.
    */
//   public function stats_from_cli()
//   {
//      $stats = array();
//      $years = array();
//      for($i=4; $i>=0; $i--)
//         $years[] = intval(Date('Y')) - $i;
//      
//      $meses = array('Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic');
//      
//      foreach($years as $year)
//      {
//         for($i = 1; $i <= 12; $i++)
//         {
//            $stats[$year.'-'.$i]['mes'] = $meses[$i-1].' '.$year;
//            $stats[$year.'-'.$i]['compras'] = 0;
//         }
//         
//         if( strtolower(FS_DB_TYPE) == 'postgresql')
//            $sql_aux = "to_char(fecha,'FMMM')";
//         else
//            $sql_aux = "DATE_FORMAT(fecha, '%m')";
//         
//         $data = $this->db->select("SELECT ".$sql_aux." as mes, sum(total) as total
//            FROM albaranescli WHERE fecha >= ".$this->empresa->var2str(Date('1-1-'.$year))."
//            AND fecha <= ".$this->empresa->var2str(Date('31-12-'.$year))." AND codcliente = ".$this->empresa->var2str($this->socio->codcliente)."
//            GROUP BY ".$sql_aux." ORDER BY mes ASC;");
//         if($data)
//         {
//            foreach($data as $d)
//               $stats[$year.'-'.intval($d['mes'])]['compras'] = number_format($d['total'], FS_NF0, '.', '');
//         }
//      }
//      
//      return $stats;
//   }
}
