<?php
try {
    $db = new PDO('mysql:host=localhost;dbname=score_crud;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
}
catch (Exception $e) {
    echo'Erreur: '.$e->getMessage().'<br>';
    echo'N° : '.$e->getCode();
    die('Fin du script');
}

$error = true;

// By default is in read
$action = 'read';

// If action isset
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

// List of players
if ($action === 'read') {
    $requete = $db->query("SELECT * FROM score ORDER BY score DESC");
    $result = $requete->fetchAll(PDO::FETCH_OBJ);
}

// NEW PLAYER
if ($action === 'create') {
    $array_player = [
        ':name' => filter_input(INPUT_POST, 'nameAdd', FILTER_SANITIZE_STRING),
        ':score' => filter_input(INPUT_POST, 'scoreAdd', FILTER_VALIDATE_INT)
    ];

    if (isset($_POST['nameAdd']) && !empty($array_player[':name'])) {
        $requestAdd = 'INSERT INTO score(name, score) VALUE (:name, :score)';
        $resultAdd = $db->prepare($requestAdd);
        $resultAdd->execute($array_player);

        $result = $db->query("SELECT * FROM score ORDER BY score DESC")->fetchAll(PDO::FETCH_OBJ);
    }
    else {
        $error = false;
    }

}

// EDIT PLAYER
if ($action === 'edit') {
    $array_player = [
        ':name' => filter_input(INPUT_POST, 'nameEdit', FILTER_SANITIZE_STRING),
        ':score' => filter_input(INPUT_POST, 'scoreEdit', FILTER_VALIDATE_INT),
        ':id' => filter_input(INPUT_POST, 'idPlayer', FILTER_VALIDATE_INT)
    ];
    if (isset($_POST['idPlayer']) && !empty($array_player[':name'])) {

        $request = 'UPDATE score SET name = :name, score = :score WHERE id = :id';
        $result = $db->prepare($request);
        $result->execute($array_player);

        $result = $db->query("SELECT * FROM score ORDER BY score DESC")->fetchAll(PDO::FETCH_OBJ);
    }
    else {
        $error = false;
    }
}

// DELETE PLAYER
if ($action === 'delete') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    if (isset($_POST['id'])) {

        $request = 'DELETE FROM score WHERE id = :id';
        $result = $db->prepare($request);
        $result->bindParam(':id', $id);
        $result->execute();

        $result = $db->query("SELECT * FROM score ORDER BY score DESC")->fetchAll(PDO::FETCH_OBJ);
    }
    else {
        $error = false;
    }
}

// Add error to result
$result['error'] = $error;

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
echo json_encode($result);
