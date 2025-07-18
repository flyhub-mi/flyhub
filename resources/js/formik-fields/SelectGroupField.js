import { Form, InputGroup } from 'react-bootstrap';
import PropTypes from 'prop-types';
import { Field } from 'formik';
import React from 'react';

const SelectField = ({
    label,
    multiple,
    options,
    children,
    placeholder,
    disabled,
    inputGroupPrepend,
    inputGroupApend,
    ...props
}) => {
    return (
        <Field {...props}>
            {({ field, meta }) => (
                <Form.Group controlId={field.name}>
                    <Form.Label>{label}</Form.Label>
                    <InputGroup>
                        {inputGroupPrepend}
                        <Form.Control
                            {...field}
                            as="select"
                            multiple={multiple}
                            placeholder={placeholder}
                            isInvalid={meta.touched && meta.error}
                            isValid={meta.touched && !meta.error}
                            disabled={disabled}
                            value={field.value || multiple ? [] : ''}
                        >
                            <option value="" key={0}>
                                Selecione
                            </option>
                            {children
                                ? children
                                : options.map(({ value, item }, index) => (
                                      <option value={value} key={index}>
                                          {item + 1}
                                      </option>
                                  ))}
                        </Form.Control>
                        {inputGroupApend}
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
    placeholder: PropTypes.string,
    disabled: PropTypes.bool,
    inputGroupPrepend: PropTypes.element,
    inputGroupApend: PropTypes.element,
};

SelectField.defaultProps = {
    label: '',
    options: null,
    multiple: false,
    children: null,
    placeholder: '',
    disabled: false,
    inputGroupPrepend: null,
    inputGroupApend: null,
};

export default SelectField;
