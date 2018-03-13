<!DOCTYPE HTML>
<html>
  <head>
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
  </head>
  <body class="form-background">
    <div class="form-container">
  <?php
  include "connection.php";
  function form($pdo, $id){
    $firstname='';
    $lastname='';
    $birthdate='';
    $sex='';
    if(isset($id)){
      $sql = "SELECT * FROM users WHERE ID = :id";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(['id' => $id]);
      $row = $stmt->fetch();
      $firstname = $row['firstname'];
      $lastname = $row['lastname'];
      $birthdate=$row['birthdate'];
      $sex = $row['sex'];
    }
    else {
      $id='';
    }
    $form=<<<EOT
    <form method="post" action="index.php">
      <div class="form-group">
        <label for="firstname">Nome</label><br>
        <input type="text" name="firstname" class="form-text input-text" value="$firstname">
      </div>
      <div class="form-group">
        <label for="lastname">Cognome</label><br>
        <input type="text" name="lastname" class="form-text input-text" value="$lastname">
      </div>
      <div class="form-group">
        <label for="birthdate">Data di nascita</label><br>
        <input type="date" name="birthdate" class="form-text input-text" value="$birthdate">
      </div>
      <label for="Sesso">Sesso</label><br>
      <div class="form-check check-align">
EOT;
      if($sex==''){
        $form=$form.'        <input class="form-check-input check-style" type="radio" name="sex" value="Male" checked> Male<br>
        <input class="form-check-input check-style" type="radio" name="sex" value="Female"> Female<br>';
      }
      else{
        if($sex=="Male"){
          $form=$form.'        <input class="form-check-input check-style" type="radio" name="sex" value="Male" checked> Male<br>
          <input class="form-check-input check-style" type="radio" name="sex" value="Female"> Female<br>';
        }else if($sex=='Female'){
          $form=$form.'        <input class="form-check-input check-style" type="radio" name="sex" value="Male"> Male<br>
          <input class="form-check-input check-style" type="radio" name="sex" value="Female" checked> Female<br>';
        }
      }
    $form=$form.<<<EOT
      </div>
      <input type="hidden" name="id" value="$id">
      <div class="button-center">
        <button type="submit" class="btn btn-dark">Submit</button>
      </div>
    </form>\n
EOT;
    echo $form;
}
  $action=$_GET['action'];
  if(isset($action)){
    if($action=='update'){
      form($pdo, $_GET['id']);
    }
    else {
      form($pdo, null);
    }
  }
?>
    </div>
  </body>
</html>
