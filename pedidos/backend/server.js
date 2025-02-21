// Backend (server.js)
const express = require("express");
const mysql = require("mysql2");
const cors = require("cors");

const app = express();
const allowedOrigins = [
  '192.168.0.20',
  '192.168.0.18:3001',
  'http://localhost:3000', // Para desarrollo local
];

app.use(cors({
  origin: function (origin, callback) {
      // Permitir solicitudes sin origen (como aplicaciones móviles o curl)
      if (!origin) return callback(null, true);

      if (allowedOrigins.indexOf(origin) === -1) {
          const msg = 'El origen de la solicitud no está permitido.';
          return callback(new Error(msg), false);
      }
      return callback(null, true);
  },
  credentials: true
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