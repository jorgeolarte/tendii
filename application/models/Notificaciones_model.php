<?php
class Notificaciones_model extends CI_Model
{
    public function __construct()
    {
        $this->load->library('email');
    }

    public function email_emprendedor()
    {
        $data = array(
            "sender" => array(
                "name" => SENDINBLUE_SENDER_NAME,
                "email" => SENDINBLUE_SENDER_EMAIL
            ),
            "to" => array([
                "name" => "Jorge Olarte",
                "email" => "info@emprendedorescartago.com"
            ]),
            "templateId" => 2,
            "subject" => "Tienes un nuevo pedido, bebe",
            "params" => array(
                "LINK" => "https://tiendaemprendedores.com/?utm_source=sendinblue&utm_medium=email&utm_campaign=notificacion_pedido",
                "EMPRENDIMIENTO" => "Jorge Olarte"
            )
        );

        $this->email($data);
    }

    public function email_cliente()
    {

        $data = array(
            "sender" => array(
                "name" => SENDINBLUE_SENDER_NAME,
                "email" => SENDINBLUE_SENDER_EMAIL
            ),
            "to" => array([
                "name" => "Jorge Olarte",
                "email" => "info@emprendedorescartago.com"
            ]),
            "templateId" => 5,
            "subject" => "Confirmación de tu pedido",
            "params" => array(
                "NOMBRES" => "JORGE EDUARDO OLARTE",
                "DETALLES" => array(
                    [
                        "nombre_producto" => "SANDWICH QBANO",
                        "emprendimiento_emprendedor" => "Antojo Urbano",
                        "subtotal_detalle" => "10200"
                    ],
                    [
                        "nombre_producto" => "GASEOSA LITRO 1/2",
                        "emprendimiento_emprendedor" => "Formula Kart",
                        "subtotal_detalle" => "3500"
                    ]
                ),
                "TOTAL_COMPRA" => "13700",
                "BARRIO" => "El Prado",
                "DIRECCION" => "Calle 14 Nro 2-18",
                "OBSERVACIONES" => "Todo bien",
            )
        );

        $this->email($data);
    }

    public function email_bienvenida($data)
    {

        $email = array(
            "sender" => array(
                "name" => SENDINBLUE_SENDER_NAME,
                "email" => SENDINBLUE_SENDER_EMAIL
            ),
            "to" => array([
                "name" => $data['nombre'],
                "email" => $data['email']
            ]),
            "templateId" => 6,
            "subject" => "Bienvenido, empieza a vender a través de Internet",
            "contact" => array(
                "FIRSTNAME " => $data['nombre']
            )
        );

        $this->email($email);
    }

    /**
     * Enviar email con la plantilla de sendinblue
     */
    public function email($data)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.sendinblue.com/v3/smtp/email",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "api-key: " . SENDINBLUE_EMAIL_API_V3,
                "content-type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
    }

    /**
     * Registra un nuevo emprendedor en mailchimp
     */
    public function mailchimp($data)
    {
        // MailChimp API URL
        $memberID = md5(strtolower($data['email']));
        $dataCenter = substr(MAILCHIMP_API_KEY, strpos(MAILCHIMP_API_KEY, '-') + 1);
        $url_mailchimp = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . MAILCHIMP_LIST_ID . '/members/' . $memberID;

        // member information
        $json = json_encode([
            'email_address' => $data['email'],
            'status'        => 'subscribed',
            'merge_fields'  => [
                'FNAME'     => $data['nombre'],
                'PHONE'     => $data['prefijo_telefono'],
                'EMPRENDE'  => $data['emprendimiento'],
                'CIUDAD'    => $data['nombre_ciudad']
            ]
        ]);

        // send a HTTP POST request with curl
        $ch_mailchimp = curl_init($url_mailchimp);
        curl_setopt($ch_mailchimp, CURLOPT_USERPWD, 'user:' . MAILCHIMP_API_KEY);
        curl_setopt($ch_mailchimp, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch_mailchimp, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_mailchimp, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch_mailchimp, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch_mailchimp, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch_mailchimp, CURLOPT_POSTFIELDS, $json);
        $result = curl_exec($ch_mailchimp);
        $httpCode = curl_getinfo($ch_mailchimp, CURLINFO_HTTP_CODE);
        curl_close($ch_mailchimp);
    }

    /**
     * Crea el contacto en sendinblue
     */
    public function sendinblue($data)
    {
        $curl = curl_init();

        // member information
        $json = json_encode([
            'email'             => $data['email'],
            'attributes'        => [
                'FIRSTNAME'      => $data['nombre'],
                'SMS'            => $data['prefijo_telefono'],
                'EMPRENDIMIENTO' => $data['emprendimiento'],
                'CIUDAD'         => $data['nombre_ciudad'],
                'PAIS'           => $data['nombre_pais']
            ]
        ]);

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.sendinblue.com/v3/contacts",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $json,
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "api-key: " . SENDINBLUE_EMAIL_API_V3,
                "content-type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
    }

    /**
     * Crea un nuevo contacto en el celular de emprendedore
     */
    public function google($data)
    {
        // Llamar el google para agregar el usuario en Google Contacts
        $url_google = 'https://hooks.zapier.com/hooks/catch/5262460/ooykbxo/';
        //create a new cURL resource
        $ch_google = curl_init($url_google);

        // Defino la data a enviar a google
        $data_google = array(
            "telefono" => $data['prefijo_telefono'],
            "nombre" => $data['nombre'],
            "emprendimiento" => $data['emprendimiento'],
            "email" => $data['email'],
            "ciudad" => $data['nombre_ciudad'],
            "pais" => $data['nombre_pais'],
        );

        $payload_google = json_encode($data_google);

        //attach encoded JSON string to the POST fields
        curl_setopt($ch_google, CURLOPT_POSTFIELDS, $payload_google);
        //set the content type to application/json
        curl_setopt($ch_google, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        //return response instead of outputting
        curl_setopt($ch_google, CURLOPT_RETURNTRANSFER, true);
        //execute the POST request
        $result = curl_exec($ch_google);
        //close cURL resource
        curl_close($ch_google);
    }

    /**
     * Envia mensaje por whatsapp
     */
    public function whatsapp($telefono, $msg)
    {
        // ACCOUNT SID = AC790792a42a24a45ff480accb88176b3b
        // AUTH TOKEN = 05b5f56247459b45c374d638d94d3270
        $data = array(
            "To" => "whatsapp:" . $telefono,
            "Body" => $msg,
            "From" => "whatsapp:" . TWILIO_WHATSAPP_FROM
            //"mediaUrl" => ["https://demo.twilio.com/owl.png"]
        );

        $post = http_build_query($data);
        $x = curl_init('https://api.twilio.com/2010-04-01/Accounts/' . TWILIO_ACCOUNT_SID . '/Messages.json');

        curl_setopt($x, CURLOPT_POST, true);
        curl_setopt($x, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($x, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($x, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($x, CURLOPT_USERPWD, TWILIO_ACCOUNT_SID . ':' . TWILIO_AUTH_TOKEN);
        curl_setopt($x, CURLOPT_POSTFIELDS, $post);

        $result =  curl_exec($x);
    }

    /**
     * METODO ANTIGUO PARA ENVIAR CORREOS
     */
    // public function email($data)
    // {
    //     $config['protocol']    = 'smtp';
    //     $config['smtp_host']    = 'smtp-relay.sendinblue.com';
    //     $config['smtp_port']    = '587';
    //     $config['smtp_timeout'] = '7';
    //     $config['smtp_user']    = SENDINBLUE_EMAIL;
    //     $config['smtp_pass']    = SENDINBLUE_EMAIL_PASSWORD;
    //     $config['charset']    = 'utf-8';
    //     $config['newline']    = "\r\n";
    //     $config['mailtype'] = 'html'; // or html
    //     $config['validation'] = TRUE; // bool whether to validate email or not      

    //     $this->email->initialize($config);

    //     $this->email->from('info@tiendaemprendedores.com', 'Tienda Emprendedores');
    //     $this->email->to($data['email'], $data['nombre']);

    //     $this->email->subject($data['asunto']);
    //     $this->email->message($data['mensaje']);

    //     $result = $this->email->send();
    // }
}
