import { Button, Form, Modal, Tab, Table } from 'react-bootstrap';
import React, { useEffect, useState } from 'react';
import Swal from 'sweetalert2';
import * as Yup from 'yup';
import { Formik } from 'formik';

import API from '../../../../services/api';
import InputField from '../../../../formik-fields/InputField';
import SelectField from '../../../../formik-fields/SelectField';

const initialValues = { name: '', redirect: '', confidential: false };

const validationSchema = Yup.object().shape({
    name: Yup.string()
        .max(50)
        .required(),
    scopes: Yup.array(),
});

const copyAccessTokenHTML = accessToken => {
    const elInput = document.createElement('input');
    elInput.type = 'text';
    elInput.value = accessToken;
    elInput.classList = 'form-control';

    const elButton = document.createElement('button');
    elButton.innerText = 'Copiar';
    elButton.classList = 'btn btn-outline-primary';
    elButton.onclick = () => navigator.clipboard.writeText(accessToken);

    const spanInputGroup = document.createElement('span');
    spanInputGroup.classList = 'input-group-btn';
    spanInputGroup.appendChild(elInput);
    spanInputGroup.appendChild(elButton);

    const divInputGroup = document.createElement('div');
    divInputGroup.classList = 'input-group';
    divInputGroup.appendChild(elInput);
    divInputGroup.appendChild(spanInputGroup);

    return divInputGroup;
};

export default function PersonalAccessTokensTab({ eventKey }) {
    const [scopes, setScopes] = useState([]);
    const [personalAccessTokens, setPersonalAccessTokens] = useState([]);
    const [modalVisible, setModalShow] = useState(false);
    const [model, setModel] = useState(initialValues);

    const getTokens = () => {
        new API('/oauth/scopes').getAll().then(setScopes);
        new API('/oauth/personal-access-tokens').getAll().then(setPersonalAccessTokens);
    };

    useEffect(() => {
        getTokens();
    }, []);

    const editPersonalAccessToken = pToken => {
        setModel(pToken);
        setModalShow(true);
    };

    const hideModal = () => setModalShow(false);

    const savePersonalAccessToken = async values => {
        const response = values.id
            ? await new API('/oauth/personal-access-tokens').update(values)
            : await new API('/oauth/personal-access-tokens').create(values);

        getTokens();

        setModalShow(false);

        Swal.fire({
            title: 'Salve a chave de acesso, pois não poderá visualizar novamente.',
            icon: 'warning',
            html: copyAccessTokenHTML(response.accessToken),
        });
    };

    const destroy = id => {
        Swal.fire({
            title: 'Deseja revogar este token de acesso pessoal?',
            icon: 'warning',
            showCloseButton: true,
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Confirmar',
            reverseButtons: true,
            focusConfirm: false,
        }).then(result => {
            if (result.value) new API('/oauth/personal-access-tokens').delete(id).then(() => getTokens());
        });
    };

    return (
        <Tab.Pane eventKey={eventKey}>
            <Table responsive>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Escopos</th>
                        <th className="text-right">
                            <Button variant="outline-primary" onClick={() => setModalShow(true)}>
                                <i className="fas fa-plus" />
                            </Button>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    {personalAccessTokens.map(pToken => (
                        <tr key={pToken.id}>
                            <td>{pToken.name}</td>
                            <td>{pToken.scopes.join(', ')}</td>
                            <td className="text-right">
                                <Button
                                    variant="outline-secondary"
                                    onClick={() => editPersonalAccessToken(pToken)}
                                    className="mr-2"
                                >
                                    <i className="fas fa-pencil" />
                                </Button>

                                <Button variant="outline-danger" onClick={() => destroy(pToken.id)}>
                                    <i className="fas fa-trash" />
                                </Button>
                            </td>
                        </tr>
                    ))}
                    {personalAccessTokens.length === 0 && (
                        <tr>
                            <td colSpan={3} className="text-center">
                                Nenhuma chave de acesso pessoal registrada.
                            </td>
                        </tr>
                    )}
                </tbody>
            </Table>

            <Modal show={modalVisible} onHide={hideModal}>
                <Modal.Header closeButton>
                    <Modal.Title>{model.id ? 'Editar' : 'Criar'} chave de acesso pessoal</Modal.Title>
                </Modal.Header>

                <Formik
                    enableReinitialize
                    validationSchema={validationSchema}
                    initialValues={{ ...initialValues, ...model }}
                    onSubmit={savePersonalAccessToken}
                >
                    {({ handleSubmit, isValid, isSubmitting }) => (
                        <Form noValidate onSubmit={handleSubmit}>
                            <Modal.Body>
                                <InputField label="Nome" name="name" />
                                <hr className="pb-3" />
                                {scopes?.length ? (
                                    <SelectField multiple label="Escopos" name="scopes" options={scopes} />
                                ) : (
                                    ''
                                )}
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
