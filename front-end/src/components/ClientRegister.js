import React, { useState } from 'react';

const ClientRegister = () => {
    const [formData, setFormData] = useState({
        razaoSocial: '',
        cnpj: '',
        email: ''
    });
    const [message, setMessage] = useState('');

    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData({
            ...formData,
            [name]: value
        });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            const response = await fetch('http://localhost:8000/api/clientes', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(formData),
            });

            if (!response.ok) {
                throw new Error('Erro ao cadastrar cliente!');
            }

            await response.json();
            setMessage('Cliente cadastrado com sucesso!');
            setFormData({
                razaoSocial: '',
                cnpj: '',
                email: ''
            });
        } catch (error) {
            setMessage(`Erro: ${error.message}`);
        }
    };

    const handleCnpjSearch = async (event) => {
        event.preventDefault();
        try {
            const response = await fetch(`http://localhost:8000/api/consulta-cnpj/${formData.cnpj}`);

            if (!response.ok) {
                throw new Error('Erro ao consultar CNPJ!');
            }

            const data = await response.json();
            if (data.success) {
                setFormData({
                    ...formData,
                    razaoSocial: data.client.razao_social,
                    email: data.client.email
                });
            } else {
                throw new Error(data.message);
            }
        } catch (error) {
            setMessage(`Erro: ${error.message}`);
        }
    };

    return (
        <div className='container mt-5'>
            <form onSubmit={handleSubmit}>
                <div className="row justify-content-center">
                    <div className='col-md-2'>
                        <label>Razão Social:</label>
                        <input
                            className="my-1"
                            type="text"
                            name="razaoSocial"
                            value={formData.razaoSocial}
                            onChange={handleChange}
                            required
                        />
                    </div>
                    <div className='col-md-2'>
                        <label>CNPJ:</label>
                        <div className="input-group">
                            <input
                                className="my-1 form-control"
                                type="text"
                                name="cnpj"
                                value={formData.cnpj}
                                onChange={handleChange}
                                required
                            />
                        </div>
                            <button type="button" className="btn btn-sm btn-success" onClick={handleCnpjSearch}>
                                Buscar
                            </button>
                    </div>
                    <div className='col-md-2'>
                        <label>Email:</label>
                        <input
                            className="my-1"
                            type="email"
                            name="email"
                            value={formData.email}
                            onChange={handleChange}
                            required
                        />
                    </div>
                </div>
            </form>
            {message && <p>{message}</p>}
        </div>
    );
};

export default ClientRegister;
