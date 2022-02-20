
const cart = {
    increaseQuantity(productId) {
        // @Todo ajax request
        /*
        const param = {
            'productId' => $productId,
            'quantity' => 1
        }
        fetch('/basket/add', {
            method: 'post',
            body: JSON.stringify(params)
        })
        .then(response => response.json().then((data) => {
        })).catch(e => {
            throw e;
        });
         */
        // If OK
        this.setQuantity(productId, 'increase');
    },
    decreaseQuantity(productId) {
        // @Todo ajax request
        /*
        const param = {
            'productId' => $productId,
            'quantity' => 1
        }
        fetch('/basket/remove', {
            method: 'post',
            body: JSON.stringify(params)
        })
        .then(response => response.json().then((data) => {
        })).catch(e => {
            throw e;
        });
         */
        // If OK
        this.setQuantity(productId, 'decrease');
    },
    setQuantity(productId, action) {
        const quantityElt = document.querySelector('[data-id="'+productId+'"][data-quantity]');
        let quantity = quantityElt.getAttribute('data-quantity');

        switch (action) {
            case 'increase':
                quantity = parseInt(quantity) + 1;
                break;
            case 'decrease':
                quantity = parseInt(quantity) - 1;
                break;
            default:
                break;
        }

        quantityElt.innerHTML = quantity.toString();
        quantityElt.setAttribute('data-quantity', quantity.toString());
    }
};

const initEvent = function() {
    document.querySelectorAll('[data-action]').forEach((element) => {
        element.addEventListener('click', (elt) => {
            const productId = element.getAttribute('data-id');
            const action = element.getAttribute('data-action');
            switch (action) {
                case 'increase':
                    cart.increaseQuantity(productId);
                    break;
                case 'decrease':
                    cart.decreaseQuantity(productId);
                    break;
                default:
                    break;
            }
        })
    });
};

window.addEventListener('DOMContentLoaded', function() {
    if(document.querySelectorAll('[data-action]')) {
        initEvent();
    }
});

window.cart = cart;