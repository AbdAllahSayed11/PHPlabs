<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
// include_once('mysqlipro.php');
// include_once('mysqlioop.php');
include ('PDOFUN.php');

function getallstudent()
{
        $sql='select * from student ';
        $res=SelectOperation($sql);
        return $res;
}
// function getallemail()
// {   //pdo
//     $res=mySelect('trainee');
//     return $res;
// }

function insertstudent($stident_id,$f_name,$email,$l_name,$image)
{
  
    //mysqli proc
    $sql="insert into student (stident_id,f_name,email,l_name)
    values({$stident_id},{$f_name},{$email},{$l_name},?)";
     if(dmloperation($sql))
     {
        return '<div><h1>student added</h1></div>';
     }
     else
    {
        return '<div><h1>Error while student adding </h1></div>';
    }
   
}
