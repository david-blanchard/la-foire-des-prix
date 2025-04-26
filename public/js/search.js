class Search {
    constructor() {
        this.searchButton = document.querySelector(
            'form[id="form0"] button[id="submit-search-cta"]'
        );
        this.searchInput = document.querySelector(
            'input[id="search"][name="product"]'
        );
    }

    attachSearchEvent() {
        this.searchButton.onclick = () => {
            const value = this.searchInput.value
            location.href = "/recherche/" + value
        };
    }
}

(() => {
    const search = new Search()
    search.attachSearchEvent()
})()