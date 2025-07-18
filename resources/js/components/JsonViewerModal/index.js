import React, { useState } from 'react';
import { Col, Modal, Row } from 'react-bootstrap';
import ReactJson from 'react-json-view';
import { isArray, isObject } from 'lodash';

function cleanJsonText(jsonText) {
    jsonText = jsonText.replaceAll('\\\\"', "'");
    jsonText = jsonText.replaceAll('\\"', '"');
    jsonText = jsonText.replaceAll("\\'", "'");
    jsonText = jsonText.replace(/^\\"(.+)\\"$/, '$1');

    return jsonText;
}

function jsonParse(jsonText) {
    try {
        return JSON.parse(cleanJsonText(jsonText));
    } catch (e) {
        return jsonText;
    }
}

export default function JsonViewerModal({ show, onHide, data = null }) {
    const [parsedJson, setParsedJson] = useState(null);
    const onShow = () => setParsedJson(jsonParse(data));

    return (
        <Modal show={show} onHide={onHide} onShow={onShow} size="xl">
            <Modal.Header closeButton>
                <Modal.Title>Visualização de Log</Modal.Title>
            </Modal.Header>
            <Modal.Body>
                <Row>
                    <Col md={12}>
                        {isArray(parsedJson) || isObject(parsedJson) ? (
                            <ReactJson src={parsedJson} theme="github" displayDataTypes={false} />
                        ) : (
                            <h5 className="text-center">{data || 'Nemhun log disponível.'}</h5>
                        )}
                    </Col>
                </Row>
            </Modal.Body>
        </Modal>
    );
}
