import { Form } from 'react-bootstrap';
import PropTypes from 'prop-types';
import { Field } from 'formik';
import React from 'react';

const TextareaField = ({ type, label, rows, cols, disabled, ...props }) => {
    return (
        <Field {...props}>
            {({ field, meta }) => (
                <Form.Group controlId={field.name}>
                    {label && <Form.Label>{label}</Form.Label>}
                    <Form.Control
                        isInvalid={meta.touched && meta.error}
                        isValid={meta.touched && !meta.error}
                        disabled={disabled}
                        as="textarea"
                        rows={rows}
                        cols={cols}
                        {...field}
                        value={field.value || ''}
                    />
                    <Form.Control.Feedback type="invalid">{meta.error}</Form.Control.Feedback>
                </Form.Group>
            )}
        </Field>
    );
};

TextareaField.propTypes = {
    label: PropTypes.string,
    disabled: PropTypes.bool,
};

export default TextareaField;
