<?php

#Denne fil er hvor alt centreres. Uden denne fil, virker intet optimalt.

#require_once er en funktion der kræver en fil ind, lidt som at man "fuser" dem samme.
#_once betyder at den kun bliver krævet én gang, og om jeg laver en require_once senere, gør den det ikke igen, fordi det er overflødigt.
#Du kan læse mere om det her: http://php.net/manual/en/function.require-once.php
#Her kræver vi connect.php. Det er den fil der sørger for der er forbindelse til databasen.
require_once('assets/connect.php');

#Her kræver vi nogle classer. Jeg kan godt lide at have mine classer i seperate filer.
#crud.php består af CRUD princippet: Create, Read, Update, Delete.
#user.php består af nogle metoder der har specifikke opgaver, så som at logge en bruger ind.
require_once('assets/classes/crud.php');
require_once('assets/classes/user.php');

#isset ser om en variable eksisterer, og melder et boolean tilbage: true/false.
#Du kan læse mere om det her:http://php.net/manual/en/function.isset.php
#$_GET er en array variabel, der kan indeholde mange forskellige ting,
#men de er altid i URL-barren. Hvis der står i URL baren:
#?page=home&article=23
#betyder det at du er på siden "home" og i "article" 23.
#De her ting kan bruges til mange ting, hvori "page" siger hvilken side man er på
#og "article=23" betyder hvilken article man læser. For at få fadt i de informationer
#bruger man $_GET.
#Du kan læse mere om det her: http://php.net/manual/en/reserved.variables.get.php
#Her ser vi om $_GET['page'] eksisterer (eller om der står ?page i URL-barren)
if(isset($_GET['page'])){

	#Variabler er lidt anderledes i PHP end de er i C#.
	#I C# skal du sige hvilken slags variabel det er, enten string (tekst) eller int (integers, heltal).
	#Siden man ikke definerer hvilken type variablen er i PHP, så betyder det, at de er dynamiske,
	#som gør at de kan være hvilken som helst type.
	#Du kan læse om dem her http://php.net/manual/en/language.variables.basics.php
	#Her tager við $_GET['page'] og sætter den i en variabel $page.
	#I C# ville denne variabel være en string.]
	$page = $_GET['page'];

}

#empty ser om $page er tom.
if(empty($page)){

	#Hvis $page er tom, så går vi over til siden der hedder registrering.
	#Jeg har en .htaccess der gør at jeg slipper fra '?page=' delen
	header('Location: registrering');

#eller hvis filen ikke eksisterer...
}elseif(!file_exists('pages/'.$page.'.php')){

	#Få brugeren over til en 404 side
	#Sidst jeg prøvede med en header, ville den ikke, så derfor er det JS
	print "<script>window.location.replace('404')</script>";

#Hvis alt er som det skal være...
}else{

	#så kræver vi headeren
	require_once('assets/viewables/header.php');

	#inkluderer midterindholdet
	#Læg mærke til at denne er inkluderet, og ikke kun én gang.
	#Det er fordi $page skifter værdi, som brugeren browser siden
	include('pages/'.$page.'.php');

	#og kræver foden til sidst.
	require_once('assets/viewables/footer.php');
}

#Tag dig ikke af den her. Brugte den til at enkryptere
#passwords uden at skulle bruge metoderne i CRUD
// echo password_hash("test", PASSWORD_DEFAULT);

#password_hash() tager en string, som er det koden skal være
#og PASSWORD_DEFAULT er måden den 'salter' på.
#Du kan læse mere om det her: http://php.net/manual/en/function.password-hash.php
