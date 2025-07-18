import * as React from 'react';
import NodeElement from './NodeElement';
import { startIsOpen, toggleIsOpen, isOpen } from './helpers';
import LeafElement from './LeafElement';

const Container = props => {
    const [_isOpen, _setIsOpen] = React.useState([]);
    const containerItems = [...props.nodes];
    const isRoot = props.level === 0;

    React.useEffect(() => {
        startIsOpen(containerItems, _setIsOpen);
    }, [containerItems.length]);

    return (
        <div className={[isRoot ? 'T-child-container' : 'T-root-container', 'T-container'].join(' ')}>
            <div className="T-dropzone">
                {containerItems.map((i, k) => {
                    return (
                        <div className={['T-content', isRoot ? 'T-root' : 'T-sub'].join(' ')} key={k}>
                            {i.children && i.children.length > 0 ? (
                                <>
                                    <NodeElement
                                        key={i}
                                        data={i}
                                        isRoot={isRoot}
                                        level={props.level}
                                        parent={props.parent}
                                        onSelect={props.onSelect}
                                        selected={props.selected}
                                        darkMode={props.darkMode}
                                        isOpen={isOpen(i, _isOpen)}
                                        toggle={() => toggleIsOpen(i, _isOpen, _setIsOpen)}
                                    />
                                    {isOpen(i, _isOpen) && (
                                        <div className="T-children">
                                            <Container
                                                key={i}
                                                parent={i}
                                                nodes={i.children}
                                                level={props.level + 1}
                                                onSelect={props.onSelect}
                                                selected={props.selected}
                                                darkMode={props.darkMode}
                                                channel={props.channel}
                                            />
                                        </div>
                                    )}
                                </>
                            ) : (
                                <LeafElement
                                    parent={props.parent}
                                    data={i}
                                    key={k}
                                    level={props.level}
                                    onSelect={props.onSelect}
                                    selected={props.selected}
                                    darkMode={props.darkMode}
                                    channel={props.channel}
                                />
                            )}
                        </div>
                    );
                })}
            </div>
        </div>
    );
};

Container.defaultProps = { nodes: [], level: 0, darkMode: false };

export default Container;
