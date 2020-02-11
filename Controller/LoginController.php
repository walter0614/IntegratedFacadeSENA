<?php
include_once("../DAO/LoginDAO.php");

$loginDAO = new LoginDAO();

class LoginController
{

    function Login($conn, $user, $pass)
    {
        global $loginDAO;
        $data = $loginDAO->GetUserByLogin($conn, $user, $pass);
        return $data;
    }
}
