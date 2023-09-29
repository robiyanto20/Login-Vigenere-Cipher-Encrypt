<?php  
$connect = mysqli_connect("localhost", "root", "", "db_users");  
session_start();  
if(isset($_SESSION["username"]))  
{  
     header("location:entry.php");  
}  
if(isset($_POST["register"]))  
{  
     if(empty($_POST["username"]) && empty($_POST["password"]))  
     {  
          echo '<script>alert("Kedua Kolom Harus Diisi")</script>';  
     }  
     else  
     {  
          $username = mysqli_real_escape_string($connect, $_POST["username"]);  
          $password = mysqli_real_escape_string($connect, $_POST["password"]);  

          // Merubah kunci Vigenere Cipher menjadi huruf kecil
          $vigenereKey = strtolower("selasa");
          
          // Inisialisasi variabel
          $text = $password;
          $ki = 0;
          $kl = strlen($vigenereKey);
          $length = strlen($text);
          
          // Iterasi karakter
          for ($i = 0; $i < $length; $i++)
          {
               // Jika karakter adalah huruf, lakukan enkripsi
               if (ctype_alpha($text[$i]))
               {
                    // Huruf besar
                    if (ctype_upper($text[$i]))
                    {
                         $text[$i] = chr(((ord($vigenereKey[$ki]) - ord("a") + ord($text[$i]) - ord("A")) % 26) + ord("A"));
                    }
                    // Huruf kecil
                    else
                    {
                         $text[$i] = chr(((ord($vigenereKey[$ki]) - ord("a") + ord($text[$i]) - ord("a")) % 26) + ord("a"));
                    }
                    
                    // Update indeks kunci
                    $ki++;
                    if ($ki >= $kl)
                    {
                         $ki = 0;
                    }
               }
          }

          $query = "INSERT INTO t_user (username, password) VALUES('$username', '$text')";  
          if(mysqli_query($connect, $query))  
          {  
               echo '<script>alert("Registrasi Berhasil")</script>';  
          }  
     }  
}  
if(isset($_POST["login"]))  
{  
     if(empty($_POST["username"]) && empty($_POST["password"]))  
     {  
          echo '<script>alert("Kedua Kolom Harus Diisi")</script>';  
     }  
     else  
     {  
          $username = mysqli_real_escape_string($connect, $_POST["username"]);  
          $password = mysqli_real_escape_string($connect, $_POST["password"]);  

          // Merubah kunci Vigenere Cipher menjadi huruf kecil
          $vigenereKey = strtolower("selasa");
          
          // Inisialisasi variabel
          $text = $password;
          $ki = 0;
          $kl = strlen($vigenereKey);
          $length = strlen($text);
          
          // Iterasi karakter
          for ($i = 0; $i < $length; $i++)
          {
               // Jika karakter adalah huruf, lakukan enkripsi
               if (ctype_alpha($text[$i]))
               {
                    // Huruf besar
                    if (ctype_upper($text[$i]))
                    {
                         $text[$i] = chr(((ord($vigenereKey[$ki]) - ord("a") + ord($text[$i]) - ord("A")) % 26) + ord("A"));
                    }
                    // Huruf kecil
                    else
                    {
                         $text[$i] = chr(((ord($vigenereKey[$ki]) - ord("a") + ord($text[$i]) - ord("a")) % 26) + ord("a"));
                    }
                    
                    // Update indeks kunci
                    $ki++;
                    if ($ki >= $kl)
                    {
                         $ki = 0;
                    }
               }
          }

          $query = "SELECT * FROM t_user WHERE username = '$username' AND password = '$text'";  
          $result = mysqli_query($connect, $query);  
          if(mysqli_num_rows($result) > 0)  
          {  
               $_SESSION['username'] = $username;  
               header("location:entry.php");  
          }  
          else  
          {  
               echo '<script>alert("Detail Pengguna Salah")</script>';  
          }  
     }  
}  
?>  
<!DOCTYPE html>  
<html>  
     <head>  
          <title>Login untuk masuk</title>  
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
          <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
     </head>  
     <body>  
          <br /><br />  
          <div class="container" style="width:500px;">  
               <h3 align="center">Halaman Login</h3>  
               <br />  
               <?php  
               if(isset($_GET["action"]) == "login")  
               {  
               ?>  
               <div class="panel panel-default">
                    <div class="panel-heading"><h3 align="center">Login</h3></div>
                    <div class="panel-body">
                         <form method="post">  
                              <div class="form-group">
                                   <label>Username</label>  
                                   <input type="text" name="username" class="form-control" />
                              </div>
                              <div class="form-group">
                                   <label>Password</label>  
                                   <input type="password" name="password" class="form-control" />
                              </div>
                              <input type="submit" name="login" value="Login" class="btn btn-primary" />
                         </form>
                         <br />
                         <p align="center"><a href="index.php">Daftar Akun Baru</a></p>  
                    </div>
               </div>
               <?php       
               }  
               else  
               {  
               ?>  
               <div class="panel panel-default">
                    <div class="panel-heading"><h3 align="center">Daftar Akun Baru</h3></div>
                    <div class="panel-body">
                         <form method="post">  
                              <div class="form-group">
                                   <label>Username</label>  
                                   <input type="text" name="username" class="form-control" />
                              </div>
                              <div class="form-group">
                                   <label>Password</label>  
                                   <input type="password" name="password" class="form-control" />
                              </div>
                              <input type="submit" name="register" value="Daftar" class="btn btn-success" />
                         </form>
                         <br />
                         <p align="center"><a href="index.php?action=login">Login</a></p>
                    </div>
               </div>
               <?php  
               }  
               ?>  
          </div>  
       </body>  
</html>  
