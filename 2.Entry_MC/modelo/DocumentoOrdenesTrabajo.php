<?php
class Ordenes_Trabajo
{
    public $Id_Orden_Trabajo;
    public $Id_Vehiculo;
    public $Codigo;
    public $Placa;
    public $Marca;
    public $Modelo;
    public $LLantas;
    public $Ventanas;
    public $Asignar;
    public $Luces;
    public $Retrovisores;
    public $Rayones;
    public $Tipo_Mantemiento;
    public $Observaciones;
    public $Fecha_Orden_Trabajo;
    public $Estado_Orden_Trabajo;

    function Agregar()
    {
        $conect = new Conexion();
        $c = $conect->conectando();
            $insert = "insert into orden_trabajo values( '$this->Id_Orden_Trabajo',
                                                                                                    '$this->Id_Vehiculo',
                                                                                                    '$this->Codigo',
                                                                                                    '$this->Placa',
                                                                                                    '$this->Marca',
                                                                                                    '$this->Modelo',
                                                                                                    '$this->LLantas',
                                                                                                    '$this->Ventanas',
                                                                                                    '$this->Asignar',
                                                                                                    '$this->Luces',
                                                                                                    '$this->Retrovisores',
                                                                                                    '$this->Rayones',
                                                                                                    '$this->Tipo_Mantemiento',
                                                                                                    '$this->Observaciones',
                                                                                                    '$this->Fecha_Orden_Trabajo',
                                                                                                    '$this->Estado_Orden_Trabajo'
                                                                                                    )";
            //echo ($insert);
            mysqli_query($c, $insert);
            echo "<script> alert('Se creo la orden de trabajo correctamente')
                            location.href='Ordenes-Trabajo-list.php';</script>";
        }
    }
