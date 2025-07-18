import React, { useEffect, useState } from 'react';
import * as Yup from 'yup';
import { Formik } from 'formik';
import { Button, Card, Col, Form, Row } from 'react-bootstrap';
import InputField from '../../formik-fields/InputField';
import API from '../../services/api';
import redirect from '../../services/redirect';

const validationSchema = Yup.object().shape({
    parent_tag: Yup.string(),
    tag: Yup.string().required(),
    name: Yup.string().required(),
});

const initialValues = {
    parent_tag: '',
    tag: '',
    name: '',
    show_when: '',
    description: '',
    taxes: [],
};

export default function({ model = {} }) {
    const [taxes, setTaxes] = useState([]);

    const saveTaxGroup = values => {
        return values.id
            ? new API('/api/v1/tax-groups').patch(values.id, values)
            : new API('/api/v1/tax-groups').create(values).then(() => redirect('/configurations/tax-groups'));
    };

    const taxChecked = (tax, values) => {
        return values.taxes.some(({ id }) => id === tax.id);
    };

    const checkTax = (tax, values, setFieldValue) => {
        if (taxChecked(tax, values)) {
            setFieldValue(
                'taxes',
                values.taxes.filter(({ id }) => id !== tax.id)
            );
        } else {
            setFieldValue('taxes', [...values.taxes, tax]);
        }
    };

    useEffect(() => {
        new API('/api/v1/taxes').getAll().then(response => {
            setTaxes(response.data);
        });
    }, []);

    return (
        <Formik
            validationSchema={validationSchema}
            initialValues={{ ...initialValues, ...model }}
            onSubmit={saveTaxGroup}
        >
            {({ handleSubmit, isValid, isSubmitting, values, setFieldValue }) => (
                <Form noValidate onSubmit={handleSubmit}>
                    <Card>
                        <Card.Body>
                            <Row>
                                <Col lg={3}>
                                    <InputField type="text" label="Tag do Grupo Pai" name="parent_tag" />
                                </Col>
                                <Col lg={3}>
                                    <InputField type="text" label="Tag" name="tag" />
                                </Col>
                                <Col lg={6}>
                                    <InputField type="text" label="Nome" name="name" />
                                </Col>
                            </Row>
                        </Card.Body>
                    </Card>

                    <Card>
                        <Card.Header>Tributos</Card.Header>
                        <Card.Body className="p-1 table-responsive">
                            <table className="table">
                                <thead>
                                    <tr>
                                        <th>Tag</th>
                                        <th>Nome</th>
                                        <th>Posição</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {taxes.map(tax => (
                                        <tr key={tax.id}>
                                            <td>
                                                <div className="form-check">
                                                    <input
                                                        className="form-check-input position-static"
                                                        type="checkbox"
                                                        value={taxChecked(tax, values)}
                                                        defaultChecked={taxChecked(tax, values)}
                                                        onClick={() => checkTax(tax, values, setFieldValue)}
                                                    />
                                                </div>
                                            </td>
                                            <td>{tax.tag}</td>
                                            <td>{tax.name}</td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </Card.Body>
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
