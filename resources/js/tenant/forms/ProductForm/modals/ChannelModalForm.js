import React, { useState } from 'react';
import { Formik } from 'formik';
import { Button, Col, Form, Modal, Nav, Row, Tab } from 'react-bootstrap';
import API from '../../../../services/api';
import SelectField from '../../../../formik-fields/SelectField';
import InputField from '../../../../formik-fields/InputField';

const findValue = (productValue = '', values = []) => {
    let val = '';

    if (productValue && values.length > 0) {
        values.forEach(({ name, value }) => {
            if (productValue.toLowerCase() === name.toLowerCase()) val = value;
        });
    }

    return val || productValue;
};

const findProductValue = (product, id, values) => {
    let val = '';

    if (id.toLowerCase().includes('size')) {
        val = findValue(product.size, values);
    } else if (id.toLowerCase().includes('color')) {
        val = findValue(product.color, values);
    } else if (id.toLowerCase().includes('sku')) {
        val = findValue(product.sku, values);
    } else {
        Object.entries(product).forEach(([key, value]) => {
            if (key.toLowerCase().includes(id.toLowerCase())) {
                val = findValue(value, values);
            }
        });
    }

    return val;
};

const findAttributesValue = (attributes, savedValues, product) => {
    const attributesValues = {};

    attributes
        .filter(({ readOnly }) => !readOnly)
        .forEach(({ id, values }) => {
            const savedValue = savedValues.find(item => item.key === id)?.value;

            attributesValues[id] = savedValue || findProductValue(product, id, values);
        });

    return attributesValues;
};

const renderField = ({ required, id, name, type, values, readOnly, multiple }, key, prefix) => {
    const label = required ? `${name} *` : `${name}`;

    if (type === 'list') {
        return (
            <Col md={6} key={key}>
                <SelectField
                    label={label}
                    name={`${prefix}.attributes.${id}`}
                    multiple={multiple}
                    disabled={readOnly}
                    options={values}
                />
            </Col>
        );
    } else if (type === 'string') {
        return (
            <Col md={6} key={key}>
                <InputField label={label} name={`${prefix}.attributes.${id}`} type="text" disabled={readOnly} />
            </Col>
        );
    }
};

export default function({ productChannel, show, onHide, product }) {
    const [initialValues, setInitialValues] = useState(false);
    const [mainAttributes, setMainAttributes] = useState([]);
    const [variationAttributes, setVariationAttributes] = useState([]);

    const attributesValues = attributes => {
        new API(`/api/v1/channels/${productChannel.channel_id}/products`).getOne(productChannel.id).then(response => {
            const values = {
                main: {
                    product_id: product.id,
                    attributes: findAttributesValue(attributes, response.data.attributes, product),
                },
                variations: {},
            };

            product.variations.forEach(variation => {
                const savedValues =
                    response.data.variations_attributes.find(({ id }) => id === variation.id)?.attributes || [];

                values['variations'][variation.id] = {
                    product_id: variation.id,
                    attributes: findAttributesValue(attributes, savedValues, variation),
                };
            });

            setInitialValues(values);
        });
    };

    const fetchAttributes = () => {
        new API(
            `/api/v1/channels/${productChannel.channel_id}/categories/${productChannel.remote_category_id}/attributes`
        )
            .getAll()
            .then(response => {
                if (response?.data) {
                    const attributes = response.data;
                    const haveVariation = product.variations.length > 0;

                    attributesValues(attributes);

                    if (haveVariation) {
                        setMainAttributes(attributes.filter(({ variationAttribute }) => !variationAttribute));
                        setVariationAttributes(attributes.filter(({ variationAttribute }) => variationAttribute));
                    } else {
                        setMainAttributes(attributes);
                    }
                } else {
                    onHide();
                }
            });
    };

    const saveChannelProductAttributes = values => {
        return new API(`/api/v1/channels/${productChannel.channel_id}/products`)
            .update({ id: productChannel.id, ...values })
            .then(response => onHide(response.data));
    };

    return (
        <Modal show={show} onHide={onHide} size="xl" onShow={fetchAttributes}>
            <Modal.Header closeButton>
                <Modal.Title>Configurar canal</Modal.Title>
            </Modal.Header>
            {initialValues ? (
                <Formik initialValues={initialValues} onSubmit={saveChannelProductAttributes}>
                    {({ handleSubmit, isValid, isSubmitting }) => (
                        <Form noValidate onSubmit={handleSubmit}>
                            <Modal.Body>
                                <Tab.Container id="left-tabs-example" defaultActiveKey="main">
                                    <Row>
                                        <Col md={2}>
                                            <Nav variant="pills" className="flex-column">
                                                <Nav.Item>
                                                    <Nav.Link eventKey="main">Principal</Nav.Link>
                                                </Nav.Item>
                                                <Nav.Item>
                                                    {product.variations.map((variation, index) => (
                                                        <Nav.Link eventKey={variation.sku}>{variation.sku}</Nav.Link>
                                                    ))}
                                                </Nav.Item>
                                            </Nav>
                                        </Col>
                                        <Col md={10}>
                                            <Tab.Content className="ml-3">
                                                <Tab.Pane eventKey="main">
                                                    <Row>
                                                        {mainAttributes.map((attribute, index) =>
                                                            renderField(attribute, index, 'main')
                                                        )}
                                                    </Row>
                                                </Tab.Pane>
                                                {product.variations.map((variation, key) => (
                                                    <Tab.Pane eventKey={variation.sku} key={key}>
                                                        <Row>
                                                            {variationAttributes.map((attribute, index) =>
                                                                renderField(
                                                                    attribute,
                                                                    index,
                                                                    `variations.${variation.id}`
                                                                )
                                                            )}
                                                        </Row>
                                                    </Tab.Pane>
                                                ))}
                                            </Tab.Content>
                                        </Col>
                                    </Row>
                                </Tab.Container>
                            </Modal.Body>
                            <Modal.Footer>
                                <Button type="button" variant="secondary" onClick={onHide}>
                                    Cancelar
                                </Button>
                                <Button type="submit" variant="primary" disabled={!isValid || isSubmitting}>
                                    Salvar
                                </Button>
                            </Modal.Footer>
                        </Form>
                    )}
                </Formik>
            ) : (
                <div className="row text-center">
                    <i className="fas fa-spinner fa-spin fa-3x" style={{ margin: '0 auto', padding: 50 }} />
                </div>
            )}
        </Modal>
    );
}
