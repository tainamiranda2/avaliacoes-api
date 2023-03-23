<?php

use LandKit\DotEnv\DotEnv;
/*
 * Variáveis de ambiente
 */

// Verifica se o arquivo .env não existe na pasta raiz da aplicação
if (!DotEnv::load(__DIR__ . '/../../')) {
    // Define o código de resposta
    http_response_code(HttpResponseCodeInterface::INTERNAL_SERVER_ERROR);

    // Retorna a resposta
    echo (new ApiProblem('Error loading .env file.'))
        ->setStatus(HttpResponseCodeInterface::INTERNAL_SERVER_ERROR)
        ->asJson();

    // Finaliza a execução
    exit;
}


/*
 * Url do sistema
 */

// Identifica se o servidor está em modo seguro
$https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 's' : null);

// Define a url do sistema
define('CONF_BASE_URL', "http{$https}://" . getenv('HOST'));


    header("Access-Control-Allow-Origin: *"); 
    header("Access-Control-Allow-Credentials: true"); 
   header("Access-Control-Allow-Methods: POST, GET, DELETE,PUT ");
    //header('Access-Control-Max-Age: 86400');    // cache for 1 day

/*
 * Banco de dados
 */

// Obtém as variáveis de ambiente
$databaseKey = getenv('DATABASE_KEY');
$databaseDriver = getenv('DATABASE_DRIVER');
$databaseHost = getenv('DATABASE_HOST');
$databasePort = getenv('DATABASE_PORT');
$databaseDbName = getenv('DATABASE_DBNAME');
$databaseUsername = getenv('DATABASE_USERNAME');
$databasePassword = getenv('DATABASE_PASSWORD');
$databaseOptions = getenv('DATABASE_OPTIONS');

// Verifica se alguma variável está vazia
if (!$databaseKey || !$databaseDriver || !$databaseHost || !$databasePort ||
    !$databaseDbName || !$databaseUsername || !$databasePassword
) {
    // Define o código de resposta
    http_response_code(HttpResponseCodeInterface::INTERNAL_SERVER_ERROR);

    // Retorna a resposta
    echo (new ApiProblem('Error loading database configuration.'))
        ->setStatus(HttpResponseCodeInterface::INTERNAL_SERVER_ERROR)
        ->asJson();

    // Finaliza a execução
    exit;
}

// Prepara as variáveis de ambiente
$database = [];
$databaseKey = explode(';;', $databaseKey);
$databaseDriver = explode(';;', $databaseDriver);
$databaseHost = explode(';;', $databaseHost);
$databasePort = explode(';;', $databasePort);
$databaseDbName = explode(';;', $databaseDbName);
$databaseUsername = explode(';;', $databaseUsername);
$databasePassword = explode(';;', $databasePassword);
$databaseOptions = explode(';;', $databaseOptions);

// Organiza as configurações em um array
foreach ($databaseKey as $i => $value) {
    // Verifica se alguma configuração não existe ou se está no formato incorreto
    if (!$value || !$databaseDriver[$i] || !$databaseHost[$i] || !$databasePort[$i]
        || !$databaseDbName[$i] || !$databaseUsername[$i] || !$databasePassword[$i]
        || !is_numeric($databasePort[$i])
    ) {
        // Define o código de resposta
        http_response_code(HttpResponseCodeInterface::INTERNAL_SERVER_ERROR);

        // Retorna a resposta
        echo (new ApiProblem('Error loading database configuration.'))
            ->setStatus(HttpResponseCodeInterface::INTERNAL_SERVER_ERROR)
            ->asJson();

        // Finaliza a execução
        exit;
    }

    // Adiciona as configurações no array
    $database[$value] = [
        'driver' => $databaseDriver[$i],
        'host' => $databaseHost[$i],
        'port' => $databasePort[$i],
        'dbname' => $databaseDbName[$i],
        'username' => $databaseUsername[$i],
        'password' => $databasePassword[$i]
    ];

    // Verifica se existem configurações específicas
    if ($databaseOptions[$i]) {
        // Converte as configurações em um array
        parse_str($databaseOptions[$i], $options);

        // Adiciona as configurações no array
        $database[$value]['options'] = array_map(fn($item) => (is_numeric($item) ? (int) $item : $item), $options);
    }
}

// Define as configurações do banco de dados
define('CONF_DATABASE', $database);
