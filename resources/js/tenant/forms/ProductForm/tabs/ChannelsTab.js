import { Button, ButtonGroup, Tab } from 'react-bootstrap';
import React, { useEffect, useState } from 'react';
import Swal from 'sweetalert2';

import API from '../../../../services/api';
import ChannelModalForm from '../modals/ChannelModalForm';

export default function ChannelsTab({ eventKey, values }) {
    const [channels, setChannels] = useState([]);
    const [productChannels, setProductChannels] = useState([]);
    const [modalShow, setModalShow] = useState(false);
    const [modalProductChannel, setModalProductChannel] = useState({});

    const getChannels = () => {
        new API('/api/v1/channels').getAll().then(response => setChannels(response?.data || []));
    };

    const findChannelByCode = channelCode => {
        return channels.filter(item => item.code === channelCode)[0];
    };

    const findProductChannelByCode = channelCode => {
        const channel = findChannelByCode(channelCode);

        return channel ? productChannels.filter(item => item.channel_id === channel.id) : [];
    };

    const hasChannel = channelCode => {
        const productChannel = findProductChannelByCode(channelCode);
        return productChannel && productChannel.length > 0;
    };

    const activateSync = channel => {
        const productChannel = findProductChannelByCode(channel.channel);

        return new API(`/api/v1/products/${values.id}/channels`).create({ code: channel }).then(result => {
            if (result.success) setProductChannels(result.data);
        });
    };

    const deactivateSync = channelCode => {
        Swal.fire({
            title: 'Deseja desativar a sincronização para este canal?',
            text: 'Se você desativar, o produto será excluído no canal!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirmar',
            cancelButtonText: 'Cancelar',
        }).then(result => {
            if (result.value) {
                const channel = findChannelByCode(channelCode);

                new API(`/api/v1/products/${values.id}/channels`).delete(channel.id).then(response => {
                    if (response.success) {
                        setChannels(items => items.filter(item => item.id !== channel.id));
                    }
                });
            }
        });
    };

    const openConfigureModal = channelCode => {
        setModalProductChannel(findProductChannelByCode(channelCode)[0]);
        setModalShow(true);
    };

    useEffect(() => {
        setProductChannels(values.channels);
        getChannels();
    }, []);

    return (
        <Tab.Pane eventKey={eventKey}>
            <div className="row">
                {channels.length > 0 &&
                    ['WooCommerce', 'MercadoLivre', 'Sisplan', 'Dafiti'].map(channel => (
                        <div className="col-6 col-sm-4 col-lg-3 col-xl-2" key={channel}>
                            <div className="small-box bg-light">
                                <div className="inner">
                                    <img
                                        src={`/images/channels/${channel.toLowerCase()}.png`}
                                        className="img-fluid"
                                        alt={channel}
                                    />
                                </div>
                                <div className="small-box-footer">
                                    {hasChannel(channel) ? (
                                        <ButtonGroup block className="w-100">
                                            <Button variant="primary" onClick={() => deactivateSync(channel)}>
                                                Desativar Sinc.
                                            </Button>
                                            <Button variant="warning" onClick={() => openConfigureModal(channel)}>
                                                Configurar
                                            </Button>
                                        </ButtonGroup>
                                    ) : (
                                        <Button
                                            type="button"
                                            variant="primary"
                                            block
                                            onClick={() => activateSync({ channel })}
                                        >
                                            Ativar sincronização
                                        </Button>
                                    )}
                                </div>
                            </div>
                        </div>
                    ))}
            </div>

            <ChannelModalForm
                productChannel={modalProductChannel}
                show={modalShow}
                onHide={() => setModalShow(false)}
                product={values}
            />
        </Tab.Pane>
    );
}
