class ApiService {
	constructor($http) {
		this.http = $http
	}

	async loadFaculties() {
		const response = await this.http.get('http://localhost/Planeador/api');
		return response.data
	}
}

ApiService.$inject = ['$http'];

export default ApiService;
