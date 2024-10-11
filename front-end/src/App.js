import React from 'react';
import ClientRegister from './components/ClientRegister';
import 'bootstrap/dist/css/bootstrap.min.css';
// import 'bootstrap/dist/css/bootstrap.min.css';
// import logo from './logo.svg';
import './App.css';

function App() {
    return (
        <div className="App">
          <h1>Cadastro de Cliente</h1>
          <ClientRegister />
        </div>
    );
}

export default App;
