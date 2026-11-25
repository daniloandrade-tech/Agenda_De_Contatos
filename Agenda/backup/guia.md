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
   * Para uma instalação de teste do zero, execute `Agenda/bd/bd_agenda_script.sql`. **Esse script apaga e recria o banco `agenda` e todos os dados nele.**
   * Para manter um banco existente sem apagar seus dados, não execute o script completo; se a tabela `usuarios` ainda não tiver a coluna `foto`, execute `Agenda/bd/adicionar_foto_perfil.sql`.

4. **Configurar a conexão PHP:**
   * Em hospedagem InfinityFree, confirme os dados em **MySQL Databases** e configure `Agenda/config/database.php`.
   * Envie esse arquivo junto com o projeto; a pasta `config` bloqueia acesso HTTP direto às credenciais.

5. **Executar a aplicação:**
   * Abra o navegador de sua preferência.
   * Acesse a URL: `http://localhost/Agenda/index.php` (ou apenas `http://localhost/Agenda/`).
