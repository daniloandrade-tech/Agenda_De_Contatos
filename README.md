# Resumo do Projeto: Sistema de Agenda de Contatos (CRUD)

Este documento apresenta uma visão consolidada do projeto de **Agenda de Contatos**, uma aplicação web focada no gerenciamento de dados cadastrais desenvolvida utilizando a stack tradicional LAMP (Linux, Apache, MySQL, PHP), HTML5 e CSS3.

## 1. Visão Geral e Propósito do Sistema

O objetivo principal do projeto é disponibilizar uma solução leve, funcional e intuitiva para o gerenciamento de informações de contatos pessoais ou profissionais. A aplicação foi concebida sob o padrão **CRUD** (*Create, Read, Update, Delete*), permitindo que o usuário mantenha um registro atualizado de pessoas e suas respectivas informações de contato.

Além da utilidade prática como ferramenta de organização pessoal, o projeto serve como um modelo fundamental para o aprendizado e demonstração de conceitos essenciais do desenvolvimento web full-stack, incluindo o manuseio de formulários, comunicação com banco de dados relacional e renderização dinâmica no servidor.

## 2. Arquitetura e Stack de Tecnologias

A aplicação adota uma arquitetura monolítica simplificada baseada no processamento server-side.

| Camada | Tecnologia | Função no Sistema |
| :--- | :--- | :--- |
| **Interface (Frontend)** | **HTML5** | Estruturação de formulários de captura, listas de exibição e tabelas de dados. |
| **Estilização** | **CSS3** | Estilização visual dos componentes, layout responsivo e usabilidade da interface. |
| **Backend (Regras de Negócio)** | **PHP** | Processamento de requisições HTTP, validação de inputs e integração com o banco de dados via PDO/MySQLi. |
| **Persistência** | **MySQL** | Armazenamento relacional de tabelas de contatos com chaves primárias e tipos de dados adequados. |
| **Servidor Web** | **Apache** | Processamento e execução das rotas e scripts PHP (ambiente local via XAMPP/WAMP). |

## 3. Módulos e Funcionalidades Principais (CRUD)

O sistema organiza suas rotas operacionais em torno de quatro ações fundamentais:

1. **Cadastro de Contatos (Create)**
   * Formulário dedicado para inserção de dados como nome completo, telefone, e-mail, endereço e observações.
   * Validação de campos obrigatórios no servidor antes da gravação na base de dados.

2. **Consulta e Listagem (Read)**
   * Painel de exibição tabular listando todos os contatos ativos armazenados no banco de dados.
   * Mecanismo de busca e filtragem para localização rápida por nome ou telefone.

3. **Atualização de Dados (Update)**
   * Interface de edição que recupera os dados existentes do contato selecionado e preenche o formulário.
   * Processamento das alterações com atualização atômica do registro no MySQL.

4. **Remoção de Registros (Delete)**
   * Exclusão definitiva ou lógica de contatos com confirmação de segurança para evitar exclusões acidentais.

## 4. Banco de Dados e Estrutura Relacional

A persistência dos dados é gerida por uma tabela relacional simples no MySQL, estruturada da seguinte forma:

```sql
CREATE TABLE contatos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    telefone VARCHAR(20) NOT NULL,
);
```

## 5. Estratégia de Implantação e Hospedagem

Para colocar a aplicação em produção em um ambiente online de forma acessível e gratuita, o projeto suporta implantação em provedores de hospedagem compartilhada com suporte à stack PHP/MySQL:

* **InfinityFree / AlwaysData**: Provedores recomendados para hospedagem gratuita de aplicações PHP com banco de dados MySQL/MariaDB e acesso ao phpMyAdmin.
* **Procedimento de Deploy**: Envio dos arquivos estáticos e scripts PHP via cliente **FTP** (como FileZilla) e execução dos scripts DDL via **phpMyAdmin** para criação da estrutura do banco.

