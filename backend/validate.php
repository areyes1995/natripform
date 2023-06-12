<?php
include '../database.php';

header('Access-Control-Allow-Origin: *');
header('Content-Type: text/plain');

$data = [];

$validate = new Validate($database);
$validate->json_print();

class Validate
{
    public $database;
    public $data = [];

    public function __construct($database)
    {
        $this->database = $database;

        $this->init();
    }

    public function init()
    {
        foreach ($_GET as $key => $item) {
            if ($key == 'valid') {
                $this->valid();
            }
            if ($key == 'allAsk') {
                $this->allAsk();
            }
            if ($key == 'crearNap') {
                $this->crearNap();
            }
            if ($key == 'access') {
                $this->allAsk();
            }
            if ($key == 'save_ask') {
                $this->save_ask();
            }
        }
    }

    public function valid()
    {
        $natrip_id = $this->get_post('natrip_id');
        $cedula = $this->get_post('cedula_');

        $natrip_index = strpos($natrip_id, 'natrip');
        if ($natrip_index >= 0) {
            $natrip_id = substr($natrip_id, $natrip_index + 6, strlen($natrip_id));

            $this->data = $this->database->select('consultations', '*', [
                'natrip_id[=]' => $natrip_id,
                'cedula[=]' => $cedula,
            ]);
        }

        if (count($this->data) > 0) {
            $this->data = $this->data[0];
        }
    }

    public function allAsk()
    {
        $data = $this->database->select('preguntas', ['ask', 'type', 'pregunta_id']);
        $data['total'] = count($data);
    }

    public function crearNap()
    {
        $natrip_id = (array) $this->database->select(
            'consultations',
            ['natrip_id'],
            [
                'LIMIT' => 1,
                'ORDER' => [
                    'natrip_id' => 'DESC',
                ],
            ],
        )[0];

        $user = $this->get_post('user');
        $email = $this->get_post('email');
        $password = $this->get_post('password');
        $consultation_id = $this->get_post('consultation_id');

        if ($user == 'neotrips23@gmail.com' && $password == 'Nathaly862301' && strlen($password) > 5) {
            try {
                $this->database->update(
                    'consultations',
                    [
                        'natrip_id' => (int) $natrip_id['natrip_id'] + 1,
                        'approved_at' => date('Y-m-d'),
                    ],
                    [
                        'consultation_id[=]' => $consultation_id,
                        'natrip_id[=]' => null,
                    ],
                );

                $mensaje = 'Este es tu código de autorización Natrip' . ($natrip_id['natrip_id'] + 1) . " de https://agenciadeviajes.do/ ahora puedes ingresar al formulario https://consulate.agenciadeviajes.do/ y responder las preguntas. \r\n\r\nUna vez completes el formulario de Visado haremos la revisión y te dejaremos saber sí ház sido calificado para tu Visado.\r\n\r\n.";
                $mensaje = wordwrap($mensaje, 70, "\r\n");

                // Enviarlo
                mail($email, 'Código de autorización | agenciadeviajes.do', $mensaje, 'From: Info@agenciadeviajes.do' . "\r\n" . 'Reply-To: Info@agenciadeviajes.do');

                $data = 1;
            } catch (Exception $error) {
                $data = 0;
            }
        }
    }

    public function access()
    {
        $user = $this->get_post('user');
        $password = $this->get_post('password');

        if ($user == 'neotrips23@gmail.com' && $password == 'Nathaly862301') {
            $this->data = $this->database->select('consultations', '*', ['ORDER' => ['consultation_id' => 'DESC']]);
        } else {
            $this->data = ['error' => 'Está cuenta no está asociada a nosotros, favor contactar al 809-475-8831 para más información.'];
        }
    }
    
    public function save_ask()
    {
        $natrip_id = $this->get_post('natrip_id');
        $cedula = $this->get_post('cedula_');

        $natrip_index = strpos($natrip_id, 'natrip');
        if ($natrip_index >= 0) {
            $natrip_id = substr($natrip_id, $natrip_index + 6, strlen($natrip_id));

            $consultation = $this->database->select(
                'consultations',
                ['consultation_id', 'email'],
                [
                    'natrip_id[=]' => $natrip_id,
                    'cedula[=]' => $cedula,
                    'created_at[>=]' => date('Y-m-d', strtotime(date('Y-m-d') . '-1 year')),
                    'LIMIT' => 1,
                ],
            );
        }

        if (count($consultation) > 0) {
            $status = false;
            $status_visa = true;
            if (count($_POST) >= 40) {
                foreach ($_POST as $key => $value) {
                    if (strpos($key, 'ask-') > -1 && ($value !== null && strlen($value) > 0 && $value != 'default')) {
                        $ask_id = (int) str_replace('ask-', '', $key);
                        try {
                            $correct = $this->database->select(
                                'preguntas',
                                ['correct'],
                                [
                                    'pregunta_id' => $ask_id,
                                    'correct[!]' => null,
                                ],
                            );

                            if (count($correct) > 0) {
                                $value = $value == 1 ? true : false;
                                if ($value != (bool) $correct[0]['correct']) {
                                    $status_visa = false;
                                }
                            }

                            $this->database->insert('answers', [
                                'consultation_id' => $consultation[0]['consultation_id'],
                                'ask_id' => $ask_id,
                                'answer' => $value,
                                'created_at' => date('Y-m-d'),
                            ]);

                            $status = true;
                        } catch (Exception $error) {
                            $status = false;
                            break;
                        }
                    }
                }

                if ($status_visa === true) {
                    $visa_status = 'Aprobado';

                    $mensaje = "Gracias por completar el su solicitud de Visado.\r\n\r\nHemos verificado y queremos informarle que su solicitud de Visado fue aprobada satisfactoriamente.\r\n\r\nEl siguiente paso a seguir es contactar con nosotros, puede hacerlo yendo a una de nuestra oficinas o puede contactarnos al 809-475-8831.\r\n\r\nUn coordial saludo agenciadeviajes.do.";
                } else {
                    $visa_status = 'Denegada';

                    $mensaje = "Gracias por completar el su solicitud de Visado.\r\n\r\nHemos revisado su solicitud y lamentamos informarles que la misma no pudo ser aprobada por nuestro departamento de calidad y gestión.\r\n\r\nPor lo tanto no es posible aceptar su Visado en este momento y debera solicitar nuevamente dentro de cierto tiempo, el cual será determinado por la agencia de Visado.\r\n\r\nUn coordial saludo agenciadeviajes.do.\r\n\r\nPara más información puede contactarnos al 809-475-8831.";
                }

                try {
                    $this->database->update(
                        'consultations',
                        [
                            'status' => $visa_status,
                        ],
                        [
                            'consultation_id[=]' => $consultation[0]['consultation_id'],
                        ],
                    );
                } catch (Exception $error) {
                    mail('abiezer.reyes95@gmail.com', 'Error al guardar status | agenciadeviajes.do', 'ID:' . $consultation[0]['consultation_id'], 'From: Info@agenciadeviajes.do' . "\r\n" . 'Reply-To: Info@agenciadeviajes.do');
                }

                $cabeceras = 'From: Info@agenciadeviajes.do' . "\r\n" . 'Reply-To: Info@agenciadeviajes.do';
                mail($consultation[0]['email'], 'Aprobación de tu visa | agenciadeviajes.do', $mensaje, $cabeceras);

                if ($status === true) {
                    $this->data = true;
                }
            }
        } else {
            $this->data = ['error' => 'Hubo un error al guardar los datos suministrados. O hay alguna pregunta sin contestar. Favor contactar al 809-475-8831 para más información.'];
        }
    }
    
    public function store_new()
    {
        $name = $this->get_post('name');
        $email = $this->get_post('email');
        $phone = $this->get_post('phone');
        $cedula = $this->get_post('cedula');
        $cellphone = $this->get_post('cellphone');
        $last_name = $this->get_post('last_name');
        $visa_type = $this->get_post('visa_type');

        if ($name != '' && $last_name != '' && $email != '' && $phone != '' && $cedula != '') {
            $cedula_sql = (array) $this->database->select(
                'consultations',
                ['cedula'],
                [
                    'cedula[=]' => $cedula,
                    'created_at[>=]' => date('Y-m-d', strtotime(date('Y-m-d') . '-1 year')),
                ],
            );

            if (count($cedula_sql) > 0) {
                $this->data = ['error' => 'Está cuenta ya ha sido creada, favor contactar al 809-475-8831 para más información.'];
            } else {
                $this->database->insert('consultations', [
                    'visa_type' => strtolower($visa_type),
                    'name' => strtolower($name),
                    'last_name' => strtolower($last_name),
                    'email' => strtolower($email),
                    'phone' => $phone,
                    'cellphone' => $cellphone,
                    'cedula' => $cedula,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);

                if ($this->database->id() !== null && $this->database->id() > 0) {
                    $this->data = ['done' => 'Data saved correctly.'];
                }
            }
        } else {
            $this->data = ['error' => 'Some fields are required'];
        }
    }

    private function get_post(string $name)
    {
        return isset($_POST[$name]) ? htmlspecialchars($_POST[$name]) : '';
    }

    private function utf8ize($d)
    {
        if (is_array($d)) {
            foreach ($d as $k => $v) {
                $d[$k] = $this->utf8ize($v);
            }
        } elseif (is_string($d)) {
            return mb_convert_encoding($d, 'UTF-8');
        }
        return $d;
    }

    public function json_print() {
        print_r(
            json_encode(
                $this->utf8ize([
                    'data' => $this->data,
                ]),
            ),
        );
    }
}
?>
