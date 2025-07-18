import React, { useEffect, useState } from 'react';
import * as Yup from 'yup';
import { Form, Formik } from 'formik';
import { Button, Card, Col, Row } from 'react-bootstrap';
import InputField from '../../formik-fields/InputField';
import API from '../../services/api';
import Tree from '../../components/Tree';
import Swal from 'sweetalert2';

const validationSchema = Yup.object().shape({
    parent_name: Yup.string().required(),
    name: Yup.string()
        .max(50)
        .required(),
});

const initialValues = { parent_id: '', parent_name: '', name: '' };

export default function({ model = {} }) {
    const [tree, setTree] = useState([]);
    const [mode, setMode] = useState('showing');
    const [selected, setSelected] = useState({});

    const refreshTree = () => {
        new API('/api/v1/categories').getAll().then(response => {
            setTree(response.data);
        });
    };

    const saveCategory = values => {
        if (mode === 'adding') {
            return new API('/api/v1/categories')
                .create({ parent_id: selected.id, name: values.name })
                .then(() => refreshTree());
        }
        return new API('/api/v1/categories')
            .patch(selected.id, {
                parent_id: selected.parent.id,
                name: values.name,
            })
            .then(() => refreshTree());
    };

    const setFields = (setFieldValue, selectedNode = selected, currentMode = mode) => {
        if (currentMode === 'adding') {
            setFieldValue('parent_name', selectedNode.name);
            setFieldValue('name', '');
        } else {
            setFieldValue('parent_name', selectedNode?.parent?.name);
            setFieldValue('name', selectedNode.name);
        }
    };

    const setModeFields = (currentMode, setFieldValue) => {
        setMode(currentMode);
        setFields(setFieldValue, selected, mode);
    };

    const onSelect = (selectedNode, setFieldValue) => {
        setSelected(selectedNode);
        setFields(setFieldValue, selectedNode);
    };

    useEffect(() => {
        refreshTree();
    }, []);

    const destroy = () => {
        Swal.fire({
            title: 'Deseja excluir esta categoria?',
            text: `Categoria: ${selected.name}`,
            icon: 'warning',
            showCloseButton: true,
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Confirmar',
            reverseButtons: true,
            focusConfirm: false,
        }).then(result => {
            if (result.value) {
                new API('/api/v1/categories').delete(selected.id).then(() => refreshTree());
            }
        });
    };

    return (
        <Card>
            <Card.Body>
                <Formik
                    validationSchema={validationSchema}
                    initialValues={{ ...initialValues, ...model }}
                    onSubmit={saveCategory}
                >
                    {({ handleSubmit, isValid, isSubmitting, setFieldValue }) => (
                        <Form noValidate onSubmit={handleSubmit}>
                            <Row>
                                <Col md={6}>
                                    {tree.length > 0 && (
                                        <Tree
                                            nodes={tree}
                                            onSelect={selectedNode => onSelect(selectedNode, setFieldValue)}
                                        />
                                    )}
                                </Col>
                                <Col md={6}>
                                    <Card>
                                        <Card.Body>
                                            <Row>
                                                <Col lg={12}>
                                                    <InputField
                                                        type="text"
                                                        label="Categoria Pai"
                                                        name="parent_name"
                                                        disabled
                                                    />

                                                    <InputField
                                                        type="text"
                                                        label="Nome"
                                                        name="name"
                                                        disabled={mode === 'showing'}
                                                    />
                                                </Col>
                                            </Row>
                                        </Card.Body>

                                        {mode === 'showing' && (
                                            <Card.Footer>
                                                <Button
                                                    type="button"
                                                    variant="primary"
                                                    className="mr-2"
                                                    onClick={() => setModeFields('adding', setFieldValue)}
                                                >
                                                    Criar categoria filha
                                                </Button>
                                                <Button
                                                    type="button"
                                                    variant="warning"
                                                    className="mr-2"
                                                    onClick={() => setModeFields('editing', setFieldValue)}
                                                >
                                                    Editar categoria
                                                </Button>
                                                <Button type="button" variant="danger" onClick={destroy}>
                                                    Excluir
                                                </Button>
                                            </Card.Footer>
                                        )}

                                        {mode === 'editing' && (
                                            <Card.Footer>
                                                <Button
                                                    type="button"
                                                    variant="secondary"
                                                    className="mr-2"
                                                    onClick={() => setModeFields('showing', setFieldValue)}
                                                >
                                                    Cancelar
                                                </Button>
                                                <Button
                                                    type="submit"
                                                    variant="primary"
                                                    disabled={!isValid || isSubmitting}
                                                >
                                                    Salvar
                                                </Button>
                                            </Card.Footer>
                                        )}

                                        {mode === 'adding' && (
                                            <Card.Footer>
                                                <Button
                                                    type="button"
                                                    variant="secondary"
                                                    className="mr-2"
                                                    onClick={() => setModeFields('showing', setFieldValue)}
                                                >
                                                    Cancelar
                                                </Button>
                                                <Button
                                                    type="submit"
                                                    variant="primary"
                                                    disabled={!isValid || isSubmitting}
                                                >
                                                    Salvar
                                                </Button>
                                            </Card.Footer>
                                        )}
                                    </Card>
                                </Col>
                            </Row>
                        </Form>
                    )}
                </Formik>
            </Card.Body>
        </Card>
    );
}
