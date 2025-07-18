import React from 'react';
import * as Yup from 'yup';
import { Formik } from 'formik';
import { Button, Card, Col, Form, Row } from 'react-bootstrap';
import InputField from '../../../formik-fields/InputField';
import SelectField from '../../../formik-fields/SelectField';
import redirect from '../../../services/redirect';
import API from '../../../services/api';
import CheckField from '../../../formik-fields/CheckField';
import OptionsFieldArray from '../../../formik-fields/OptionsFieldArray';

const validationSchema = Yup.object().shape({
    code: Yup.string().max(191),
    name: Yup.string()
        .max(191)
        .required(),
    input_type: Yup.string().required(),
    position: Yup.number(),
    is_required: Yup.boolean(),
    value_per_channel: Yup.boolean(),
    is_filterable: Yup.boolean(),
    is_configurable: Yup.boolean(),
    is_user_defined: Yup.boolean(),
    default_value: Yup.string(),
    options: Yup.array(),
});

const initialValues = {
    code: '',
    name: '',
    input_type: '',
    position: '',
    is_required: false,
    is_unique: false,
    value_per_channel: false,
    is_filterable: false,
    is_configurable: false,
    is_user_defined: false,
    options: [{ name: '', sort_order: '' }],
};

export default function({ model = {} }) {
    const handleSubmit = values => {
        const formatedValues = { ...values, options: values.options.filter(({ name }) => name) };

        model.id ? updateOptions(formatedValues) : createOptions(formatedValues);
    };

    const updateOptions = values => {
        return new API('/api/v1/attributes').patch(model.id, values);
    };

    const createOptions = values => {
        return new API('/api/v1/attributes').create(values).then(response => {
            if (response.success) {
                redirect('/catalog/attributes');
            }
        });
    };

    return (
        <>
            <Formik
                enableReinitialize
                validationSchema={validationSchema}
                initialValues={{ ...initialValues, ...model }}
                onSubmit={handleSubmit}
            >
                {({ handleSubmit, isValid, values, setFieldValue }) => (
                    <Form noValidate onSubmit={handleSubmit}>
                        <Card>
                            <Card.Body>
                                <Row>
                                    <Col lg={6}>
                                        <Row>
                                            <Col>
                                                <InputField label="Código Interno" name="code" disabled />
                                            </Col>
                                        </Row>
                                        <Row>
                                            <Col>
                                                <InputField label="Nome" name="name" />
                                            </Col>
                                            <Col>
                                                <SelectField label="Campo de entrada" name="input_type">
                                                    <option value="text">Texto</option>
                                                    <option value="textarea">Area de Texto</option>
                                                    <option value="price">Preço</option>
                                                    <option value="weight">Peso</option>
                                                    <option value="integer">Número Inteiro</option>
                                                    <option value="float">Número Decimal</option>
                                                    <option value="boolean">Verdadeiro ou Falso</option>
                                                    <option value="select">Escolha</option>
                                                    <option value="multiselect">Multi Escolha</option>
                                                    <option value="datetime">Data e Hora</option>
                                                    <option value="date">Data</option>
                                                    <option value="media_image">Mídia Imagem</option>
                                                    <option value="media_video">Mídia Vídeo</option>
                                                    <option value="file">Arquivo</option>
                                                    <option value="checkbox">Caixa de Marcação</option>
                                                </SelectField>
                                            </Col>
                                        </Row>

                                        <fieldset>
                                            <legend>Configurações</legend>
                                            <Row>
                                                <Col>
                                                    <CheckField
                                                        type="checkbox"
                                                        label="Valor por canal"
                                                        name="value_per_channel"
                                                    />
                                                </Col>
                                                <Col>
                                                    <CheckField
                                                        type="checkbox"
                                                        label="Obrigatório informar"
                                                        name="is_required"
                                                    />
                                                </Col>
                                                <Col>
                                                    <CheckField
                                                        type="checkbox"
                                                        label="Filtrável na Loja"
                                                        name="is_filterable"
                                                    />
                                                </Col>
                                                <Col>
                                                    <CheckField
                                                        type="checkbox"
                                                        label="Configurável"
                                                        name="is_configurable"
                                                    />
                                                </Col>
                                                <Col>
                                                    <CheckField
                                                        type="checkbox"
                                                        label="Definido pelo cliente na Loja"
                                                        name="is_user_defined"
                                                    />
                                                </Col>
                                                <Col>
                                                    <InputField label="Valor padrão" name="default_value" />
                                                </Col>
                                            </Row>
                                        </fieldset>
                                    </Col>
                                    <Col lg={6}>
                                        {['select', 'multiselect'].indexOf(values.type) !== -1 && (
                                            <fieldset>
                                                <legend>Opções</legend>
                                                <Row>
                                                    <Col lg={12}>
                                                        <fieldset>
                                                            <OptionsFieldArray options={values.options} />
                                                        </fieldset>
                                                    </Col>
                                                </Row>
                                            </fieldset>
                                        )}
                                    </Col>
                                </Row>
                            </Card.Body>
                            <Card.Footer>
                                <Button
                                    type="button"
                                    variant="secondary"
                                    className="mr-2"
                                    onClick={() => redirect('/catalog/attributes')}
                                >
                                    Voltar
                                </Button>
                                <Button type="submit" variant="primary" disabled={!isValid}>
                                    Salvar
                                </Button>
                            </Card.Footer>
                        </Card>
                    </Form>
                )}
            </Formik>
        </>
    );
}
