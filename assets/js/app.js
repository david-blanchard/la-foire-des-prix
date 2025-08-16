// import "./styles/app.css";
import * as bootstrap from "bootstrap";
import Cart from "./lib/cart.js";
import ProductPage from "./lib/product-page.js";
import Search from "./lib/search.js";

const page = new ProductPage();
page.bindImages();
page.attachImageEvents();
page.attachQuantityEvents();
page.attachAddToCartEvent();

const search = new Search()
search.attachSearchEvent()

const cart = new Cart()
cart.retrieve()
