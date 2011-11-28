<?php

	class MysqliModel
	{
		private $mConnection = null;
	
		public function __construct($aDatabaseAddress, $aDatabaseUsername, $aDatabasePassword, $aDatabaseName)
		{
			$this->mConnection = new mysqli
			(
				$aDatabaseAddress, 
				$aDatabaseUsername, 
				$aDatabasePassword,
				$aDatabaseName
			);
			
			if (mysqli_connect_errno()) 
			{
				printf("Connect failed: %s\n", mysqli_connect_error());
				exit();
			}
		}
		
		public function PrepareStatement($aSqlStatement) 
		{
			return $this->mConnection->prepare($aSqlStatement);
		}
		
		public function SelectDatabase($aDbName)
		{
			return $this->mConnection->select_db($aDbName);
		}
	}