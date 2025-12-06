# 🔧 Sistema de Gestão de Oficina Mecânica

Este é um sistema completo para gerenciamento de oficinas mecânicas, desenvolvido com uma arquitetura distribuída utilizando **Laravel (PHP)** no Frontend e **Spring Boot (Java)** no Backend, com comunicação via API REST e integração com **Inteligência Artificial (Google Gemini)** para análise de dados.

## 🚀 Sobre o Projeto

O sistema permite o cadastro e gerenciamento de clientes, veículos, peças/serviços e a emissão de Ordens de Serviço (OS). Além disso, conta com um módulo de IA que gera relatórios gerenciais estratégicos automaticamente.

### 🏗️ Arquitetura do Sistema

O fluxo de dados segue a seguinte ordem:

1.  **Frontend (Laravel):** Interface do usuário (Blade Templates). Envia requisições HTTP para o Backend.
2.  **Backend Proxy (Java - Porta 8080):** Recebe as requisições do Frontend, molda os dados (DTOs) e repassa para a API Core.
3.  **Backend Core API (Java - Porta 9090):** Contém a lógica de negócios, regras de validação, acesso ao Banco de Dados e **integração com a IA**.
4.  **Google Gemini AI:** Serviço externo consumido pelo Backend para gerar análises de faturamento e insights.
5.  **Banco de Dados (MySQL):** Armazena todas as informações com integridade referencial rigorosa.

---

## 🛠️ Tecnologias Utilizadas

* **Frontend:**
    * PHP 8.2+
    * Laravel Framework
    * Blade Templates
    * Bootstrap 5 (Interface)
    * JavaScript (UX e Loading States)
* **Backend:**
    * Java 17
    * Spring Boot 3
    * Spring Data JPA / Hibernate
    * **Google Gemini API** (IA Generativa v1beta)
    * Java HttpClient (Integração API Externa)
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
* **Chave de API do Google Gemini** (Gratuita via Google AI Studio).

---

## 📦 Como Rodar o Projeto

Siga a ordem abaixo para evitar erros de conexão.

### 1. Configuração do Banco de Dados
1.  Crie um banco de dados MySQL chamado `oficina`.
2.  Importe o arquivo `database.sql` (disponível na pasta `/docs` ou raiz) para criar as tabelas e relacionamentos.

### 2. Rodando a API Core (Porta 9090)
Esta é a aplicação que conecta no banco e na IA.
1.  Acesse a pasta do projeto `APIRest`.
2.  Abra o arquivo `src/main/resources/application.properties`.
3.  Configure o banco de dados e adicione sua chave de IA:
    ```properties
    spring.datasource.url=jdbc:mysql://localhost:3306/oficina
    spring.datasource.username=root
    spring.datasource.password=
    
    # Configuração da IA
    gemini.api.key=SUA_CHAVE_AIza_AQUI
    ```
4.  Inicie a aplicação Java (`mvn spring-boot:run`).

### 3. Rodando o Proxy (Porta 8080)
Esta aplicação intermedeia a comunicação.
1.  Acesse a pasta do projeto `BackendProxy`.
2.  Inicie a aplicação Java.
3.  Certifique-se de que ela subiu na porta **8080**.

### 4. Rodando o Frontend (Laravel - Porta 8000)
1.  Acesse a pasta do projeto `frontend`.
2.  Instale as dependências:
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

O Frontend se comunica com o Backend através das seguintes rotas base:

| Recurso | Método | Rota | Descrição |
| :--- | :---: | :--- | :--- |
| **Itens** | GET | `/items-proxy` | Lista peças e serviços |
| **Veículos** | GET | `/veiculos-proxy` | Lista veículos |
| **Pessoas** | GET | `/pessoas-proxy` | Lista clientes |
| **Ordens** | GET | `/ordens-proxy` | Lista OS com itens aninhados |
| | POST | `/ordens-proxy` | Cria OS (JSON hierárquico) |
| **Inteligência** | POST | `/ia/gerar-relatorio` | **[NOVO]** Analisa dados e gera relatório via IA |

---

## 🤖 Funcionalidade de IA

O sistema possui um menu **"Relatórios IA"**. Ao clicar em gerar:
1.  O Backend coleta todos os dados de vendas, clientes e veículos.
2.  Envia um prompt estruturado para o **Google Gemini 1.5 Flash**.
3.  A IA analisa os dados e retorna um resumo executivo em HTML.
4.  O Frontend exibe faturamento total, clientes top-tier e veículos recorrentes.

---

## 🛡️ Regras de Negócio e Segurança

* **Integridade de Dados:** O banco de dados utiliza `ON DELETE RESTRICT`. Não é possível excluir Clientes, Veículos ou Itens que estejam vinculados a uma Ordem de Serviço.
* **Segurança da API:** A chave da IA é protegida no Backend e enviada via Header (`x-goog-api-key`), não ficando exposta no Frontend.
* **Tratamento de Erros:** O sistema detecta automaticamente se a API da IA está indisponível e avisa o usuário sem quebrar a aplicação.

---

## 🤝 Contribuição

1.  Faça um Fork do projeto.
2.  Crie uma Branch para sua Feature (`git checkout -b feature/MinhaFeature`).
3.  Faça o Commit (`git commit -m 'Adicionando nova feature'`).
4.  Faça o Push (`git push origin feature/MinhaFeature`).
5.  Abra um Pull Request.

---

**Desenvolvido por Régis Thein Rinaldi**
Dev em Formação 🚀