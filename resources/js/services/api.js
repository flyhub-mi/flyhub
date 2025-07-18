import toastr from 'toastr';
import axios from './axios';

function onSuccess(response) {
    if (
        response.data.message &&
        !response.data.message.includes('requisitado') &&
        !response.data.message.includes('requisitada')
    ) {
        toastr.success(response.data.message);
    }

    return response.data;
}

function onError(response) {
    if (response?.data?.message) {
        toastr.error(response.data.message);
    } else {
        toastr.error(response);
    }

    return response;
}

export default class API {
    constructor(resource) {
        this.resource = resource;
    }

    getAll(params = {}, config = {}) {
        return axios
            .get(this.resource, { params }, config)
            .then(onSuccess)
            .catch(error => {
                onError(error);
            });
    }

    getOne(id, config = {}) {
        return axios
            .get(`${this.resource}/${id}`, config)
            .then(onSuccess)
            .catch(error => {
                onError(error.response);
            });
    }

    create(data, config = {}) {
        return axios
            .post(this.resource, data, config)
            .then(onSuccess)
            .catch(error => {
                onError(error.response);
            });
    }

    update(data, config = {}) {
        return axios
            .put(`${this.resource}/${data.id}`, data, config)
            .then(onSuccess)
            .catch(error => {
                onError(error.response);
            });
    }

    patch(id, data, config = {}) {
        return axios
            .patch(`${this.resource}/${id}`, data, config)
            .then(onSuccess)
            .catch(error => {
                onError(error.response);
            });
    }

    delete(id, config = {}) {
        return axios
            .delete(`${this.resource}/${id}`, config)
            .then(onSuccess)
            .catch(error => {
                onError(error.response);
            });
    }
}
