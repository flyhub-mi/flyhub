import React, { useEffect, useState } from 'react';
import { useDropzone } from 'react-dropzone';
import Swal from 'sweetalert2';
import { Button } from 'react-bootstrap';

import API from '../../services/api';
import './style.scss';

const thumbsContainer = {
    display: 'flex',
    flexDirection: 'row',
    flexWrap: 'wrap',
    marginTop: 16,
};

const thumb = {
    display: 'inline-flex',
    borderRadius: 2,
    border: '1px solid #eaeaea',
    marginBottom: 8,
    marginRight: 8,
    width: 100,
    height: 100,
    padding: 4,
    boxSizing: 'border-box',
};

const thumbInner = {
    display: 'flex',
    minWidth: 0,
    overflow: 'hidden',
    position: 'relative',
};

const img = {
    display: 'block',
    width: 'auto',
    height: '100%',
    margin: '0 auto',
};

function Dropzone({ postUrl, existingFiles, onSelect }) {
    const [files, setFiles] = useState([]);
    const [selectedFiles, setSelectedFiles] = useState([]);

    const { getRootProps, getInputProps } = useDropzone({
        accept: 'image/*',
        onDrop: acceptedFiles => {
            acceptedFiles.forEach(file => {
                const formData = new FormData();
                formData.append('file', file);

                new API(postUrl)
                    .create(formData, {
                        headers: { 'content-type': 'multipart/form-data' },
                    })
                    .then(({ data: { url, id } }) => setFiles(files => [...files, { name: file.name, url, id }]));
            });
        },
    });

    const selectFile = (file, index) => {
        setSelectedFiles(items => {
            const selecteds = items.includes(index) ? items.filter(value => value !== index) : [...items, index];
            onSelect(() => files.filter((_, index) => selecteds.includes(index)));

            return selecteds;
        });
    };

    const deleteImages = images => {
        Swal.fire({
            title: 'Deseja excluir estas imagens?',
            text: 'Você não vai poder reverter isto!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirmar',
            cancelButtonText: 'Cancelar',
        }).then(result => {
            if (result.value) {
                images.forEach(index => {
                    const image = files[index];

                    new API(postUrl).delete(image.id).then(response => {
                        if (response.success) {
                            const validFileIndex = files.findIndex(e => e.index === index);
                            files.splice(validFileIndex, 1);
                            setFiles([...files]);
                            const selectedFileIndex = selectedFiles.findIndex(e => e.index === index);
                            selectedFiles.splice(selectedFileIndex, 1);
                            setSelectedFiles([...selectedFiles]);
                        }
                    });
                });
            }
        });
    };

    useEffect(() => {
        existingFiles.forEach(file => {
            setFiles(files => [...files, file]);
        });
    }, []);

    return (
        <section className="container-fluid">
            <div {...getRootProps({ className: 'dropzone' })}>
                <input {...getInputProps()} />
                <p>Arraste as imagens aqui ou clique para selecionar.</p>
            </div>
            <div style={thumbsContainer}>
                {files.map((file, index) => (
                    <div
                        key={index}
                        style={{
                            ...thumb,
                            border: selectedFiles.includes(index) ? '2px solid #2799f3' : '1px solid #eaeaea',
                        }}
                        onClick={() => selectFile(file, index)}
                    >
                        <div style={thumbInner}>
                            <img src={`https://s3.us-east-2.amazonaws.com/${file.url}`}  style={img} />
                        </div>
                    </div>
                ))}
            </div>
            <div className="container-fluid">
                <Button type="button" variant="default" disabled={selectedFiles.length !== 1}>
                    <i className="fas fa-address-book" /> Marcar foto como capa
                </Button>
                <Button type="button" variant="default" className="ml-2" disabled={selectedFiles.length < 1}>
                    <i className="fas fa-copy" /> Replicar fotos para variações
                </Button>
                <Button
                    type="button"
                    variant="danger"
                    className="ml-2"
                    disabled={selectedFiles.length < 1}
                    onClick={() => deleteImages(selectedFiles)}
                >
                    <i className="fas fa-trash" /> Excluir fotos
                </Button>
            </div>
        </section>
    );
}

Dropzone.defaultProps = {
    postUrl: '',
    existingFiles: [],
    onSelect: () => {},
};

export default Dropzone;
