<?php
  // Pega todas as noticias em JSON
  function showAll() {
    $url = 'http://localhost:8080/Mini-projeto-04/webresources/noticias/listar/';
    $response = file_get_contents($url);
    echo $http_response_header[0]; // PEGANDO STATUS DA REQUISIÇÃO
    var_dump(json_decode($response));
  }

  // Pega noticia especifica em JSON
  function show($value='') {
    $url = 'http://localhost:8080/Mini-projeto-04/webresources/noticias/mostrar/';
    $response = file_get_contents($url.$value);
    echo $http_response_header[0]; // PEGANDO STATUS DA REQUISIÇÃO
    var_dump(json_decode($response));
  }

  // Exclui noticia especifica
  function remove($value='') {
    $url = 'http://localhost:8080/Mini-projeto-04/webresources/noticias/deletar/';
    $response = file_get_contents($url.$value, false,
      stream_context_create(array(
          'http' => array(
              'method' => 'DELETE'
          )
      ))
    );
  }

  // Cria uma Noticia no Servidor, retorna JSON
  function create($autor='', $conteudo='', $data='', $titulo='') {
    // CRIAÇÃO DO ARRAY QUE REPRESENTA NOTICIA
    $notice = array('autor' => $autor, 'conteudo' => $conteudo, 'data' => $data, 'titulo' => $titulo);

    // CRIAÇÃO DO CONTEXTO PARA A REQUISIÇÃO
    $context = stream_context_create(array(
      'http' => array(
        'method' => 'POST',
        'header'  => 'Content-type: application/json',
        'content' => json_encode($notice) // converte o JSON para string (só consegui dessa forma)
        )
    ));
    $url = 'http://localhost:8080/Mini-projeto-04/webresources/noticias/criar';
    $response = file_get_contents($url, false, $context);
    echo $http_response_header[0]; // PEGANDO STATUS DA REQUISIÇÃO
    var_dump(json_decode($response));
  }

  // Cria uma Noticia no Servidor, retorna JSON
  function update($id='', $titulo='') {
    // CRIAÇÃO DO ARRAY QUE REPRESENTA NOTICIA
    $notice = array('autor' => 'no', 'conteudo' => 'no', 'data' => '2017-08-25T00:00:00-03:00', 'titulo' => $titulo);

    // CRIAÇÃO DO CONTEXTO PARA A REQUISIÇÃO
    $context = stream_context_create(array(
      'http' => array(
        'method' => 'PUT',
        'header'  => 'Content-type: application/json',
        'content' => json_encode($notice) // converte o JSON para string (só consegui dessa forma)
        )
    ));
    $url = 'http://localhost:8080/Mini-projeto-04/webresources/noticias/';
    $response = file_get_contents($url.$id, false, $context);
    echo $http_response_header[0]; // PEGANDO STATUS DA REQUISIÇÃO
    var_dump(json_decode($response));
  }

  // DESCOMENTE AS CHAMADAS DAS FUNÇÕES ABAIXO PARA TESTAR
  // showAll();
  // show(); // Tem que passar o ID
  // remove(); // Tem que passar o ID
  // create('Autor para TESTE', 'Lorem ipsum dolor sit amet.', '2017-08-25T00:00:00-03:00', 'Titulo TESTE');
  // update(, 'Mudança TESTE'); // Tem que passar o ID no primeiro PARAMETRO

  // OBS
  // PARA QUEM FOR FAZER O CLIENTE, O $response TÁ VOLTANDO UMA STRING NO FORMATO DE json OU xml
  // PARA FORMATO json USAR O json_decode($response) PARA TRANSFORMAR EM OBJETO
  // PARA FORMATO xml USAR O 'alguma função' PARA TRANSFORMAR EM OBJETO
  // PARA FORMATO xml TEM QUE PROCURAR ALGO POIS O PROFESSOR QUE O RETORNO DE DELETE EM xml
?>
