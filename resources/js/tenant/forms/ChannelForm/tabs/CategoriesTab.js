import React, { useEffect, useState } from 'react';
import { Button, Card, Col, Form, Row, Tab } from 'react-bootstrap';
import API from '../../../../services/api';
import Tree from '../../../../components/Tree';

const cardBodyStyle = { height: 'calc(100vh - 450px)', minHeight: 400 };

const recursiveMap = (items, selectedNode, children) => {
    return items.map(item => {
        const newItem = { ...item };
        newItem.children = item.children ? recursiveMap(item.children, selectedNode, children) : [];
        return newItem.id === selectedNode.id ? { ...newItem, children: children } : newItem;
    });
};

export default function({ eventKey, channel }) {
    const [localCategoriesTree, setLocalCategoriesTree] = useState([]);
    const [channelCategoriesTree, setChannelCategoriesTree] = useState([]);
    const [selectedLocalCategory, setSelectedLocalCategory] = useState(null);
    const [selectedChannelCategory, setSelectedChannelCategory] = useState(null);

    const onSelectLocalCategory = selectedNode => {
        if (selectedNode?.children?.length === 0) {
            setSelectedLocalCategory(selectedNode);
        }
    };

    const onSelectChannelCategory = selectedNode => {
        fetchAndSetChannelCategories(selectedNode);
    };

    const fetchAndSetChannelCategories = selectedNode => {
        const url = `/api/v1/channels/${channel.id}/categories${selectedNode ? '/' + selectedNode.id : ''}`;

        new API(url).getAll().then(response => {
            if (selectedNode && response.data.length > 0) {
                setChannelCategoriesTree(recursiveMap([...channelCategoriesTree], selectedNode, response.data));
            } else if (response.data.length > 0) {
                setChannelCategoriesTree(response.data);
            } else if (response.data.length === 0) {
                setSelectedChannelCategory(selectedNode);
            }
        });
    };

    const parseValue = selected => {
        return selected ? `${selected.id} - ${selected.name}` : '';
    };

    useEffect(() => {
        new API('/api/v1/categories').getAll().then(response => {
            setLocalCategoriesTree(response.data || []);
        });

        fetchAndSetChannelCategories();
    }, []);

    const linkCategories = () => {
        if (selectedLocalCategory && selectedChannelCategory) {
            const data = {
                channel_id: channel.id,
                category_id: selectedLocalCategory.id,
                remote_category_id: selectedChannelCategory.id,
                channel_category_name: selectedChannelCategory.name,
            };
            new API(`/api/v1/channels/${channel.id}/categories`).create(data).then(response => {
                setLocalCategoriesTree(response.data || []);
            });
        } else {
            alert('Selecione as categorias.');
        }
    };

    return (
        <Tab.Pane eventKey={eventKey}>
            <Row>
                <Col md={6}>
                    <Card>
                        <Card.Header>
                            <Card.Title>Categorias Locais</Card.Title>
                        </Card.Header>
                        <Card.Body className="overflow-auto p-0" style={cardBodyStyle}>
                            {localCategoriesTree.length && (
                                <Tree
                                    nodes={localCategoriesTree}
                                    onSelect={onSelectLocalCategory}
                                    channel={channel.id}
                                />
                            )}
                        </Card.Body>
                    </Card>
                </Col>
                <Col md={6}>
                    <Card>
                        <Card.Header>
                            <Card.Title>Categorias do Canal</Card.Title>
                        </Card.Header>
                        <Card.Body className="overflow-auto p-0" style={cardBodyStyle}>
                            {channelCategoriesTree.length && (
                                <Tree nodes={channelCategoriesTree} onSelect={onSelectChannelCategory} />
                            )}
                        </Card.Body>
                    </Card>
                </Col>
            </Row>

            <Row>
                <Col>
                    <Card>
                        <Card.Footer>
                            <Form>
                                <Row>
                                    <Col>
                                        <Form.Control
                                            type={'text'}
                                            value={parseValue(selectedLocalCategory)}
                                            disabled
                                        />
                                    </Col>
                                    <Col>
                                        <Button primary block onClick={linkCategories}>
                                            Linkar Categorias
                                        </Button>
                                    </Col>
                                    <Col>
                                        <Form.Control
                                            type={'text'}
                                            value={parseValue(selectedChannelCategory)}
                                            disabled
                                        />
                                    </Col>
                                </Row>
                            </Form>
                        </Card.Footer>
                    </Card>
                </Col>
            </Row>
        </Tab.Pane>
    );
}
