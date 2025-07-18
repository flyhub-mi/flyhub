import React from 'react';
import Swal from 'sweetalert2';
import { FieldArray } from 'formik';
import { Accordion, Button, Card, Col, Row, Tab } from 'react-bootstrap';

import InputField from '../../../../formik-fields/InputField';
import API from '../../../../services/api';

const buttonMargin = { marginTop: 32 };

const deleteVariation = (id, afterDelete) => {
    Swal.fire({
        title: 'Deseja excluir esta variação?',
        text: 'Você não vai poder reverter isto!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar',
    }).then(result => {
        if (result.value) {
            new API('/api/v1/products').delete(id).then(response => response.success && afterDelete());
        }
    });
};

const Variation = ({ id, index, arrayHelpers }) => {
    const deleteAndRemoveVariation = () => {
        deleteVariation(id, () => arrayHelpers.remove(index));
    };

    return (
        <Row className="h-100" key={id}>
            <Col md={3}>
                <InputField type="text" label="SKU / Referência" name={`variations.[${index}].sku`} />
            </Col>
            <Col md={2}>
                <InputField type="text" label="Cor" name={`variations.[${index}].color`} />
            </Col>
            <Col md={2}>
                <InputField type="text" label="Tamanho" name={`variations.[${index}].size`} />
            </Col>
            <Col md={2}>
                <InputField type="number" label="Preço" name={`variations.[${index}].price`} />
            </Col>
            <Col md={2}>
                <InputField type="number" label="Estoque" name={`variations.[${index}].stock_quantity`} />
            </Col>
            <Col md={1}>
                <Accordion.Toggle as={Button} variant="default" eventKey={index} className="mr-2" style={buttonMargin}>
                    <i className="fas fa-tools" />
                </Accordion.Toggle>
                <Button variant="danger" onClick={deleteAndRemoveVariation} style={buttonMargin}>
                    <i className="fas fa-trash" />
                </Button>
            </Col>
        </Row>
    );
};

export default function({ eventKey, values }) {
    return (
        <Tab.Pane eventKey={eventKey}>
            <FieldArray
                name="variations"
                render={arrayHelpers => (
                    <>
                        {values.variations.map((variation, index) => (
                            <Row key={variation.id}>
                                <Card style={{ width: '100%' }}>
                                    <Accordion>
                                        <Card.Header>
                                            <Variation id={variation.id} index={index} arrayHelpers={arrayHelpers} />
                                        </Card.Header>
                                        <Accordion.Collapse eventKey={index}>
                                            <Card.Body>Detalhes adicionais da variação.</Card.Body>
                                        </Accordion.Collapse>
                                    </Accordion>
                                </Card>
                            </Row>
                        ))}
                        <Button type="button" variant="default" onClick={() => arrayHelpers.push({})}>
                            <i className="fas fa-plus" /> Adicionar Variação
                        </Button>
                    </>
                )}
            ></FieldArray>
        </Tab.Pane>
    );
}
