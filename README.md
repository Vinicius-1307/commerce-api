API de Gerenciamento de Jogos de Futsal - Laravel

Bem-vindo à API de Gerenciamento de Comércios em geral construída com Laravel. Esta API permite o gerenciamento de produtos, estoques, valores e autenticação de usuários com JWT. É uma ferramenta poderosa para administrar informações relacionadas a comércio de forma eficaz e eficiente.

**Configuração:**

Antes de começar a usar a API Laravel, siga as etapas a seguir para configurar o ambiente:

1.	Clonar o repositório:

    •	git clone https://github.com/Vinicius-1307/commerce-api.git

2.	Instalar dependências:	

    •	```composer install```

3.	Configurar Variáveis de Ambiente:
Copie o arquivo ```.env.example``` para ```.env``` e configure as seguintes variáveis de ambiente:

    •	```DB_CONNECTION```: Defina a conexão com o banco de dados (por exemplo, mysql).
  	
    •	```DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD```: Configure as informações do banco de dados.
  	
    •	```JWT_SECRET```: Sua chave secreta para autenticação JWT.

5.	Gerar uma Chave de Aplicativo:
   
    Execute o comando ```php artisan key:generate``` para gerar uma chave de aplicativo.

6.	Executar Migrações:

    Execute as migrações para criar as tabelas no banco de dados:
    ```php artisan migrate```

7.	Iniciar o servidor de desenvolvimento:

    ```php artisan serve```

**Endpoints:**

As rotas estão sendo documentadas via [Postman](https://www.postman.com), porém ainda não estão prontas.



**Contato:**
Se você tiver alguma dúvida ou precisar de assistência, entre em contato com viniciusjose9@outlook.com.

Aproveite a API de Gerenciamento de Comércios construída com Laravel!	

	
