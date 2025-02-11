<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\validacionmodel;

class OtpController extends Controller
{
    public function verifyotp()
    {
        // Habilitar CORS
        $this->response->setHeader('Access-Control-Allow-Origin', '*');
        $this->response->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
        $this->response->setHeader('Access-Control-Allow-Headers', 'Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
        
        // Obtener los datos enviados desde el cliente
        $rut = $this->request->getGet('rut');
        $otp = $this->request->getGet('otp');
        $timestamp = $this->request->getGet('DateWithTimeZone');
        $user_id = session()->get('iduser');
        var_dump($user_id);
        exit;
        // URL de verificación de OTP
        $url = "https://apiede.mineduc.cl/otp/verify-otp?rut={$rut}&otp={$otp}&DateWithTimeZone={$timestamp}";
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        $validacionModel = new validacionmodel();
        $fecha_val = date('Y-m-d');
        $status = $error ? 'Error' : 'Success';

        // Guardar en la tabla validación
        $data = [
            'rut'=>$rut,
            'fecha_val' => $fecha_val,
            'user_id' => $user_id,
            'status' => $status
        ];
        
        $validacionModel->insert($data);

        // Retornar respuesta JSON
        if ($error) {
            return $this->response->setStatusCode(500)->setJSON(['error' => $error]);
        } else {
            return $this->response->setStatusCode(200)->setJSON(json_decode($response, true));
        }
    }
}
