<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Sistema de Login - Autenticando</title>
	</head>

	<body>
		<?php 
			include_once 'connect.php';
			
			//Recebendo os dados do formulário
			$email = addslashes($_POST["email"]);
			$senha = addslashes($_POST["senha"]);
			//$senha = md5(addslashes($_POST["senha"]));
			
			if(isset($_GET['usuario']))
			{
				$sql = "SELECT * FROM usuario WHERE email = '$email' AND senha = '$senha'";
			}
			else if(isset($_GET['admin']))
			{
				$cpf = addslashes($_POST["cpf"]);
				$sql = "SELECT * FROM administrador WHERE cpf = '$cpf' AND email = '$email' AND senha = '$senha'";
			}
			$rs = mysql_query($sql);
			
			if(mysql_num_rows($rs) == 1)
			{
				$user = mysql_fetch_array($rs);
				
				//conferindo o login e senha para segurança
				if($email == $user['email'])
				{
					//se entrou, entao o login é igual
					if($senha == $user['senha'])
					{
						//se entrou, então a senha também é igual
						$logado = "1";
						$id_user = $user['idusuario'];
						
						//criando a sessão
						session_start();
						$_SESSION["id_user"] = $id_user;;
						$_SESSION["logado"] = $logado;
						
						header("Location: home.php");
					}
					else
					{
						if(isset($_GET['usuario'])) { header("Location:login.php?error"); } else { header("Location:login_admin.php?error"); }
					}
				}
				else
				{
					if(isset($_GET['usuario'])) { header("Location:login.php?error"); } else { header("Location:login_admin.php?error"); }
				}
			}
			else
			{
				if(isset($_GET['usuario'])) { header("Location:login.php?error"); } else { header("Location:login_admin.php?error"); }
			}
			
		?>
	</body>
</html>
