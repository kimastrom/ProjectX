<?php

class UserHandler
{
	//modelen praatr med db
    private $m_database = NULL;
    
	public function __construct(DatabaseConnection $database) 
    {
		$this->m_database = $database;
	}

    public function GetAllUsers()
    {
        $userArray = array();
        $result = array();
        if($stmt = $this->m_database->PrepareStatement("SELECT userId, userName FROM user"))
        {
            $stmt->execute();
			$stmt->bind_result($result[0],$result[1]);
			while($stmt->fetch())
			{
			    $resultObject = new TestComment($result[0],$result[1]);
                $userArray[] = $resultObject;
			}
            $stmt->close();
        }
        return $userArray;
    }
}