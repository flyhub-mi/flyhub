import React from 'react';
import ReactDOM from 'react-dom';
import AttributeSetForm from './AttributeSetForm';
import AttributeForm from './AttributeForm/index';
import CategoriesForm from './CategoriesForm';
import ChannelForm from './ChannelForm/index';
import ProductForm from './ProductForm/index';
import TokensForm from './TokensForm/index';
import TaxForm from './TaxForm/TaxForm';
import TaxGroupForm from './TaxGroupForm';

function mountComponent(Component, id) {
    const element = document.getElementById(id);

    if (element) {
        const props = {
            model: JSON.parse(element.getAttribute('model') || '{}'),
            fields: JSON.parse(element.getAttribute('fields') || '{}'),
            configs: JSON.parse(element.getAttribute('configs') || '{}'),
        };

        ReactDOM.render(<Component {...props} />, element);
    }
}

mountComponent(AttributeSetForm, 'attribute-set-form');
mountComponent(AttributeForm, 'attribute-form');
mountComponent(CategoriesForm, 'categories-form');
mountComponent(ChannelForm, 'channel-form');
mountComponent(ProductForm, 'product-form');
mountComponent(TokensForm, 'tokens-form');
mountComponent(TaxForm, 'tax-form');
mountComponent(TaxGroupForm, 'tax-group-form');
