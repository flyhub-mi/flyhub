import * as React from 'react';
import PropTypes from 'prop-types';

import Container from './Tree/Container';
import './styles/Tree.scss';

const Tree = props => {
    const [_nodeList, _setNodeList] = React.useState(null);
    const [_selected, _setSelected] = React.useState(null);

    const selectNode = selectedNode => {
        _setSelected(selectedNode);
        props.onSelect(selectedNode);
    };

    React.useEffect(() => {
        if (props.selected) {
            _setSelected(props.selected);
        }

        _setNodeList(props.nodes);
    });

    return (
        <div
            className={[
                'Tree',
                props.size + '-width',
                props.darkMode ? 'T-dark' : 'T-light',
                props.nodes ? '' : 'T-loading',
            ].join(' ')}
            style={{ minHeight: 400 }}
        >
            {_nodeList && (
                <Container
                    selected={_selected}
                    onSelect={selectNode}
                    parent={null}
                    nodes={_nodeList}
                    darkMode={props.darkMode}
                    channel={props.channel}
                />
            )}
            {!_nodeList && (
                <div className="T-loader">
                    <div className="T-spinner">
                        <i className="fas fa-circle-notch fa-lg fa-spin" />
                    </div>
                </div>
            )}
        </div>
    );
};

Tree.defaultProps = {
    nodes: null,
    refresh: 0,
    size: 'full',
    darkMode: false,
    onSelect: () => {},
    channel: null,
};

Tree.protoTypes = {
    nodes: PropTypes.array,
    refresh: PropTypes.number,
    size: PropTypes.string,
    darkMode: PropTypes.bool,
    onSelect: PropTypes.func,
};

export default Tree;
