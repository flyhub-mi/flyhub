import * as React from 'react';
import PropTypes from 'prop-types';
import Container from './Tree/Container';
import './styles/Tree.scss';

const CheckboxTree = props => {
    const [_itemList, _setItemList] = React.useState(null);
    const [_selected, _setSelected] = React.useState(null);

    const selectItem = selectedItem => {
        _setSelected(selectedItem);
        props.onSelect(selectedItem);
    };

    React.useEffect(() => {
        _setItemList(props.items);
    });

    return (
        <div
            className={[
                'Tree',
                props.size + '-width',
                props.darkMode ? 'T-dark' : 'T-light',
                props.items ? '' : 'T-loading',
            ].join(' ')}
            style={{ minHeight: 400 }}
        >
            {_itemList && (
                <Container
                    selected={_selected}
                    onSelect={selectItem}
                    parent={null}
                    items={_itemList}
                    darkMode={props.darkMode}
                    channel={props.channel}
                />
            )}
            {!_itemList && (
                <div className="T-loader">
                    <div className="T-spinner">
                        <i className="fas fa-circle-notch fa-lg fa-spin" />
                    </div>
                </div>
            )}
        </div>
    );
};

CheckboxTree.defaultProps = {
    items: null,
    size: 'full',
    onSelect: () => {},
};

CheckboxTree.protoTypes = {
    items: PropTypes.array,
    size: PropTypes.string,
    onSelect: PropTypes.func,
};

export default CheckboxTree;
