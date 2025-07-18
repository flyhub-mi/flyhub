import { Col, Row, Tab } from 'react-bootstrap';
import React, { useEffect, useState } from 'react';

import SelectField from '../../../../formik-fields/SelectField';
import InputField from '../../../../formik-fields/InputField';
import API from '../../../../services/api';
import TextareaField from '../../../../formik-fields/TextareaField';
import CheckField from '../../../../formik-fields/CheckField';

const AttributeField = ({ attribute }) => {
    const fieldName = `attributes.${attribute.code}`;
    const attrType = attribute.type;
    const attrName = attribute.name;

    if (['select', 'multiselect'].indexOf(attrType) !== -1) {
        return (
            <SelectField
                label={attrName}
                name={fieldName}
                isIdValue
                options={attribute.options}
                multiple={attrType === 'multiselect'}
            />
        );
    }
    if (attrType === 'textarea') return <TextareaField label={attrName} name={fieldName} />;
    if (attrType === 'price') return <InputField label={attrName} name={fieldName} type="number" />;
    if (attrType === 'datetime') return <InputField label={attrName} name={fieldName} type="datetime-local" />;
    if (attrType === 'date') return <InputField label={attrName} name={fieldName} type="date" />;
    if (attrType === 'file') return <InputField label={attrName} name={fieldName} type="file" />;
    if (attrType === 'image') return <InputField label={attrName} name={fieldName} type="file" />;
    if (['checkbox', 'boolean'].indexOf(attrType) !== -1) {
        return <CheckField label={attrName} name={fieldName} />;
    }

    return <InputField label={attrName} name={fieldName} />;
};

const getAttributes = id => {
    return new API('/api/v1/attribute-sets').getOne(id).then(({ data: { attributes } }) => attributes);
};

const handleAttributeSetChange = (id, setAttributes, setFieldValue) => {
    setAttributes([]);
    setFieldValue('attribute_set_id', id);

    if (id) getAttributes(id).then(setAttributes);
};

export default function AttributesTab({ eventKey, setFieldValue, values }) {
    const [attributeSets, setAttributeSets] = useState([]);
    const [attributes, setAttributes] = useState([]);

    useEffect(() => {
        new API('/api/v1/attribute-sets').getAll().then(response => {
            setAttributeSets(response.data);

            if (values.attribute_set_id) getAttributes(values.attribute_set_id).then(setAttributes);
        });
    }, []);

    return (
        <Tab.Pane eventKey={eventKey}>
            <Tab.Container id="left-tabs-example" defaultActiveKey="default">
                <Row>
                    <Col md={10}>
                        <Tab.Content className="ml-3">
                            <Tab.Pane eventKey="default">
                                <Row>
                                    <Col sm={12} md={6} lg={4}>
                                        <SelectField
                                            label="Conjunto de Atributos"
                                            name="attribute_set_id"
                                            isIdValue
                                            onChange={e =>
                                                handleAttributeSetChange(e.target.value, setAttributes, setFieldValue)
                                            }
                                            options={attributeSets}
                                        />
                                    </Col>
                                </Row>
                                <fieldset>
                                    <legend>Padrão</legend>
                                    <Row>
                                        <Col sm={12} md={6} lg={4}>
                                            <SelectField label="Cor" name="color" options={[]} />
                                        </Col>
                                        <Col sm={12} md={6} lg={4}>
                                            <SelectField label="Tamanho" name="size" options={[]} />
                                        </Col>
                                        <Col sm={12} md={6} lg={4}>
                                            <SelectField label="Marca" name="brand" options={[]} />
                                        </Col>
                                    </Row>
                                </fieldset>
                                <fieldset>
                                    <legend>Personalizados</legend>
                                    <Row>
                                        {attributes
                                            ? attributes.map(attribute => (
                                                  <Col sm={12} md={6} lg={4}>
                                                      <AttributeField key={attribute.id} attribute={attribute} />
                                                  </Col>
                                              ))
                                            : null}
                                    </Row>
                                </fieldset>
                            </Tab.Pane>
                        </Tab.Content>
                    </Col>
                </Row>
            </Tab.Container>
        </Tab.Pane>
    );
}
