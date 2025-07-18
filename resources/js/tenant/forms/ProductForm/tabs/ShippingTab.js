import { Col, Row, Tab } from 'react-bootstrap';
import React from 'react';
import InputField from '../../../../formik-fields/InputField';

export default function ShippingTab({ eventKey }) {
    return (
        <Tab.Pane eventKey={eventKey}>
            <Row>
                <Col md={4}>
                    <InputField type="text" label="Comprimento" name="depth" />
                </Col>
                <Col md={4}>
                    <InputField type="text" label="Largura" name="width" />
                </Col>
                <Col md={4}>
                    <InputField type="text" label="Altura" name="height" />
                </Col>
            </Row>
            <Row>
                <Col md={4}>
                    <InputField type="number" label="Peso bruto" name="gross_weight" />
                </Col>
                <Col md={4}>
                    <InputField type="number" label="Peso líquido" name="net_weight" />
                </Col>
            </Row>
        </Tab.Pane>
    );
}
