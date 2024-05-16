<?php

namespace App\Controllers;

use App\Models\EstablecimientoModel;

class Directive extends BaseController
{
    private $establecimientoModel;

    public function __construct()
    {
        $this->establecimientoModel = new EstablecimientoModel();
    }

    public function establecimientos()
    {
        $data['establecimientos'] = $this->establecimientoModel->getEstablecimientosForDirective();
        return view('components/establecimientos', $data);
    }
}
