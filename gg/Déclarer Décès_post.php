<?php

$err_s = 0;
include 'inc/connextion.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if(isset($_POST['submit'])){
    if(isset($_POST['num'])){
        $num=$_POST['num'];

    }
    else{
header('Location:Front.php');
die();

    }
    if(isset($_POST['sexe'])){
        $Sexe = htmlentities(mysqli_real_escape_string($conn,$_POST['sexe']));
        if(!in_array($Sexe,['Male','Femelle'])){
            $Sexe_error = "S'il vous plait choisir un sexe pas un text !<br>";
            $err_s = 1;
    
        }
        
    }
  
   $Nom = stripcslashes($_POST['Nom']);
   $Prenom = stripcslashes($_POST['Prenom']);
   if(isset($_POST['birthday_day']) && isset($_POST['birthday_month']) && isset($_POST['birthday_year'])) {
        $birthday_day=(int)$_POST['birthday_day'];
        $birthday_month=(int)$_POST['birthday_month'];
        $birthday_year=(int)$_POST['birthday_year'];
        $Jour = htmlentities(mysqli_real_escape_string($conn,$birthday_day.'-'.$birthday_month.'-'.$birthday_year));
   }
   
   $Nom = htmlentities(mysqli_real_escape_string($conn,$_POST['Nom']));
   $Prenom = htmlentities(mysqli_real_escape_string($conn,$_POST['Prenom']));
  
if(isset($_POST['Heure'])){
$Heure=$_POST['Heure'];

}
else {
    $err_s = 1;

}

$insert=mysqli_query($conn,"INSERT INTO `déclarer décès`(`Numero d'acte`, `Nom`, `Prenom`, `Sexe`, `Jour de Déce`, `Heure De Déce`) VALUES ('$num','$Nom','$Prenom','$Sexe','$Jour','$Heure')");

    if($insert)
    {
        try
      {
        $mail = new PHPMailer(true);            
        $mail->isSMTP();                                            
        $mail->Host       = 'smtp.gmail.com';                    
        $mail->SMTPAuth   = true;                                  
        $mail->Username   = 'anissannabi2@gmail.com';                    
          $mail->Password   = 'utujimqawmiwodas';                           
          $mail->SMTPSecure = 'tls';           
          $mail->Port       = 587;                                   
          $mail->setFrom('anissannabi2@gmail.com');
          $mail->addAddress('anissannabi2@gmail.com');    
          $mail->isHTML(true);
          
          $mail->Subject = ' Verification Email Addresse';
          
          $mail->Body  = "NumeroAct: $num <br> Nom: $Nom <br> Prenom: $Prenom <br> Jour: $Jour <br> Heure: $Heure";
          $true=$mail->send();
          
          if($true)
          {
            header('location:Déclarer Décès.php');
            die();
          }
          
         
          

        }catch(Exception $e){
          
          
        }
        
    }

}



?>