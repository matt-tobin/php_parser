<?php
namespace TobinParser;


class Parser
{
	private $paramArray = [];
	private $booleanArrayTrue = ["yes", "true", "on"];
	private $booleanArrayFalse = ["no", "false", "off"];
	
	public function __construct()
	{
		
	}	
	
	public function parse($logFile)
	{
		$this->paramArray = [];
		try{
			$fp = fopen($logFile, 'r');
			if (!$fp) {
				throw new \Exception("Could not open the file!");
			}
			while($line = fgets($fp)){		
				$this->parseLine($line);			
			}
			fclose($fp);
		}
		catch(\Exception $e){
			echo "Error (File: ".$e->getFile().", line ".
			$e->getLine()."): ".$e->getMessage();
		}
	}
	
	public function getParameter($param)
	{
		if(array_key_exists($param,$this->paramArray) == True){
			return $this->paramArray[$param];
		}
		else{
			return NULL;
		}
	}
	
	private function parseLine($line)
	{
		if(strncmp($line, "#", 1)==0){//skip comments
			return;
		}
		$match = preg_match('/([^=]*)=([^=]*)/', $line, $out);//match before and after equals sign
		if($match == 1){
			$param = trim($out[1]);
			$value = trim($out[2]);
			if(strlen($param) == 0 || strlen($value) == 0){//empty param or value, skip
				return;
			}
			$value = $this->convertTypeFromString($value);
			$this->paramArray[$param] = $value;
		}		
	}
	
	private function convertTypeFromString($input)
	{
		if(is_numeric($input)){//float or int
			$match = preg_match('/^[-+]?\d+$/', $input);//integer
			if($match == 1){	
				return (int)$input;
			}			
			else{			
				return (double)$input;				
			}
		}
		else if(in_array(strtolower($input), $this->booleanArrayTrue)){
			return True;
		}
		else if(in_array(strtolower($input), $this->booleanArrayFalse)){
			return False;
		}
		else{
			return $input;
		}

	}
}

