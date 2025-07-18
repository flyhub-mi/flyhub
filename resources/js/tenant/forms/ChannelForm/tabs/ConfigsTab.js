import React from 'react';
import { Button, Card, Col, Form, Row, Tab } from 'react-bootstrap';
import API from '../../../../services/api';
import SelectField from '../../../../formik-fields/SelectField';
import InputField from '../../../../formik-fields/InputField';
import { Formik } from 'formik';
import CheckField from '../../../../formik-fields/CheckField';

const renderField = ({ name, label, type = 'text', options = {}, disabled = false }, key) => {
    if (type === 'select') {
        return (
            <Col md={6} key={key}>
                <SelectField
                    label={label}
                    name={name}
                    disabled={disabled}
                    options={Object.entries(options).map(([value, name]) => ({
                        name,
                        value,
                    }))}
                />
            </Col>
        );
    } else if (type === 'checkbox') {
        return (
            <Col md={6} key={key}>
                <br />
                <br />
                <CheckField label={label} name={name} disabled={disabled} />
            </Col>
        );
    } else {
        return (
            <Col md={6} key={key}>
                <InputField label={label} name={name} type={type} disabled={disabled} />
            </Col>
        );
    }
};

export default function({ eventKey, channel, configs = {}, fields = [] }) {
    const handleSubmit = values => {
        return new API('/api/v1/channels').patch(channel.id, {
            configs: values,
        });
    };

    return (
        <Tab.Pane eventKey={eventKey}>
            <Row>
                <Col md={12}>
                    <Formik initialValues={{ ...configs }} onSubmit={handleSubmit}>
                        {({ handleSubmit, isValid, isSubmitting }) => (
                            <Form noValidate onSubmit={handleSubmit}>
                                <Card>
                                    <Card.Body>
                                        <Row>{fields.map(renderField)}</Row>

                                        <hr />

                                        <fieldset>
                                            <legend>Sincronização de Produtos.</legend>
                                            <Row>
                                                <Col md={3}>
                                                    <CheckField label={'Receber produtos'} name={'products_receive'} />
                                                </Col>
                                                <Col md={3}>
                                                    <CheckField label={'Enviar produtos'} name={'products_send'} />
                                                </Col>
                                            </Row>
                                        </fieldset>

                                        <hr />

                                        <fieldset>
                                            <legend>Sincronização de Pedidos.</legend>
                                            <Row>
                                                <Col md={3}>
                                                    <CheckField label={'Receber pedidos'} name={'orders_receive'} />
                                                </Col>
                                                <Col md={3}>
                                                    <CheckField label={'Enviar pedidos'} name={'orders_send'} />
                                                </Col>
                                            </Row>
                                        </fieldset>
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
                            </Form>
                        )}
                    </Formik>
                </Col>
            </Row>
        </Tab.Pane>
    );
}
