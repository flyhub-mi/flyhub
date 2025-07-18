import { Button, Form, Modal, Tab, Table } from 'react-bootstrap';
import React, { useEffect, useState } from 'react';
import Swal from 'sweetalert2';
import { Formik } from 'formik';
import * as Yup from 'yup';

import API from '../../../../services/api';
import InputField from '../../../../formik-fields/InputField';
import CheckField from '../../../../formik-fields/CheckField';

const initialValues = { name: '', redirect: '', confidential: false };

const validationSchema = Yup.object().shape({
    name: Yup.string()
        .max(50)
        .required(),
    redirect: Yup.string()
        .max(2083)
        .required(),
    confidential: Yup.boolean().required(),
});

export default function ClientsTab({ eventKey }) {
    const [clients, setClients] = useState([]);
    const [modalVisible, setModalShow] = useState(false);
    const [model, setModel] = useState(initialValues);

    const getTokens = () => {
        new API('/oauth/clients').getAll().then(data => {
            setClients(data);
        });
    };

    useEffect(() => {
        getTokens();
    }, []);

    const editClient = client => {
        setModel(client);
        setModalShow(true);
    };

    const hideModal = () => setModalShow(false);

    const saveClient = values => {
        (values.id
            ? new API('/oauth/clients').update(values)
            : new API('/oauth/clients').create(values).then(getTokens)
        ).then(() => {
            getTokens();
            hideModal();
        });
    };

    const destroy = id => {
        Swal.fire({
            title: 'Deseja revogar este cliente?',
            icon: 'warning',
            showCloseButton: true,
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Confirmar',
            reverseButtons: true,
            focusConfirm: false,
        }).then(result => {
            if (result.value) {
                new API('/oauth/clients').delete(id).then(() => getTokens());
            }
        });
    };

    return (
        <Tab.Pane eventKey={eventKey}>
            <Table responsive>
                <thead>
                    <tr>
                        <th>ID do Cliente</th>
                        <th>Nome</th>
                        <th>Segredo</th>
                        <th className="text-right">
                            <Button variant="outline-primary" onClick={() => setModalShow(true)}>
                                <i className="fas fa-plus" />
                            </Button>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    {clients.map((client, key) => (
                        <tr key={key}>
                            <td>{client.id}</td>
                            <td>{client.name}</td>
                            <td>
                                <code className="p-1">{client.secret}</code>
                            </td>
                            <td className="text-right">
                                <Button variant="outline-secondary" onClick={() => editClient(client)} className="mr-2">
                                    <i className="fas fa-pen" />
                                </Button>

                                <Button variant="outline-danger" onClick={() => destroy(client.id)}>
                                    <i className="fas fa-trash" />
                                </Button>
                            </td>
                        </tr>
                    ))}
                    {clients.length === 0 && (
                        <tr>
                            <td colSpan={3} className="text-center">
                                Nenhum cliente oAuth registrado.
                            </td>
                        </tr>
                    )}
                </tbody>
            </Table>

            <Modal show={modalVisible} onHide={hideModal}>
                <Modal.Header closeButton>
                    <Modal.Title>{model.id ? 'Editar cliente' : 'Criar cliente'}</Modal.Title>
                </Modal.Header>

                <Formik
                    enableReinitialize
                    validationSchema={validationSchema}
                    initialValues={model}
                    onSubmit={saveClient}
                >
                    {({ handleSubmit, isValid, isSubmitting }) => (
                        <Form noValidate onSubmit={handleSubmit}>
                            <Modal.Body>
                                <InputField label="Nome" name="name" />
                                <span className="form-text text-muted pb-3">
                                    Algo que seus usuários reconhecerão e confiarão.
                                </span>
                                <hr className="pb-3" />

                                <InputField label="URL de redirecionamento" name="redirect" />
                                <span className="form-text text-muted">
                                    URL de retorno de chamada de autorização do seu aplicativo.
                                </span>
                                <hr className="pb-3" />

                                <CheckField label="Confidencial" name="confidential" />
                                <span className="form-text text-muted">
                                    Exija que o cliente se autentique com um segredo. Clientes confidenciais podem
                                    manter as credenciais de maneira segura, sem expô-las a terceiros não autorizados.
                                    Aplicativos públicos, como aplicativos de área de trabalho nativa ou JavaScript SPA,
                                    não conseguem guardar segredos com segurança.
                                </span>
                            </Modal.Body>

                            <Modal.Footer>
                                <Button type="button" variant="secondary" onClick={hideModal}>
                                    Cancelar
                                </Button>
                                <Button type="submit" variant="primary" disabled={!isValid || isSubmitting}>
                                    Salvar
                                </Button>
                            </Modal.Footer>
                        </Form>
                    )}
                </Formik>
            </Modal>
        </Tab.Pane>
    );
}
