import { Button, Tab, Table } from 'react-bootstrap';
import React, { useEffect, useState } from 'react';
import Swal from 'sweetalert2';
import API from '../../../../services/api';

export default function AuthorizedClientsTab() {
    const [tokens, setTokens] = useState([]);

    const getTokens = () => new API('/oauth/tokens').getAll().then(setTokens);

    const destroy = (url, id) => {
        Swal.fire({
            title: 'Deseja revogar este cliente?',
            icon: 'warning',
            showCloseButton: true,
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Confirmar',
            reverseButtons: true,
            focusConfirm: false,
        }).then(result => {
            if (result.value) new API(url).delete(id).then(() => getTokens());
        });
    };

    useEffect(() => getTokens(), []);

    return (
        <Tab.Pane eventKey="tokens">
            <Table responsive>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    {tokens.map(token => (
                        <tr key={token.id}>
                            <td>{token.name}</td>
                            <th className="text-right">
                                <Button variant="outline-danger" onClick={() => destroy('/oauth/clients', token.id)}>
                                    <i className="fas fa-trash" />
                                </Button>
                            </th>
                        </tr>
                    ))}
                    {tokens.length === 0 && (
                        <tr>
                            <td colSpan={2} className="text-center">
                                Nenhuma aplicação autorizada.
                            </td>
                        </tr>
                    )}
                </tbody>
            </Table>
        </Tab.Pane>
    );
}
