<?php

require_once 'SSH.php';

/**
 * <b>CLASS</b>
 * Classe responsável pelos métodos gerenciadores 
 * dos comandos que serão executados nos hosts.
 * 
 * @author    Igor Maximo <igormaximo_1989@hotmail.com>
 * @date      30/06/2020
 */
class CommandManipulator extends SSH {

    /**
     * <b>FUNCTION</b>
     * <br>Método que executa comandos no host desejado.
     * 
     * OBS: Implemente seus comandos nesse método ou crie novos
     * 
     * @author    Igor Maximo <igormaximo_1989@hotmail.com>
     * @date      30/06/2020
     */
    public function set($hostIP, $user, $pass) {
        try {
            // Abre conexão com host/equipamento
            $connection = $this->conectarViaSSH($hostIP, $user, $pass);
            // Abre o fluxo de comandos
            $stream = ssh2_shell($connection);
            // Escreve comandos durante o fluxo aberto
            $this->setExecutarComando("enable", $stream);
            $this->setExecutarComando("config", $stream);
            $this->setExecutarComando("mmi original-output", $stream);
            $this->setExecutarComando("display ont autofind all", $stream, 450000);
            $this->setExecutarComando("", $stream); // [ENTER]...
            // Após o comando ser dado, faz php aguardar 1 segundo ou mais a resposta do comando para coletar a o retorno
            sleep(1);
            // RESULTADO/RESPOSTA DOS COMANDOS NESSA VARIÁVEL result...
            print $this->result; // Trate os dados retornados a sua vontade
            // Encerra conexão com o host...
            fclose($stream);
            // Retorne a resposta da operação ou trate os dados aqui...
            return $this->result;
        } catch (Exception $ex) {
            // Faça algo...
        }
    }
}
