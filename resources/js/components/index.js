import React from 'react';
import ReactDOM from 'react-dom';
import ChannelSyncLogResult from './ChannelSyncLogResult';

export function mountComponent(component, id, props) {
    const element = document.getElementById(id);

    if (element && component === 'ChannelSyncLogResult') {
        ReactDOM.render(<ChannelSyncLogResult {...props} />, element);
    }
}
