PHP ITAUCRIPTO Itau Bankline
==============

Vers�o em PHP com a classe ItauCripto, originalmente escrita em Java baseado em gabrielrcouto/php-itaucripto.

Implementamos na mesma biblioteca as chamadas Webservice para gera��o de transa��o no Itau Bankline e tamb�m consultas.

Nossa biblioteca foi desenvolvida inicialmente para utilizar apenas o Boleto banc�rio, mas nada impede de usar as outras formas de pagamento.

Caso queira contribuir com as outras formas de pagamento, ser� muito bem vindo tamb�m.

Como a classe ItauCripto em Java foi descompilada, alguns nomes se tornaram nomes gen�ricos (ex: $paramString1, $paramString2).

Instala��o
==============
```php
composer require dilneiss/itaubankline
```

Como usar o Webservice utilizando a pr�pria Biblioteca
==============
Para gerar uma url para o cliente efetuar o pagamento, utilize o seguinte c�digo
```php
	try {
			
		  //Coloque o c�digo da empresa em MAI�SCULO
		  $codEmp = "J1234567890123456789012345";
		  //Coloque a chave de criptografia em MAI�SCULO
		  $chave = "ABCD123456ABCD12";
		  
		  //Preencha as vari�veis abaixo com os dados do cliente e da cobran�a
		  //Abaixo � s� um exemplo!
		  $pedido = "1234";
		  $valor = "150,00";
		  $observacao = 1;
		  $nomeSacado = "Dilnei Soethe Spancerski";
		  $codigoInscricao = "";
		  $numeroInscricao = "";
		  $enderecoSacado = "";
		  $bairroSacado = "";
		  $cepSacado = "";
		  $cidadeSacado = "";
		  $estadoSacado = "";
		  $dataVencimento = "";
		  $urlRetorna = "";
		  $obsAd1 = "Observa��es linha 1";
		  $obsAd2 = "Observa��es linha 2";
		  $obsAd3 = "Observa��es linha 3";
		  
		  $itauCripto = new ItauCripto();
		  
		  $dados_criptografados = $itauCripto->geraDados($codEmp,$pedido,$valor,$observacao,$chave,$nomeSacado,$codigoInscricao,
		  													$numeroInscricao,$enderecoSacado,$bairroSacado,$cepSacado,$cidadeSacado,$estadoSacado,
													      $dataVencimento,$urlRetorna,$obsAd1,$obsAd2,$obsAd3);
													      
		  $itauService = new ItauBanklineService();
		  
		  $urlBoleto = $itauService->generateUrlBoletoItauBankline($dados_criptografados); //Utilize essa url para ir direto ao boleto banc�rio
		  
		  $urlItauBankline = $itauService->generateUrlBoletoItauBankline($dados_criptografados); //Utilize essa url para ir a tela do Itau Bankline e o cliente escolher a forma de pagamento
		  
		  //Aqui fa�a seu redirecionamento para a url gerada conforme desejado
			
		} catch (Exception $e) {
			exit($e->getMessage());
		}
```

Para efetuar uma consulta no Itau Bankline e retornar o status da transa��o, utilize o seguinte c�digo
```php
	$metodoResultado = 1; //0 Para exibir a consulta em html leg�vel e 1 para exibir a consulta em xml
	
	$itauCripto = new ItauCripto();
	$dadosCriptografados = $itauCripto->geraConsulta($codEmp , $pedido , $metodoResultado , $chave);
		
	try {
	
		$itauService = new ItauBanklineService();
		
		$transacao = $itauService->consultaTransacao($dadosCriptografados);
		
		var_dump($transacao);
		
	} catch (Exception $e) {
		exit($e->getMessage());
	}
```

Campos
==============

```php
  $pedido // Identifica��o do pedido - m�ximo de 8 d�gitos (12345678) - Obrigat�rio  
  $valor // Valor do pedido - m�ximo de 8 d�gitos + v�rgula + 2 d�gitos - 99999999,99 - Obrigat�rio  
  $observacao // Observa��es - m�ximo de 40 caracteres  
  $nomeSacado // Nome do sacado - m�ximo de 30 caracteres  
  $codigoInscricao // C�digo de Inscri��o: 01->CPF, 02->CNPJ  
  $numeroInscricao // N�mero de Inscri��o: CPF ou CNPJ - at� 14 caracteres  
  $enderecoSacado // Endereco do Sacado - m�ximo de 40 caracteres  
  $bairroSacado // Bairro do Sacado - m�ximo de 15 caracteres  
  $cepSacado // Cep do Sacado - m�ximo de 8 d�gitos  
  $cidadeSacado // Cidade do sacado - m�ximo 15 caracteres  
  $estadoSacado // Estado do Sacado - 2 caracteres  
  $dataVencimento // Vencimento do t�tulo - 8 d�gitos - ddmmaaaa  
  $urlRetorna // URL do retorno - m�ximo de 60 caracteres  
  $obsAdicional1 // ObsAdicional1 - m�ximo de 60 caracteres  
  $obsAdicional2 // ObsAdicional2 - m�ximo de 60 caracteres  
  $obsAdicional3 // ObsAdicional3 - m�ximo de 60 caracteres
```

Author
==============

[@dilneiss88](http://twitter.com/dilneiss88)

Licen�a
==============

[MIT License](http://zenorocha.mit-license.org/)