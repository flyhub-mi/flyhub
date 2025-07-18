import { Form, InputGroup } from 'react-bootstrap';
import PropTypes from 'prop-types';
import { Field } from 'formik';
import React from 'react';

const CheckField = ({ type, label, placeholder, disabled, className, ...props }) => {
    return (
        <Field {...props}>
            {({ field, meta }) => (
                <Form.Group controlId={field.name} className={className}>
                    <Form.Check
                        {...field}
                        type={type}
                        placeholder={placeholder}
                        isInvalid={meta.touched && meta.error}
                        isValid={meta.touched && !meta.error}
                        disabled={disabled}
                        label={label}
                        checked={field.value === '1' || field.value === true}
                        value={field.value ? 'true' : 'false'}
                    />
                    <Form.Control.Feedback type="invalid">{meta.error}</Form.Control.Feedback>
                </Form.Group>
            )}
        </Field>
    );
};

CheckField.propTypes = {
    type: PropTypes.oneOf(['checkbox', 'radio']),
    label: PropTypes.string,
    disabled: PropTypes.bool,
};

CheckField.defaultProps = {
    type: 'checkbox',
    label: '',
    disabled: false,
};

export default CheckField;
