# API CRUD COM PHP E MYSQL

Bruno Rocha de Lima - obrunorocha@outlook.com

Rotas:

# Gestão de pessoas
Exibir todas as pessoas cadastradas

http://localhost/goomer/public/api/pessoas

Exibir pessoa cadastrada através do id

http://localhost/goomer/public/api/pessoa/id

	Ex: http://localhost/goomer/public/api/pessoa/1

Efetuar cadastro de uma pessoa

http://localhost/goomer/public/api/pessoa/cadastrar

	Exemplo de cadastro:

	{
		"nome": "FULANO",
		"email": "FULANO@EMAIL.COM",
		"senha": "123456",
		"cpf": "37303778098",
		"telefone": "15912345678",
		"endereco": "RUA FULANO DE TAL 123, JD FULANO - SAO PAULO - SP"
	}

Atualizar dados de uma pessoa cadastrada através do id

http://localhost/goomer/public/api/pessoa/atualizar/id

	Exemplo de como atualizar dados de uma pessoa cadastrada:

	Inserir o id no endereço da rota
	http://localhost/goomer/public/api/pessoa/atualizar/1

	E enviar as alterações:

	{
		"nome": "TESTE",
		"email": "TESTE@EMAIL.COM",
		"senha": "998877",
		"cpf": "11122233344",
		"telefone": "11999991234",
		"endereco": "RUA DO TESTE 456, JD TESTE - TESTE - SP"
	}

Deletar uma pessoa cadastrada através do id

http://localhost/goomer/public/api/pessoa/deletar/id

	Ex: http://localhost/goomer/public/api/pessoa/deletar/1

# Gestão de grupos de discussão

Exibir todos os grupos cadastrados

http://localhost/goomer/public/api/grupos

Exibir apenas um grupo cadastrado através do seu id

http://localhost/goomer/public/api/grupos/id

	Ex: http://localhost/goomer/public/api/grupos/1

Efetuar o cadastro de um grupo

http://localhost/goomer/public/api/grupo/cadastrar

	Exemplo de cadastro de grupo

	Enviar os dados da seguinte maneira
	{
		"nome": "IOGA",
		"tema": "GINASTICA",
		"descricao": "ESTE GRUPO DESTINA-SE A PESSOAS QUE PRATICAM IOGA"
	}

Efetuar atualização do grupo através do id

http://localhost/goomer/public/api/grupo/atualizar/id

	Exemplo de como atualizar dados do grupo:
	
	Inserir o id de identificação do grupo
	http://localhost/goomer/public/api/grupo/atualizar/1
	
	E enviar as alterações:
	
	{
		"nome": "TECNOLOGIA",
		"tema": "INFORMATICA",
		"descricao": "ESTE GRUPO DESTINA-SE A PESSOAS QUE AMAM TUDO SOBRE INFORMATICA"
	}

Efetua a exclusão de um grupo através do id

http://localhost/goomer/public/api/grupo/deletar/id

	Ex: http://localhost/goomer/public/api/grupo/deletar/1

Exibe todos os membros cadastrados junto aos seus respectivos grupos

http://localhost/goomer/public/api/grupos/membros

Exibe apenas um membro associado a grupos através do id

http://localhost/goomer/public/api/grupos/membro/id

	Ex: http://localhost/goomer/public/api/grupos/membro/1

Adicionar um membro a um grupo

http://localhost/goomer/public/api/grupo/membro/adicionar

	Exemplo de como adicionar um membro a um grupo
	
	Passar os seguintes parametros com o id do grupo e o id da pessoa
	{
		"idgrupo":"1",
		"idpessoa":"1"
    }

Efetua a exclusão de um membro de um grupo através do seu id associativo

http://localhost/goomer/public/api/grupo/membro/deletar/id

Neste caso o id a ser inserido para exclusão vem da rota 

http://localhost/goomer/public/api/grupos/membros 

	Ex: http://localhost/goomer/public/api/grupo/membro/deletar/1

Obs: Antes de iniciar os testes, efetuar a criação do Banco de Dados utilizando o arquivo sqlGoomer.sql;

# Referências:

Documentação PHP

http://php.net/manual/pt_BR/index.php

Slim Framework

https://www.slimframework.com/

Composer

https://getcomposer.org/

Ferramentas de Desenvolvimento 

Visual Studio Code

https://code.visualstudio.com/

WampServer

http://www.wampserver.com/

Banco de dados - Mysql
