import moment from 'moment';
import React, { useEffect, useState } from 'react';
import { Button } from 'react-bootstrap';
import DataTable from 'react-data-table-component';

import API from '../../services/api';
import JsonViewerModal from '../JsonViewerModal';
import './styles.scss';

function getResults(logId) {
    return new API(`/api/v1/channel-sync-logs/${logId}/results`).getAll().then(response => response.data);
}

const moreDetailCell = (data, showJsonModal) => {
    return (
        <div data-tag="allowRowEvents">
            <Button variant="primary" onClick={() => showJsonModal(data)} size="xs">
                <i className="fas fa-info" />
            </Button>
        </div>
    );
};

const dateTimeCell = date => {
    return <div data-tag="allowRowEvents">{moment(date).format('DD/MM/YYYY - HH:mm:ss')}</div>;
};

const columns = showJsonModal => [
    {
        name: 'Status',
        selector: 'status',
        sortable: true,
        grow: 1,
    },
    {
        name: 'Dados',
        selector: 'error',
        grow: 1,
        cell: row => moreDetailCell(row.error, showJsonModal),
    },
    {
        name: 'Erro',
        selector: 'data',
        grow: 1,
        cell: row => moreDetailCell(row.data, showJsonModal),
    },
    {
        name: 'Resultado',
        selector: 'result',
        grow: 1,
        cell: row => moreDetailCell(row.result, showJsonModal),
    },
    {
        name: 'Criado em',
        selector: 'created_at',
        grow: 2,
        sortable: true,
        cell: row => dateTimeCell(row.created_at),
    },
    {
        name: 'Atualizado em',
        selector: 'updated_at',
        grow: 2,
        sortable: true,
        cell: row => dateTimeCell(row.updated_at),
    },
];

export default function ChannelSyncLogResult({ logId }) {
    const [logResults, setLogResults] = useState([]);
    const [loading, setLoading] = useState(true);
    const [data, setData] = useState(null);
    const [showJsonViewerModal, setShowJsonViewerModal] = useState(false);

    const showJsonModal = async data => {
        setData(data);
        setShowJsonViewerModal(true);
    };

    useEffect(() => {
        setLogResults([]);
        getResults(logId).then(results => {
            setLogResults(results);
            setLoading(false);
        });
    }, [logId]);

    return (
        <>
            <DataTable
                columns={columns(showJsonModal)}
                data={logResults}
                pagination
                striped
                progressPending={loading}
            />

            <JsonViewerModal show={showJsonViewerModal} data={data} onHide={() => setShowJsonViewerModal(false)} />
        </>
    );
}
