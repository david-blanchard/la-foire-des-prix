// import "./styles/app.css";
import Cart from '../../app/Service/cart.ts';
import ProductPageService from '../../app/Components/ProductInfo/ProductInfoService.tsx';
import Search from '../../app/Components/Search/SearchPageService.tsx';

const page = new ProductPageService();
page.bindImages();
page.attachImageEvents();
page.attachQuantityEvents();
page.attachAddToCartEvent();

const search = new Search();
search.attachSearchEvent();

const cart = new Cart();
cart.retrieve();
