<?php
if (isset($_POST['submit'])) {
session_start();
include 'dbconnection.php';
    $username = $_POST['username'];
    $password = $_POST["password"];
  
    $sql="SELECT * FROM user_master WHERE username = '$username' AND password='$password' AND status = 'Active'";
       // echo $sql;
    $rows1 = $conn->query($sql);
        $row=mysqli_fetch_array($rows1);
    
    if ($row>0)
    {
        $_SESSION['user_code']    = $row["code"];
        $_SESSION['username']     = $row["username"];
         $_SESSION['role']     = $row["role"];
        header("Location: index.php");
    }
    else{
      $displaystr="Incorrect Username/Password!";
    }
  }
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login - Inventory System</title>
  <style>
    body { font-family: Arial; background: #f0f2f5; display: flex; justify-content: center; align-items: center; height: 100vh; }
    .login-box { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.2); width: 320px; }
    h2 { text-align: center; margin-bottom: 20px; }
    input[type="text"], input[type="password"] {
      width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px;
    }
    button {
      width: 100%; padding: 10px; background: #3498db; color: white; border: none; border-radius: 5px;
    }
    button:hover { background: #2980b9; }
    .error { color: red; text-align: center; margin-top: 10px; }
  </style>
</head>
<body>
  <div class="login-box">
    <h2>Inventory Login</h2>
    <form method="POST" action="">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit" name="submit">Login</button>
        <div class="error"><?=$displaystr?></div>
    </form>
  </div>
</body>
</html>
