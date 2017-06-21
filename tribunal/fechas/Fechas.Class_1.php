<?php

class Fechas {

    protected $dias = array("DOMINGO", "LUNES", "MARTES", "MIERCOLES", "JUEVES", "VIERNES", "SABADO");

    public function avanzaDiaXHora($fecha, $horas, $habiles = false, $festivos = "", $especial = "N", $horasSuma = 0) {
        $fecha = substr($fecha, 6, 4) . "-" . substr($fecha, 3, 2) . "-" . substr($fecha, 0, 2);
        $dias = 0;
        $horasRestantes = $horas + 24;
        $diaFestivo = false;

        while ($horasRestantes > 0) {
            $fechaTmp = explode("-", $fecha);
            $diaSemana = date("w", mktime(0, 0, 0, $fechaTmp[1], $fechaTmp[2], $fechaTmp[0]));
            $diaFestivo = false;
            if ($habiles) {
                if (($diaSemana >= 1) && ($diaSemana <= 5)) {
                    if ($especial == "N") {
                        for ($index = 0; $index < count($festivos); $index++) {
                            $diaAuxiliar1 = strtotime('+' . 0 . ' day', strtotime($festivos[$index]["fecha"]));
                            $diaAuxiliar2 = strtotime('+' . 0 . ' day', strtotime($fecha));
                            if ($diaAuxiliar1 == $diaAuxiliar2) {
                                $diaFestivo = true;
                                break;
                            }
                        }

                        if (!$diaFestivo) {
                            $horasRestantes = $horasRestantes - 24;
                        }
                    } else {
                        for ($index = 0; $index < count($festivos); $index++) {

                            $diaAuxiliar1 = strtotime('+' . 0 . ' day', strtotime($festivos[$index]["fecha"]));
                            $diaAuxiliar2 = strtotime('+' . 0 . ' day', strtotime($fecha));
                            if ($diaAuxiliar1 == $diaAuxiliar2) {
                                if ($festivos[$index]["Tipo"] == 'S') {
                                    $diaFestivo = true;
                                    break;
                                }
                            }
                        }
                        if (!$diaFestivo) {
                            $horasRestantes = $horasRestantes - 24;
                        }
                    }
                }
            } else {
                $horasRestantes = $horasRestantes - 24;
            }
            $dias+=1;

            $fechaAuxiliar = strtotime('+' . 1 . 'day', strtotime($fecha));
            $fecha = date('Y-m-d', $fechaAuxiliar);
        }
        $horaParaSumar = (($dias - 1) * 24) + $horasSuma;
        return $horaParaSumar;
    }

    public function avanzaDiaDisponible($fecha, $fechaMax, $catAudienciasDto, $habiles = false, $festivos = "", $especial = "N") { //$catAudienciasDto
        /*
         * Verificamos si el dia esta disponible para programar audiencias
         */

        $fechaMinima = substr($fecha, 6, 4) . "-" . substr($fecha, 3, 2) . "-" . substr($fecha, 0, 2);
        $fechaMaxima = substr($fechaMax, 6, 4) . "-" . substr($fechaMax, 3, 2) . "-" . substr($fechaMax, 0, 2);
        $dias = 0;
        $diaDisponible = false;

        if (($catAudienciasDto->getCveTipoAudiencia() == 1) || ($catAudienciasDto->getCveTipoAudiencia() == 3)) { //AUDIENCIA PROGRAMADA O MIXTA
            while ($diaDisponible == false) {
                $fechaTmp = explode("-", $fechaMinima);

                $diaSemana = date("w", mktime(0, 0, 0, $fechaTmp[1], $fechaTmp[2], $fechaTmp[0]));
                $diaFestivo = false;
                if ($habiles) {
                    if (($diaSemana >= 1) && ($diaSemana <= 5)) {
                        if ($especial == "N") {//No es un tipo de audiencia especial se le da un trato normal
                            for ($index = 0; $index < count($festivos); $index++) {
                                $diaAuxiliar1 = strtotime('+' . 0 . ' day', strtotime($festivos[$index]["fecha"]));
                                $diaAuxiliar2 = strtotime('+' . 0 . ' day', strtotime($fechaMinima));
                                if ($diaAuxiliar1 == $diaAuxiliar2) {
                                    $diaFestivo = true;
                                    break;
                                }
                            }

                            if ($diaFestivo) {//Avanzamos un dia porque ese dia no lo podemos contemplar 
                                $fechaAuxiliar = strtotime('+' . 1 . 'day', strtotime($fechaMinima));
                                $fechaMinima = date('Y-m-d', $fechaAuxiliar);
                                $dias+=1;
                            } else { //Ese dia es valido para comenzar con la programacion de las audiencias
                                $diaDisponible = true;
                            }
                        } else {// Es un tipo de audiencia especial que es programada pero se considera urgente
                            for ($index = 0; $index < count($festivos); $index++) {

                                $diaAuxiliar1 = strtotime('+' . 0 . ' day', strtotime($festivos[$index]["fecha"]));
                                $diaAuxiliar2 = strtotime('+' . 0 . ' day', strtotime($fechaMinima));
                                if ($diaAuxiliar1 == $diaAuxiliar2) {
                                    if ($festivos[$index]["Tipo"] == 'S') {
                                        $diaFestivo = true;
                                        break;
                                    }
                                }
                            }

                            if ($diaFestivo) {
                                $fechaAuxiliar = strtotime('+' . 1 . 'day', strtotime($fechaMinima));
                                $fechaMinima = date('Y-m-d', $fechaAuxiliar);
                                $dias+=1;
                            } else {
                                $diaDisponible = true;
                            }
                        }
                    } else {
                        $fechaAuxiliar = strtotime('+' . 1 . 'day', strtotime($fechaMinima));
                        $fechaMinima = date('Y-m-d', $fechaAuxiliar);
                        $dias+=1;
                    }
                }
            }

            return $dias * 24;
        } else if ($catAudienciasDto->getCveTipoAudiencia() == 2) { //AUDIENCIA URGENTE
            return 0;
        }
    }

    public function tiempoUtilizacion($imputados, $ofendidos, $catAudiencia) {
        $numImputadosDetenidos = 0;
        $total = 0;

        for ($index = 0; $index < count($imputados); $index++) { //Obtenemos el numero de imputados detenidos
            if ($imputados[$index]->getDetenido() == "S") {
                $numImputadosDetenidos+=1;
            }
        }

        if ($numImputadosDetenidos > 2) {
            $total = ((($numImputadosDetenidos / 2) * $catAudiencia->getMaxDuracion()) + $catAudiencia->getHolgura());

            if ($total > 360) {//Revizamos si el timepo no rebaza las 6 horas
                $total = 360; // Equivalente a 6 horas  
            }
        } else {
            $total = ($catAudiencia->getMaxDuracion() + $catAudiencia->getHolgura());
        }

        unset($numImputadosDetenidos);
        unset($catAudiencia);
        unset($imputados);
        unset($ofendidos);
        unset($index);

        return $total;
    }

}

?>