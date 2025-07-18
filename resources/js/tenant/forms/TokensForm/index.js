import React from 'react';
import { Card, Tab, Nav } from 'react-bootstrap';
import AuthorizedClientsTab from './tabs/AuthorizedClientsTab';
import ClientsTab from './tabs/ClientsTab';
import PersonalAccessTokensTab from './tabs/PersonalAccessTokensTab';

export default function TokensForm() {
    return (
        <Tab.Container defaultActiveKey="personalAccessTokens">
            <Card>
                <Card.Header>
                    <Nav variant="pills">
                        <Nav.Item>
                            <Nav.Link eventKey="personalAccessTokens">Tokens de acesso pessoal</Nav.Link>
                        </Nav.Item>
                        <Nav.Item>
                            <Nav.Link eventKey="tokens">Aplicações Autorizadas</Nav.Link>
                        </Nav.Item>
                        <Nav.Item>
                            <Nav.Link eventKey="clients">Clientes oAuth</Nav.Link>
                        </Nav.Item>
                    </Nav>
                </Card.Header>
                <Card.Body className="p-0">
                    <Tab.Content>
                        <PersonalAccessTokensTab eventKey="personalAccessTokens" />
                        <AuthorizedClientsTab eventKey="tokens" />
                        <ClientsTab eventKey="clients" />
                    </Tab.Content>
                </Card.Body>
            </Card>
        </Tab.Container>
    );
}
