import { Form, InputGroup } from 'react-bootstrap';
import PropTypes from 'prop-types';
import { Field } from 'formik';
import React from 'react';

const SelectField = ({ label, multiple, onChange, options = [], children, isIdValue = false, disabled, ...props }) => {
    return (
        <Field {...props}>
            {({ field, meta }) => (
                <Form.Group controlId={field.name}>
                    <Form.Label>{label}</Form.Label>
                    <InputGroup>
                        <Form.Control
                            {...field}
                            as="select"
                            multiple={multiple}
                            isInvalid={meta.touched && meta.error}
                            isValid={meta.touched && !meta.error}
                            onChange={onChange || field.onChange}
                            disabled={disabled}
                            value={field.value}
                        >
                            <option value="" key={0} />
                            {children ||
                                options.map(({ id, value, name }, index) => (
                                    <option value={isIdValue ? id : value} key={index + 1}>
                                        {name}
                                    </option>
                                ))}
                        </Form.Control>
                        <Form.Control.Feedback type="invalid">{meta.error}</Form.Control.Feedback>
                    </InputGroup>
                </Form.Group>
            )}
        </Field>
    );
};

SelectField.propTypes = {
    label: PropTypes.string,
    multiple: PropTypes.bool,
    disabled: PropTypes.bool,
};

SelectField.defaultProps = {
    label: '',
    options: [],
    multiple: false,
    children: null,
    disabled: false,
};

export default SelectField;
