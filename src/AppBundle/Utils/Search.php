<?php

/**
 * Created by PhpStorm.
 * User: luismicoms
 * Date: 19/10/17
 * Time: 11:03
 */
namespace AppBundle\Utils;
class Search
{

    private $atributos;
    private $cadena;
    private $palabras;

    /**
     * Constructor
     * @param $parametros, Array con los parámetros a buscar
     * @param $cadena String con los criterios de busqueda
     */
    public function __construct($atributos, $cadena = '')
    {
        $this->atributos = $atributos;
        $this->cadena = $cadena;
        $this->preparaCadena();
    }

    private function preparaCadena()
    {
        //Palabras a omitir en la busqueda
        $filtro = array();
        $filtro[] = "";
        $filtro[] = "EL";
        $filtro[] = "EN";
        $filtro[] = "LA";
        $filtro[] = "LOS";
        $filtro[] = "LAS";
        $filtro[] = "DE";
        $filtro[] = "DEL";
        $filtro[] = "UN";
        $filtro[] = "UNA";
        $filtro[] = "UN0";
        $filtro[] = "UNOS";
        $filtro[] = "UNAS";
        $filtro[] = "DR";
        $filtro[] = "DR.";
        $filtro[] = "DRA";
        $filtro[] = "DRA.";
        $filtro[] = "MTRO";
        $filtro[] = "MTRO.";
        $filtro[] = "MTRA";
        $filtro[] = "MTRA.";
        $filtro[] = "ING";
        $filtro[] = "ING.";
        $filtro[] = "LIC";
        $filtro[] = "LIC.";
        $filtro[] = "_";
        $filtro[] = "-";

        $aux_arr_cad = explode(" ", $this->cadena);
        $arr_cad = array();

        //FILTRO
        foreach ($aux_arr_cad as $palabra) {
            if ( !in_array(strtoupper(trim($palabra)), $filtro)) {
                $arr_cad[] = $palabra;
            }
        }


        if (!empty($arr_cad)) {
            $this->palabras = $arr_cad;
        }

        // dump($this->palabras); exit();
    }

    /**
     *
     */
    public function getWhere()
    {
        $query = null;
        if($this->palabras != null)
        {
            $query = '( ';
            foreach ($this->palabras as $i => $palabra)
            {
                if( $i > 0 ) { $query .= ' AND '; }

                $query .= '(';
                foreach ($this->atributos as $k => $atributo)
                {
                    if ($k != 0 ) { $query .= 'OR '; }
                   // $query .= .$atributo. LIKE :palabra_'.$i.' ';

                    $query .= $atributo.' LIKE :palabra_'.$i.' ';
                }
                $query .= ') ';
            }
            $query .= ' )';
        }

        return $query;
    }


    /**
     * Regresa un array con los parametros
     */
    public function getParametros()
    {
        $aux = array();
        foreach($this->palabras as $i => $palabra)
        {
            $aux['palabra_'.$i] = '%'.$palabra.'%';
        }
        return $aux;
    }

    public function size()
    {
        return count($this->palabras);
    }
    
}