<?php
namespace ItauBankline;

use Httpful\Request;
use ItauBankline\Model\ConsultaTransacaoItauBanklineModel;
class ItauBanklineService
{
	
	//Gera��o de transa��o
	const URL_REQUISICAO_ITAU_BANKLINE 		= 'https://shopline.itau.com.br/shopline/shopline.aspx?DC=';
	const URL_REQUISICAO_BOLETO_BANCARIO 	= 'https://shopline.itau.com.br/shopline/Itaubloqueto.asp?DC=';

	//Consulta de Transa��es
	const URL_CONSULTA_TRANSACOES 			= 'https://shopline.itau.com.br/shopline/consulta.aspx?DC=';
	
	/**
	 * Gerando a url para o usu�rio entrar na tela do Itau Bankline
	 * @param string $dadosCriptografados
	 */
	public function generateUrlItauBankline($dadosCriptografados){
		return static::URL_REQUISICAO_ITAU_BANKLINE.$dadosCriptografados;
	}
	
	/**
	 * Gerando a url para o usu�rio entrar diretamente no boleto banc�rio sem passar pela tela do Itau Bankline
	 * @param string $dadosCriptografados
	 */
	public function generateUrlBoletoItauBankline($dadosCriptografados){
		return static::URL_REQUISICAO_BOLETO_BANCARIO.$dadosCriptografados;
	}
	
	public function consultaTransacao($dadosCriptografados){
		
		$xml = Request::get(static::URL_CONSULTA_TRANSACOES.$dadosCriptografados)->withoutStrictSsl()->expectsXml()->send();
		
		if (!$xml){
			throw new \Exception("Nenhum dado coletado no webservice");
		}
		
		if ($xml->code != 200){
			throw new \Exception("O servidor retornou status {$xml->code}");
		}
		
		return $this->populateConsultaTransacao($xml->body);
		
	}
	
	/**
	 * Convertendo o resultado em XML para um objeto �nico
	 * @param string $body
	 * @return ConsultaTransacaoModel
	 */
	private function populateConsultaTransacao($body){
		
		$consultaTransacaoModel = new ConsultaTransacaoItauBanklineModel();
		
		$json = json_encode($body);
		$array = json_decode($json,true);
		
		foreach ($array['PARAMETER']['PARAM'] as $param){
			
			$consultaTransacaoModel->$param['@attributes']['ID'] = $param['@attributes']['VALUE'];
			
		}
		
		return $consultaTransacaoModel;
		
	}
	
}