import * as React from 'react';
import Wrapper from './Wrapper';
import { getSelectedClass } from './helpers';

const NodeElement = props => {
    if (props.data === null) {
        return null;
    }

    const selectedClass = getSelectedClass(props.data, props.selected, props.darkMode);

    return (
        <div
            onClick={() => {
                props.toggle();
                props.onSelect({ ...props.data, parent: props.parent });
            }}
            className={['T-node', props.isOpen && props.isRoot ? 'T-open-node' : '', selectedClass].join(' ')}
        >
            <Wrapper level={props.level}>
                <span className="T-icon">
                    <i className={props.isOpen ? 'fas fa-chevron-down' : 'fas fa-chevron-right'} />
                </span>
                <span className="T-ntext">{props.data.name}</span>
            </Wrapper>
        </div>
    );
};

Node.defaultProps = {
    parent: null,
    data: null,
    toggle: () => {},
    isOpen: false,
    isRoot: false,
    level: 0,
    selected: null,
    onSelect: () => {},
    darkMode: false,
};

export default NodeElement;
