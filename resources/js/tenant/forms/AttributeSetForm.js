import React, { useEffect, useState } from 'react';
import * as Yup from 'yup';
import { Formik } from 'formik';
import { Button, Card, Col, Form, Row } from 'react-bootstrap';
import InputField from '../../formik-fields/InputField';
import API from '../../services/api';

const validationSchema = Yup.object().shape({
    name: Yup.string()
        .min(5)
        .max(50)
        .required(),
    attributes: Yup.mixed().test(
        'duplicated',
        'Os atributos selecionados não devem ter códigos repetidos.',
        attributes => !attributes.some(({ code }) => attributes.filter(item => item.code === code).length > 1)
    ),
});

const initialValues = { name: '', attributes: [] };

const saveAttributeSet = values => {
    return new API('/api/v1/attribute-sets').patch(values.id, values);
};

const attributeChecked = (attribute, values) => {
    return values.attributes.some(({ id }) => id === attribute.id);
};

const checkAttribute = (attribute, values, setFieldValue) => {
    if (attributeChecked(attribute, values)) {
        setFieldValue(
            'attributes',
            values.attributes.filter(({ id }) => id !== attribute.id)
        );
    } else {
        setFieldValue('attributes', [...values.attributes, attribute]);
    }
};

export default function AttributeSetForm({ model = {} }) {
    const [attributes, setAttributes] = useState([]);

    useEffect(() => {
        new API('/api/v1/attributes').getAll().then(response => {
            setAttributes(response.data);
        });
    }, []);

    return (
        <Formik
            validationSchema={validationSchema}
            initialValues={{ ...initialValues, ...model }}
            onSubmit={saveAttributeSet}
        >
            {({ handleSubmit, isValid, isSubmitting, values, setFieldValue, errors }) => (
                <Form noValidate onSubmit={handleSubmit}>
                    <Card>
                        <Card.Body>
                            <Row>
                                <Col md={6} lg={8}>
                                    <InputField type="text" label="Nome" name="name" />
                                </Col>
                            </Row>
                        </Card.Body>
                    </Card>

                    <Card>
                        <Card.Header>Atributos</Card.Header>
                        <Card.Body className="p-1 table-responsive">
                            <table className="table">
                                <thead>
                                    <tr>
                                        <th>Selecionado</th>
                                        <th>Código</th>
                                        <th>Nome</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {attributes.map(attribute => (
                                        <tr key={attribute.id}>
                                            <td>
                                                <div className="form-check">
                                                    <input
                                                        className="form-check-input position-static"
                                                        type="checkbox"
                                                        value={attributeChecked(attribute, values)}
                                                        defaultChecked={attributeChecked(attribute, values)}
                                                        onClick={() => checkAttribute(attribute, values, setFieldValue)}
                                                    />
                                                </div>
                                            </td>
                                            <td>{attribute.code}</td>
                                            <td>{attribute.name}</td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </Card.Body>
                        <Card.Footer>
                            {errors.attributes ? <div className="alert alert-danger">{errors.attributes}</div> : null}
                        </Card.Footer>
                    </Card>

                    <Card>
                        <Card.Footer>
                            <Button type="button" variant="secondary" className="mr-2">
                                Cancelar
                            </Button>
                            <Button type="submit" variant="primary" disabled={!isValid || isSubmitting}>
                                Salvar
                            </Button>
                        </Card.Footer>
                    </Card>
                </Form>
            )}
        </Formik>
    );
}
