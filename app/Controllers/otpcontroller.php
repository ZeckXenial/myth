<?php namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\validacionmodel;

class OtpController extends Controller
{
    protected $session;

    public function __construct()
    {
        helper('session'); // Cargar helper de sesi��n
        $this->session = session(); // Iniciar sesi��n
    }

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
        $user_id = $this->session->get('iduser');

        // URL de verificaci��n de OTP
        $url = "https://apiede.mineduc.cl/otp/verify-otp?rut={$rut}&otp={$otp}&DateWithTimeZone={$timestamp}";
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        $validacionModel = new validacionmodel();
        $fecha_val = date('Y-m-d');

        // Verificar si hay error en la respuesta usando expresi��n regular
        $status = ($error || preg_match('/ERROR:/i', $response)) ? 'Error' : 'Success';

        // Guardar en la tabla validaci��n
        $data = [
            'rut' => $rut,
            'fecha_val' => $fecha_val,
            'user_id' => $user_id,
            'status' => $status
        ];
    
        $validacionModel->insert($data);

        // Retornar respuesta JSON
        return $this->response->setStatusCode($status === 'Error' ? 500 : 200)->setJSON(json_decode($response, true));
    }
}
