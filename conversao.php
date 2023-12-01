<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Conversor de moedas_API_BCB</title>
</head>
<body>
    <main>

    <h1>Conversor de moedas_API_BCB</h1>

      <?php
        date_default_timezone_set("America/Sao_Paulo");
        $dataInicial = date("m-d-Y", strtotime("-7 days"));
        $dataFinal = date("m-d-Y");
        $url = 'https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoDolarPeriodo(dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@dataInicial=\''.$dataInicial.'\'&@dataFinalCotacao=\''.$dataFinal.'\'&$top=1&$orderby=dataHoraCotacao%20desc&$format=json&$select=cotacaoCompra';

        $dados = json_decode(file_get_contents($url), true);
        $cotacao = $dados['value'][0]['cotacaoCompra'];

        //Quantos $$ você tem?
        $real = $_REQUEST['dinheiro'] ?? 0;

        //Equivalência em dólar
        $dolar = $real   / $cotacao;

        
        // Mostrar o resultado
        $padrao = numfmt_create("pt_BR", NumberFormatter::CURRENCY);

        echo "<p>Seus ".numfmt_format_currency($padrao, $real, "BRL")." equivalem a <strong>".numfmt_format_currency($padrao, $dolar, "USD")."</strong></p>";

        echo "<p>*Cotação obtida diretamente do site do <a href='https://www.bcb.gov.br'>Banco Central do Brasil</a>.</p>";
      ?>
      <button class="btn" onclick="javascript:history.go(-1)">
        <?= "\u{2B05}" ?> Voltar
      </button>
  </main>
</body>
</html>