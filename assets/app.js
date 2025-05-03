import "./styles/app.css";
import Cart from "./lib/cart";
import ProductPage from "./lib/product-page";
import Search from "./lib/search";

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
