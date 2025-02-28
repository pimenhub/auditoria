import React, { useEffect, useState } from "react";
import axios from "axios";
import pedidoIcon from "./logo.jpeg"; // Imagen relacionada con pedidos
import "./App.css";

const PedidoTable = ({ pedidos }) => {
  return (
    <div className="table-scroll-container">
    <table className="pedido-table">
      <thead>
        <tr>
        <th>ID</th>
    <th>ID del Cliente</th>
    <th>Producto</th>
    <th>Cantidad</th>
    <th>Precio en Quetzales</th>
    <th>Fecha del Pedido</th>
        </tr>
      </thead>
      <tbody>
        {pedidos.map(pedido => (
          <tr key={pedido.id}>
            <td>{pedido.id}</td>
            <td>{pedido.cliente_id}</td>
            <td>{pedido.producto}</td>
            <td>{pedido.cantidad}</td>
            <td>{pedido.precio}</td>
            <td>{pedido.fecha_pedido}</td>
          </tr>
        ))}
      </tbody>
    </table>
  </div>
  );
};

const App = () => {
  const [pedidos, setPedidos] = useState([]);
  
  const fetchPedidos = () => {
    axios.get("http://192.168.0.18:3001/api/pedidos")
      .then(response => setPedidos(response.data))
      .catch(error => console.error("Error al obtener pedidos:", error));
  };

  useEffect(() => {
    fetchPedidos();
  }, []);

  return (
    <div className="app-container">
      <h1 className="title">Listado de Pedidos</h1>
      <img src={pedidoIcon} alt="Pedidos" className="pedido-icon" />
      <button className="refresh-button" onClick={fetchPedidos}>Actualizar Lista</button>
      <PedidoTable pedidos={pedidos} />
    </div>
  );
};

export default App;