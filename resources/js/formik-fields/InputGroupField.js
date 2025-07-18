import { Form, InputGroup } from 'react-bootstrap';
import PropTypes from 'prop-types';
import { Field } from 'formik';
import React from 'react';

const InputField = ({ type, label, placeholder, disabled, inputGroupPrepend, inputGroupApend, ...props }) => {
    return (
        <Field {...props}>
            {({ field, meta }) => (
                <Form.Group controlId={field.name}>
                    {label && <Form.Label>{label}</Form.Label>}
                    <InputGroup>
                        {inputGroupPrepend}
                        <Form.Control
                            placeholder={placeholder}
                            isInvalid={meta.touched && meta.error}
                            isValid={meta.touched && !meta.error}
                            disabled={disabled}
                            type={type}
                            {...field}
                            value={field.value || ''}
                        />
                        {inputGroupApend}
                        <Form.Control.Feedback type="invalid">{meta.error}</Form.Control.Feedback>
                    </InputGroup>
                    <Form.Control.Feedback type="invalid">{meta.error}</Form.Control.Feedback>
                </Form.Group>
            )}
        </Field>
    );
};

InputField.propTypes = {
    type: PropTypes.oneOf(['text', 'email', 'password', 'date', 'number']),
    label: PropTypes.string,
    disabled: PropTypes.bool,
    placeholder: PropTypes.string,
    inputGroupApend: PropTypes.element,
    inputGroupPrepend: PropTypes.element,
};

export default InputField;
