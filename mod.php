
<?php

function connect(){
	try
{
	// On se connecte à MySQL
	$bdd = new PDO('mysql:host=localhost;dbname=annuaire_film;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
// ini_set('memory_limit', '512M');
// 	 $storage = null;
	return $bdd;
}
catch(Exception $e)
{
	// En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
}
}
// affichage nom +image
function afficher(){
	$con=connect();
	$tab = array();  
	$reponse1 = $con->query('SELECT nomF,descript/*pic*/ FROM films');
	while($result = $reponse1->fetch())
		{
			
			//  var_dump($result);
			 array_push($tab, $result['nomF']).'<br>';
			 array_push($tab, $result['descript']).'<br>';
		}
		// for($i=0;$i<count($tab);$i++)
		// {
			
		// 	echo "$tab[$i]".'<br>';

		// }
		
	 return $tab;
}

// affichage details film
function film_carac(){
	$con=connect();
	$tab = array();  
	$reponse2 = $con->query('SELECT pic,nomF,descript,langue,duree,date_sortie,nomR,prenomR
	 FROM films,realisateurs,realiser WHERE  films.id=realiser.id_film AND realisateurs.id=realiser.id_realisateur');
		while($result = $reponse2->fetch())
		{
			array_push($tab, $result['nomF']).'<br>';
			array_push($tab, $result['descript']).'<br>';
			array_push($tab, $result['langue']).'<br>';
			array_push($tab, $result['duree']).'<br>';
			array_push($tab, $result['date_sortie']).'<br>';
			array_push($tab, $result['descript']).'<br>';
			array_push($tab, $result['prenomR']. ' ' . $result['nomR']);
		}
		// for($i=0;$i<count($tab);$i++)
		// {
			
		// 	echo "$tab[$i]".'<br>';

		// }
	 return $tab;
}
// afficher les acteurs, les libelles et les maisons d'editions

function film_details($film,$type)
{
	$con=connect();
	$tab = array();  
	if($type == 'acteur')
	{
		
		$my_query= $con->query('SELECT nomA,prenomA FROM films,acteurs,jouer WHERE films.id=jouer.id_film AND acteurs.id=jouer.id_acteur AND films.nomF="'.$film.'"');
		while($result = $my_query->fetch())
		{
			
			 array_push($tab, $result['prenomA']. ' ' . $result['nomA']);
		}
		// for($i=0;$i<count($tab);$i++)
		// {
		// 	echo "$tab[$i]".'<br>';

		// }
		return $tab;
	}
	else if($type == 'producteur')
	{
		$my_query= $con->query('SELECT nom_prod FROM films,producteurs,produire WHERE films.id=produire.id_film AND producteurs.id=produire.id_producteur AND films.nomF="'.$film.'"');
		while($result = $my_query->fetch())
	{
	// remplissage du tableau 
		array_push($tab, $result['nom_prod']).'<br>';
	}
	// for($i=0;$i<count($tab);$i++)
	// 	{
	// 		echo "$tab[$i]".'<br>';

	// 	}
	return $tab;
	}
	else if($type == 'genre')
	{
	$my_query= $con->query('SELECT categ FROM films,genre,film_genre WHERE films.id=film_genre.id_film AND genre.id=film_genre.id_genre AND films.nomF="'.$film.'"');
	while($result = $my_query->fetch())
	{
	// remplissage du tableau 
	array_push($tab, $result['categ']).'<br>';
	}
	// for($i=0;$i<count($tab);$i++)
	// 	{

	// 		echo "$tab[$i]".'<br>';

	// 	}
	
	}
	
	return $tab;
}
// affichafe film par genre
function is_categ($categorie){
	$con=connect();
	$tab = array();  
	
		 $my_query= $con->query('SELECT nomF,descript/*pic*/ FROM films,genre,film_genre WHERE films.id=film_genre.id_film 
		AND genre.id=film_genre.id_genre AND genre.categ="'.$categorie.'"');

		while($result = $my_query->fetch())
		{
			 array_push($tab, $result['nomF']).'<br>';
			 array_push($tab, $result['descript']).'<br>';
		}
		// for($i=0;$i<count($tab);$i++)
		// {
		// 	echo "$tab[$i]".'<br>';

		// }
		return $tab;
	}	
	// recuperation par url
function search($entree){
	$con=connect();
	$tab = array();  
	
		 $my_query= $con->query('SELECT distinct nomF/*pic*/ 
		 FROM films,genre,film_genre,acteurs,jouer
		  WHERE films.id=film_genre.id_film AND genre.id=film_genre.id_genre AND films.id=jouer.id_film AND acteurs.id=jouer.id_acteur 
		 AND categ="'.$entree.'"');

		while($result = $my_query->fetch())
		{
			 array_push($tab, $result['nomF']).'<br>';
		}
		for($i=0;$i<count($tab);$i++)
		{
			echo "$tab[$i]".'<br>';

		}
		// return $tab;

}
// search("");
// film_carac();
?>