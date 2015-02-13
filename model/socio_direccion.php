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

/**
 * Una dirección de un socio. Puede tener varias.
 */
class socio_direccion extends fs_model
{
   public $id;
   public $cedula;
   public $urbanismo;
   public $urbanismo_nombre;
   public $carrera_avenida;
   public $calle;
   public $sector;
   public $vivienda;
   public $vivienda_nombre;
   public $piso;
   public $numero;
   public $telefono;
   public $descripcion;


   public function __construct($d=FALSE)
   {
      parent::__construct('sociosdir', 'plugins/caja_ahorros/');
      if($d)
      {
         $this->id = $this->intval($d['id']);
         $this->cedula = $d['cedula'];
         $this->urbanismo = $d['urbanismo'];
         $this->urbanismo_nombre = $d['urbanismo_nombre'];
         $this->carrera_avenida = $d['carrera_avenida'];
         $this->calle = $d['calle'];
         $this->sector = $d['sector'];
         $this->vivienda = $d['vivienda'];
         $this->vivienda_nombre = $d['vivienda_nombre'];
         $this->piso = $d['piso'];
         $this->numero = $d['numero'];
         $this->telefono = $d['telefono'];
         $this->descripcion = $d['descripcion'];
      }
      else
      {
         $this->id = NULL;
         $this->cedula = NULL;
         $this->urbanismo = NULL;
         $this->urbanismo_nombre = NULL;
         $this->carrera_avenida = NULL;
         $this->calle = NULL;
         $this->sector = NULL;
         $this->vivienda = NULL;
         $this->vivienda_nombre = TRUE;
         $this->piso = TRUE;
         $this->numero = NULL;
         $this->telefono = NULL;
         $this->descripcion = NULL;
      }
   }
   
   protected function install()
   {
      return '';
   }
   
   public function get($id)
   {
      $dir = $this->db->select("SELECT * FROM ".$this->table_name." WHERE id = ".$this->var2str($id).";");
      if($dir)
         return new socio_direccion($dir[0]);
      else
         return FALSE;
   }

   public function exists()
   {
      if( is_null($this->id) )
         return FALSE;
      else
         return $this->db->select("SELECT * FROM ".$this->table_name." WHERE id = ".$this->var2str($this->id).";");
   }
   
   public function test()
   {
      $this->urbanismo_nombre = $this->no_html($this->urbanismo_nombre);
      $this->calle = $this->no_html($this->calle);
      $this->sector = $this->no_html($this->sector);
      $this->numero = $this->no_html($this->numero);
      $this->vivienda = $this->no_html($this->vivienda);
      $this->carrera_avenida = $this->no_html($this->carrera_avenida);
      return TRUE;
   }
   
   public function save()
   {
      if( $this->test() )
      {
         if( $this->exists() )
         {
            $sql = "UPDATE ".$this->table_name." SET cedula = ".$this->var2str($this->cedula).",
               urbanismo = ".$this->var2str($this->urbanismo).", urbanismo_nombre = ".$this->var2str($this->urbanismo_nombre).",
               carrera_avenida = ".$this->var2str($this->carrera_avenida).", calle = ".$this->var2str($this->calle).",
               sector = ".$this->var2str($this->sector).", vivienda = ".$this->var2str($this->vivienda).",
               vivienda_nombre = ".$this->var2str($this->vivienda_nombre).", piso = ".$this->var2str($this->piso).",
               numero = ".$this->var2str($this->numero).", telefono = ".$this->var2str($this->telefono).", 
               descripcion = ".$this->var2str($this->descripcion)."  WHERE id = ".$this->var2str($this->id).";";
            return $this->db->exec($sql);
         }
         else
         {
            $sql = "INSERT INTO ".$this->table_name." (cedula,urbanismo,urbanismo_nombre,carrera_avenida,calle,sector,vivienda,
               vivienda_nombre,piso,numero,telefono,descripcion) VALUES (".$this->var2str($this->cedula).",".$this->var2str($this->urbanismo).",
               ".$this->var2str($this->urbanismo_nombre).",".$this->var2str($this->carrera_avenida).",".$this->var2str($this->calle).",
               ".$this->var2str($this->sector).",".$this->var2str($this->vivienda).",".$this->var2str($this->vivienda_nombre).",
               ".$this->var2str($this->piso).",".$this->var2str($this->numero).",".$this->var2str($this->telefono).",".$this->var2str($this->descripcion).");";
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
      return $this->db->exec("DELETE FROM ".$this->table_name." WHERE id = ".$this->var2str($this->id).";");
   }
   
   public function all_from_socio($cod)
   {
      $dirlist = array();
      $dirs = $this->db->select("SELECT * FROM ".$this->table_name.
              " WHERE cedula = ".$this->var2str($cod).";");
      if($dirs)
      {
         foreach($dirs as $d)
            $dirlist[] = new socio_direccion($d);
      }
      return $dirlist;
   }
   
   public function valor_urbanismo()
   {
      return array('Urbanización', 'Conjunto Residencial', 'Barrio');
   }
   public function valor_vivienda()
   {
      return array('Urbanización', 'Conjunto Residencial', 'Barrio');
   }
}
