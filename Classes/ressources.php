<?php

class Ressources
{
	private $_pieces;
	
	public function  __construct()
	{
		//Recupere la date de debut du minage, pieces, date_pa, pa
		$sql = "SELECT date_pieces, pieces FROM membres, ressources WHERE membres.id = ressources.id AND login='".$_SESSION['login']."'";
		$req = mysql_query($sql);
		$rep = mysql_fetch_array($req);
		
		$this->_pieces = $rep['pieces'];
		
		//Donne le temps écoulé depuis le debut du minage
		$sql = "SELECT TIMESTAMPDIFF(MINUTE,'".date('Y-m-d H:i:s')."','".$rep['date_pieces']."')";
		$req = mysql_query($sql);
		$rep = mysql_fetch_array($req);
		
		if(-$rep[0] >= 1)
		{
		
			$this->_pieces += floor(-$rep[0]);
			
			$sql = "UPDATE ressources, membres SET pieces='".$this->_pieces."', date_pieces='".date('Y-m-d H:i:s')."' WHERE membres.id = ressources.id AND login='".$_SESSION['login']."'";
			mysql_query($sql);
		}
	}
	
	public function afficherPiece()
	{		
		echo $this->_pieces;
	}
	
}

?>