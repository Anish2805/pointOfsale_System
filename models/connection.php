<?php

// $host = "ec2-52-204-20-42.compute-1.amazonaws.com";
// $user = "lnnsdbhninifnn";
// $password = "234c127c2cce31ceff5498771b5e93e18d337e101eb55505d711f083c9260471";
// $dbname = "d41haiu3p8sie3";
// $port = "5432";

class Connection{

	public function connect(){

		$link = new PDO("mysql:host=localhost;dbname=posdb2", "root", "");
		//$link = new PDO("pgsql:host=".$host.";port=".$port.";dbname=".$dbname.";user=".$user.";password=".$password.";");

		$link -> exec("set names utf8");

		return $link;
	}

}