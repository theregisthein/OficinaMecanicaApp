# 🔧 Sistema de Gestão de Oficina Mecânica

Este é um sistema completo para gerenciamento de oficinas mecânicas, desenvolvido com uma arquitetura distribuída utilizando **Laravel (PHP)** no Frontend e **Spring Boot (Java)** no Backend, com comunicação via API REST.

## 🚀 Sobre o Projeto

O sistema permite o cadastro e gerenciamento de clientes, veículos, peças/serviços e a emissão de Ordens de Serviço (OS). A arquitetura foi desenhada para separar responsabilidades, utilizando um padrão de microserviços/proxy.

### 🏗️ Arquitetura do Sistema

O fluxo de dados segue a seguinte ordem:

1.  **Frontend (Laravel):** Interface do usuário (Blade Templates). Envia requisições HTTP para o Proxy.
2.  **Backend Proxy (Java - Porta 8080):** Recebe as requisições do Frontend, molda os dados (DTOs) e repassa para a API Core.
3.  **Backend Core API (Java - Porta 9090):** Contém a lógica de negócios, regras de validação e acesso direto ao Banco de Dados.
4.  **Banco de Dados (MySQL):** Armazena todas as informações com integridade referencial rigorosa.

---

## 🛠️ Tecnologias Utilizadas

* **Frontend:**
    * PHP 8.2+
    * Laravel Framework
    * Blade Templates
    * Bootstrap 5 (Interface)
    * JavaScript (Manipulação de itens da OS)
* **Backend:**
    * Java 17
    * Spring Boot 3
    * Spring Data JPA / Hibernate
    * Maven
* **Banco de Dados:**
    * MySQL / MariaDB (XAMPP)

---

## ⚙️ Pré-requisitos

Para rodar o projeto localmente, você precisará de:

* **Java JDK 17** instalado.
* **PHP 8.2+** e **Composer** instalados.
* **MySQL** rodando (Recomendado: XAMPP ou Docker).
* **Maven** (opcional, se usar IDE como VS Code ou IntelliJ o Maven já vem embutido).

---

## 📦 Como Rodar o Projeto

Siga a ordem abaixo para evitar erros de conexão.

### 1. Configuração do Banco de Dados
1.  Crie um banco de dados MySQL chamado `oficina`.
2.  Importe o arquivo `database.sql` (disponível na pasta `/docs` ou raiz) para criar as tabelas (`pessoa`, `veiculo`, `item`, `ordemservico`, `OS_Item`) com as devidas chaves estrangeiras.

### 2. Rodando a API Core (Porta 9090)
Esta é a aplicação que conecta no banco.
1.  Acesse a pasta do projeto `APIRest`.
2.  Verifique o arquivo `src/main/resources/application.properties` e confirme se as credenciais do banco (user/password) estão corretas.
3.  Inicie a aplicação Java.
    * *Via VS Code:* Abra a classe `DemoApplication.java` e clique em "Run".
    * *Via Terminal:* `mvn spring-boot:run`

### 3. Rodando o Proxy (Porta 8080)
Esta aplicação intermedeia a comunicação.
1.  Acesse a pasta do projeto `BackendProxy` (ou nome correspondente).
2.  Inicie a aplicação Java (da mesma forma que a API).
3.  Certifique-se de que ela subiu na porta **8080**.

### 4. Rodando o Frontend (Laravel - Porta 8000)
1.  Acesse a pasta do projeto `frontend`.
2.  Instale as dependências (se for a primeira vez):
    ```bash
    composer install
    cp .env.example .env
    php artisan key:generate
    ```
3.  Inicie o servidor local:
    ```bash
    php artisan serve
    ```
4.  Acesse no navegador: `http://localhost:8000`

---

## 🔌 Endpoints Principais (Documentação API)

O Frontend se comunica com o Proxy através das seguintes rotas base:

| Recurso | Método | Rota Proxy (8080) | Descrição |
| :--- | :---: | :--- | :--- |
| **Itens** | GET | `/items-proxy` | Lista peças e serviços |
| | POST | `/items-proxy` | Cria novo item |
| **Veículos** | GET | `/veiculos-proxy` | Lista veículos |
| | POST | `/veiculos-proxy` | Cria novo veículo |
| **Pessoas** | GET | `/pessoas-proxy` | Lista clientes |
| | POST | `/pessoas-proxy` | Cria novo cliente |
| **Ordens** | GET | `/ordens-proxy` | Lista OS com itens aninhados |
| | POST | `/ordens-proxy` | Cria OS (JSON hierárquico) |
| | PUT | `/ordens-proxy/{id}` | Atualiza OS e seus itens |

---

## 🛡️ Regras de Negócio e Segurança

* **Integridade de Dados:** O banco de dados utiliza `ON DELETE RESTRICT`. Não é possível excluir Clientes, Veículos ou Itens que estejam vinculados a uma Ordem de Serviço existente.
* **Formato de Dados:** O sistema trata automaticamente a conversão de datas (BR <-> ISO) e valores monetários para garantir compatibilidade entre PHP e Java.
* **Validação:** O Frontend valida campos obrigatórios e o Backend valida a existência das entidades relacionadas.

---

## 🤝 Contribuição

1.  Faça um Fork do projeto.
2.  Crie uma Branch para sua Feature (`git checkout -b feature/MinhaFeature`).
3.  Faça o Commit (`git commit -m 'Adicionando nova feature'`).
4.  Faça o Push (`git push origin feature/MinhaFeature`).
5.  Abra um Pull Request.

---

**Desenvolvido por [Régis Thein Rinaldi]**
Dev em Formação 🚀
