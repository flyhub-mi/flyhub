import React from 'react';
import { Card, Tab, Nav } from 'react-bootstrap';
import CategoriesTab from './tabs/CategoriesTab';
import ConfigsTab from './tabs/ConfigsTab';

export default function({ model = {}, configs = {}, fields = [] }) {
    return (
        <Tab.Container defaultActiveKey="config">
            <Card>
                <Card.Header>
                    <Nav variant="pills">
                        <Nav.Item>
                            <Nav.Link eventKey="config">Configurações</Nav.Link>
                        </Nav.Item>
                        <Nav.Item>
                            <Nav.Link eventKey="categories">Categorias</Nav.Link>
                        </Nav.Item>
                    </Nav>
                </Card.Header>
            </Card>
            <Tab.Content>
                <CategoriesTab eventKey="categories" channel={model} />
                <ConfigsTab eventKey="config" channel={model} fields={fields} configs={configs} />
            </Tab.Content>
        </Tab.Container>
    );
}
