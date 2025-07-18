import { Accordion, Button, Card, Col, Nav, Row, Tab } from 'react-bootstrap';
import React, { useState } from 'react';
import Swal from 'sweetalert2';

import Dropzone from '../../../../components/Dropzone';
import API from '../../../../services/api';

const deleteImages = (type, productId, selectedFiles, setSelectedFiles) => {
    Swal.fire({
        title: 'Deseja excluir estas imagens?',
        text: 'Você não vai poder reverter isto!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar',
    }).then(result => {
        if (result.value) {
            selectedFiles[type].forEach(file => {
                new API(`/api/v1/products/${productId}/images`).delete(file.id).then(response => {
                    if (response.success) {
                        setSelectedFiles([]);
                    }
                });
            });
        }
    });
};

const VariationImage = ({ variation }) => {
    return (
        <Row>
            <Col style={{ marginLeft: '20px' }}>
                <Card style={{ width: '100%' }}>
                    <Accordion>
                        <Card.Header>
                            <Card.Title>
                                <Accordion.Toggle as={Button} variant="link" eventKey={variation.id}>
                                    {variation.sku}
                                </Accordion.Toggle>
                            </Card.Title>
                        </Card.Header>
                        <Accordion.Collapse eventKey={variation.id}>
                            <Card.Body>
                                <Dropzone
                                    postUrl={`/api/v1/products/${variation.id}/images`}
                                    existingFiles={variation.images}
                                />
                            </Card.Body>
                        </Accordion.Collapse>
                    </Accordion>
                </Card>
            </Col>
        </Row>
    );
};

export default function PhotosTab({ eventKey, values }) {
    const [selectedFiles, setSelectedFiles] = useState({
        main: [],
        variations: [],
        dafiti: [],
        mercadoLivre: [],
        wooCommerce: [],
    });

    const setSetSelectedByType = (type, selected) => {
        setSelectedFiles(items => ({ ...items, [type]: selected() }));
    };

    return (
        <Tab.Pane eventKey={eventKey}>
            <Tab.Container id="left-tabs-example" defaultActiveKey="principal">
                <Row>
                    <Col md={2}>
                        <Nav variant="pills" className="flex-column">
                            <Nav.Item>
                                <Nav.Link eventKey="principal">Principal</Nav.Link>
                            </Nav.Item>
                            <Nav.Item>
                                <Nav.Link eventKey="variations">Variações</Nav.Link>
                            </Nav.Item>
                            {/* <Nav.Item>
                                <Nav.Link eventKey="dafiti">Dafiti</Nav.Link>
                            </Nav.Item>
                            <Nav.Item>
                                <Nav.Link eventKey="mercado-livre">Mercado Livre</Nav.Link>
                            </Nav.Item>
                            <Nav.Item>
                                <Nav.Link eventKey="woocommerce">WooCommerce</Nav.Link>
                            </Nav.Item> */}
                        </Nav>
                    </Col>
                    <Col md={10}>
                        <Tab.Content>
                            <Tab.Pane eventKey="principal">
                                <Dropzone
                                    postUrl={`/api/v1/products/${values.id}/images`}
                                    existingFiles={values.images}
                                    onSelect={items => setSetSelectedByType('main', items)}
                                />
                                <div className="container-fluid">
                                    <Button type="button" variant="default" disabled={selectedFiles.main.length !== 1}>
                                        <i className="fas fa-address-book" /> Marcar foto como capa
                                    </Button>
                                    <Button
                                        type="button"
                                        variant="default"
                                        className="ml-2"
                                        disabled={selectedFiles.main.length < 1}
                                    >
                                        <i className="fas fa-copy" /> Replicar fotos para variações
                                    </Button>
                                    <Button
                                        type="button"
                                        variant="danger"
                                        className="ml-2"
                                        disabled={selectedFiles.main.length < 1}
                                        onClick={() => deleteImages('main', values.id, selectedFiles, setSelectedFiles)}
                                    >
                                        <i className="fas fa-trash" /> Excluir fotos
                                    </Button>
                                </div>
                            </Tab.Pane>
                            <Tab.Pane eventKey="variations">
                                {values.variations.map(variation => (
                                    <VariationImage variation={variation} key={variation.id} />
                                ))}
                            </Tab.Pane>
                            <Tab.Pane eventKey="dafiti">
                                <Dropzone
                                    postUrl={`/api/v1/products/${values.id}/images`}
                                    existingFiles={values.images}
                                />
                            </Tab.Pane>
                            <Tab.Pane eventKey="mercado-livre">
                                <Dropzone
                                    postUrl={`/api/v1/products/${values.id}/images`}
                                    existingFiles={values.images}
                                />
                            </Tab.Pane>
                            <Tab.Pane eventKey="woocommerce">
                                <Dropzone
                                    postUrl={`/api/v1/products/${values.id}/images`}
                                    existingFiles={values.images}
                                />
                            </Tab.Pane>
                        </Tab.Content>
                    </Col>
                </Row>
            </Tab.Container>
        </Tab.Pane>
    );
}
