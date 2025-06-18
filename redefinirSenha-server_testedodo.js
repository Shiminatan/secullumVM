const express = require("express");
const mysql = require("mysql");
const cors = require("cors");
const bodyParser = require("body-parser");

const app = express();
app.use(cors());
app.use(bodyParser.json());

const db = mysql.createConnection({
  host: "20.206.161.175", // IP da VM
  user: "root", // Usuário do banco
  password: "", // Senha do banco
  database: "formulariovms", // Nome do banco de dados
  port: 3306, // Porta do MySQL (padrão)
  ssl: { rejectUnauthorized: false } // Caso a conexão use SSL, necessário para algumas configurações da Azure
});

db.connect(err => {
  if (err) {
    console.error("Erro ao conectar ao MySQL:", err);
  } else {
    console.log("Conectado ao MySQL na VM da Azure!");
  }
});


app.post("/reset-password", (req, res) => {
  const { usuario, novaSenha } = req.body;

  // Verifica se o usuário existe no banco
  db.query(
    "SELECT * FROM usuarios WHERE nome = ?",
    [usuario],
    (err, results) => {
      if (err) {
        console.error("Erro ao buscar usuário:", err);
        res.status(500).json({ message: "Erro no servidor." });
        return;
      }

      if (results.length === 0) {
        res.status(404).json({ message: "Usuário não encontrado!" });
        return;
      }

      // Atualiza a senha apenas se o usuário existir
      const updateQuery = "UPDATE usuarios SET senha = ? WHERE nome = ?";
      db.query(updateQuery, [novaSenha, usuario], (updateErr) => {
        if (updateErr) {
          console.error("Erro ao atualizar a senha:", updateErr);
          res.status(500).json({ message: "Erro ao redefinir senha." });
        } else {
          res.json({ message: "Senha redefinida com sucesso!" });
        }
      });
    }
  );
});

app.listen(3000, () => {
  console.log("Servidor rodando na porta 3000");
});
