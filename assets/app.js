import "./styles/app.css";
import "./js/vendor/bootstrap.bundle.min.js";
import "./js/vendor/jquery.min.js";
import Cart from "./js/cart.js";
import ProductPage from "./js/product-page.js";
import Search from "./js/search.js";

const page = new ProductPage();
page.bindImages();
page.attachImageEvents();
page.attachQuantityEvents();
page.attachAddToCartEvent();

const search = new Search()
search.attachSearchEvent()

const cart = new Cart()
cart.retrieve()

console.log("Happy coding !!");
