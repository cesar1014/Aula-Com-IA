<?php

header('Access-Control-Allow-Origin: *');

// Função para calcular o IMC
function calcularIMC($peso, $altura) {
    if ($altura == 0) {
        return 0; // Prevenção de divisão por zero
    }
    return $peso / ($altura * $altura);
}

// Função para classificar o IMC
function classificarIMC($imc) {
    if ($imc < 18.5) {
        return "Abaixo do peso";
    } elseif ($imc >= 18.5 && $imc < 24.9) {
        return "Peso normal";
    } elseif ($imc >= 25 && $imc < 29.9) {
        return "Sobrepeso";
    } elseif ($imc >= 30 && $imc < 34.9) {
        return "Obesidade grau 1";
    } elseif ($imc >= 35 && $imc < 39.9) {
        return "Obesidade grau 2";
    } else {
        return "Obesidade grau 3";
    }
}

// Função para calcular o peso ideal para IMC 24.9
function calcularPesoIdeal($altura) {
    return 24.9 * ($altura * $altura);
}

// Verifica se os parâmetros peso e altura foram passados via GET ou POST
if ((isset($_GET['peso']) && isset($_GET['altura'])) || (isset($_POST['peso']) && isset($_POST['altura']))) {
    
    // Verifica se os parâmetros foram passados via GET ou POST
    $peso = isset($_GET['peso']) ? (float) $_GET['peso'] : (float) $_POST['peso'];
    $altura = isset($_GET['altura']) ? (float) $_GET['altura'] : (float) $_POST['altura'];

    if ($peso > 0 && $altura > 0) {
        // Calcula o IMC
        $imc = calcularIMC($peso, $altura);

        // Classifica o IMC
        $classificacao = classificarIMC($imc);

        // Calcula o peso ideal para IMC de 24.9
        $pesoIdeal = calcularPesoIdeal($altura);

        // Calcula a diferença de peso
        $diferencaPeso = $pesoIdeal - $peso;

        // Mensagem sobre ganhar ou perder peso
        if ($diferencaPeso > 0) {
            $mensagem = "Você precisa ganhar " . round($diferencaPeso, 2) . " kg para atingir um IMC de 24.9.";
        } elseif ($diferencaPeso < 0) {
            $mensagem = "Você precisa perder " . round(abs($diferencaPeso), 2) . " kg para atingir um IMC de 24.9.";
        } else {
            $mensagem = "Você já está com um IMC de 24.9!";
        }

        // Retorna o resultado em formato JSON
        echo json_encode([
            'imc' => round($imc, 2),
            'classificacao' => $classificacao,
            'mensagem' => $mensagem,
        ]);
    } else {
        echo json_encode(['erro' => 'Peso e altura devem ser maiores que zero.']);
    }
} else {
    echo json_encode(['erro' => 'Parâmetros peso e altura são obrigatórios.']);
}

?>