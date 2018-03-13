<!DOCTYPE html>
<html>
<head>
    <title>Users</title>
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <h1>Utenti</h1>
    <div class="insertbutton">
      <a href="user_form.php?action=add" class="btn-lg btn-dark">Insert</a>
    </div>
<?php
include "connection.php";

function getAllUsers($pdo){
    echo <<<EOT
		<div class="table100 ver2 m-b-110">
      <table data-vertable="ver2">
        <thead>
          <tr class="row100 head">
            <th class="column100 column1" data-column="column1">Nome/Cognome</th>
            <th class="column100 column2" data-column="column2">Data di nascita</th>
            <th class="column100 column3" data-column="column3">Sesso</th>
            <th class="column100 column4" data-column="column4"></th>
            <th class="column100 column5" data-column="column5"></th>
          </tr>
        </thead>
        <tbody>\n
EOT;
    $stmt=$pdo->query('SELECT * FROM users');
    while($row = $stmt->fetch()){
        echo "\t\t\t".'<tr class="row100">';
        echo '<td class="column100 column1" data-column="column1">'.$row['firstname'].' '.$row['lastname'].'</td>'."\n\t\t\t\t";
        echo '<td class="column100 column2" data-column="column2">'.$row['birthdate'].'</td>'."\n\t\t\t\t";
        echo '<td class="column100 column3" data-column="column3">'.$row['sex'].'</td>'."\n\t\t\t\t";
        echo '<td class="column100 column4" data-column="column4"><a width="500" href="user_form.php?action=update&id='.$row['ID'].'" class="btn btn-dark">Update</a></td>'."\n\t\t\t\t";
        echo '<td class="column100 column5" data-column="column5"><a href="index.php?action=delete&id='.$row['ID'].'" class="btn btn-dark">Remove</a></td>'."\n\t\t\t\t";
        echo '</tr>'."\n";
    }
    echo <<<EOT
        </tbody>
      </table>
    </div>
EOT;
}
function delete($pdo, $id)
{
    $sql = "DELETE FROM users WHERE ID = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    if ($stmt->rowCount() == 1)
        return true;
    return false;
}

if (isset($_POST['firstname']))
{
    $values = ['firstname' => $_POST['firstname'],
               'lastname' => $_POST['lastname'],
               'birthdate'=>$_POST['birthdate'],
               'sex' => $_POST['sex']];

    if ($_POST['id']!='')
    {
        $sql = <<<EOT
        UPDATE users SET firstname = :firstname,
        lastname = :lastname,
        birthdate=:birthdate,
        sex = :sex
        WHERE ID = :id
EOT;
        $values['id'] = $_POST['id'];
    }
    else {
        $sql = <<<EOT
        INSERT INTO users (firstname, lastname,  birthdate, sex)
        VALUES (:firstname,:lastname, :birthdate, :sex);
EOT;
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($values);
    if ($stmt->rowCount() == 1)
        echo "<p class=\"bg-success\">Success</p>";
    else
        echo "<p class=\"bg-danger\">Error</p>";
}
//getAllUsers($pdo);
if(!isset($_GET['action'])){
  getAllUsers($pdo);
}
else{
  if($_GET['action']=='delete'){
    delete($pdo, $_GET['id']);
    getAllUsers($pdo);
  }
}
?>

  <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
  <script src="vendor/bootstrap/js/popper.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
  <script src="vendor/select2/select2.min.js"></script>
  <script src="js/main.js"></script>
  </body>
</html>
