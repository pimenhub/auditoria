// Backend (server.js)
const express = require("express");
const mysql = require("mysql2");
const cors = require("cors");

const app = express();

app.use(cors({
  origin: "*",
  methods: ["GET", "POST", "PUT", "DELETE"],
  allowedHeaders: ["Content-Type", "Authorization"]
}));

app.use(express.json());

// Configuración de la base de datos
const db = mysql.createConnection({
  host: "192.168.0.20",
  user: "dba",
  password: "Admin.*", // Cambia por tu contraseña si tienes una
  database: "DB_Tienda"
});

db.connect(err => {
  if (err) {
    console.error("Error conectando a MySQL: ", err);
    return;
  }
  console.log("Conectado a la base de datos MySQL");
});

// Endpoint para obtener los pedidos
app.get("/api/pedidos", (req, res) => {
  db.query("SELECT * FROM pedido", (err, results) => {
    if (err) {
      res.status(500).json({ error: err.message });
    } else {
      res.json(results);
    }
  });
});

app.listen(3001, () => {
  console.log("Servidor backend corriendo en puerto 3001");
});