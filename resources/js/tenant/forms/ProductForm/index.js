import React from 'react';
import * as Yup from 'yup';
import { Formik } from 'formik';
import { Button, Card, Form, Nav, Tab } from 'react-bootstrap';

import API from '../../../services/api';
import BasicDataTab from './tabs/BasicDataTab';
import DescriptionTab from './tabs/DescriptionTab';
import ShippingTab from './tabs/ShippingTab';
import AttributesTab from './tabs/AttributesTab';
import VariationsTab from './tabs/VariationsTab';
import PhotosTab from './tabs/PhotosTab';
import ChannelsTab from './tabs/ChannelsTab';
import TaxesTab from './tabs/TaxesTab';

const validationSchema = Yup.object().shape({
    name: Yup.string().required(),
});

const initialValues = {
    sku: '',
    name: '',
    description: '',
    short_description: '',
    new: true,
    status: '',
    thumbnail: '',
    price: '',
    cost: '',
    special_price: '',
    special_price_from: '',
    special_price_to: '',
    gross_weight: '',
    net_weight: '',
    unit: '',
    color: '',
    size: '',
    brand: '',
    width: '',
    height: '',
    depth: '',
    min_price: '',
    max_price: '',
    ncm: '',
    gtin: '',
    mpn: '',
    main_category_id: '',
    attribute_set_id: '',
    type: '',
    stock_quantity: '',
};

export default function ProductForm({ model = {} }) {
    const saveProduct = values => {
        return new API('/api/v1/products').patch(model.id, values);
    };

    return (
        <Formik
            enableReinitialize
            validationSchema={validationSchema}
            initialValues={{ ...initialValues, ...model }}
            onSubmit={saveProduct}
        >
            {({ handleSubmit, isValid, isSubmitting, values, setFieldValue }) => (
                <Form noValidate onSubmit={handleSubmit}>
                    <Tab.Container defaultActiveKey="basicData">
                        <Card>
                            <Card.Header className="p-2 px-3">
                                <Nav variant="pills">
                                    <Nav.Item>
                                        <Nav.Link eventKey="basicData">
                                            <i className="fas fa-barcode" /> DADOS
                                        </Nav.Link>
                                    </Nav.Item>
                                    <Nav.Item>
                                        <Nav.Link eventKey="general">
                                            <i className="fas fa-file-alt" /> DESCRIÇÂO
                                        </Nav.Link>
                                    </Nav.Item>
                                    <Nav.Item>
                                        <Nav.Link eventKey="shipping">
                                            <i className="fas fa-truck" /> TRANSPORTE
                                        </Nav.Link>
                                    </Nav.Item>
                                    <Nav.Item>
                                        <Nav.Link eventKey="attributes">
                                            <i className="fas fa-bezier-curve" /> ATRIBUTOS
                                        </Nav.Link>
                                    </Nav.Item>
                                    <Nav.Item>
                                        <Nav.Link eventKey="taxes">
                                            <i className="fas fa-percent" /> IMPOSTOS
                                        </Nav.Link>
                                    </Nav.Item>
                                    <Nav.Item>
                                        <Nav.Link eventKey="variations">
                                            <i className="fas fa-shopping-cart" /> VARIAÇÕES
                                        </Nav.Link>
                                    </Nav.Item>
                                    <Nav.Item>
                                        <Nav.Link eventKey="photos">
                                            <i className="fas fa-images" /> FOTOS
                                        </Nav.Link>
                                    </Nav.Item>
                                    <Nav.Item>
                                        <Nav.Link eventKey="channels">
                                            <i className="fas fa-bezier-curve" /> CANAIS
                                        </Nav.Link>
                                    </Nav.Item>
                                </Nav>
                            </Card.Header>
                            <Card.Body>
                                <Tab.Content>
                                    <BasicDataTab eventKey="basicData" setFieldValue={setFieldValue} values={values} />
                                    <DescriptionTab eventKey="general" setFieldValue={setFieldValue} values={values} />
                                    <ShippingTab eventKey="shipping" setFieldValue={setFieldValue} values={values} />
                                    <AttributesTab
                                        eventKey="attributes"
                                        setFieldValue={setFieldValue}
                                        values={values}
                                    />
                                    <TaxesTab eventKey="taxes" setFieldValue={setFieldValue} values={values} />
                                    <VariationsTab
                                        eventKey="variations"
                                        setFieldValue={setFieldValue}
                                        values={values}
                                    />
                                    <PhotosTab eventKey="photos" setFieldValue={setFieldValue} values={values} />
                                    <ChannelsTab eventKey="channels" setFieldValue={setFieldValue} values={values} />
                                </Tab.Content>
                            </Card.Body>
                        </Card>
                    </Tab.Container>

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
