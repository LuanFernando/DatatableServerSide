<?php

#Importando a classe de conexão com banco de dados.
include_once("conexao_bd.php");

# Array sendo inicializado, este será usado para retornar o valores apos a consulta no banco de dados.
$dataReturn = array( 
    "draw" => 0,
    "recordsTotal" => 0, //Total de registro
    "recordsFiltered" => 0,//Total de registros apos o filtro
    "data" => null // Registro
);

$data = array();

// If verificando o tipo de method esta recebendo.
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    
    # Resgata os valores do post
    $post = $_POST;

    # Query de consulta banco de dados
    $query = "SELECT * FROM alunos WHERE 1=1 ";

    // Verifica se no filtro veio o campo nome
    if(isset($_POST['nome']) && $_POST['nome'] != '')
    {
        $query .= "AND nome_aluno ='{$_POST['nome']}'";
    }

    // Verifica se no filtro veio o campo sexo
    if(isset($_POST['sexo']) && $_POST['sexo'] != '')
    {
        $query .= "AND Sexo ='{$_POST['sexo']}'";
    }

    // 
    if($_POST['length'] != -1)
    {
        $query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
    }

    // Executando a query e retornando o resultado para variavel response
    $response = mysqli_query($conn,$query);
    $dadosAlunos = $response->fetch_all(MYSQLI_ASSOC);  
    // Resgatando o numero de linhas retornou a consulta.
    $filtered_rows = $response->num_rows;
    
    // // Fecha a conexão com banco de dados.
    // mysqli_close($conn);

    # Foreach percorrendo  valores retornando da consulta do banco de dados.
    foreach ($dadosAlunos as $value) 
    {
        // Array auxiliar para salvar os valors de cada registro antes de da push com outro array
        $aluno = [  
            "<a href='{$value['id']}'>".$value['id']."</a>",
            $value['nome_aluno'],
            $value['telefone'],
            $value['Sexo'],
            $value['email'],
            $value['cpf'],
            $value['data_nasci'],
            $value['status'],
        ];

        array_push($data,$aluno);
    }
    # fim foreach

    ## Inicio nova consulta apenas para saber total de linhas ##
    // Query de consulta banco de dados
    $query1 = "SELECT * FROM alunos ";

    // Verifica se no filtro veio o campo nome
    if(isset($_POST['nome']) && $_POST['nome'] != '')
    {
        $query .= "AND nome_aluno ='{$_POST['nome']}'";
    }

    // Verifica se no filtro veio o campo sexo
    if(isset($_POST['sexo']) && $_POST['sexo'] != '')
    {
        $query .= "AND Sexo ='{$_POST['sexo']}'";
    }

    // Executando a query e retornando o resultado para variavel response
    $response1 = mysqli_query($conn,$query1);
    // Resgatando o numero de linhas retornou a consulta.
    $totalRows = $response1->num_rows;
    
    // Fecha a conexão com banco de dados.
    mysqli_close($conn);
    ## Fim nova consulta apenas para saber total de linhas.... ##


    # O draw vem no post , informação que o datatable envia e ajuda a controlar a quantidade de registro deve ser buscada.
    $data1["draw"] = intval($_POST["draw"]); 
    $data1["recordsTotal"] = $filtered_rows; // Atribuindo total de registro retornandos da consulta.
    $data1["recordsFiltered"] = $totalRows; //  Total de registro apos o filtro(numero de linhas).
    $data1["data"] = $data; // Atribuindo valores da consulta
    $data1['post'] = $post;
}

//converte o conteúdo do array associativo para uma string JSON
$json_str = json_encode($data1);

//imprime a string JSON
echo "$json_str";

