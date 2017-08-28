class HomeController {
	constructor(ApiService) {
		this.api = ApiService;
		this.loadFaculties();
	}

	loadFaculties() {
		this.api.loadFaculties().then(data => { this.faculties = data });
	}

}

HomeController.$inject = ['ApiService']

export default HomeController;
