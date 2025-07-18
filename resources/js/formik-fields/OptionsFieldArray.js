import React from 'react';
import { Button, Col, Row } from 'react-bootstrap';
import { FieldArray } from 'formik';

import InputField from './InputField';

const blankOption = { name: '', sort_order: 1 };

const optionRow = ({ value, position }, index, remove, push, options) => {
    return (
        <Row key={index}>
            <Col lg={7}>
                <InputField name={`options[${index}].name`} value={value} />
            </Col>
            <Col lg={3}>
                <InputField name={`options[${index}].sort_order`} value={position} />
            </Col>
            <Col>
                <Row>
                    {options.length > 1 && (
                        <Col>
                            <Button onClick={() => remove(index)} variant="danger">
                                <i className="fa fa-trash" />
                            </Button>
                        </Col>
                    )}
                    {options.length - 1 === index && (
                        <Col>
                            <Button
                                onClick={() => push({ ...blankOption, sort_order: index + 2 })}
                                variant="primary"
                                style={{ paddingLeft: '5ps' }}
                            >
                                <i className="fa fa-plus" />
                            </Button>
                        </Col>
                    )}
                </Row>
            </Col>
        </Row>
    );
};

export default function OptionsFieldArray(props) {
    return (
        <FieldArray name="options" {...props}>
            {({ remove, push }) => (
                <>
                    {props.options.length > 0
                        ? props.options.map((item, index) => optionRow(item, index, remove, push, props.options))
                        : push(blankOption)}
                </>
            )}
        </FieldArray>
    );
}
