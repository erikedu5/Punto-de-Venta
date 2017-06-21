<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);
//set_include_path(get_include_path() . PATH_SEPARATOR . 'phpseclib0.3.7');
//include('Net/SFTP.php');
//include('Crypt/RSA.php');
//class asterisk {
//
//    private $host;
//    private $port;
//    private $user;
//    private $password;
//    private $path;
//    private $name;
//
//    public function __construct($host = "10.22.165.2", $port = "22", $user = "oper", $password = "oper", $path = "/home/oper") {
//        $this->host = $host;
//        $this->port = $port;
//        $this->user = $user;
//        $this->password = $password;
//        $this->path = $path;
//    }
//
//    public function execute($celular, $name) {
//        $ssh = new Net_SFTP($this->host, $this->port);
//        $key = new Crypt_RSA();
//        $key->loadKey(file_get_contents('/root/.ssh/id_rsa.pub'));
//        if (!$ssh->login($this->user, $key)) {
//            exit('Login Failed');
//        }
//        $data = "Channel: SIP/044" . $celular . "@" . $this->host . "
//MaxRetries: 5
//RetryTime: 60
//WaitTime: 45
//Context: outboundmsg1
//Extension: s
//Priority: 1";
//        $ssh->put($this->path . $name, $data);
//    }
//
//}

class asterisk2 {

    public function llamar($host, $celular, $path, $name) {
        $tmp = fopen($path . $name, "w");
        $data = "Channel: SIP/" . $celular . "@" . $host . "
MaxRetries: 5
RetryTime: 60
WaitTime: 45
Context: outboundmsg1
Extension: s
Priority: 1";
        fwrite($tmp, $data);
        fclose($tmp);
        $tmp = fopen($path . $name, "r");
        $conn_id = ftp_connect($host) or die("No se pudo conectar a 10.22.165.2");
        if (ftp_login($conn_id, "asterisk", "12qwaszx")) {
            if (ftp_fput($conn_id, $name, $tmp, FTP_ASCII)) {
                return "Archivo cargado de forma correcta al servidor(" . $host . ") con el nombre " . $name . " ";
            } else {
                return "Ocurrio un problema al cargar el archivo $name al servidor (" . $host . ")\n";
            }
            ftp_close($conn_id);
        } else {
            return "No se pudo autentificar en el servidor(" . $host . ")";
        }
        fclose($tmp);
    }

}
?>

