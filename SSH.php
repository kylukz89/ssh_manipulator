<?php

/**
 * Classe responsável por manipular 
 * as conexões e demais procedimentos
 * via SSH
 * 
 * @author      Igor Maximo
 * @date        03/07/2020
 */
abstract class SSH {
    
    var $result; // Armazena o retorno de um comando executado
    
    /**
     * <b>FUNCTION</b>
     * <br>Efetua conexão via SSH com qualquer equipamento
     * que aceite esse tipo de conectividade.
     * 
     * @return    array Retorna da solicitação
     * @author    Igor Maximo <igormaximo_1989@hotmail.com>
     * @date      29/06/2020
     */
    public function conectarViaSSH($oltIP, $user, $pass, $port = 22) {
        $connection = ssh2_connect($oltIP, $port);
        if (ssh2_auth_password($connection, $user, $pass)) {
            return $connection;
        } else {
            die('Authentication Failed...');
        }
    }

    /**
     * <b>FUNCTION</b>
     * <br>Set executar comando e aguardar a resposta
     * 
     * @return    array Retorna da solicitação
     * @author    Igor Maximo <igormaximo_1989@hotmail.com>
     * @date      30/06/2020
     */
    public function setExecutarComando($comando, $stream, $microSegundo = null) {
        try {
            fwrite($stream, $comando . PHP_EOL);
            // O comando pode demorar para responder dependendo do host
            // então o sleep serve para fazer o php aguardar o suficiente para não atropelar
            // o fluxo de dados...
            if (!empty($microSegundo)) {
                $this->setSleep($microSegundo);
            } else {
                $this->setSleep();
            }
            while ($buf = stream_get_contents($stream)) {
                $this->result .= $buf;
            }
        } catch (Exception $ex) {
            echo $ex;
        }
    }

    /**
     * <b>FUNCTION</b>
     * <br>Set esperar resposta sleep personalizado
     * 
     * @return    array Retorna da solicitação
     * @author    Igor Maximo <igormaximo_1989@hotmail.com>
     * @date      30/06/2020
     */
    public function setSleep($microSegundo = null) {
        if (!empty($microSegundo)) {
            usleep($microSegundo);
        } else {
            usleep(250000); // Padrão em microsegundos 
        }
    }

}
