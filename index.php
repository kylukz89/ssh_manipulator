<?php
 
require_once 'CommandManipulator.php';

$manipuladorComando = new CommandManipulator();

$hostIP = "192.168.0.1";
$hostUser = "admin";
$hostPass = "987654";

/**
 * $hostIP      = IP do Host destino desejado
 * $hostUser    = Usuário de login do host
 * $hostPass    = Senha de login do host
 */
$response = $manipuladorComando->set($hostIP, $hostUser, $hostPass);
// Faça algo com a resposta dos comandos...
print_r($response);

// ...
// ...
// ...
