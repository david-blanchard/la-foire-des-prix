class ProductPage {
    constructor() {
        this.quantityComponent = document.querySelector(
            'span[id="quantity"][name="count"]'
        );
        this.productComponent = document.querySelector(
            'div[id="product"][name="product-data"]'
        );
    }

    get productId() {
        const product = this.productComponent;
        const id = product.dataset["id"];

        return id;
    }

    get quantity() {
        let count = parseInt(this.quantityComponent.innerText);
        count = count === NaN ? 1 : count;

        return count;
    }

    bindImages() {
        document.querySelectorAll('img[name="picto"]').forEach((item) => {
            item.src = item.dataset["src"];
        });
    }

    attachImageEvents() {
        const mainPicto = document.querySelector(
            '#main-picto img[name="picto"]'
        );

        document
            .querySelectorAll('button[name="btn-picto"]')
            .forEach((item) => {
                item.onclick = (e) => {
                    mainPicto.src = e.target.dataset["src"];
                };
            });
    }

    attachQuantityEvents() {
        document
            .querySelectorAll('a[name="quantity-handler"]')
            .forEach((item) => {
                const operand = item.id;
                item.onclick = () => {
                    const inc =
                        operand === "more" ? 1 : operand === "less" ? -1 : 0;
                    let count = this.quantity + inc;
                    count = count < 1 ? 1 : count;
                    this.quantityComponent.innerText = count;
                };
            });
    }

    attachAddToCartEvent() {
        let addToCart = document.querySelector('button[id="add-to-cart"]');

        addToCart.onclick = () => {
            const cart = new Cart()
            cart.store(this.productId, this.quantity);
        };
    }

}

(() => {
    let page = new ProductPage();
    page.bindImages();
    page.attachImageEvents();
    page.attachQuantityEvents();
    page.attachAddToCartEvent();

})();
