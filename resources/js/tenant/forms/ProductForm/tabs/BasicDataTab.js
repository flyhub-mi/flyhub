import { Col, Row, Tab } from 'react-bootstrap';
import React, { useEffect, useState } from 'react';

import InputField from '../../../../formik-fields/InputField';
import API from '../../../../services/api';
import Tree from '../../../../components/Tree';

const setSelectedNode = (selectedValue, setSelected) => {
    new API('/api/v1/categories').getOne(selectedValue).then(response => {
        setSelected(response.data);
    });
};

const onSelect = (selectedNode, setSelected, setFieldValue) => {
    setSelected(selectedNode);

    setFieldValue('main_category_id', selectedNode.id);
};

export default function BasicDataTab({ eventKey, setFieldValue, selectedValue }) {
    const [tree, setTree] = useState([]);
    const [selected, setSelected] = useState({});

    useEffect(() => {
        new API('/api/v1/categories').getAll().then(response => setTree(response.data || []));

        if (selectedValue) setSelectedNode(selectedValue, setSelected);
    }, []);

    return (
        <Tab.Pane eventKey={eventKey}>
            <Row>
                <Col lg={8}>
                    <Row>
                        <Col md={6}>
                            <InputField type="text" label="SKU / Referência" name="sku" disabled />
                        </Col>
                        <Col md={6}>
                            <InputField type="text" label="Nome" name="name" />
                        </Col>
                    </Row>
                    <hr />
                    <Row>
                        <Col md={4}>
                            <InputField type="text" label="Código GTIN / UPC / EAN" name="gtin" />
                        </Col>
                        <Col md={4}>
                            <InputField type="text" label="Código NCM" name="ncm" />
                        </Col>
                        <Col md={4}>
                            <InputField type="text" label="Código MPN" name="mpn" />
                        </Col>
                    </Row>
                    <hr />
                    <Row>
                        <Col md={6}>
                            <InputField type="number" label="Custo" name="cost" />
                        </Col>
                        <Col md={6}>
                            <InputField type="number" label="Preço normal" name="price" />
                        </Col>
                    </Row>
                    <hr />
                    <Row>
                        <Col md={4}>
                            <InputField type="number" label="Preço promocional" name="special_price" />
                        </Col>
                        <Col md={4}>
                            <InputField type="date" label="Início do preço promocional" name="special_price_from" />
                        </Col>
                        <Col md={4}>
                            <InputField type="date" label="Validade do preço promocional" name="special_price_to" />
                        </Col>
                    </Row>
                </Col>
                <Col lg={4}>
                    {tree.length > 0 && (
                        <Tree
                            selected={selected}
                            nodes={tree}
                            onSelect={selectedNode => onSelect(selectedNode, setSelected, setFieldValue)}
                        />
                    )}
                </Col>
            </Row>
        </Tab.Pane>
    );
}
