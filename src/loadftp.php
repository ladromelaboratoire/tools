<?php
/********************
 *
 *	@file : ftp.php
 *	@author : La Drome laboratoire
 *	@version: 1.0.0
 *	@Date: 18/03/2021
 *	@license GPL
 *
 *	Connexion à un serveur FTP et upload de fichiers
 *
 *
 ********************/ 
namespace ladromelaboratoire\tools;

class loadftp {
	
	private const __default_timeout = 90;
	private const __default_port = 21;
	private const __ftp_mode = FTP_BINARY;
	
	private $server = null;
	private $login = null;
	private $pwd = null;
	private $connect = null;
	private $error = false;
	private $error_msg = array();
	
	function __construct($server = "localhost", $login = "user", $pwd = "pwd") {
		$this->server = $server;
		$this->login = $login;
		$this->pwd = $pwd;
	}
	
	/*******
	* This function attemps connection & login to the FTP host.
	* in
	*     port, default 21
	*     timeout, default 90
	*     passive mode, default true
	* returns 
	*     true in case of success
	*     false otherwise
	*******/
	
	public function connectftp($port = null, $timeout = null, $passive = true) {
		if (is_null($port)) $port = self::__default_port;
		if (is_null($timeout)) $timeout = self::__default_timeout;
		
		$this->connect = ftp_connect($this->server, $port, $timeout);
		if ($this->connect === false) {
			$this->error = true;
			$this->error_msg[] = "FTP connection failed";
		}
		
		if(!$this->error) {
			$connected = ftp_login($this->connect, $this->login, $this->pwd);
			if (!$connected) {
				$this->error = true;
				$this->error_msg[] = "FTP login failed";				
			}
			$passive = ftp_pasv($this->connect, $passive);
		}
		return !$this->error;
	}
	
	/*******
	* This attemps to load files provided one by one
	* in
	*     files, arrays of local files with full path
	* returns 
	*    false in case or error 
	*    array of result for each file
	*******/
	public function load($files) {
		if (is_null($this->connect)) {
			//attemps default connection
			$this->connectftp();
		}
		if ($this->error) return !$this->error;
		
		$loadlist = array();
		$notloaded = array();
		$finished = false;
		if (is_array($files) && count($files) > 0) {
			foreach($files as $file) {
				if(is_file($file)) {
					$loadlist[] = array(
						'file' => $file,
						'status' => ftp_put($this->connect, basename($file), $file, self::__ftp_mode)
					);
				}
				else {
					$loadlist[] = array(
						'file' => $file,
						'status' => 'not a file'
					);
				}
			}
			return $loadlist;
		}
			
		else {
			$this->error = true;
			$this->error_msg[] = "Empty file array, nothing to load";
			return !$this->error;
		}
		
	}
	public function getErrors() {
		if ($this->error) return $this->error_msg;
		return $this->error;
	}
	
	public function disconnect() {
		ftp_close($this->connect);
	}
	
	function __destruct() {
	}
}
?>