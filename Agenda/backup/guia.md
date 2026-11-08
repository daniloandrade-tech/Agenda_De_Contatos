# 🚀 Guia de Configuração

### Pré-requisitos
* XAMPP instalado.
* MySQL Workbench (ou outro cliente SQL de sua preferência).

---

### Passo a Passo

1. **Baixar e extrair o projeto:**
   * Baixe o arquivo `.zip` do projeto e extraia o seu conteúdo dentro da pasta `xampp/htdocs/`.
   * Certifique-se de que a pasta extraída se chame **Agenda**.

2. **Iniciar os serviços no XAMPP:**
   * Abra o **XAMPP Control Panel**.
   * Clique em **Start** nos serviços **Apache** e **MySQL**.

3. **Criar e popular o Banco de Dados:**
   * Abra o **MySQL Workbench** e conecte-se ao seu servidor local.
   * Abra e execute o arquivo `.sql` que acompanha o projeto para criar a base de dados e as tabelas.

4. **Configurar a conexão PHP (se necessário):**
   * Verifique no arquivo de configuração do projeto (ex: `conexao.php`) se o usuário (`root`), senha e porta do banco correspondem às configurações do seu ambiente local.

5. **Executar a aplicação:**
   * Abra o navegador de sua preferência.
   * Acesse a URL: `http://localhost/Agenda/index.php` (ou apenas `http://localhost/Agenda/`).
