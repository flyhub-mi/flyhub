import React from 'react';
import * as Yup from 'yup';
import { Formik } from 'formik';
import { Button, Card, Form, Nav, Tab } from 'react-bootstrap';
import redirect from '../../../services/redirect';
import API from '../../../services/api';
import GeneralTab from './tabs/GeneralTab';
import OptionsTab from './tabs/OptionsTab';

const validationSchema = Yup.object().shape({
    tag: Yup.string()
        .max(191)
        .required(),
    name: Yup.string()
        .max(191)
        .required(),
    type: Yup.string()
        .max(191)
        .required(),
    size: Yup.string().max(191),
    description: Yup.string().max(191),
    tax_rate: Yup.number(),
    formula: Yup.string().max(191),
    position: Yup.number().max(99),
    required: Yup.boolean(),
    visible: Yup.boolean(),
    default_value: Yup.string().max(191),
});

const defaultOption = { label: '', value: '', position: 1 };

const initialValues = {
    tag: '',
    name: '',
    type: '',
    size: '',
    description: '',
    tax_rate: 0,
    formula: '',
    required: false,
    visible: true,
    default_value: 0,
    options: [defaultOption],
};

export default function TaxForm({ model = {} }) {
    const saveTax = values => {
        return values.id
            ? new API('/api/v1/taxes').patch(values.id, values)
            : new API('/api/v1/taxes').create(values).then(() => redirect('/configurations/taxes'));
    };

    return (
        <Formik validationSchema={validationSchema} initialValues={{ ...initialValues, ...model }} onSubmit={saveTax}>
            {({ handleSubmit, isValid, isSubmitting, values }) => (
                <Form noValidate onSubmit={handleSubmit}>
                    <Tab.Container defaultActiveKey="general">
                        <Card>
                            <Card.Header className="p-2 px-3">
                                <Nav variant="pills">
                                    <Nav.Item>
                                        <Nav.Link eventKey="general">
                                            <i className="fas fa-file-alt" /> GERAL
                                        </Nav.Link>
                                    </Nav.Item>
                                    <Nav.Item>
                                        <Nav.Link eventKey="options">
                                            <i className="fas fa-bezier-curve" /> OPÇÕES
                                        </Nav.Link>
                                    </Nav.Item>
                                </Nav>
                            </Card.Header>
                            <Card.Body className="p-0">
                                <Tab.Content>
                                    <GeneralTab eventKey="general" />
                                    <OptionsTab eventKey="options" values={values} />
                                </Tab.Content>
                            </Card.Body>
                            <Card.Footer>
                                <Button type="button" variant="secondary" className="mr-2">
                                    Cancelar
                                </Button>
                                <Button type="submit" variant="primary" disabled={!isValid || isSubmitting}>
                                    Salvar
                                </Button>
                            </Card.Footer>
                        </Card>
                    </Tab.Container>
                </Form>
            )}
        </Formik>
    );
}
