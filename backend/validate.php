<?php 
include '../database.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: text/plain");

$data = [];

// $data = $database->select("consultations", '*', [
//     "natrip_id[=]" => 1000000,
//     "cedula[=]" => '03105686210',
// ]);

// if (count($data) > 0) {
//     $data[0]['questions'] = $database->select("preguntas", '*',);
//     $data = $data[0];
// }

// $natrip_id = (array)$database->select("consultations", ['natrip_id'], ['LIMIT' => 1, "ORDER" => [
//     "natrip_id" => "DESC",
// ]])[0];

// print_r($natrip_id['natrip_id']);
// return;
foreach ($_GET as $key => $item) {
    if ($key == 'valid') {
        $natrip_id =isset($_POST['natrip_id']) ? htmlspecialchars($_POST['natrip_id']) : '';
        $cedula= isset($_POST['cedula_']) ? htmlspecialchars($_POST['cedula_']) : '';
        
        $natrip_index = strpos($natrip_id, 'natrip');
        if ($natrip_index >= 0) {
            $natrip_id = substr($natrip_id, $natrip_index+6, strlen($natrip_id));

            $data = $database->select("consultations", '*', [
                "natrip_id[=]" => $natrip_id,
                "cedula[=]" => $cedula,
            ]);
        }

        if (count($data) > 0) {
            $data = $data[0];
        }
    }

    if ($key == 'allAsk') {
        $data = $database->select("preguntas", ['ask', 'type', 'pregunta_id'],);
        $data['total'] =count($data);
    }
    
    if ($key == 'crearNap') {
        $natrip_id = (array)$database->select("consultations", ['natrip_id'], ['LIMIT' => 1, "ORDER" => [
            "natrip_id" => "DESC",
        ]])[0];

        $user =isset($_POST['user']) ? htmlspecialchars($_POST['user']) : '';
        $password =isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '';
        $email =isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
        $consultation_id =isset($_POST['consultation_id']) ? htmlspecialchars($_POST['consultation_id']) : '';

        if ($user == 'neotrips23@gmail.com' && $password == 'Nathaly862301' && strlen($password) > 5) {
            try {
                $database->update("consultations", [
                    "natrip_id" => (int)$natrip_id['natrip_id']+1,
                    "approved_at" => date('Y-m-d'),
                ], [
                    'consultation_id[=]' => $consultation_id,
                    'natrip_id[=]' => null,
                ]);

                $mensaje = "Este es tu código de autorización Natrip".($natrip_id['natrip_id']+1)." de https://agenciadeviajes.do/ ahora puedes ingresar al formulario https://consulate.agenciadeviajes.do/ y responder las preguntas. \r\n\r\nUna vez completes el formulario de Visado haremos la revisión y te dejaremos saber sí ház sido calificado para tu Visado.\r\n\r\n.";

                // Si cualquier línea es más larga de 70 caracteres, se debería usar wordwrap()
                $mensaje = wordwrap($mensaje, 70, "\r\n");

                // Enviarlo
                $cabeceras = 'From: Info@agenciadeviajes.do' . "\r\n" .'Reply-To: Info@agenciadeviajes.do';
                mail($email, 'Código de autorización | agenciadeviajes.do', $mensaje, $cabeceras);

                $data = 1;
            }
            catch(Exception $error) {
                $data = 0;
            }
        }
    }
    
    if ($key == 'access') {
        $user =isset($_POST['user']) ? htmlspecialchars($_POST['user']) : '';
        $password =isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '';

        if ($user == 'neotrips23@gmail.com' && $password == 'Nathaly862301') {
            $data = $database->select("consultations", '*', ["ORDER" => [
                    "consultation_id" => "DESC",]]);
        } else {
            $data = ['error' => 'Está cuenta no está asociada a nosotros, favor contactar al 809-475-8831 para más información.'];
        }
    }

    if ($key == 'store_new') {
        $visa_type =isset($_POST['visa_type']) ? htmlspecialchars($_POST['visa_type']) : '';
        $name =isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
        $last_name =isset($_POST['last_name']) ? htmlspecialchars($_POST['last_name']) : '';
        $email =isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
        $phone =isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '';
        $cellphone =isset($_POST['cellphone']) ? htmlspecialchars($_POST['cellphone']) : ''; //opcional
        $cedula =isset($_POST['cedula']) ? htmlspecialchars($_POST['cedula']) : '';

        if ($name != '' && $last_name != '' && $email != '' && $phone != '' && $cedula != '') {
            $cedula_sql = (array)$database->select("consultations", ['cedula'], 
                    [
                        'cedula[=]'=>$cedula, 
                        'created_at[>=]' => date('Y-m-d', strtotime(date('Y-m-d'). '-1 year'))
                    ]);

            if (count($cedula_sql) > 0) {
                $data = ['error' => 'Está cuenta ya ha sido creada, favor contactar al 809-475-8831 para más información.'];
            } else {                
                $database->insert("consultations", [
                    'visa_type' => strtolower($visa_type),
                    'name' => strtolower($name),
                    'last_name' => strtolower($last_name), 
                    'email' => strtolower($email), 
                    'phone' => $phone, 
                    'cellphone' => $cellphone, 
                    'cedula' => $cedula,
                    // 'natrip_id' => (int)$natrip_id['natrip_id']+1, 
                    'created_at' => date('Y-m-d H:i:s'),
                ]);

                if ($database->id() !== null && $database->id() > 0) {
                    $data = ['done' => 'Data saved correctly.'];
                }
            }
        } else {
            $data = ['error' => 'Some fields are required'];
        }
    }

    if ($key == 'save_ask') {
        $natrip_id =isset($_POST['natrip_id']) ? htmlspecialchars($_POST['natrip_id']) : '';
        $cedula= isset($_POST['cedula_']) ? htmlspecialchars($_POST['cedula_']) : '';
        
        $natrip_index = strpos($natrip_id, 'natrip');
        if ($natrip_index >= 0) {
            $natrip_id = substr($natrip_id, $natrip_index+6, strlen($natrip_id));

            $consultation = $database->select("consultations", ['consultation_id', 'email'], [
                "natrip_id[=]" => $natrip_id,
                "cedula[=]" => $cedula,
                'created_at[>=]' => date('Y-m-d', strtotime(date('Y-m-d'). '-1 year')),
                'LIMIT' => 1,
            ]);
        }

        if (count($consultation) > 0) {
            $status = false;
            $status_visa = true;
            if (count($_POST) >= 40) {
                foreach ($_POST as $key => $value) {
                    if (strpos($key,  'ask-') > -1 && ($value !== null && strlen($value) > 0 && $value != 'default')) {
                        $ask_id = (int)str_replace('ask-', '', $key);
                        try {
                            $correct = $database->select("preguntas", ['correct'], 
                            [
                                'pregunta_id' => $ask_id,
                                'correct[!]'=>NULL,
                            ]);

                            if (count($correct) > 0) {
                                $value = ($value == 1) ? true : false;
                                if ($value != (bool)$correct[0]['correct']) {
                                    $status_visa = false;
                                }
                            }
                            
                            $database->insert("answers", [
                                'consultation_id' => $consultation[0]['consultation_id'],
                                'ask_id' => $ask_id,
                                'answer' => $value,
                                'created_at' => date('Y-m-d'),
                            ]);
                            
                            $status = true;
                        }
                        catch(Exception $error) {
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
                    $database->update("consultations", [
                        "status" => $visa_status,
                    ], [
                        'consultation_id[=]' => $consultation[0]['consultation_id'],
                    ]);
                }
                catch(Exception $error) {
                    mail('abiezer.reyes95@gmail.com', 'Error al guardar status | agenciadeviajes.do', 'ID:'.$consultation[0]['consultation_id'], $cabeceras);    
                }

                $cabeceras = 'From: Info@agenciadeviajes.do' . "\r\n" .'Reply-To: Info@agenciadeviajes.do';
                mail($consultation[0]['email'], 'Aprobación de tu visa | agenciadeviajes.do', $mensaje, $cabeceras);

                if ($status === true) {
                    $data = true;
                }
            }
        } else {
            $data = ['error' => 'Hubo un error al guardar los datos suministrados. O hay alguna pregunta sin contestar. Favor contactar al 809-475-8831 para más información.'];
        }
    }
}

function utf8ize($d) {
    if (is_array($d)) {
       foreach ($d as $k => $v) {
         $d[$k] = utf8ize($v);
       }
    } else if (is_string ($d)) {
       return mb_convert_encoding($d, 'UTF-8');
    }
     return $d;
  }

// print_r([
//     'data' => $data
// ]);
print_r(json_encode(utf8ize([
    'data' => $data
])));
?>