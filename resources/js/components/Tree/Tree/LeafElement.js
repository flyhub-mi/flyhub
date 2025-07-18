import * as React from 'react';
import Wrapper from './Wrapper';
import { getSelectedClass } from './helpers';

const LeafElement = props => {
    const selectedClass = getSelectedClass(props.data, props.selected, props.darkMode);
    const mappedCategory = props.channel && props.data.channels.find(({ channel_id }) => channel_id === props.channel);

    return (
        <div
            onClick={() => props.onSelect({ ...props.data, parent: props.parent })}
            className={['T-leaf', selectedClass].join(' ')}
        >
            <Wrapper level={props.level}>
                <span className="T-icon">
                    <i className="fas fa-tag" />
                </span>
                <span className="T-ltext">
                    {props.data.name}
                    {mappedCategory && (
                        <span>
                            {' '}
                            <i className="fas fa-link" /> {mappedCategory.channel_category_name}
                        </span>
                    )}
                </span>
            </Wrapper>
        </div>
    );
};

LeafElement.defaultProps = {
    data: { id: null, name: null },
    level: 0,
    darkMode: false,
    onSelect: () => {},
    selected: null,
};

export default LeafElement;
