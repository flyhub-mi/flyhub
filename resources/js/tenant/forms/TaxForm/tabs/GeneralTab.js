import { Col, Row, Tab } from 'react-bootstrap';
import React from 'react';

import InputField from '../../../../formik-fields/InputField';
import SelectField from '../../../../formik-fields/SelectField';
import TextareaField from '../../../../formik-fields/TextareaField';
import CheckField from '../../../../formik-fields/CheckField';

export default function({ eventKey }) {
    return (
        <Tab.Pane eventKey={eventKey} className="px-4 py-3">
            <Row>
                <Col lg={6}>
                    <InputField label="Tag" name="tag" />
                </Col>
                <Col lg={6}>
                    <InputField label="Nome" name="name" />
                </Col>
            </Row>

            <Row>
                <Col lg={6}>
                    <SelectField label="Tipo de Valor" name="type">
                        <option value="text">Texto</option>
                        <option value="integer">Inteiro</option>
                        <option value="double">Decimal</option>
                        <option value="option">Opções</option>
                    </SelectField>
                </Col>
                <Col lg={6}>
                    <InputField label="Tamanho" name="size" />
                </Col>
            </Row>

            <Row>
                <Col lg={6}>
                    <InputField label="Taxa" name="tax_rate" type="number" />
                </Col>
                <Col lg={6}>
                    <InputField label="Valor padrão" name="default_value" />
                </Col>
            </Row>

            <Row>
                <Col lg={12}>
                    <InputField label="Fórmula" name="formula" />
                </Col>
            </Row>

            <Row>
                <Col lg={12}>
                    <TextareaField label="Descrição" name="description" />
                </Col>
            </Row>

            <fieldset>
                <legend>Configurações</legend>
                <Row>
                    <Col lg={12}>
                        <CheckField type="checkbox" label="Obrigatório" name="required" />
                    </Col>
                    <Col lg={12}>
                        <CheckField type="checkbox" label="Vísivel" name="visible" />
                    </Col>
                </Row>
            </fieldset>
        </Tab.Pane>
    );
}
