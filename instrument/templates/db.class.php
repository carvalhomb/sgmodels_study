<?php

class config
{
	public $hostname;
	public $username;
	public $password;
	public $database;
	public $prefix;
	public $connector;

	function __construct($config_array)
	{
		if (!empty($config_array)) {
			$this->hostname = (array_key_exists('host',$config_array) && !empty($config_array['host']) ) ? $config_array['host'] : "";
			$this->username = (array_key_exists('username',$config_array) &&  !empty($config_array['username']) ) ? $config_array['username'] : "";
			$this->password = (array_key_exists('password',$config_array) && !empty($config_array['password']) ) ? $config_array['password'] : "";
			$this->database = (array_key_exists('database',$config_array) && !empty($config_array['database']) ) ? $config_array['database'] : "";
			$this->prefix = (array_key_exists('prefix',$config_array) && !empty($config_array['prefix']) ) ? $config_array['prefix'] : "";
			$this->connector = (array_key_exists('connector',$config_array) && !empty($config_array['connector']) ) ? $config_array['connector'] : "mysqli";
		}
	}
	
	function __destruct()
	{
		
	}
}

class db
{
	private $connection;
	private $selectdb;
	private $lastQuery;
	private $config;

	function __construct($config)
	{
		$this->config = $config;
	}
	
	function __destruct()
	{
		
	}

	public function openConnection()
	{
		try
		{
			if($this->config->connector == "mysql")
			{
				$this->connection = mysql_connect($this->config->hostname, $this->config->username, $this->config->password);
				$this->selectdb = mysql_select_db($this->config->database);
			}
			elseif($this->config->connector == "mysqli")
			{
				$this->connection = mysqli_connect($this->config->hostname, $this->config->username, $this->config->password);
				$this->selectdb = mysqli_select_db($this->connection, $this->config->database);
			}
		}
		catch(exception $e)
		{
			return $e;
		}
	}

	public function closeConnection()
	{
		try
		{
			if($this->config->connector == "mysql")
			{
				mysql_close($this->connection);
			}
			elseif($this->config->connector == "mysqli")
			{
				mysqli_close($this->connection);
			}
		}
		catch(exception $e)
		{
			return $e;
		}
	}
	
	public function ecapeString($string, $param=false)
	{
		return sprintf(addslashes($string), '"'.$param.'"');
	}
	

	public function query($query, $param=false)
	{
		$query = str_replace("}", "", $query);
		$query = str_replace("{", $this->config->prefix, $query);
		
	
		try
		{
			if(empty($this->connection))
			{
				
				$this->openConnection();
				
				if($this->config->connector == "mysql")
				{
					$this->lastQuery = mysql_query($this->ecapeString($query, $param));
				}
				elseif($this->config->connector == "mysqli")
				{
					$this->lastQuery = mysqli_query($this->connection, $this->ecapeString($query, $param));
				}
			
				$this->closeConnection();
				
				return $this->lastQuery;
			}
			else
			{					
				if($this->config->connector == "mysql")
				{
					$this->lastQuery = mysql_query($this->ecapeString($query, $param));
				}
				elseif($this->config->connector == "mysqli")
				{
					$this->lastQuery = mysqli_query($this->connection, $this->ecapeString($query, $param));
				}
				
				return $this->lastQuery;
			}
		}
		catch(exception $e)
		{
			return $e;
		}
	}

	public function lastQuery()
	{
		return $this->lastQuery;
	}

	public function pingServer()
	{
		try
		{
			if($this->config->connector == "mysql")
			{
				if(!mysql_ping($this->connection))
				{
					return false;
				}
				else
				{
					return true;
				}
			}
			elseif($this->config->connector == "mysqli")
			{
				if(!mysqli_ping($this->connection))
				{
					return false;
				}
				else
				{
					return true;
				}
			}
		}
		catch(exception $e)
		{
			return $e;
		}
	}
	
	public function hasRows($result)
	{
		try
		{
			if($this->config->connector == "mysql")
			{
				if(mysql_num_rows($result)>0)
				{
					return true;
				}
				else
				{
					return false;
				}
			}
			elseif($this->config->connector == "mysqli")
			{
				if(mysqli_num_rows($result)>0)
				{
					return true;
				}
				else
				{
					return false;
				}
			}
		}
		catch(exception $e)
		{
			return $e;
		}
	}
	
	public function countRows($result)
	{
		try
		{
			if($this->config->connector == "mysql")
			{
				return mysql_num_rows($result);
			}
			elseif($this->config->connector == "mysqli")
			{
				return mysqli_num_rows($result);
			}
		}
		catch(exception $e)
		{
			return $e;
		}
	}
	
	public function affectedRows()
	{
		try
		{
			if($this->config->connector == "mysql")
			{
				return mysql_affected_rows($this->connection);
			}
			elseif($this->config->connector == "mysqli")
			{
				return mysqli_affected_rows($this->connection);
			}
		}
		catch(exception $e)
		{
			return $e;
		}
	}
	
	public function fetchAssoc($result)
	{
		try
		{
			if($this->config->connector == "mysql")
			{
				return mysql_fetch_assoc($result);
			}
			elseif($this->config->connector == "mysqli")
			{
				return mysqli_fetch_assoc($result);
			}
		}
		catch(exception $e)
		{
			return $e;
		}
	}
	
	public function fetchArray($result)
	{
		try
		{
			if($this->config->connector == "mysql")
			{
				return mysql_fetch_array($result);
			}
			elseif($this->config->connector == "mysqli")
			{
				return mysqli_fetch_array($result);
			}
		}
		catch(exception $e)
		{
			return $e;
		}
	}
}

?>