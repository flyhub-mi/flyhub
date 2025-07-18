import { Button, Tab, Table } from 'react-bootstrap';
import React from 'react';
import { FieldArray } from 'formik';
import InputField from '../../../../formik-fields/InputField';

export default function({ eventKey, values }) {
    const defaultOption = { label: '', value: '', position: 1 };

    return (
        <Tab.Pane eventKey={eventKey}>
            <Table striped bordered hover>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Valor</th>
                        <th />
                    </tr>
                </thead>
                <tbody>
                    <FieldArray name="options">
                        {({ push, remove }) => (
                            <>
                                {values.options.map(({ label, value, position }, index) => (
                                    <tr key={index}>
                                        <td>
                                            <InputField name={`options[${index}].label`} value={label} />
                                        </td>
                                        <td>
                                            <InputField name={`options[${index}].value`} value={value} />
                                        </td>
                                        <td>
                                            <Button onClick={() => remove(index)}>
                                                <i className="fa fa-trash" />
                                            </Button>
                                        </td>
                                    </tr>
                                ))}
                                <tr>
                                    <td colSpan="2" />
                                    <td>
                                        <Button onClick={() => push(defaultOption)}>
                                            Adicionar opção <i className="fa fa-plus-circle" />
                                        </Button>
                                    </td>
                                </tr>
                            </>
                        )}
                    </FieldArray>
                </tbody>
            </Table>
        </Tab.Pane>
    );
}
