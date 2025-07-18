import { Tab } from 'react-bootstrap';
import React from 'react';
import TextareaField from '../../../../formik-fields/TextareaField';

export default function DescriptionTab({ eventKey }) {
    return (
        <Tab.Pane eventKey={eventKey}>
            <TextareaField rows="5" label="Descrição curta" name="short_description" />
            <TextareaField rows="5" label="Descrição completa" name="description" />
        </Tab.Pane>
    );
}
