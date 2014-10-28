<?php

require 'PHPMailer/PHPMailerAutoload.php';
include 'class.constantes.php';

class Correo {
	
	private $string_de;
	private $string_deNombre;
	private $string_para;
	private $string_paraNombre;
	private $string_responder;
	private $string_responderNombre;
	private $string_copia;
	private $string_copiaOculta;
	private $string_asunto;
	private $string_cuerpo;

	public function __get($property){
        if (property_exists($this, $property)){
            return $this->$property;
        }
    }
 
    public function __set($property, $value){
        if (property_exists($this, $property)){
            $this->$property = $value;
        }
    }

	public function EnviarCorreo(){
		
		$mail = new PHPMailer;

		# habilitar el modo debug
		//$mail->SMTPDebug = 3;
		$mail->isSMTP();                                      
		$mail->Host = constant('hostCorreo');
		$mail->SMTPAuth = true;
		$mail->Username = constant('userCorreo');
		$mail->Password = constant('passCorreo');
		$mail->SMTPSecure = 'tls';
		$mail->Port = constant('puertoSCorreo');

		$mail->From     = $this->string_de;
		$mail->FromName = $this->string_deNombre;
		$mail->addAddress($this->string_para, $this->string_paraNombre);
		$mail->addReplyTo($this->string_responder, $this->string_responderNombre);
		
		if ($this->string_copia != "") {
			$mail->addCC($this->string_copia);
		}

		if ($this->string_copiaOculta != "") {
			$mail->addBCC($this->string_copiaOculta);
		}
		
		# archivos adjuntos
		//$mail->addAttachment('/var/tmp/file.tar.gz');
		//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');

		$mail->isHTML(true);

		$mail->Subject = $this->string_asunto;
		$mail->Body    = $this->string_cuerpo;

		if(!$mail->send()) {
		    # Habilitar el log de errores
		    //echo 'Mailer Error: ' . $mail->ErrorInfo;
		    return false;
		}else{
		    return true;
		}
	}

}



