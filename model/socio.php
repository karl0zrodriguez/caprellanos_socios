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

require_once 'base/fs_model.php';
//require_model('estado.php');


/**
 * El cliente. Puede tener una o varias direcciones y subcuentas asociadas.
 */
class socio extends fs_model
{
   public $nacionalidad;
   public $cedula;
   public $nombre_1;
   public $nombre_2;
   public $apellido_1;
   public $apellido_2;
   public $sexo;
   public $estado_civil;
   public $fecha_nac;
   public $lugar_nac;
   public $cod_estado;
   public $cod_municipio;
   public $telefono_movil;
   public $telefono;
   public $email;
   public $fecha_registro;
   public $fecha_baja;
   public $status;
   public $zona;
   public $personal;
   public $areapersonal;
   public $tiponomina;
   public $empresaingreso;
   public $cargo;
   public $codunidad;
   public $unidad;
   public $ubicacion;
   public $centro_trabajo;

   public function __construct($s=FALSE)
   {
      parent::__construct('socios', 'plugins/caja_ahorros/');
      if($s)
      {
         $this->id = $s['id'];
         $this->nacionalidad = $s['nacionalidad'];
         $this->cedula = $s['cedula'];
         $this->nombre_1 = $s['nombre_1'];
         $this->nombre_2 = $s['nombre_2'];
         $this->apellido_1 = $s['apellido_1'];
         $this->apellido_2 = $s['apellido_2'];
         $this->sexo = $s['sexo'];
         $this->estado_civil = $s['estado_civil'];
         $this->fecha_nac = $s['fecha_nac'];
         $this->lugar_nac = $s['lugar_nac'];
         $this->cod_estado = $s['cod_estado'];
         $this->cod_municipio = $s['cod_municipio'];
         $this->telefono_movil = $s['telefono_movil'];
         $this->telefono = $s['telefono'];
         $this->email = $s['email'];
         $this->fecha_registro = $s['fecha_registro'];
         $this->fecha_baja = $s['fecha_baja'];
         $this->status = $s['status'];
         $this->zona = $s['zona'];
         $this->personal = $s['personal'];
         $this->areapersonal = $s['areapersonal'];
         $this->tiponomina = $s['tiponomina'];
         $this->empresaingreso = $s['empresaingreso'];
         $this->cargo = $s['cargo'];
         $this->codunidad = $s['codunidad'];
         $this->unidad = $s['unidad'];
         $this->ubicacion = $s['ubicacion'];
         $this->centro_trabajo = $s['centro_trabajo'];
      }
      else
      {
         $this->id = NULL;
         $this->nacionalidad = NULL;
         $this->cedula = '';
         $this->nombre_1 = NULL;
         $this->nombre_2 = NULL;
         $this->apellido_1 = NULL;
         $this->apellido_2 = NULL;
         $this->sexo = NULL;
         $this->estado_civil = NULL;
         $this->fecha_nac = NULL;
         $this->lugar_nac = NULL;
         $this->cod_estado = NULL;
         $this->cod_municipio = NULL;
         $this->telefono_movil = NULL;
         $this->telefono = NULL;
         $this->email = NULL;
         $this->fecha_registro = NULL;
         $this->fecha_baja = NULL;
         $this->status = NULL;
         $this->zona = NULL;
         $this->personal = NULL;
         $this->areapersonal = NULL;
         $this->tiponomina = NULL;
         $this->empresaingreso = NULL;
         $this->cargo = NULL;
         $this->codunidad = NULL;
         $this->unidad = NULL;
         $this->ubicacion = NULL;
         $this->centro_trabajo = NULL;
      }
   }
   
   protected function install()
   {
      $this->clean_cache();
      return '';
   }
   
//   public function observaciones_resume()
//   {
//      if($this->observaciones == '')
//         return '-';
//      else if( strlen($this->observaciones) < 60 )
//         return $this->observaciones;
//      else
//         return substr($this->observaciones, 0, 50).'...';
//   }
   
   public function url()
   {
      if( is_null($this->cedula) )
         return "index.php?page=asociados_perfiles";
      else
         return "index.php?page=asociados_perfil&id=".$this->id;
   }

//   public function is_default()
//   {
//      return ( $this->codcliente == $this->default_items->codcliente() );
//   }
   
   public function valor_nacionalidad()
   {
      return array('Venezolana', 'Extranjero');
   }
   
   public function valor_sexo()
   {
      return array('Masculino', 'Femenino');
   }
   
   public function valor_estadocivil()
   {
      return array('Soltero(a)', 'Casado(a)', 'Divorsiado(a)', 'Concubino(a)','Viudo(a)');
   }
   
   public function valor_centrotrabajo()
   {
      return array('Sede Acarigua', 'Central Zona', 'Comercial', 'Oficina Comercial','Distrito','Caprellanos');
   }
   
   public function get($ced)
   {
      $soc = $this->db->select("SELECT * FROM ".$this->table_name." WHERE id = ".$this->var2str($ced).";");
      if($soc)
      {
         return new socio($soc[0]);
      }
      else
         return FALSE;
   }
   
   public function get_direcciones()
   {
      $dir = new socio_direccion();
      return $dir->all_from_socio($this->cedula);
   }
   
//   public function get_subcuentas()
//   {
//      $subclist = array();
//      $subc = new subcuenta_cliente();
//      foreach($subc->all_from_cliente($this->codcliente) as $s)
//      {
//         $s2 = $s->get_subcuenta();
//         if($s2)
//         {
//            $subclist[] = $s2;
//         }
//         else
//            $s->delete();
//      }
//      
//      return $subclist;
//   }
//   
//   public function get_subcuenta($ejercicio)
//   {
//      $subcuenta = FALSE;
//      
//      foreach($this->get_subcuentas() as $s)
//      {
//         if($s->codejercicio == $ejercicio)
//         {
//            $subcuenta = $s;
//            break;
//         }
//      }
//      
//      if(!$subcuenta)
//      {
//         /// intentamos crear la subcuenta y asociarla
//         $continuar = TRUE;
//         
//         $cuenta = new cuenta();
//         $ccli = $cuenta->get_cuentaesp('CLIENT', $ejercicio);
//         if($ccli)
//         {
//            $subc0 = $ccli->new_subcuenta($this->codcliente);
//            $subc0->descripcion = $this->nombre;
//            if( !$subc0->save() )
//            {
//               $this->new_error_msg('Imposible crear la subcuenta para el cliente '.$this->codcliente);
//               $continuar = FALSE;
//            }
//            
//            if($continuar)
//            {
//               $sccli = new subcuenta_cliente();
//               $sccli->codcliente = $this->codcliente;
//               $sccli->codejercicio = $ejercicio;
//               $sccli->codsubcuenta = $subc0->codsubcuenta;
//               $sccli->idsubcuenta = $subc0->idsubcuenta;
//               if( $sccli->save() )
//               {
//                  $subcuenta = $subc0;
//               }
//               else
//                  $this->new_error_msg('Imposible asociar la subcuenta para el cliente '.$this->codcliente);
//            }
//         }
//      }
//      
//      return $subcuenta;
//   }
   
   public function exists()
   {
      if( is_null($this->id) )
         return FALSE;
      else
         return $this->db->select("SELECT * FROM ".$this->table_name." WHERE id = ".$this->var2str($this->id).";");
   }
   
//   public function get_new_codigo()
//   {
//      $cod = $this->db->select("SELECT MAX(".$this->db->sql_to_int('codcliente').") as cod FROM ".$this->table_name.";");
//      if($cod)
//         return sprintf('%06s', (1 + intval($cod[0]['cod'])));
//      else
//         return '000001';
//   }
   
   public function test()
   {
      $status = FALSE;
      
      $this->cedula = trim($this->cedula);
      $this->nombre_1 = $this->no_html($this->nombre_1);
      $this->nombre_2 = $this->no_html($this->nombre_2);
      $this->apellido_1 = $this->no_html($this->apellido_1);
      $this->apellido_2 = $this->no_html($this->apellido_2);
      
      if( !preg_match("/^[0-9]{1,20}$/i", $this->cedula) )
         $this->new_error_msg("Cédula no válida.");
      else if( strlen($this->nombre_1) < 1 OR strlen($this->nombre_1) > 100 )
         $this->new_error_msg("Primer Nombre no válido.");
//      else if( strlen($this->nombre_2) < 1 OR strlen($this->nombre_2) > 100 )
//         $this->new_error_msg("Segundo Nombre no válido.");
      else if( strlen($this->apellido_1) < 1 OR strlen($this->apellido_1) > 100 )
         $this->new_error_msg("Primer Apellido no válido.");
//      else if( strlen($this->apellido_2) < 1 OR strlen($this->apellido_2) > 100 )
//         $this->new_error_msg("Segundo Apellido no válido.");
      else
         $status = TRUE;
      
      return $status;
   }
   
   public function save()
   {
      if( $this->test() )
      {
         $this->clean_cache();
         if( $this->exists() )
         {
            $sql = "UPDATE ".$this->table_name." SET nacionalidad = ".$this->var2str($this->nacionalidad).",
               cedula = ".$this->var2str($this->cedula).", nombre_1 = ".$this->var2str($this->nombre_1).",
               nombre_2 = ".$this->var2str($this->nombre_2).", apellido_1 = ".$this->var2str($this->apellido_1).",
               apellido_2 = ".$this->var2str($this->apellido_2).", sexo = ".$this->var2str($this->sexo).",
               estado_civil = ".$this->var2str($this->estado_civil).", fecha_nac = ".$this->var2str($this->fecha_nac).",
               lugar_nac = ".$this->var2str($this->lugar_nac).", cod_estado = ".$this->var2str($this->cod_estado).",
               cod_municipio = ".$this->var2str($this->cod_municipio).", telefono_movil = ".$this->var2str($this->telefono_movil).",
               telefono = ".$this->var2str($this->telefono).", email = ".$this->var2str($this->email).",
               fecha_registro = ".$this->var2str($this->fecha_registro).",
               fecha_baja = ".$this->var2str($this->fecha_baja).", status = ".$this->var2str($this->status).",
               telefono = ".$this->var2str($this->telefono).", email = ".$this->var2str($this->email).",
               zona = ".$this->var2str($this->zona).", personal = ".$this->var2str($this->personal).",
               areapersonal = ".$this->var2str($this->areapersonal).", tiponomina = ".$this->var2str($this->tiponomina).",
               empresaingreso = ".$this->var2str($this->empresaingreso).", cargo = ".$this->var2str($this->cargo).",
               codunidad = ".$this->var2str($this->codunidad).", unidad = ".$this->var2str($this->unidad).",    
               ubicacion = ".$this->var2str($this->ubicacion).", centro_trabajo = ".$this->var2str($this->centro_trabajo)."
               WHERE id = ".$this->var2str($this->id).";";
            return $this->db->exec($sql);
         }
         else
         {
            $sql = "INSERT INTO ".$this->table_name." (nacionalidad,cedula,nombre_1,nombre_2,apellido_1,
               apellido_2,sexo,estado_civil,fecha_nac,lugar_nac,cod_estado,cod_municipio,telefono_movil,telefono,email,fecha_registro,
               fecha_baja,status,zona,personal,areapersonal,tiponomina,empresaingreso,cargo,codunidad,unidad,ubicacion,centro_trabajo)
               VALUES (".$this->var2str($this->nacionalidad).",".$this->var2str($this->cedula).",
               ".$this->var2str($this->nombre_1).",".$this->var2str($this->nombre_2).",
               ".$this->var2str($this->apellido_1).",".$this->var2str($this->apellido_2).",
               ".$this->var2str($this->sexo).",".$this->var2str($this->estado_civil).",
               ".$this->var2str($this->fecha_nac).",".$this->var2str($this->lugar_nac).",
               ".$this->var2str($this->cod_estado).",".$this->var2str($this->cod_municipio).",".$this->var2str($this->telefono_movil).",
               ".$this->var2str($this->telefono).",".$this->var2str($this->email).",".$this->var2str($this->fecha_registro).",
               ".$this->var2str($this->fecha_baja).",".$this->var2str($this->status).",
               ".$this->var2str($this->zona).",".$this->var2str($this->personal).",".$this->var2str($this->areapersonal).",".$this->var2str($this->tiponomina).",
               ".$this->var2str($this->empresaingreso).",".$this->var2str($this->cargo).",".$this->var2str($this->codunidad).",".$this->var2str($this->unidad).",
               ".$this->var2str($this->ubicacion).",".$this->var2str($this->centro_trabajo).");";
            $resultado = $this->db->exec($sql);
            if($resultado)
            {
               $newid = $this->db->lastval();
               if($newid)
                  $this->id = intval($newid);
            }
            return $resultado;
         }
         
      }
      else
         return FALSE;
   }
   
   public function delete()
   {
      $this->clean_cache();
      return $this->db->exec("DELETE FROM ".$this->table_name." WHERE id = ".$this->var2str($this->id).";");
   }
   
   private function clean_cache()
   {
      $this->cache->delete('m_socio_all');
   }
   
   public function all($offset=0)
   {
      $soclist = array();
      $socios = $this->db->select_limit("SELECT * FROM ".$this->table_name." ORDER BY cedula ASC", FS_ITEM_LIMIT, $offset);
      if($socios)
      {
         foreach($socios as $s)
            $soclist[] = new socio($s);
      }
      return $soclist;
   }
   
   public function all_full()
   {
      $soclist = $this->cache->get_array('m_socio_all');
      if( !$soclist )
      {
         $socios = $this->db->select("SELECT * FROM ".$this->table_name." ORDER BY cedula ASC;");
         if($socios)
         {
            foreach($socios as $s)
               $soclist[] = new socio($s);
         }
         $this->cache->set('m_socio_all', $soclist);
      }
      return $soclist;
   }
   
   public function search($query, $offset=0)
   {
      $soclist = array();
      $query = strtolower( $this->no_html($query) );
      
      $consulta = "SELECT * FROM ".$this->table_name." WHERE ";
      if( is_numeric($query) )
      {
         $consulta .= "cedula LIKE '%".$query."%' OR nombre_1 LIKE '%".$query."%' OR nombre_2 LIKE '%".$query."%' OR apellido_1 LIKE '%".$query."%' OR apellido_2 LIKE '%".$query."%'";
      }
      else
      {
         $buscar = str_replace(' ', '%', $query);
         $consulta .= "lower(cedula) LIKE '%".$buscar."%' OR lower(nombre_1) LIKE '%".$buscar."%'
            OR lower(nombre_2) LIKE '%".$buscar."%' OR lower(apellido_1) LIKE '%".$buscar."%' OR lower(apellido_2) LIKE '%".$buscar."%'";
      }
      $consulta .= " ORDER BY cedula ASC";
      
      $socios = $this->db->select_limit($consulta, FS_ITEM_LIMIT, $offset);
      if($socios)
      {
         foreach($socios as $c)
            $soclist[] = new socio($c);
      }
      
      return $soclist;
   }
   
   public function search_by_ced($ced, $offset=0)
   {
      $soclist = array();
      $query = strtolower( $this->no_html($ced) );
      $consulta = "SELECT * FROM ".$this->table_name." WHERE lower(cedula) LIKE '".$query."%' ORDER BY cedula ASC";
      $socios = $this->db->select_limit($consulta, FS_ITEM_LIMIT, $offset);
      if($socios)
      {
         foreach($socios as $c)
            $soclist[] = new socio($c);
      }
      
      return $soclist;
   }
}
