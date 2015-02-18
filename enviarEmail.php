<?php

/**
 * Enviar E-mail
 *
 * @author		Tiago Dias de Mello
 * @copyright	Copyright (c) 2015.
 * @since		Version 1.0
 */

/**
 * enviarEmail
 *
 * Função para envio de e-mail.
 *
 * @param string $mensagem
 * @param string $assunto
 * @param int $prioridade (1 = alta, 5 baixa)
 * @param string $de
 * @param string $responderA
 * @param string $para
 * @param array $cc
 * @param array $bcc
 * @param string $tipo
 * @return bol	
 */
if (!function_exists('enviarEmail')) {
    
    function enviarEmail($mensagem, $assunto, $prioridade, $de, $responderA, $para, $cc, $bcc, $tipo){
        
        //Validacao dos campos que não podem estar em branco
        
        //Validacao dos email usando a funcao nativa nativa filter_var()
        if(!filter_var($de, FILTER_VALIDATE_EMAIL) && !filter_var($para, FILTER_VALIDATE_EMAIL)){
            return FALSE;
        } else {
            
            //Criacao do Cabecalho
            $headers = "From: $de\r\n";
            if($tipo == "html"){

                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
            }
            
            //Verifica a prioridade
            if($prioridade > 0){

                $headers .= "X-Priority: $prioridade\r\n";
            }
            
            //Verifica e possui email de resposta
            if($responderA != ""){

                $headers .= "Reply-To: $responderA\r\n";
            }
            
            //Verifica se possui copia
            if(!empty($cc)){
                
                if(count($cc)){
                    
                    $headers .= "Cc: ";
                    foreach($cc as $value){
                        $headers .= $value . ",";
                    }
                    
                    $headers = substr($headers, 0, -1) . "\r\n";
                }
            }
            
            //Verifica se possui copia oculta
            if (!empty($bcc)){

                if(count($bcc)){
                    
                    $headers .= "Bcc: ";
                    foreach($bcc as $value){
                        $headers .= $value . ",";
                    }
                    $headers = substr($headers, 0, -1) . "\r\n";
                }
            }
            
            //Envia o e-mail
            return mail($para, $assunto, $mensagem, $headers);            
        }   
    }
        
}

//Usando a funcao enviarEmail()
enviarEmail('<html><body><h1>Teste</h1></body></html>','Teste','responder_a@mail.com','de@mail.com','','para@email.com',array('cc1@mail.com','cc2@mail.com'),array('bcc1@mail.com','bcc2@mail.com'),'html');

?>
