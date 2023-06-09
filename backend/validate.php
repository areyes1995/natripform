<?php 
include '../database.php';

// $data = [];

// $data = $database->select("consultations", '*', [
//     "natrip_id[=]" => 1000000,
//     "cedula[=]" => '03105686210',
// ]);

// if (count($data) > 0) {
//     $data[0]['questions'] = $database->select("preguntas", '*',);
//     $data = $data[0];
// }

// print_r(json_encode([
//     'data' => $data
// ]));
// return;
foreach ($_GET as $key => $item) {
    if ($key == 'valid') {
        $natrip_id =isset($_POST['natrip_id']) ? htmlspecialchars($_POST['natrip_id']) : '';
        $cedula= isset($_POST['cedula']) ? htmlspecialchars($_POST['cedula']) : '';
        
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
}

// print_r([
//     'data' => $data
// ]);
print_r(json_encode([
    'data' => $data
]));
?>