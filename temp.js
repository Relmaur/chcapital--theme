import "https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js";
import "https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js";

document.addEventListener('alpine:init', () => {

    console.log("Alpine instantiated from Events: ", Alpine)

    Alpine.data('Events', () => ({
        selected_category: "all",
        selectCategory(category) {
            this.selected_category = category;
        }
    }));

    Alpine.data('EventItem', () => ({
        categories_array: [],
        init() {
            let categories_raw = this.$el.querySelector('.categories').innerText;
            let categories_array = categories_raw.trim().split(" ");
            this.categories_array = categories_array;
        },
        showCard() {
            if (this.categories_array.includes(this.selected_category) || this.selected_category === 'all') {
                return true;
            } else {
                return false;
            }
        }
    }));
});

document.addEventListener('alpine:init', () => {

    console.log("Alpine instantiated from Events: ", Alpine)

    Alpine.data('Events', () => ({

        openedFAQ: '',
        openFAQ(index) {
            if (this.openedFAQ === index) {
                this.openedFAQ = false;
            } else {
                this.openedFAQ = index
            }
        },
        isFAQOpened(index) {
            return index === this.openedFAQ
        }

    }));
});


document.addEventListener('alpine:init', () => {
    Alpine.data('FAQs', () => ({

        openedFAQ: '',
        openFAQ(index) {
            if (this.openedFAQ === index) {
                this.openedFAQ = false;
            } else {
                this.openedFAQ = index
            }
        },
        isFAQOpened(index) {
            return index === this.openedFAQ
        }

    }));
});

document.addEventListener('alpine:init', () => {

    console.log("Alpine instantiated from Events: ", Alpine)

    Alpine.data('Resources', () => ({

        selected_cost: '',
        selected_categories: ['all'],

        selectCost(cost) {
            this.selected_cost = (this.selected_cost === cost) ? '' : cost;
        },
        isCostSelected(cost) {
            return this.selected_cost === cost;
        },

        selectCategory(category) {
            if (category === 'all') {
                this.selected_categories = ['all'];
            } else {
                if (this.selected_categories.includes(category)) {
                    let newArr = this.selected_categories.filter(item => item !== category);
                    if (this.selected_categories.length === 1) {
                        this.selected_categories = ['all'];
                    } else {
                        this.selected_categories = newArr;
                    }
                } else {
                    this.selected_categories.push(category);
                    let newArr = this.selected_categories.filter(item => item !== 'all');
                    this.selected_categories = newArr;
                }
            }
        },
        isCategorySelected(category) {
            return this.selected_categories.includes(category)
        }

    }));

    Alpine.data('ResourceItem', () => ({

        categories_array: [],
        init() {
            let categories_raw = this.$el.querySelector('.categories').innerText;
            let categories_array = categories_raw.trim().split(" ");
            this.categories_array = categories_array;
            console.log('Item categories: ', categories_array);
        },
        showCard() {
            const cost_match = (this.selected_cost === '') || this.categories_array.includes(this.selected_cost);
            const category_match = this.selected_categories.includes('all') || this.categories_array.some(item => this.selected_categories.includes(item));

            return cost_match && category_match;
        }

    }));
});