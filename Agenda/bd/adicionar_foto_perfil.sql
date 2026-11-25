-- Para bancos existentes sem a coluna foto; o script completo já a inclui.
ALTER TABLE usuarios
ADD COLUMN IF NOT EXISTS foto VARCHAR(255) NULL;
