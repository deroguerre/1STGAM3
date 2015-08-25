<?php
class Armee
{
	//Attributs joueur 1
	private $_qteSoldat;
	private $_qteArcher;
	private $_qteCavalier;
	private $_pieces;
	private $_force;
	private $_defense;
	private $_victoire;
	private $_defaite;
	private $_pa;
	
	//Attributs joueur 2
	private $_qteSoldatJ2;
	private $_qteArcherJ2;
	private $_qteCavalierJ2;
	private $_piecesJ2;
	private $_forceJ2;
	private $_defenseJ2;
	private $_victoireJ2;
	private $_defaiteJ2;
	
	public function __construct()
	{
		$sql = "SELECT qte_soldat, qte_archer, qte_cavalier, pieces, nb_victoire, nb_defaite, date_pa, pa FROM membres, ressources, armees WHERE membres.id = ressources.id AND membres.id = armees.id AND login='".$_SESSION['login']."'";
		$req = mysql_query($sql);
		$rep = mysql_fetch_array($req);
		
		$this->_qteSoldat = $rep['qte_soldat'];
		$this->_qteArcher = $rep['qte_archer'];
		$this->_qteCavalier = $rep['qte_cavalier'];
		$this->_pieces = $rep['pieces'];
		$this->_force = ($this->_qteSoldat) + ($this->_qteArcher*2) + ($this->_qteCavalier*4);
		$this->_defense = ($this->_qteSoldat*4) + ($this->_qteArcher*3) + ($this->_qteCavalier);
		$this->_victoire = $rep['nb_victoire'];
		$this->_defaite = $rep['nb_defaite'];
		
		$this->_pa = $rep['pa'];
		
		//Temps écoulé pour les pa
		$sql = "SELECT TIMESTAMPDIFF(HOUR,'".date('Y-m-d H:i:s')."','".$rep['date_pa']."')";
		$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
		$diffDate = mysql_fetch_array($req);
		
		$date_pa = floor(-$diffDate[0]);
		
		if($date_pa >= 1)
		{
			$this->_pa = 5;
			$sql = "UPDATE ressources, membres SET date_pa='".date('Y-m-d H:i:s')."', pa='".$this->_pa."' WHERE ressources.id = membres.id AND login='".$_SESSION['login']."'";
			mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
		}
		
	}
	
	public function acheterSoldat($qteSoldat, $qteArcher, $qteCavalier)
	{
		
		$somme = ($qteSoldat*5) + ($qteArcher*8) + ($qteCavalier*15);
		
		if($this->_pieces < $somme)
		{
			echo "Pas assez d'argent !";
		}
		else
		{
			$this->_pieces -= $somme;
			$this->_qteSoldat += $qteSoldat;
			$this->_qteArcher += $qteArcher;
			$this->_qteCavalier += $qteCavalier;
			
			$sql = "UPDATE armees a, ressources r, membres m SET pieces='".$this->_pieces."', qte_soldat='".$this->_qteSoldat."', qte_archer='".$this->_qteArcher."', qte_cavalier='".$this->_qteCavalier."' WHERE a.id = m.id AND r.id = m.id AND  login='".$_SESSION['login']."'";
			$req = mysql_query($sql);
			
		}
		
		
	}
	
	public function attaque($whoFight)
	{
		//Recupere info J2
		$sql="SELECT qte_soldat, qte_archer, qte_cavalier, pieces, date_pieces, nb_victoire FROM ressources r, armees a, membres m WHERE r.id = m.id AND a.id = m.id AND login='".$whoFight."'";
		$req = mysql_query($sql);
		$rep = mysql_fetch_array($req);
		
		$this->_qteSoldatJ2 = $rep['qte_soldat'];
		$this->_qteArcherJ2 = $rep['qte_archer'];
		$this->_qteCavalierJ2 = $rep['qte_cavalier'];
		$this->_piecesJ2 = $rep['pieces'];
		$this->_forceJ2 = ($this->_qteSoldatJ2) + ($this->_qteArcherJ2*2) + ($this->_qteCavalierJ2*4);
		$this->_defenseJ2 = ($this->_qteSoldatJ2*4) + ($this->_qteArcherJ2*3) + ($this->_qteCavalierJ2);
		$this->_victoireJ2 = $rep[nb_victoire];
		
		$sql = "SELECT TIMESTAMPDIFF(MINUTE,'".date('Y-m-d H:i:s')."','".$rep['date_pieces']."')";
		$req = mysql_query($sql);
		$rep = mysql_fetch_array($req);
		
		if(-$rep[0] >= 1)
		{
		
			$this->_piecesJ2 += floor(-$rep[0]);
			
			$sql = "UPDATE ressources, membres SET pieces='".$this->_pieces."', date_pieces='".date('Y-m-d H:i:s')."' WHERE membres.id = ressources.id AND login='".$whoFight."'";
			mysql_query($sql);
		}

		function perte1($type)
		{
			$perteMin = floor($type*5/100);
			$perteMax = floor($type*12/100);
			
			$qtePerdu = rand($perteMin, $perteMax);
			
			return $qtePerdu;
		}
		
		function perte2($type)
		{
			$perteMin = floor($type*10/100);
			$perteMax = floor($type*50/100);
			
			$qtePerdu = rand($perteMin, $perteMax);
			
			return $qtePerdu;	
		}

		if($this->_pa == 0)
		{
			echo "Vous n'avez plus de PA !";
		}
		else if($this->_force > $this->_defenseJ2)
		{
			//Perte troupe du joueur 2
			$soldatsPerduJ2 = perte1($this->_qteSoldatJ2);
			$this->_qteSoldatJ2 -= $soldatsPerduJ2;
			$ArcherPerduJ2 = perte1($this->_qteArcherJ2);
			$this->_qteArcherJ2 -= $ArcherPerduJ2;
			$CavalierPerduJ2 = perte1($this->_qteCavalierJ2);
			$this->_qteCavalierJ2 -= $CavalierPerduJ2;
			
			//Pieces perdu
			$piecesPerduJ2 = perte1($this->_piecesJ2);
			$this->_piecesJ2 -= $piecesPerduJ2*2;
			
			//Perte Victoire			
			if($this->_victoireJ2 > 0)
			{
				$this->_victoireJ2--;
			}
			
			//MAJ J2
			$sql = "UPDATE membres, armees, ressources SET qte_soldat='".$this->_qteSoldatJ2."', qte_archer='".$this->_qteArcherJ2."', qte_cavalier='".$this->_qteCavalierJ2."', pieces='".$this->_piecesJ2."', nb_victoire='".$this->_victoireJ2."' WHERE armees.id = membres. id AND ressources.id = membres.id AND login='".$whoFight."'";
			mysql_query($sql);
			
			//Perte troupe du joueur 1
			$soldatsPerduJ1 = perte2($soldatsPerduJ2);
			$this->_qteSoldat -= $soldatsPerduJ1;
			$ArcherPerduJ1 = perte2($ArcherPerduJ2);
			$this->_qteArcher -= $ArcherPerduJ1;
			$CavalierPerduJ1 = perte2($CavalierPerduJ2);
			$this->_qteCavalier -= $CavalierPerduJ1;
			
			//Pieces et victoire gagné J1
			$this->_pieces += $piecesPerduJ2*2;
			$this->_victoire++;
			$this->_pa--;
			
			
			//MAJ J1
			$sql = "UPDATE membres, ressources, armees SET qte_soldat='".$this->_qteSoldat."', qte_archer='".$this->_qteArcher."', qte_cavalier='".$this->_qteCavalier."', pieces='".$this->_pieces."', nb_victoire='".$this->_victoire."', pa='".$this->_pa."' WHERE ressources.id = membres.id AND armees.id = membres.id AND login='".$_SESSION['login']."'";
			mysql_query($sql);
			
			echo "Vous avez gagné !<br>".$whoFight." a perdu ".$soldatsPerduJ2." soldats, ".$ArcherPerduJ2." archers, ".$CavalierPerduJ2." cavaliers et vous lui subtilisez ".($piecesPerduJ2*2)." pièces.<br>Vous perdez ".$soldatsPerduJ1." soldats, ".$ArcherPerduJ1." archers et ".$CavalierPerduJ1." cavaliers.";
		}
		else
		{	
		
			//Perte troupe du joueur 1
			$soldatsPerduJ1 = perte1($this->_qteSoldat);
			$this->_qteSoldat -= $soldatsPerduJ1;//soldat
			$ArcherPerduJ1 = perte1($this->_qteArcher);
			$this->_qteArcher -= $ArcherPerduJ1;//archer
			$CavalierPerduJ1 = perte1($this->_qteCavalier);
			$this->_qteCavalier -= $CavalierPerduJ1;//cavalier
			
			//Pieces perdu
			$piecesPerdu = perte1($this->_pieces);
			$this->_pieces -= $piecesPerdu*2;
			
			$this->_pa--;
			
			if($this->_victoire > 0)
			{
				$this->_victoire--;
			}
			
			//MAJ J1
			$sql = "UPDATE membres, ressources, armees SET qte_soldat='".$this->_qteSoldat."', qte_archer='".$this->_qteArcher."', qte_cavalier='".$this->_qteCavalier."', pieces='".$this->_pieces."', pa='".$this->_pa."', nb_victoire='".$this->_victoire."' WHERE ressources.id = membres.id AND armees.id = membres.id AND login='".$_SESSION['login']."'";
			mysql_query($sql);
			
			//Perte troupe du joueur 2
			$soldatsPerduJ2 = perte2($soldatsPerduJ1);
			$this->_qteSoldatJ2 -= $soldatsPerduJ2;//soldat
			$ArcherPerduJ2 = perte2($ArcherPerduJ1);
			$this->_qteArcherJ2 -= $ArcherPerduJ2;//archer
			$CavalierPerduJ2 = perte2($CavalierPerduJ1);
			$this->_qteCavalierJ2 -= $CavalierPerduJ2;//cavalier
			
			
			$this->_piecesJ2 += $piecesPerdu*2;
			$this->_victoireJ2++;
			
			//MAJ J2
			$sql = "UPDATE membres, ressources, armees SET qte_soldat='".$this->_qteSoldatJ2."', qte_archer='".$this->_qteArcherJ2."', qte_cavalier='".$this->_qteCavalierJ2."', pieces='".$this->_piecesJ2."', nb_victoire='".$this->_victoireJ2."' WHERE ressources.id = membres.id AND armees.id = membres.id AND login='".$whoFight."'";
			mysql_query($sql);
			
			echo "Vous avez perdu ...<br>Vous perdez ".$soldatsPerduJ1." soldats, ".$ArcherPerduJ1." archers, ".$CavalierPerduJ1." cavaliers et ".($piecesPerdu*2)." pièces !";	
		}
	}
	
	public function afficherArmee()
	{
		echo $this->_qteSoldat;
	}
	
	public function afficherArcher()
	{
		echo $this->_qteArcher;
	}
	
	public function afficherCavalier()
	{
		echo $this->_qteCavalier;
	}
	
	public function afficherForce()
	{
		echo $this->_force;
	}
	
	public function afficherDefense()
	{
		echo $this->_defense;
	}
	
	public function afficherPa()
	{
		echo $this->_pa;
	}
	
	public function afficherMaxSoldat()
	{
		$maxSoldats = floor($this->_pieces/5);
		echo $maxSoldats;
	}
		public function afficherMaxArcher()
	{
		$maxSoldats = floor($this->_pieces/8);
		echo $maxSoldats;
	}
		public function afficherMaxCavalier()
	{
		$maxSoldats = floor($this->_pieces/15);
		echo $maxSoldats;
	}
	
}
?>