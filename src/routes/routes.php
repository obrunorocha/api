<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

//exibir todas as pessoas cadastradas
$app->get('/api/pessoas', function(Request $request, Response $response){
    try
    {
        $con = new config();
        $con = $con->conectar();

        $stmt = $con->prepare("SELECT IDPESSOA AS 'ID', NOME, EMAIL, CPF, TELEFONE, ENDERECO FROM tb_pessoas");
        $stmt->execute();

        $pessoa = $stmt->fetchAll(PDO::FETCH_OBJ);
        $con = null;
        echo json_encode($pessoa);
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }
});

//exibir pessoa cadastrada através do seu id
$app->get('/api/pessoa/{id}', function(Request $request, Response $response){

    $id = $request->getAttribute('id');

    try
    {
        $con = new config();
        $con = $con->conectar();

        $stmt = $con->prepare("SELECT IDPESSOA AS 'ID', NOME, EMAIL, CPF, TELEFONE, ENDERECO FROM tb_pessoas WHERE idpessoa = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $pessoa = $stmt->fetchAll(PDO::FETCH_OBJ);
        $con = null;
        echo json_encode($pessoa);
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }
});

//efetua o cadastro de uma pessoa
$app->post('/api/pessoa/cadastrar', function(Request $request, Response $response){

    $nome     = $request->getParam('nome');
    $email    = $request->getParam('email');
    $senha    = $request->getParam('senha');
    $cpf      = $request->getParam('cpf');
    $telefone = $request->getParam('telefone');
    $endereco = $request->getParam('endereco');

    try
    {
        $con = new config();
        $con = $con->conectar();

        $stmt = $con->prepare("INSERT INTO tb_pessoas (nome, email, senha, cpf, telefone, endereco)
        VALUES (:nome, :email, MD5(:senha), :cpf, :telefone, :endereco)");

        $stmt->bindParam(':nome',     $nome);
        $stmt->bindParam(':email',    $email);
        $stmt->bindParam(':senha',    $senha);
        $stmt->bindParam(':cpf',      $cpf);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':endereco', $endereco);

        $stmt->execute();
        
        echo "Usuario cadastrado com sucesso!";
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }
});

//atualiza dados de uma pessoa cadastrada através do seu id
$app->put('/api/pessoa/atualizar/{id}', function(Request $request, Response $response){

    $id       = $request->getAttribute('id');

    $nome     = $request->getParam('nome');
    $email    = $request->getParam('email');
    $senha    = $request->getParam('senha');
    $cpf      = $request->getParam('cpf');
    $telefone = $request->getParam('telefone');
    $endereco = $request->getParam('endereco');

    try
    {
        $con = new config();
        $con = $con->conectar();

        $stmt = $con->prepare("UPDATE tb_pessoas SET
                                      nome     = :nome, 
                                      email    = :email, 
                                      senha    = MD5(:senha), 
                                      cpf      = :cpf, 
                                      telefone = :telefone, 
                                      endereco = :endereco 
                                WHERE idpessoa = :id");

        $stmt->bindParam(':id',       $id);
        $stmt->bindParam(':nome',     $nome);
        $stmt->bindParam(':email',    $email);
        $stmt->bindParam(':senha',    $senha);
        $stmt->bindParam(':cpf',      $cpf);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':endereco', $endereco);

        $stmt->execute();
        
        echo "Usuário atualizado com sucesso!";
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }
});

//deleta uma pessoa cadastrada através do seu id
$app->delete('/api/pessoa/deletar/{id}', function(Request $request, Response $response){

    $id = $request->getAttribute('id');

    try
    {
        $con = new config();
        $con = $con->conectar();

        $search = $con->prepare("SELECT * FROM tb_pessoas WHERE idpessoa = :id");
        $search->bindParam(":id", $id);
        $search->execute();

        $result = $search->rowCount();

        if($result > 0)
        {
            $stmt = $con->prepare("DELETE FROM tb_pessoas WHERE idpessoa = :id");
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $con = null;
            echo "Usuario deletado com sucesso!";
        }
        else
        {
            echo "Usuário inexistente em nossa base de dados, digite novamente.";
        }
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }
});

//exibi todos os grupos cadastrados
$app->get('/api/grupos', function(Request $request, Response $response){
    try
    {
        $con = new config();
        $con = $con->conectar();

        $stmt = $con->prepare("SELECT G.IDGRUPO AS ID, G.NOME AS GRUPO, G.TEMA, G.DESCRICAO, COUNT(P.NOME) AS 'QTDE MEMBROS' 
        FROM TB_PESSOA_GRUPO PG
        RIGHT JOIN TB_PESSOAS P
        ON PG.ID_PESSOA = P.IDPESSOA
        RIGHT JOIN TB_GRUPOS G
        ON PG.ID_GRUPO = G.IDGRUPO
        GROUP BY G.IDGRUPO");

        $stmt->execute();

        $grupo = $stmt->fetchAll(PDO::FETCH_OBJ);
        $con = null;
        echo json_encode($grupo);
        
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }
});

//exibi apenas um grupo através do seu id
$app->get('/api/grupo/{id}', function(Request $request, Response $response){

    $id = $request->getAttribute('id');

    try
    {
        $con = new config();
        $con = $con->conectar();

        $stmt = $con->prepare("SELECT * FROM tb_grupos WHERE idgrupo = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $grupo = $stmt->fetchAll(PDO::FETCH_OBJ);
        $con = null;
        echo json_encode($grupo);
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }
});

//efetua o cadastro de um grupo
$app->post('/api/grupo/cadastrar', function(Request $request, Response $response){

    $nome      = $request->getParam('nome');
    $tema      = $request->getParam('tema');
    $descricao = $request->getParam('descricao');

    try
    {
        $con = new config();
        $con = $con->conectar();

        $stmt = $con->prepare("INSERT INTO tb_grupos (nome, tema, descricao) 
        VALUES (:nome, :tema, :descricao)");

        $stmt->bindParam(':nome',      $nome);
        $stmt->bindParam(':tema',      $tema);
        $stmt->bindParam(':descricao', $descricao);

        $stmt->execute();

        echo "Grupo cadastrado com sucesso!";
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }
});

//atualiza dados de um grupo através do id
$app->put('/api/grupo/atualizar/{id}', function(Request $request, Response $response){

    $id        = $request->getAttribute('id');
    $nome      = $request->getParam('nome');
    $tema      = $request->getParam('tema');
    $descricao = $request->getParam('descricao');

    try
    {
        $con = new config();
        $con = $con->conectar();

        $stmt = $con->prepare("UPDATE tb_grupos SET
                                      nome      = :nome, 
                                      tema      = :tema, 
                                      descricao = :descricao
                                WHERE idgrupo = :id");

        $stmt->bindParam(':id',        $id);
        $stmt->bindParam(':nome',      $nome);
        $stmt->bindParam(':tema',      $tema);
        $stmt->bindParam(':descricao', $descricao);

        $stmt->execute();
        
        echo "Grupo atualizado com sucesso!";
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }
});

//efetua a exclusão de um grupo através do seu id
$app->delete('/api/grupo/deletar/{id}', function(Request $request, Response $response){

    $id = $request->getAttribute('id');

    try
    {
        $con = new config();
        $con = $con->conectar();

        $grupoSearch = $con->prepare("SELECT COUNT(P.NOME) AS membro
        FROM TB_PESSOA_GRUPO PG
        RIGHT JOIN TB_PESSOAS P
        ON PG.ID_PESSOA = P.IDPESSOA
        RIGHT JOIN TB_GRUPOS G
        ON PG.ID_GRUPO = G.IDGRUPO
        WHERE G.IDGRUPO = :id
        GROUP BY G.IDGRUPO");

        $grupoSearch->bindParam(':id', $id);

        $grupoSearch->execute();

        $search = $grupoSearch->fetch(PDO::FETCH_ASSOC);

        if(empty($search))
        {
            echo "Grupo solicitado não existe, digite novamente.";
        }
        else if(!empty($search))
        {
            foreach ($search as $result) { $result; }

            if($result <= 2)
            {
                $pessoaGrupo = $con->prepare("DELETE FROM tb_pessoa_grupo WHERE id_grupo = :id");
                $pessoaGrupo->bindParam(":id", $id);
                $pessoaGrupo->execute();

                $stmt = $con->prepare("DELETE FROM tb_grupos WHERE idgrupo = :id");
                $stmt->bindParam(":id", $id);
                $stmt->execute();
                $con = null;
                echo "Grupo deletado com sucesso!";
            }
            else
            {
                echo "O grupo não pode ser excluído pois possui 3 ou mais membros!";
            }
        }
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }
});

//exibe todos os membros cadastrados junto aos seus respectivos grupos
$app->get('/api/grupos/membros', function(Request $request, Response $response){
    try
    {
        $con = new config();
        $con = $con->conectar();

        $stmt = $con->prepare("SELECT PG.ID_PG AS ID, G.NOME AS GRUPO, P.NOME AS MEMBRO
        FROM TB_PESSOA_GRUPO PG
        INNER JOIN TB_PESSOAS P
        ON PG.ID_PESSOA = P.IDPESSOA
        INNER JOIN TB_GRUPOS G
        ON PG.ID_GRUPO = G.IDGRUPO
        ORDER BY PG.ID_PG");

        $stmt->execute();

        $detalhes = $stmt->fetchAll(PDO::FETCH_OBJ);
        $con = null;
        echo json_encode($detalhes);
        
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }
});

//exibe membros do grupo através do seu id
$app->get('/api/grupos/membro/{id}', function(Request $request, Response $response){

    $id = $request->getAttribute('id');

    try
    {
        $con = new config();
        $con = $con->conectar();

        $stmt = $con->prepare("SELECT PG.ID_PG AS ID, G.NOME AS GRUPO, P.NOME AS MEMBRO
        FROM TB_PESSOA_GRUPO PG
        INNER JOIN TB_PESSOAS P
        ON PG.ID_PESSOA = P.IDPESSOA
        INNER JOIN TB_GRUPOS G
        ON PG.ID_GRUPO = G.IDGRUPO
        WHERE PG.ID_PESSOA = :id");

        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $detalhes = $stmt->fetchAll(PDO::FETCH_OBJ);
        $con = null;
        echo json_encode($detalhes);
        
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }
});


//adicionar um membro a um grupo
$app->post('/api/grupo/membro/adicionar', function(Request $request, Response $response){

    $idgrupo  = $request->getParam('idgrupo');
    $idpessoa = $request->getParam('idpessoa');
    
    try
    {
        $con = new config();
        $con = $con->conectar();

        $pesqGrupo = $con->prepare("SELECT * FROM tb_grupos WHERE idgrupo = :idgrupo");

        $pesqGrupo->bindParam(':idgrupo' , $idgrupo);

        $pesqGrupo->execute();

        $pg = $pesqGrupo->rowCount();

        $pesqPessoa = $con->prepare("SELECT * FROM tb_pessoas WHERE idpessoa = :idpessoa");
        
        $pesqPessoa->bindParam(':idpessoa', $idpessoa);

        $pesqPessoa->execute();

        $pp = $pesqPessoa->rowCount();

        if($pg == 0)
        {
            echo "Grupo não cadastrado, por favor, digite novamente";
        }
        else if($pp == 0)
        {
            echo "Pessoa não cadastrada, por favor, digite novamente";
        }
        else
        {
            $search = $con->prepare("SELECT * FROM tb_pessoa_grupo WHERE id_grupo = :idgrupo AND id_pessoa = :idpessoa");

            $search->bindParam(':idgrupo' , $idgrupo);
            $search->bindParam(':idpessoa', $idpessoa);

            $search->execute();

            $result = $search->rowCount();

            if($result > 0)
            {
                echo "Membro já cadastrado neste grupo.";
            }
            else
            {
                $stmt = $con->prepare("INSERT INTO tb_pessoa_grupo (id_grupo, id_pessoa) 
                VALUES (:idgrupo, :idpessoa)");

                $stmt->bindParam(':idgrupo' , $idgrupo);
                $stmt->bindParam(':idpessoa', $idpessoa);

                $stmt->execute();

                echo "Membro adicionado ao grupo.";
            }
        }
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }
});

//efetua a exclusão de um membro de um grupo através do seu id
$app->delete('/api/grupo/membro/deletar/{id}', function(Request $request, Response $response){

    $id = $request->getAttribute('id');

    try
    {
        $con = new config();
        $con = $con->conectar();

        $stmt = $con->prepare("SELECT COUNT(P.NOME) AS membro
        FROM TB_PESSOA_GRUPO PG
        RIGHT JOIN TB_PESSOAS P
        ON PG.ID_PESSOA = P.IDPESSOA
        RIGHT JOIN TB_GRUPOS G
        ON PG.ID_GRUPO = G.IDGRUPO
        WHERE G.IDGRUPO = (SELECT ID_GRUPO FROM TB_PESSOA_GRUPO WHERE ID_PG = :id)
        GROUP BY G.IDGRUPO");

        $stmt->bindParam(':id', $id);

        $stmt->execute();

        $search = $stmt->fetch(PDO::FETCH_ASSOC);

        if(empty($search))
        {
            echo "Membro solicitado não existe, digite novamente.";
        }
        else if(!empty($search))
        {
            foreach ($search as $result) {$result;}
               
            if($result == 2)
            {
                echo "O membro não pode ser excluído do grupo, pois o grupo esta com 2 membros.";
            }
            else
            {
                $stmt = $con->prepare("DELETE FROM tb_pessoa_grupo WHERE id_pg = :id");
                $stmt->bindParam(":id", $id);
                $stmt->execute();
                $con = null;
                echo "Membro deletado com sucesso!";
            }
        }
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }
});

?>