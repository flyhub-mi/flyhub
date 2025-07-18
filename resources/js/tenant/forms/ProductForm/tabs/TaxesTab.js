import { Col, Row, Tab } from 'react-bootstrap';
import React, { useEffect, useState } from 'react';

import API from '../../../../services/api';

export default function TaxTab({ eventKey }) {
    const [taxes, setTaxes] = useState([]);

    useEffect(() => {
        new API('/api/v1/tax-groups').getAll().then(response => {
            setTaxes(response.data);
        });
    }, []);

    return (
        <Tab.Pane eventKey={eventKey}>
            <Tab.Container id="left-tabs-example" defaultActiveKey="default">
                <Row>
                    <Col md={10}>
                        <Tab.Content className="ml-3">
                            <Tab.Pane eventKey="default">
                                {taxes.map(tax => (
                                    <fieldset>
                                        <legend>{tax.name}</legend>
                                        <Row>
                                            <Col>{/*TODO: Campos de cada grupo de taxas.*/}</Col>
                                        </Row>
                                    </fieldset>
                                ))}
                            </Tab.Pane>
                        </Tab.Content>
                    </Col>
                </Row>
            </Tab.Container>
        </Tab.Pane>
    );
}
