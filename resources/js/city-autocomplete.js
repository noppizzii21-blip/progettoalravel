import { CITIES_ATTRIBUTES } from 'comuni-province-regioni/lib/city';

const cityEntries = Object.values(CITIES_ATTRIBUTES)
    .map((item) => ({
        name: item.name,
        province: item.province,
        region: item.region,
    }))
    .reduce((acc, next) => {
        if (!acc.some((city) => city.name === next.name)) {
            acc.push(next);
        }
        return acc;
    }, [])
    .sort((a, b) => a.name.localeCompare(b.name, 'it'));

window.citySearchData = cityEntries;

window.cityAutocomplete = () => ({
    selected: '',
    selectedProvince: '',
    selectedRegion: '',
    query: '',
    open: false,
    activeIndex: -1,
    init(value) {
        if (value) {
            this.selected = value;
            this.query = value;
            const match = this.cityList.find((item) => item.name.toLowerCase() === value.toLowerCase());
            if (match) {
                this.selectedProvince = match.province;
                this.selectedRegion = match.region;
            }
        }
    },
    get cityList() {
        return window.citySearchData;
    },
    get filtered() {
        if (!this.query) {
            return this.cityList.slice(0, 10);
        }

        const lowerQuery = this.query.toLowerCase();
        return this.cityList
            .filter((item) =>
                item.name.toLowerCase().includes(lowerQuery) ||
                item.province.toLowerCase().includes(lowerQuery) ||
                item.region.toLowerCase().includes(lowerQuery)
            )
            .slice(0, 12);
    },
    searchCities() {
        this.open = true;
        this.activeIndex = 0;
        this.selectedProvince = '';
        this.selectedRegion = '';
    },
    move(direction) {
        if (!this.filtered.length) {
            return;
        }
        this.activeIndex = (this.activeIndex + direction + this.filtered.length) % this.filtered.length;
    },
    choose(index) {
        if (index < 0 || index >= this.filtered.length) {
            return;
        }
        const city = this.filtered[index];
        this.selected = city.name;
        this.selectedProvince = city.province;
        this.selectedRegion = city.region;
        this.open = false;
    },
});
